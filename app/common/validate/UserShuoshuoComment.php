<?php

namespace app\common\validate;

class UserShuoshuoComment extends Base
{
    // 验证规则
    protected $rule = [
        'id' => 'require|number|gt:0',
        'parent_id' => 'number|egt:0',
        'user_id' => 'require|number|egt:11',
        'user_shuoshuo_id' => 'require|number|egt:11',
        'desc' => 'max:150',
        'add_time' => 'require|number|gt:0',
    ];
    
    protected $message = [
        'id.require' => 'ID不能为空',
        'id.number' => 'ID必须是数字',
        'id.gt' => 'ID格式不正确',
        'parent_id.number' => '名称不能为空',
        'parent_id.egt' => '名称不能超过36个字符',
        'user_id.require' => '用户ID不能为空',
        'user_id.number' => '用户ID必须是数字',
        'user_id.egt' => '用户ID格式不正确',
        'user_shuoshuo_id.require' => '说说ID不能为空',
        'user_shuoshuo_id.number' => '说说ID必须是数字',
        'user_shuoshuo_id.egt' => '说说ID格式不正确',
        'desc.max' => '描述不能超过150个字符',
        'add_time.require' => '添加时间不能为空',
        'add_time.number' => '添加时间格式不正确',
        'add_time.gt' => '添加时间格式不正确',
    ];

    protected $scene = [
        'add' => ['parent_id', 'user_id', 'user_shuoshuo_id', 'desc', 'add_time'],
        'edit' => ['parent_id', 'user_id', 'user_shuoshuo_id', 'desc'],
        'del' => ['id'],
    ];
}