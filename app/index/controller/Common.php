<?php

namespace app\index\controller;

use app\common\controller\CommonController;
use think\facade\Request;
use think\facade\Db;
use think\facade\Log;
use app\common\lib\Helper;

class Common extends CommonController
{
    protected $login_info;

    /**
     * 初始化
     * @param void
     * @return void
     */
    public function __construct()
    {
        if (strlen($_SERVER['REQUEST_URI']) > 100) {
            header("HTTP/1.1 404 Not Found");
            header("Status: 404 Not Found");
            exit;
        }

        //店铺登录信息
        $this->login_info = session('shop_info');

        //判断是否拥有权限
        /* if($this->shop_info['role_id'] <> 1)
        {
            $uncheck = array('shop/index/index','shop/index/upconfig','shop/index/upcache','shop/index/welcome');

            if(!in_array($route, $uncheck))
            {

            }
        } */

        //请求日志
        Log::info('【请求地址】：' . request()->ip() . ' [' . date('Y-m-d H:i:s') . '] ' . request()->method() . ' ' . '/index/' . request()->controller() . '/' . request()->action());
        Log::info('【请求参数】：' . json_encode(request()->param(), JSON_UNESCAPED_SLASHES));
        Log::info('【请求头】：' . json_encode(request()->header(), JSON_UNESCAPED_SLASHES));
		
		// 添加操作记录
		$this->operation_log_add($this->login_info);
    }

    // 设置空操作
    public function _empty()
    {
        Helper::http404();
    }

	// 添加操作记录
    public function operation_log_add($login_info = [])
    {
        $time = time();
        // 记录操作
        if ($login_info) {
            $data['login_id'] = $login_info['id'];
            $data['login_name'] = $login_info['user_name'];
        }
        $data['type'] = 2;
        $data['ip'] = request()->ip();
        $data['url'] = mb_strcut(request()->url(), 0, 255, 'UTF-8');
        $data['http_method'] = request()->method();
        $data['domain_name'] = mb_strcut($_SERVER['SERVER_NAME'], 0, 60, 'UTF-8');
        if ($data['http_method'] != 'GET') {
            $data['content'] = mb_strcut(json_encode(input(), JSON_UNESCAPED_SLASHES), 0, 255, 'UTF-8');
        }
        if (!empty($_SERVER['HTTP_REFERER'])) {
            $data['http_referer'] = mb_strcut($_SERVER['HTTP_REFERER'], 0, 255, 'UTF-8');
        }
        $data['add_time'] = $time;
        logic('Log')->add($data);
    }
}