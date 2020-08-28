<?php

namespace app\common\validate;

class Friendlink extends Base
{
    // 验证规则
    protected $rule = [
        'id' => 'require|number|gt:0',
        'name' => 'require|max:30',
        'url' => 'require|max:150',
        'target' => 'number|egt:0',
        'group_id' => 'number|egt:0',
        'listorder' => 'number|egt:0',
    ];
    
    protected $message = [
        'id.require' => 'ID不能为空',
        'id.number' => 'ID必须是数字',
        'id.gt' => 'ID格式不正确',
        'name.require' => '链接名称不能为空',
        'name.max' => '链接名称不能超过30个字符',
        'url.require' => '跳转链接名称不能为空',
        'url.max' => '跳转链接不能超过150个字符',
        'target.number' => '跳转方式必须是数字',
        'target.egt' => '跳转方式格式不正确',
        'group_id.number' => '分组ID必须是数字',
        'group_id.egt' => '分组ID格式不正确',
        'listorder.number' => '排序必须是数字',
        'listorder.egt' => '排序格式不正确',
    ];

    protected $scene = [
        'add' => ['name', 'url', 'target', 'group_id', 'listorder'],
        'edit' => ['name', 'url', 'target', 'group_id', 'listorder'],
        'del' => ['id'],
    ];
}