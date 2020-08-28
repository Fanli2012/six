<?php

namespace app\common\validate;

class Page extends Base
{
    // 验证规则
    protected $rule = [
        'id' => 'require|number|gt:0',
        'title' => 'require|max:150',
        'seotitle' => 'max:150',
        'keywords' => 'max:60',
        'description' => 'max:250',
        'template' => 'max:30',
        'filename' => 'require|max:60|regex:/^[a-z]{1,}[a-z0-9]*$/',
        'litpic' => 'max:150',
        'click' => 'number|egt:0',
        'group_id' => 'number|egt:0',
        'add_time' => 'require|number|gt:0',
        'update_time' => 'require|number|gt:0',
    ];
    
    protected $message = [
        'id.require' => 'ID不能为空',
        'id.number' => 'ID必须是数字',
        'id.gt' => 'ID格式不正确',
        'title.require' => '标题不能为空',
        'title.max' => '标题不能超过150个字符',
		'seotitle.max' => 'SEO标题不能超过150个字符',
        'keywords.max' => '关键词不能超过60个字符',
        'description.max' => '描述不能超过250个字符',
        'template.max' => '模板名称不能超过30个字符',
        'filename.require' => '别名不能为空',
        'filename.max' => '别名不能超过60个字符',
        'filename.regex' => '别名格式不正确',
        'litpic.max' => '缩略图不能超过150个字符',
        'click.number' => '点击量必须是数字',
        'click.gt' => '点击量格式不正确',
        'group_id.number' => '分组ID必须是数字',
        'group_id.gt' => '分组ID格式不正确',
        'add_time.require' => '添加时间不能为空',
        'add_time.number' => '添加时间格式不正确',
        'add_time.gt' => '添加时间格式不正确',
        'update_time.require' => '更新时间不能为空',
        'update_time.number' => '更新时间格式不正确',
        'update_time.gt' => '更新时间格式不正确',
    ];

    protected $scene = [
        'add' => ['title', 'seotitle', 'keywords', 'description', 'template', 'filename', 'litpic', 'click', 'group_id', 'add_time', 'update_time'],
        'edit' => ['title', 'seotitle', 'keywords', 'description', 'template', 'filename', 'litpic', 'click', 'group_id', 'update_time'],
        'del' => ['id'],
    ];
}