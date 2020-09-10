<?php

namespace app\fladmin\controller;

use app\common\lib\ReturnData;
use app\common\lib\Helper;
use app\common\logic\SysconfigLogic;

class Sysconfig extends Base
{
    public function _initialize()
    {
        parent::_initialize();
    }

    public function getLogic()
    {
        return new SysconfigLogic();
    }

    //列表
    public function index()
    {
        $where = array();
        if (!empty($_REQUEST["keyword"])) {
			$where[] = ['info', 'like', '%' . $_REQUEST['keyword'] . '%'];
        }
        $list = $this->getLogic()->getPaginate($where, ['id' => 'desc']);
        //echo '<pre>';print_r($list);exit;
        $assign_data['page'] = $list->render(); // 获取分页显示
        $assign_data['list'] = $list;

        //echo '<pre>';print_r($list);exit;
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

            cache('sysconfig', NULL);
            $this->success($res['msg'], url('index'), '', 1);
        }

        return view();
    }

    //修改
    public function edit()
    {
        if (Helper::isPostRequest()) {
            $where['id'] = $_POST['id'];
            unset($_POST['id']);

            $res = $this->getLogic()->edit($_POST, $where);
            if ($res['code'] != ReturnData::SUCCESS) {
                $this->error($res['msg']);
            }

            cache('sysconfig', NULL);
            $this->success($res['msg'], url('index'), '', 1);
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
        if ($res['code'] != ReturnData::SUCCESS) {
            $this->error($res['msg']);
        }

        cache('sysconfig', NULL);
        $this->success("删除成功");
    }

	//其它配置
    public function other()
    {
		if (Helper::isPostRequest()) {
			$post_data = input('post.');
			foreach ($post_data as $k=>$v) {
				model('Sysconfig')->edit(['value' => $v], ['varname' => $k]);
			}
			// 删除缓存数据
			cache('sysconfig', NULL);
            $this->success('操作成功');
        }

        return view('');
    }
}