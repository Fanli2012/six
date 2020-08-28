<?php

namespace app\fladmin\controller;

use think\facade\Db;
use app\common\lib\ReturnData;
use app\common\lib\Helper;
use app\common\logic\AdminLogLogic;

class AdminLog extends Base
{
    public function _initialize()
    {
        parent::_initialize();
    }

    public function getLogic()
    {
        return new AdminLogLogic();
    }

    //列表
    public function index()
    {
        $where = array();
		if (!empty($_REQUEST["keyword"])) {
            $where[] = array('content', 'like', '%' . $_REQUEST['keyword'] . '%');
        }
        //用户ID
        if (isset($_REQUEST['user_id'])) {
			$where[] = array('user_id', '=', $_REQUEST['user_id']);
        }
        //IP
        if (isset($_REQUEST['ip'])) {
			$where[] = array('ip', '=', $_REQUEST['ip']);
        }
        //请求方式
        if (isset($_REQUEST['http_method'])) {
			$where[] = array('http_method', '=', $_REQUEST['http_method']);
        }
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

        return view('');
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
            $this->success('删除成功');
        }

        $this->error($res['msg']);
    }

    //清空
    public function clear()
    {
        // 截断表
        Db::execute('truncate table `fl_admin_log`');
        $this->success('操作成功', url('index'), '', 1);
    }
}