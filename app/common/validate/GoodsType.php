<?php

namespace app\common\validate;

class GoodsType extends Base
{
    // 验证规则
    protected $rule = [
        'id' => 'require|number|gt:0',
        'parent_id' => 'number|egt:0',
        'name' => 'require|max:30',
        'seotitle' => 'max:150',
        'keywords' => 'max:60',
        'description' => 'max:250',
        'filename' => 'require|max:30|regex:/^[a-z]{1,}[a-z0-9]*$/',
        'templist' => 'max:50|regex:/^[a-z]{1,}[a-z0-9]*$/',
        'temparticle' => 'max:50|regex:/^[a-z]{1,}[a-z0-9]*$/',
        'litpic' => 'max:150',
        'cover_img' => 'max:150',
        'listorder' => 'number|egt:0',
        'shop_id' => 'number|egt:0',
        'add_time' => 'require|number|egt:0',
        'update_time' => 'require|number|egt:0',
    ];

	protected $message = [
        'id.require' => 'ID不能为空',
        'id.number' => 'ID必须是数字',
        'id.gt' => 'ID格式不正确',
        'parent_id.require' => '父级ID必须是数字',
        'parent_id.egt' => '父级ID格式不正确',
        'name.require' => '栏目名称不能为空',
        'name.max' => '栏目名称不能超过30个字符',
        'seotitle.max' => 'SEO标题不能超过150个字符',
        'keywords.max' => '关键词不能超过60个字符',
        'description.max' => '描述不能超过250个字符',
        'filename.require' => '别名不能为空',
        'filename.max' => '别名不能超过30个字符',
        'filename.regex' => '别名格式不正确',
        'templist.max' => '列表页模板不能超过50个字符',
        'templist.regex' => '列表页模板格式不正确',
        'temparticle.max' => '文章页模板不能超过50个字符',
        'temparticle.regex' => '文章页模板格式不正确',
        'litpic.max' => '缩略图不能超过150个字符',
        'cover_img.max' => '封面不能超过150个字符',
        'is_part.in' => '栏目属性：0列表栏目（允许发布文档），1频道封面（不允许发布文档）',
        'listorder.number' => '排序必须是数字',
        'listorder.egt' => '排序格式不正确',
        'shop_id.number' => '店铺ID必须是数字',
        'shop_id.egt' => '店铺ID格式不正确',
        'add_time.require' => '添加时间不能为空',
        'add_time.number' => '添加时间格式不正确',
        'add_time.gt' => '添加时间格式不正确',
        'update_time.require' => '更新时间不能为空',
        'update_time.number' => '更新时间格式不正确',
        'update_time.gt' => '更新时间格式不正确',
    ];

    protected $scene = [
        'add' => ['parent_id', 'name', 'seotitle', 'keywords', 'description', 'filename', 'templist', 'temparticle', 'litpic', 'is_part', 'listorder', 'shop_id', 'add_time', 'update_time'],
        'edit' => ['parent_id', 'name', 'seotitle', 'keywords', 'description', 'filename', 'templist', 'temparticle', 'litpic', 'is_part', 'listorder', 'shop_id', 'update_time'],
        'del' => ['id'],
    ];
}