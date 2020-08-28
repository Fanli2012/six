<?php

namespace app\common\validate;

class GoodsBrand extends Base
{
    // 验证规则
    protected $rule = [
        'id' => 'require|number|gt:0',
        'parent_id' => 'number|egt:0',
        'name' => 'require|max:30',
        'seotitle' => 'max:150',
        'keywords' => 'max:60',
        'description' => 'max:250',
        'click' => 'number|egt:0',
        'litpic' => 'max:150',
        'cover_img' => 'max:150',
        'listorder' => 'number|egt:0',
        'status' => 'in:0,1,2',
        'add_time' => 'require|number|gt:0',
    ];
	
	protected $message = [
        'id.require' => 'ID不能为空',
        'id.number' => 'ID必须是数字',
        'id.gt' => 'ID格式不正确',
        'parent_id.number' => '父级ID必须是数字',
        'parent_id.egt' => '父级ID格式不正确',
        'name.require' => '品牌名称不能为空',
        'name.max' => '品牌名称不能超过30个字符',
        'seotitle.max' => 'SEO标题不能超过150个字符',
        'keywords.max' => '关键词不能超过60个字符',
        'description.max' => '描述不能超过250个字符',
        'click.number' => '点击量必须是数字',
        'click.egt' => '点击量格式不正确',
        'litpic.max' => '缩略图不能超过150个字符',
        'cover_img.max' => '封面不能超过150个字符',
        'listorder.number' => '排序必须是数字',
        'listorder.egt' => '排序格式不正确',
        'status.in' => '状态，0正常，1禁用',
        'add_time.require' => '添加时间不能为空',
        'add_time.number' => '添加时间格式不正确',
        'add_time.gt' => '添加时间格式不正确',
    ];

    protected $scene = [
        'add' => ['parent_id', 'name', 'seotitle', 'keywords', 'description', 'click', 'litpic', 'cover_img', 'listorder', 'status', 'add_time'],
        'edit' => ['parent_id', 'name', 'seotitle', 'keywords', 'description', 'click', 'litpic', 'cover_img', 'listorder', 'status', 'add_time'],
        'del' => ['id'],
    ];
}