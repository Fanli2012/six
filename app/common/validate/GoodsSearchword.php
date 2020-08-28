<?php

namespace app\common\validate;

class GoodsSearchword extends Base
{
    // 验证规则
    protected $rule = [
        'id' => 'require|number|gt:0',
        'name' => 'require|max:30',
        'click' => 'number|egt:0',
        'listorder' => 'number|egt:0',
        'status' => 'in:0,1',
        'add_time' => 'require|number|gt:0',
    ];

	protected $message = [
        'id.require' => 'ID不能为空',
        'id.number' => 'ID必须是数字',
        'id.gt' => 'ID格式不正确',
        'name.require' => '搜索词不能为空',
        'name.max' => '搜索词不能超过30个字符',
        'click.number' => '点击量必须是数字',
        'click.egt' => '点击量格式不正确',
        'listorder.number' => '排序必须是数字',
        'listorder.egt' => '排序格式不正确',
        'status.in' => '状态：0正常，1禁用',
        'add_time.number' => '添加时间格式不正确',
        'add_time.gt' => '添加时间格式不正确',
    ];

    protected $scene = [
        'add' => ['name', 'click', 'listorder', 'status', 'add_time'],
        'edit' => ['name', 'click', 'listorder', 'status'],
        'del' => ['id'],
    ];
}