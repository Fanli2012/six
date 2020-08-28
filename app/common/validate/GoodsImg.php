<?php

namespace app\common\validate;

class GoodsImg extends Base
{
    // 验证规则
    protected $rule = [
        'id' => 'require|number|gt:0',
        'goods_id' => 'require|number|gt:0',
        'url' => 'require|max:150',
        'des' => 'max:150',
        'listorder' => 'number|egt:0',
        'add_time' => 'require|number|egt:0',
    ];

	protected $message = [
        'id.require' => 'ID不能为空',
        'id.number' => 'ID必须是数字',
        'id.gt' => 'ID格式不正确',
        'goods_id.require' => '商品ID不能为空',
        'goods_id.number' => '商品ID必须是数字',
        'goods_id.gt' => '商品ID格式不正确',
        'url.require' => '图片地址不能为空',
        'url.max' => '图片地址不能超过150个字符',
        'des.max' => '描述不能超过150个字符',
        'listorder.number' => '排序必须是数字',
        'listorder.egt' => '排序格式不正确',
        'add_time.require' => '添加时间不能为空',
        'add_time.number' => '添加时间格式不正确',
        'add_time.gt' => '添加时间格式不正确',
    ];

    protected $scene = [
        'add' => ['goods_id', 'url', 'des', 'listorder', 'add_time'],
        'edit' => ['goods_id', 'url', 'des', 'listorder', 'add_time'],
        'del' => ['id'],
    ];
}