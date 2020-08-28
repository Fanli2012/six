<?php

namespace app\index\controller;

use think\facade\View;
use think\facade\Db;
use think\facade\Log;
use think\facade\Request;
use app\common\lib\ReturnData;
use app\common\lib\Helper;
use app\common\logic\ArticleLogic;

class Article extends Base
{
    public function _initialize()
    {
        parent::_initialize();
    }

    public function getLogic()
    {
        return new ArticleLogic();
    }

    //列表
    public function index()
    {
        $where = [];
        $title = '';

		// page参数不能为1
		if (isset($_GET['page']) && $_GET['page'] == 1) {
			Helper::http404();
		}
        $uri = $_SERVER["REQUEST_URI"]; //获取当前url的参数
        $key = input('key', null);
        if ($key != null) {
            $arr_key = logic('Article')->getArrByString($key);
            if (!$arr_key) {
                Helper::http404();
            }

            //分类id
            if (isset($arr_key['f']) && $arr_key['f'] > 0) {
                $type_id = $arr_key['f'];
				$where[] = ['type_id', '=', $type_id];
				
                $post = model('ArticleType')->getOne(['id' => $arr_key['f']]);
                if (!$post) {
                    Helper::http404();
                }
                $title = $post['name'] . '-' . sysconfig('CMS_WEBNAME');
                if ($post['seotitle']) {
                    $title = $post['seotitle'];
                }
				$assign_data['post'] = $post;

                //面包屑导航
				$assign_data['bread'] = logic('Article')->get_article_type_path($type_id);
            }
        }

		$where[] = ['delete_time', '=', 0];
		$where[] = ['status', '=', 0];
		$where[] = ['add_time', '<', time()];
        $posts = cache("index_article_index_posts_" . md5($uri));
        if (!$posts) {
            $posts = $this->getLogic()->getPaginate($where, 'id desc', ['content'], 11);
            cache("index_article_index_posts_" . md5($uri), $posts, 7200);
        }

        $page = $posts->render();
        $page = preg_replace('/key=[a-z0-9]+&amp;/', '', $page);
        $page = preg_replace('/&amp;key=[a-z0-9]+/', '', $page);
        $page = preg_replace('/\?page=1"/', '"', $page);
		$assign_data['page'] = $page;
        $list = $posts->toArray();
		$assign_data['list'] = $list;
        if (!$list['data']) {
            Helper::http404();
        }

        //推荐文章
        $relate_tuijian_list = cache("index_article_detail_relate_tuijian_list_$key");
        if (!$relate_tuijian_list) {
			$where_tuijian[] = ['delete_time', '=', 0];
			$where_tuijian[] = ['status', '=', 0];
			$where_tuijian[] = ['tuijian', '=', 1];
			$where_tuijian[] = ['litpic', '<>', ''];
			$where_tuijian[] = ['add_time', '<', time()];
            if (isset($type_id)) {
				$where_tuijian[] = ['type_id', '=', $type_id];
            }
            $relate_tuijian_list = logic('Article')->getAll($where_tuijian, 'update_time desc', ['content'], 5);
            cache("index_article_detail_relate_tuijian_list_$key", $relate_tuijian_list, 2592000);
        }
		$assign_data['relate_tuijian_list'] = $relate_tuijian_list;

        //随机文章
        $relate_rand_list = cache("index_article_detail_relate_rand_list_$key");
        if (!$relate_rand_list) {
			$where_rand[] = ['delete_time', '=', 0];
			$where_rand[] = ['status', '=', 0];
			$where_rand[] = ['add_time', '<', time()];
            if (isset($type_id)) {
                $where_rand[] = ['type_id', '=', $type_id];
            }
            $relate_rand_list = logic('Article')->getAll($where_rand, ['orderRaw', 'rand()'], ['content'], 5);
            cache("index_article_detail_relate_rand_list_$key", $relate_rand_list, 2592000);
        }
		$assign_data['relate_rand_list'] = $relate_rand_list;

        //seo标题设置
		$assign_data['title'] = $title;
        return view('index/Article/index', $assign_data);
    }

    //详情
    public function detail()
    {
        if (!checkIsNumber(input('id/d', null))) {
            Helper::http404();
        }
        $id = input('id');

        $post = cache("index_article_detail_$id");
        if (!$post) {
            $where['id'] = $id;
            $post = $this->getLogic()->getOne($where);
            if (!$post) {
                Helper::http404();
            }
            $post['content'] = $this->getLogic()->replaceKeyword($post['content']);
            cache("index_article_detail_$id", $post, 2592000);

        }
		$assign_data['post'] = $post;
        //var_dump($post);exit;
        //最新文章
        $relate_zuixin_list = cache("index_article_detail_relate_zuixin_list_$id");
        if (!$relate_zuixin_list) {
			$where_zuixin[0] = ['delete_time', '=', 0];
			$where_zuixin[1] = ['status', '=', 0];
			$where_zuixin[2] = ['type_id', '=', $post['type_id']];
			$where_zuixin[3] = ['id', '<', ($id - 1)];
            $relate_zuixin_list = logic('Article')->getAll($where_zuixin, 'update_time desc', ['content'], 5);
            if (!$relate_zuixin_list) {
                unset($where_zuixin[3]);
                $relate_zuixin_list = logic('Article')->getAll($where_zuixin, 'update_time desc', ['content'], 5);
            }
            cache("index_article_detail_relate_zuixin_list_$id", $relate_zuixin_list, 2592000);
        }
		$assign_data['relate_zuixin_list'] = $relate_zuixin_list;

        //随机文章
        $relate_rand_list = cache("index_article_detail_relate_rand_list_$id");
        if (!$relate_rand_list) {
			$where_rand[] = ['delete_time', '=', 0];
			$where_rand[] = ['status', '=', 0];
			$where_rand[] = ['type_id', '=', $post['type_id']];
			$where_rand[] = ['add_time', '<', time()];
            $relate_rand_list = logic('Article')->getAll($where_rand, ['orderRaw', 'rand()'], ['content'], 5);
            cache("index_article_detail_relate_rand_list_$id", $relate_rand_list, 2592000);
        }
		$assign_data['relate_rand_list'] = $relate_rand_list;

        //面包屑导航
		$assign_data['bread'] = logic('Article')->get_article_type_path($post['type_id']);

        //上一篇、下一篇
		$assign_data = array_merge($assign_data, $this->getPreviousNextArticle(['article_id' => $id]));

        return view('index/Article/detail', $assign_data);
    }

    /**
     * 获取文章上一篇，下一篇
     * @param int $param ['article_id'] 当前文章id
     * @return array
     */
    public function getPreviousNextArticle(array $param)
    {
        $res['previous_article'] = [];
        $res['next_article'] = [];

        $where['id'] = $param['article_id'];
        $post = model('Article')->getOne($where, ['content']);
        if (!$post) {
            return $res;
        }
        $res['previous_article'] = model('Article')->getOne(['id' => ['<', $param['article_id']], 'type_id' => $post['type_id']], ['content'], 'id desc');
        $res['next_article'] = model('Article')->getOne(['id' => ['>', $param['article_id']], 'type_id' => $post['type_id']], ['content'], 'id asc');
        return $res;
    }

    //详情
    public function imglist()
    {
        return view('index/Article/imglist');
    }
}