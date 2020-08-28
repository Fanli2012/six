<?php

namespace app\common\validate;

use think\Validate;
use app\common\lib\Helper;
use app\common\lib\Validator;

class UserRank extends Validate
{
    // 验证规则
    protected $rule = [
        'id' => 'require|number|gt:0',
        'title' => 'require|max:30',
        'min_points' => 'require|number|egt:0',
        'max_points' => 'require|number|egt:0|gt:min_points',
        'discount' => 'require|number|between:0,100',
        'rank' => 'require|number|gt:0',
        'listorder' => 'number|egt:0',
    ];

	protected $message = [
        'id.require' => 'ID不能为空',
        'id.number' => 'ID必须是数字',
        'id.gt' => 'ID格式不正确',
        'title.require' => '会员等级名称不能为空',
        'title.max' => '会员等级名称不能超过30个字符',
        'min_points.require' => '等级的最低积分不能为空',
        'min_points.number' => '等级的最低积分必须是数字',
        'min_points.egt' => '等级的最低积分格式不正确',
        'max_points.require' => '等级的最高积分不能为空',
        'max_points.number' => '等级的最高积分必须是数字',
        'max_points.egt' => '等级的最高积分格式不正确',
        'max_points.gt' => '最高积分应大于最低积分',
        'discount.require' => '会员等级的商品折扣不能为空',
        'discount.number' => '会员等级的商品折扣格式不正确',
        'discount.between' => '会员等级的商品折扣格式不正确',
        'rank.require' => '会员等级不能为空',
        'rank.number' => '会员等级格式不正确',
        'rank.gt' => '会员等级要大于0',
        'listorder.number' => '排序格式不正确',
        'listorder.egt' => '排序格式不正确',
    ];

    protected $scene = [
        'add' => ['title', 'min_points', 'max_points', 'discount', 'rank', 'listorder'],
        'edit' => ['title', 'min_points', 'max_points', 'discount', 'rank', 'listorder'],
        'del' => ['user_id'],
    ];
}