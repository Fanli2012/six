<?php

namespace app\common\validate;

class Slide extends Base
{
    // 验证规则
    protected $rule = [
        'id' => 'require|number|gt:0',
        'title' => 'require|max:150',
        'url' => 'max:150',
        'target' => 'number|egt:0',
        'group_id' => 'number|egt:0',
        'pic' => 'require|max:150',
        'listorder' => 'number|egt:0',
        'status' => 'in:0,1,2',
    ];
    
    protected $message = [
        'id.require' => 'ID不能为空',
        'id.number' => 'ID必须是数字',
        'id.gt' => 'ID格式不正确',
        'title.require' => '标题不能为空',
        'title.max' => '标题不能超过150个字符',
        'url.max' => '跳转链接不能超过150个字符',
        'target.number' => '跳转方式必须是数字',
        'target.egt' => '跳转方式格式不正确',
        'group_id.number' => '分组ID必须是数字',
        'group_id.egt' => '分组ID格式不正确',
        'pic.require' => '图片地址不能为空',
        'pic.max' => '图片地址不能超过150个字符',
        'listorder.number' => '排序必须是数字',
        'listorder.egt' => '排序格式不正确',
        'status.in' => '状态 0正常，1禁用',
    ];

    protected $scene = [
        'add' => ['title', 'url', 'target', 'group_id', 'pic', 'listorder', 'status'],
        'edit' => ['title', 'url', 'target', 'group_id', 'pic', 'listorder', 'status'],
        'del' => ['id'],
    ];
}