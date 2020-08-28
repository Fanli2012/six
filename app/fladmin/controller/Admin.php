<?php

namespace app\fladmin\controller;

use app\common\lib\ReturnData;
use app\common\lib\Helper;
use app\common\logic\AdminLogic;

class Admin extends Base
{
    public function _initialize()
    {
        parent::_initialize();
    }

    public function getLogic()
    {
        return new AdminLogic();
    }

    //列表
    public function index()
    {
        $where = array();
        if (!empty($_REQUEST["keyword"])) {
			$where[] = array('name|mobile|email', 'like', '%' . $_REQUEST['keyword'] . '%');
        }
		$where[] = array('delete_time', '=', 0); //未删除
        $list = $this->getLogic()->getPaginate($where, ['id' => 'desc']);

        //echo '<pre>';print_r($list);exit;
        $assign_data['page'] = $list->render();
        $assign_data['list'] = $list;

        return view('', $assign_data);
    }

    //添加
    public function add()
    {
        if (Helper::isPostRequest()) {
            $res = $this->getLogic()->add($_POST);
            if ($res['code'] == ReturnData::SUCCESS) {
                $this->success($res['msg'], url('index'), '', 1);
            }

            $this->error($res['msg']);
        }

        $assign_data['rolelist'] = model('AdminRole')->getAll([], 'listorder asc');

        return view('', $assign_data);
    }

    //修改
    public function edit()
    {
        if (Helper::isPostRequest()) {
            $where['id'] = $_POST['id'];
            unset($_POST['id']);
			if (!$_POST['pwd']) {
				unset($_POST['pwd']);
			}

            $res = $this->getLogic()->edit($_POST, $where);
            if ($res['code'] == ReturnData::SUCCESS) {
                $this->success($res['msg'], url('index'), '', 1);
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
        $assign_data['rolelist'] = model('AdminRole')->getAll([], 'listorder asc');

        return view('', $assign_data);
    }

    //删除
    public function del()
    {
        if (!checkIsNumber(input('id', null))) {
            $this->error('删除失败！请重新提交');
        }
        $where['id'] = input('id');

        $res = $this->getLogic()->del($where);
        if ($res['code'] == ReturnData::SUCCESS) {
            $this->success("删除成功");
        }

        $this->error($res['msg']);
    }
}