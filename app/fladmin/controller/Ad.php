<?php

namespace app\fladmin\controller;

use app\common\lib\ReturnData;
use app\common\lib\Helper;
use app\common\logic\AdLogic;
use think\Loader;
use think\Validate;

class Ad extends Base
{
    public function _initialize()
    {
        parent::_initialize();
    }

    public function getLogic()
    {
        return new AdLogic();
    }

    //列表
    public function index()
    {
        $where = array();
        if (!empty($_REQUEST["keyword"])) {
            $where[] = array('name', 'like', '%' . $_REQUEST['keyword'] . '%');
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
            //表单令牌验证
            $this->form_token_verification();

            if ($_POST['start_time'] && $_POST['end_time']) {
                $_POST['start_time'] = strtotime($_POST['start_time']);
                $_POST['end_time'] = strtotime($_POST['end_time']);
            }

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
            //表单令牌验证
            $validate = new Validate([
                ['__token__', 'require|token', '非法提交|请不要重复提交表单'],
            ]);
            if (!$validate->check($_POST)) {
                $this->error($validate->getError());
            }

            $where['id'] = $_POST['id'];
            unset($_POST['id']);

            if ($_POST['start_time'] && $_POST['end_time']) {
                $_POST['start_time'] = strtotime($_POST['start_time']);
                $_POST['end_time'] = strtotime($_POST['end_time']);
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

        //时间戳转日期格式
        if ($post['start_time'] > 0) {
            $post['start_time'] = date('Y-m-d H:i:s', $post['start_time']);
        } else {
            $post['start_time'] = '';
        }
        if ($post['end_time'] > 0) {
            $post['end_time'] = date('Y-m-d H:i:s', $post['end_time']);
        } else {
            $post['end_time'] = '';
        }

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
            $this->success("删除成功");
        }

        $this->error($res['msg']);
    }
}