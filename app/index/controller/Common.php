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
    }

    // 设置空操作
    public function _empty()
    {
        Helper::http404();
    }
}