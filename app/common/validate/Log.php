<?php

namespace app\common\validate;

use app\common\lib\Helper;
use app\common\lib\Validator;

class Log extends Base
{
    // 验证规则
    protected $rule = [
        'id' => 'require|number|gt:0',
        'ip' => 'require|max:15|ip',
        'content' => 'max:250',
        'login_name' => 'max:30',
        'login_id' => 'number|egt:0',
        'url' => 'require|max:255',
        'domain_name' => 'max:60',
        'http_referer' => 'max:255',
        'http_method' => 'require|max:10',
        'add_time' => 'require|number|gt:0',
    ];
    
    protected $message = [
        'id.require' => 'ID不能为空',
        'id.number' => 'ID必须是数字',
        'id.gt' => 'ID格式不正确',
        'ip.require' => 'IP不能为空',
        'ip.max' => 'IP不能超过15个字符',
        'ip.ip' => 'IP格式不正确',
        'content.max' => '操作内容不能超过255个字符',
        'login_name.require' => '登录名称不能为空',
        'login_name.max' => '登录名称不能超过30个字符',
        'login_id.require' => '登录ID不能为空',
        'login_id.number' => '登录ID必须是数字',
        'login_id.egt' => '登录ID格式不正确',
        'url.require' => 'URL不能为空',
        'url.max' => 'URL不能超过255个字符',
        'domain_name.max' => '域名不能超过60个字符',
        'http_referer.max' => '上一个页面URL不能超过250个字符',
        'http_method.require' => '请求方式不能为空',
        'http_method.max' => '请求方式不能超过10个字符',
        'add_time.require' => '添加时间不能为空',
        'add_time.number' => '添加时间格式不正确',
        'add_time.gt' => '添加时间格式不正确',
    ];

    protected $scene = [
        'add' => ['ip', 'content', 'login_name', 'login_id', 'route', 'http_method', 'add_time'],
        'edit' => ['ip', 'content', 'login_name', 'login_id', 'route', 'http_method'],
        'del' => ['id'],
    ];
}