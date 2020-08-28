<?php

namespace app\common\validate;

use think\Validate;

class AdminRole extends Validate
{
    // 验证规则
    protected $rule = [
        'id' => 'require|number|gt:0',
        'parent_id' => 'number|egt:0',
        'name' => 'require|max:30',
        'des' => 'max:150',
        'listorder' => 'number|egt:0',
        'status' => 'in:0,1,2',
    ];
    
    protected $message = [
        'id.require' => 'ID不能为空',
        'id.number' => 'ID必须是数字',
        'id.gt' => 'ID格式不正确',
        'parent_id.number' => '父级ID必须是数字',
        'parent_id.egt' => '父级ID格式不正确',
        'name.require' => '名称不能为空',
        'name.max' => '名称不能超过30个字符',
        'des.max' => '描述不能超过150个字符',
        'listorder.number' => '排序必须是数字',
        'listorder.egt' => '排序格式不正确',
        'status.in' => '状态，0正常，1禁用',
    ];

    protected $scene = [
        'add' => ['parent_id', 'name', 'des', 'listorder', 'status'],
        'edit' => ['parent_id', 'name', 'des', 'listorder', 'status'],
        'del' => ['id'],
    ];
}