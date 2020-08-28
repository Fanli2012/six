<?php

namespace app\common\validate;

class UserShuoshuoImg extends Base
{
    // 验证规则
    protected $rule = [
        'id' => 'require|number|gt:0',
        'user_shuoshuo_id' => 'require|number|gt:0',
        'url' => 'require|max:150',
        'desc' => 'max:150',
        'listorder' => 'number|egt:0',
        'add_time' => 'require|number|max:11',
    ];
    
    protected $message = [
        'id.require' => 'ID不能为空',
        'id.number' => 'ID必须是数字',
        'id.gt' => 'ID格式不正确',
        'user_shuoshuo_id.require' => '说说ID不能为空',
        'user_shuoshuo_id.number' => '说说ID必须是数字',
        'user_shuoshuo_id.gt' => '说说ID格式不正确',
        'url.require' => '图片地址不能为空',
        'url.max' => '图片地址不能超过150个字符',
        'desc.max' => '描述不能超过150个字符',
        'listorder.number' => '排序必须是数字',
        'listorder.egt' => '排序格式不正确',
        'add_time.require' => '添加时间不能为空',
        'add_time.number' => '添加时间格式不正确',
        'add_time.gt' => '添加时间格式不正确',
    ];

    protected $scene = [
        'add' => ['user_shuoshuo_id', 'url', 'desc', 'listorder', 'add_time'],
        'edit' => ['user_shuoshuo_id', 'url', 'desc', 'listorder'],
        'del' => ['id'],
    ];
}