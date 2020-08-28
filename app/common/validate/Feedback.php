<?php

namespace app\common\validate;

use app\common\lib\Validator;

class Feedback extends Base
{
    // 验证规则
    protected $rule = [
        'id' => 'require|number|gt:0',
        'title' => 'max:150',
        'user_id' => 'number|egt:0',
        'content' => 'require',
        'mobile' => 'isMobile',
        'type' => 'max:20',
        'add_time' => 'require|number|gt:0',
    ];
    
    protected $message = [
        'id.require' => 'ID不能为空',
        'id.number' => 'ID必须是数字',
        'id.gt' => 'ID格式不正确',
        'title.max' => '标题不能超过150个字符',
        'user_id.number' => '用户ID必须是数字',
        'user_id.egt' => '用户ID格式不正确',
        'content.require' => '意见反馈内容不能为空',
        'type.max' => '意见反馈类型不能超过20个字符',
        'add_time.require' => '添加时间不能为空',
        'add_time.number' => '添加时间格式不正确',
        'add_time.gt' => '添加时间格式不正确',
    ];

    protected $scene = [
        'add' => ['title', 'user_id', 'content', 'mobile', 'type'],
        'del' => ['id'],
    ];

    // 手机号校验
    protected function isMobile($value, $rule, $data)
    {
        if (empty($value)) {
            return '手机号不能为空';
        }

        if (Validator::isMobile($value)) {
            return true;
        }

        return '手机号格式不正确';
    }
}