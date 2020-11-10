<?php

namespace app\index\controller;

use think\Db;
use think\Request;
use app\common\lib\ReturnData;
use app\common\lib\Helper;
use app\common\logic\AdLogic;

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
        $where = [];
        $title = '';

        $key = input('key', null);
        if ($key != null) {
            $arr_key = logic('Article')->getArrByString($key);
            if (!$arr_key) {
                Helper::http404();
            }

            //分类id
            if (isset($arr_key['f']) && $arr_key['f'] > 0) {
                $where['type_id'] = $arr_key['f'];

                $post = model('ArticleType')->getOne(['id' => $arr_key['f']]);
				$assign_data['post'] = $post;

                //面包屑导航
				$assign_data['bread'] = logic('Article')->get_article_type_path($where['type_id']);
            }
        }

        $where['delete_time'] = 0;
        $where['status'] = 0;
        $list = $this->getLogic()->getPaginate($where, 'id desc', ['content']);
        if (!$list) {
            Helper::http404();
        }

        $page = $list->render();
        $page = preg_replace('/key=[a-z0-9]+&amp;/', '', $page);
        $page = preg_replace('/&amp;key=[a-z0-9]+/', '', $page);
        $page = preg_replace('/\?page=1"/', '"', $page);;
		$assign_data['page'] = $page;
		$assign_data['list'] = $list;

        //最新
        $where2['delete_time'] = 0;
        $where2['status'] = 0;
        $zuixin_list = logic('Article')->getAll($where2, 'id desc', ['content'], 5);
		$assign_data['zuixin_list'] = $zuixin_list;

        //推荐
        $where3['delete_time'] = 0;
        $where3['status'] = 0;
        $where3['tuijian'] = 1;
        $where3['litpic'] = ['<>', ''];
        $tuijian_list = logic('Article')->getAll($where3, 'id desc', ['content'], 5);
		$assign_data['tuijian_list'] = $tuijian_list;

        //seo标题设置
        $title = $title . '最新动态';
		$assign_data['title'] = $title;
        return view('index/Page/index', $assign_data);
    }

    //详情
    public function detail()
    {
        $id = input('id');
		$where[] = ['id|flag', '=', $id];
        $post = cache("index_ad_detail_$id");
        if (!$post) {
			$time = time();
            $post = $this->getLogic()->getOne($where);
            if (!$post) {
                exit('not found');
            }
			if ($post['is_expire'] == 1 && $post['end_time'] < $time) {
				exit('expired');
			}
            cache("index_ad_detail_$id", $post, 2592000);
        }

		$assign_data['post'] = $post;
		if (Helper::is_mobile_access()) {
			if ($post['content_wap']) {
				exit($post['content_wap']);
			}
		}
        exit($post['content']);
    }
}