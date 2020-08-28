<?php

namespace app\common\validate;

use app\common\lib\Helper;

class Guestbook extends Base
{
    // 验证规则
    protected $rule = [
        'id' => 'require|number|gt:0',
        'title' => 'max:150',
        'msg' => 'require|max:250',
        'name' => 'require|max:30',
        'mobile' => 'require|max:20|checkMobile',
        'email' => 'email',
        'status' => 'number|in:0,1',
        'shop_id' => 'number|egt:0',
        'add_time' => 'require|number|gt:0',
    ];
    
    protected $message = [
        'id.require' => 'ID不能为空',
        'id.number' => 'ID必须是数字',
        'id.gt' => 'ID格式不正确',
        'title.max' => '标题不能超过150个字符',
        'msg.require' => '内容不能为空',
        'msg.max' => '内容不能超过250个字符',
        'name.require' => '姓名不能为空',
        'name.max' => '姓名不能超过30个字符',
        'mobile.require' => '手机号不能为空',
        'mobile.max' => '手机号不能超过20个字符',
        'email.email' => '邮箱格式不正确',
        'status.number' => '是否阅读必须是数字',
        'status.in' => '是否阅读，默认0未阅读',
        'shop_id.number' => '店铺ID必须是数字',
        'shop_id.egt' => '店铺ID格式不正确',
        'add_time.require' => '添加时间不能为空',
        'add_time.number' => '添加时间格式不正确',
        'add_time.gt' => '添加时间格式不正确',
    ];

    protected $scene = [
        'add' => ['title', 'msg', 'name', 'mobile', 'email', 'status', 'shop_id', 'add_time'],
        'edit' => ['title', 'msg', 'name', 'mobile', 'email', 'status', 'shop_id', 'add_time'],
        'del' => ['id'],
    ];

    /**
     * 手机号码验证
     * 参数依次为验证数据，验证规则，全部数据(数组)，字段名
     */
    protected function checkMobile($value, $rule, $data, $field)
    {
        if (Helper::isValidMobile($value)) {
            return true;
        }

        return '手机号码格式不正确';
    }
}