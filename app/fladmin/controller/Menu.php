<?php

namespace app\fladmin\controller;

use app\common\lib\ReturnData;
use app\common\lib\Helper;
use app\common\logic\MenuLogic;

class Menu extends Base
{
    public function _initialize()
    {
        parent::_initialize();
    }

    public function getLogic()
    {
        return new MenuLogic();
    }

    public function index()
    {
        $where = array();
        if (!empty($_REQUEST["keyword"])) {
			$where[] = ['name', 'like', '%' . $_REQUEST['keyword'] . '%'];
        }
		if (isset($_REQUEST["status"]) && $_REQUEST["status"] != '') {
			$where[] = ['status', '=', $_REQUEST["status"]];
        }

        $list = $this->getLogic()->getPaginate($where, ['id' => 'desc']);

        //echo '<pre>';var_dump($list->total());exit;
        $assign_data['page'] = $list->render();
        $assign_data['list'] = $list;

        return view('', $assign_data);
    }

    //添加
    public function add()
    {
        if (Helper::isPostRequest()) {
            $res = $this->getLogic()->add($_POST);
            if ($res['code'] != ReturnData::SUCCESS) {
                $this->error($res['msg']);
            }

            //添加超级管理员权限
            logic('Access')->add(['role_id' => 1, 'menu_id' => $res['data']]);
            $this->success($res['msg'], url('index'), '', 1);
        }

        if (!empty($_GET['parent_id'])) {
            $parent_id = $_GET['parent_id'];
        } else {
            $parent_id = 0;
        }
        $menu = model('Menu')->category_tree(model('Menu')->get_category());

        $assign_data['menu'] = $menu;
        $assign_data['parent_id'] = $parent_id;

        return view('', $assign_data);
    }

    //修改
    public function edit()
    {
        if (Helper::isPostRequest()) {
            $where['id'] = $_POST['id'];
            unset($_POST['id']);

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
        $assign_data['menu'] = model('Menu')->category_tree(model('Menu')->get_category());

        return view('', $assign_data);
    }

    //删除
    public function del()
    {
        if (!checkIsNumber(input('id', null))) {
            $this->error('删除失败！请重新提交');
        }
        $where['id'] = input('id'); //角色ID

        $res = $this->getLogic()->del($where);
        if ($res['code'] == ReturnData::SUCCESS) {
            //删除权限
            model('Access')->del($where);

            $this->success("删除成功");
        }

        $this->error($res['msg']);
    }

}