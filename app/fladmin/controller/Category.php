<?php

namespace app\fladmin\controller;

use app\common\lib\Helper;
use app\common\lib\ReturnData;
use app\common\logic\CategoryLogic;

class Category extends Base
{
    public function _initialize()
    {
        parent::_initialize();
    }

    public function getLogic()
    {
        return new CategoryLogic();
    }

    public function index()
    {
        $where = array();
        if (!empty($_REQUEST["keyword"])) {
            $where[] = array('name', 'like', '%' . $_REQUEST['keyword'] . '%');
        }

        $where[] = array('parent_id', '=', 0);
        $where[] = array('delete_time', '=', 0); //未删除
        $list = $this->getLogic()->getAllCategoryList($where, ['update_time' => 'desc'], ['content']);

        $assign_data['list'] = $list;

        return view('', $assign_data);
    }

    public function add()
    {
        if (Helper::isPostRequest()) {
            $res = $this->getLogic()->add($_POST);
            if ($res['code'] == ReturnData::SUCCESS) {
                $this->success($res['msg'], url('index'));
            }

            $this->error($res['msg']);
        }

        $parent_id = 0;
        if (input('parent_id', null) != null) {
            $parent_id = input('parent_id', 0);
            if (preg_match('/[0-9]*/', $parent_id)) {
            } else {
                exit;
            }
            if ($parent_id != 0) {
				$assign_data['postone'] = $this->getLogic()->getOne(['id' => $parent_id]);
            }
        }

        $assign_data['parent_id'] = $parent_id;
        return view('', $assign_data);
    }

    public function edit()
    {
        if (Helper::isPostRequest()) {
            $where['id'] = $_POST['id'];

            $res = $this->getLogic()->edit($_POST, $where);
            if ($res['code'] == ReturnData::SUCCESS) {
                $this->success($res['msg'], url('index'));
            }

            $this->error($res['msg']);
        }

        if (!checkIsNumber(input('id', null))) {
            $this->error('参数错误');
        }
        $where['id'] = input('id');
		$assign_data['id'] = $where['id'];

        $post = $this->getLogic()->getOne($where);
        $assign_data['post'] = $post;

        return view('', $assign_data);
    }

    public function del()
    {
        if (!empty($_REQUEST["id"])) {
            $id = $_REQUEST["id"];
        } else {
            $this->error('删除失败！请重新提交');
        }

        if (db('category')->where("parent_id=$id")->find()) {
            $this->error('删除失败！请先删除子栏目');
        } else {
            if (db('category')->where("id=$id")->delete()) {
                $this->success('删除成功');
            }
            $this->error('删除失败！请重新提交');
        }
    }
}