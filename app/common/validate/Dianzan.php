<?php

namespace app\common\validate;

class Dianzan extends Base
{
    // 验证规则
    protected $rule = [
        'id' => 'require|number|gt:0',
        'id_value' => 'require|number|gt:0',
        'type' => 'in:0,1,2,3,4,5',
        'user_id' => 'require|number|gt:0',
        'add_time' => 'require|number|gt:0',
    ];
    
    protected $message = [
        'id.require' => 'ID不能为空',
        'id.number' => 'ID必须是数字',
        'id.gt' => 'ID格式不正确',
        'id_value.require' => '评论或文章的ID不能为空',
        'id_value.number' => '评论或文章的ID必须是数字',
        'id_value.gt' => '评论或文章的ID格式不正确',
        'type.in' => '用户点赞类型，0评论，1文章',
        'user_id.require' => '用户ID不能为空',
        'user_id.number' => '用户ID必须是数字',
        'user_id.gt' => '用户ID格式不正确',
        'add_time.require' => '添加时间不能为空',
        'add_time.number' => '添加时间格式不正确',
        'add_time.gt' => '添加时间格式不正确',
    ];

    protected $scene = [
        'add'  => ['id_value', 'type', 'user_id'],
        'edit' => ['id_value', 'type', 'user_id'],
        'del'  => ['id'],
    ];
}