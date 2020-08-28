<?php

namespace app\common\validate;

class UserShuoshuo extends Base
{
    // 验证规则
    protected $rule = [
        'id' => 'require|number|gt:0',
        'user_id' => 'number|gt:0',
        'desc' => 'max:150',
        'add_time' => 'require|number|max:11',
    ];
    
    protected $message = [
        'id.require' => 'ID不能为空',
        'id.number' => 'ID必须是数字',
        'id.gt' => 'ID格式不正确',
        'user_id.number' => '用户ID必须是数字',
        'user_id.gt' => '用户ID格式不正确',
        'desc.max' => '描述不能超过150个字符',
        'add_time.require' => '添加时间不能为空',
        'add_time.number' => '添加时间格式不正确',
        'add_time.gt' => '添加时间格式不正确',
    ];

    protected $scene = [
        'add' => ['user_id', 'desc', 'add_time'],
        'edit' => ['user_id', 'desc'],
        'del' => ['id'],
    ];
}