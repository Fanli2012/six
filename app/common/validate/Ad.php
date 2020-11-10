<?php

namespace app\common\validate;

class Ad extends Base
{
    // 验证规则
    protected $rule = [
        'id' => 'require|number|gt:0',
        'name' => 'require|max:60',
        'description' => 'max:255',
        'flag' => 'max:30',
        'is_expire' => 'in:0,1,2',
        'start_time' => 'number|egt:0',
        'end_time' => 'number|egt:start_time',
        'add_time' => 'require|number|gt:0',
    ];
    
    protected $message = [
        'id.require' => 'ID不能为空',
        'id.number' => 'ID必须是数字',
        'id.gt' => 'ID格式不正确',
        'name.require' => '名称不能为空',
        'name.max' => '名称不能超过60个字符',
        'description.max' => '描述不能超过255个字符',
        'flag.max' => '标识不能超过30个字符',
        'is_expire.in' => '0永不过期',
        'start_time.number' => '投放开始时间格式不正确',
        'start_time.egt' => '投放开始时间格式不正确',
        'end_time.number' => '投放结束时间格式不正确',
        'end_time.egt' => '投放结束时间格式不正确',
        'add_time.require' => '添加时间不能为空',
        'add_time.number' => '添加时间格式不正确',
        'add_time.gt' => '添加时间格式不正确',
    ];

    protected $scene = [
        'add' => ['name', 'description', 'flag', 'is_expire', 'start_time', 'end_time', 'add_time'],
        'edit' => ['name', 'description', 'flag', 'is_expire', 'start_time', 'end_time', 'add_time'],
        'del' => ['id'],
    ];
}