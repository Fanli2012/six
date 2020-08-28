<?php

namespace app\common\validate;

class Article extends Base
{
    // 验证规则
    protected $rule = [
        'id' => 'require|number|gt:0',
        'type_id' => 'require|egt:0',
        'tuijian' => 'number|egt:0',
        'click' => 'number|egt:0',
        'title' => 'require|max:150',
        'writer' => 'max:20',
        'source' => 'max:30',
        'litpic' => 'max:150',
        'seotitle' => 'max:150',
        'keywords' => 'max:60',
        'description' => 'max:250',
        'status' => 'in:0,1',
        'type_id2' => 'number|gt:0',
        'user_id' => 'number|gt:0',
        'shop_id' => 'number|gt:0',
        'add_time' => 'require|number|gt:0',
        'update_time' => 'require|number|gt:0',
    ];

    protected $message = [
        'id.require' => 'ID不能为空',
        'id.number' => 'ID必须是数字',
        'id.gt' => 'ID格式不正确',
        'type_id.require' => '栏目ID不能为空',
        'type_id.egt' => '栏目ID格式不正确',
        'tuijian.number' => '推荐等级必须是数字',
        'tuijian.egt' => '推荐等级格式不正确',
        'click.number' => '点击量必须是数字',
        'click.egt' => '点击量格式不正确',
        'title.require' => '标题不能为空',
        'title.max' => '标题不能超过150个字符',
        'writer.max' => '作者不能超过20个字符',
        'source.max' => '来源不能超过30个字符',
        'litpic.max' => '缩略图不能超过150个字符',
        'seotitle.max' => 'SEO标题不能超过150个字符',
        'keywords.max' => '关键词不能超过60个字符',
        'description.max' => '描述不能超过250个字符',
        'status.in' => '审核状态：0正常，1未审核',
        'type_id2.number' => '栏目ID必须是数字',
        'type_id2.egt' => '栏目ID格式不正确',
        'user_id.number' => '发布者ID必须是数字',
        'user_id.egt' => '发布者ID格式不正确',
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
        'add' => ['type_id', 'tuijian', 'click', 'title', 'writer', 'source', 'litpic', 'keywords', 'seotitle', 'description', 'status', 'type_id2', 'user_id', 'shop_id', 'add_time', 'update_time'],
        'edit' => ['type_id', 'tuijian', 'click', 'title', 'writer', 'source', 'litpic', 'keywords', 'seotitle', 'description', 'status', 'type_id2', 'user_id', 'shop_id', 'add_time', 'update_time'],
        'del' => ['id'],
    ];
}