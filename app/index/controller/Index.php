<?php
namespace app\index\controller;

use think\facade\View;
use think\facade\Db;
use think\facade\Log;
use think\facade\Request;
use think\facade\Session;
use app\common\lib\ReturnData;
use app\common\lib\Helper;
use app\common\logic\ShopLogic;

class Index extends Base
{
    public function index()
    {url();
		Log::error('错误信息');
        Log::info('首页');
        $pagesize = 5;
        $offset = 0;
        if (isset($_REQUEST['page'])) {
            $offset = ($_REQUEST['page'] - 1) * $pagesize;
        }
		$where[] = ['delete_time', '=', 0];
		$where[] = ['status', '=', 0];
		$where[] = ['add_time', '<', time()];
        $res = logic('Article')->getList($where, 'id desc', ['content'], $offset, $pagesize);
        if ($res['list']) {
            foreach ($res['list'] as $k => $v) {

            }
        }
        $assign_data['list'] = $res['list'];
        $totalpage = ceil($res['count'] / $pagesize);
		$assign_data['totalpage'] = $totalpage;
		
        if (isset($_REQUEST['page_ajax']) && $_REQUEST['page_ajax'] == 1) {
            $html = '';
            if ($res['list']) {
                foreach ($res['list'] as $k => $v) {
                    $html .= '<div class="list">';
                    if (!empty($v['litpic'])) {
                        $html .= '<a class="limg" href="' . model('Article')->getArticleDetailUrl(array('id' => $v['id'])) . '"><img alt="' . $v['title'] . '" src="' . $v['litpic'] . '"></a>';
                    }
                    $html .= '<strong class="tit"><a href="' . model('Article')->getArticleDetailUrl(array('id' => $v['id'])) . '">' . $v['title'] . '</a></strong><p>' . mb_strcut($v['description'], 0, 150, 'UTF-8') . '..</p>';
                    $html .= '<div class="info"><span class="fl"><em>' . date("m-d H:i", $v['update_time']) . '</em></span><span class="fr"><em>' . $v['click'] . '</em>人阅读</span></div>';
                    $html .= '<div class="cl"></div></div>';
                }
            }

            exit(json_encode($html));
        }

        //推荐文章
        $relate_tuijian_list = cache("index_index_index_relate_tuijian_list");
        if (!$relate_tuijian_list) {
            $where2[] = ['delete_time', '=', 0];
			$where2[] = ['status', '=', 0];
			$where2[] = ['tuijian', '=', 1];
			$where2[] = ['add_time', '<', time()];
            $relate_tuijian_list = logic('Article')->getAll($where2, 'update_time desc', ['content'], 5);
            cache("index_index_index_relate_tuijian_list", $relate_tuijian_list, 3600); //1小时
        }
		$assign_data['relate_tuijian_list'] = $relate_tuijian_list;

        //随机文章
        $relate_rand_list = cache("index_index_index_relate_rand_list");
        if (!$relate_rand_list) {
            $where_rand[] = ['delete_time', '=', 0];
			$where_rand[] = ['status', '=', 0];
			$where_rand[] = ['add_time', '<', time()];
            $relate_rand_list = logic('Article')->getAll($where_rand, ['orderRaw', 'rand()'], ['content'], 5);
            cache("index_index_index_relate_rand_list", $relate_rand_list, 3600); //1小时
        }
		$assign_data['relate_rand_list'] = $relate_rand_list;

        //标签
        $relate_tag_list = cache("index_index_index_relate_tag_list");
        if (!$relate_tag_list) {
            $where_tag['status'] = 0;
            $relate_tag_list = logic('Tag')->getAll($where_tag, 'id desc', ['content'], 5);
            cache("index_index_index_relate_tag_list", $relate_tag_list, 3600); //1小时
        }
		$assign_data['relate_tag_list'] = $relate_tag_list;

        //友情链接
        $friendlink_list = cache("index_index_index_friendlink_list");
        if (!$friendlink_list) {
            $friendlink_list = logic('Friendlink')->getAll('', 'id desc', '*', 5);
            cache("index_index_index_friendlink_list", $friendlink_list, 604800); //7天
        }
		$assign_data['friendlink_list'] = $friendlink_list;

        //轮播图
        $slide_list = cache("index_index_index_slide_list");
        if (!$slide_list) {
            $where_slide['status'] = 0;
            $where_slide['group_id'] = 0;
            $slide_list = logic('Slide')->getAll($where_slide, 'listorder asc', '*', 5);
            cache("index_index_index_slide_list", $slide_list, 86400); //1天
        }
		$assign_data['slide_list'] = $slide_list;

        return view('index', $assign_data);
    }

	//XML地图
    public function sitemap()
    {
        //最新文章
		$where[] = ['delete_time', '=', 0];
		$where[] = ['status', '=', 0];
		$where[] = ['add_time', '<', time()];
        $list = logic('Article')->getAll($where, 'update_time desc', ['content'], 100);
        $assign_data['list'] = $list;

        return view('index/Index/sitemap', $assign_data);
    }

    //404页面
    public function notfound()
    {
        return view('index/Index/notfound');
    }
}
