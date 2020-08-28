<?php

namespace app\common\validate;

class Searchword extends Base
{
    // 验证规则
    protected $rule = [
        'id' => 'require|number|gt:0',
        'name' => 'require|max:36',
        'title' => 'max:60',
        'keywords' => 'max:100',
        'description' => 'max:250',
        'click' => 'number|egt:0',
        'litpic' => 'max:150',
        'template' => 'max:30',
        'filename' => 'require|max:60|regex:/^[a-z]{1,}[a-z0-9]*$/',
        'status' => 'in:0,1,2',
        'update_time' => 'require|number|gt:0',
    ];
    
    protected $message = [
        'id.require' => 'ID不能为空',
        'id.number' => 'ID必须是数字',
        'id.gt' => 'ID格式不正确',
        'name.require' => '名称不能为空',
        'name.max' => '名称不能超过36个字符',
        'title.max' => 'SEO标题不能超过60个字符',
        'keywords.max' => '关键词不能超过100个字符',
        'description.max' => '描述不能超过250个字符',
        'click.number' => '点击量必须是数字',
        'click.egt' => '点击量格式不正确',
        'litpic.max' => '缩略图不能超过150个字符',
        'template.max' => '模板名称不能超过30个字符',
        'filename.require' => '别名不能为空',
        'filename.max' => '别名不能超过60个字符',
        'filename.regex' => '别名格式不正确',
        'status.in' => '状态，0正常，1禁用',
        'update_time.require' => '添加时间不能为空',
        'update_time.number' => '添加时间格式不正确',
        'update_time.gt' => '添加时间格式不正确',
    ];

    protected $scene = [
        'add' => ['name', 'title', 'keywords', 'description', 'click', 'litpic', 'template', 'filename', 'status', 'update_time'],
        'edit' => ['name', 'title', 'keywords', 'description', 'click', 'litpic', 'template', 'filename', 'status', 'update_time'],
        'del' => ['id'],
    ];
}