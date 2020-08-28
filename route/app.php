<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
use think\facade\Route;

//index模块
Route::rule('sitemap', 'app\index\controller\Index@sitemap', 'GET')->option(['ext' => 'xml']);
//文章
Route::rule('articlelist/[:key]', 'app\index\controller\Article@index', 'GET')->pattern(['key' => '[a-z0-9]*']);
Route::rule('p/<id>', 'app\index\controller\Article@detail', 'GET')->pattern(['id' => '\d+']);
//标签
Route::get('taglist/[:key]', 'app\index\controller\Tag@index', 'GET')->pattern(['key' => '[a-z0-9]*']);
Route::get('tag/<id>', 'app\index\controller\Tag@detail', 'GET')->pattern(['id' => '\d+']);
//商品
Route::get('goodslist/[:key]', 'app\index\controller\Goods@index', 'GET')->pattern(['key' => '[a-z0-9]*']);
Route::get('goods/<id>', 'app\index\controller\Goods@detail', 'GET')->pattern(['id' => '\d+']);
//单页
Route::get('pagelist/<key>', 'app\index\controller\Page@index', 'GET')->pattern(['key' => '[a-z0-9]*']);
Route::get('page/<id>', 'app\index\controller\Page@detail', 'GET')->pattern(['id' => '[a-z0-9]+'])->option(['ext' => 'html']);
