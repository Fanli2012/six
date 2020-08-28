<?php

namespace app\fladmin\controller;

use app\common\lib\ReturnData;
use app\common\lib\Helper;

class Push extends Base
{
    public function _initialize()
    {
        parent::_initialize();
    }

    public function index()
    {
        $where = array();
        if (!empty($_REQUEST["keyword"])) {
            $where[] = array('title', 'like', '%' . $_REQUEST['keyword'] . '%');
        }
        $where[] = array('delete_time', '=', 0); //未删除
        $list = $this->getLogic()->getPaginate($where, ['update_time' => 'desc'], ['content']);

        //echo '<pre>';var_dump($list);exit;
        $assign_data['page'] = $list->render();
        $assign_data['list'] = $list;

        return view('', $assign_data);
    }

    public function add()
    {
        if (Helper::isPostRequest()) {
            $_POST['add_time'] = $_POST['update_time'] = time();//添加、更新时间
            $_POST['click'] = rand(200, 500);//点击

            $res = $this->getLogic()->add($_POST);
            if ($res['code'] == ReturnData::SUCCESS) {
                $this->success($res['msg'], url('index'));
            }

            $this->error($res['msg']);
        }

        return view();
    }

    public function edit()
    {
        if (Helper::isPostRequest()) {
            $_POST['update_time'] = time();
            $where['id'] = $_POST['id'];
            unset($_POST['id']);

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

    public function push_url_to_baidu()
    {
        if (Helper::isPostRequest()) {
			if (empty($_POST['urls'])) {
				$this->error('链接不能为空');
			}
			$_POST['urls'] = str_replace(" ","",str_replace("\n",",",$_POST['urls']));
            $urls = explode(",", $_POST['urls']);
			foreach ($urls as $row) {
				if(!strstr($row, 'http')){
					$this->error('链接错误！请重新输入');
				}
			}
            $res = logic('Article')->push_url_to_baidu_search_engine($urls,'43NVPDOFqd1wlkWy');
            if ($res['code'] != ReturnData::SUCCESS) {
                $this->error($res['msg']);
            }
            $this->success($res['msg'], url('push_url_to_baidu'));
        }

        return view();
    }
}