<?php

namespace app\common\validate;

class Keyword extends Base
{
    // 验证规则
    protected $rule = [
        'id' => 'require|number|gt:0',
        'name' => 'require|max:30',
        'url' => 'require|max:150',
    ];
    
    protected $message = [
        'id.require' => 'ID不能为空',
        'id.number' => 'ID必须是数字',
        'id.gt' => 'ID格式不正确',
        'name.require' => '内链关键词不能为空',
        'name.max' => '内链关键词不能超过30个字符',
        'url.require' => '跳转链接不能为空',
        'url.max' => '跳转链接不能超过150个字符',
    ];

    protected $scene = [
        'add' => ['name', 'url'],
        'edit' => ['name', 'url'],
        'del' => ['id'],
    ];
}