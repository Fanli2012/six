<?php

namespace app\common\validate;

class Job extends Base
{
    // 验证规则
    protected $rule = [
        'id' => 'require|number|gt:0',
        'click' => 'number|egt:0',
        'title' => 'require|max:150',
        'keywords' => 'max:60',
        'seotitle' => 'max:150',
        'description' => 'max:250',
        'add_time' => 'require|number|gt:0',
        'update_time' => 'require|number|gt:0',
    ];

	protected $message = [
        'id.require' => 'ID不能为空',
        'id.number' => 'ID必须是数字',
        'id.gt' => 'ID格式不正确',
        'click.number' => '点击量必须是数字',
        'click.egt' => '点击量格式不正确',
        'title.require' => '标题不能为空',
        'title.max' => '标题不能超过150个字符',
        'seotitle.max' => 'SEO标题不能超过150个字符',
        'keywords.max' => '关键词不能超过60个字符',
        'description.max' => '描述不能超过250个字符',
        'add_time.require' => '添加时间不能为空',
        'add_time.number' => '添加时间格式不正确',
        'add_time.gt' => '添加时间格式不正确',
        'update_time.require' => '更新时间不能为空',
        'update_time.number' => '更新时间格式不正确',
        'update_time.gt' => '更新时间格式不正确',
    ];

    protected $scene = [
        'add' => ['title', 'click', 'keywords', 'seotitle', 'description', 'add_time', 'update_time'],
        'edit' => ['title', 'click', 'keywords', 'seotitle', 'description', 'update_time'],
        'del' => ['id'],
    ];
}