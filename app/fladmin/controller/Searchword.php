<?php

namespace app\fladmin\controller;

use app\common\lib\ReturnData;
use app\common\lib\Helper;
use app\common\logic\SearchwordLogic;

class Searchword extends Base
{
    public function _initialize()
    {
        parent::_initialize();
    }

    public function getLogic()
    {
        return new SearchwordLogic();
    }

    //列表
    public function index()
    {
        $where = array();
        if (!empty($_REQUEST['keyword'])) {
            $where[] = array('name', 'like', '%' . $_REQUEST['keyword'] . '%');
        }
        $list = $this->getLogic()->getPaginate($where, ['id' => 'desc']);

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

            $_POST['update_time'] = time(); //更新时间
            $_POST['click'] = rand(200, 500); //点击

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

            if (!empty($_POST["keywords"])) {
                $_POST['keywords'] = str_replace("，", ",", $_POST["keywords"]);
            } else {
                $_POST['keywords'] = "";
            } //关键词
            $_POST['update_time'] = time(); //更新时间

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
            $this->success("删除成功");
        }

        $this->error($res['msg']);
    }
}