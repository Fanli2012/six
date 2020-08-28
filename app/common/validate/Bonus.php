<?php

namespace app\common\validate;

use app\common\lib\Helper;
use app\common\lib\Validator;

class Bonus extends Base
{
    // 验证规则
    protected $rule = [
        'id' => 'require|number|gt:0',
        'name' => 'require|max:60',
        'money' => 'require|regex:/^\d{0,10}(\.\d{0,2})?$/|gt:0',
        'min_amount' => 'require|regex:/^\d{0,10}(\.\d{0,2})?$/|egt:money',
        'start_time' => 'require|number|gt:0',
        'end_time' => 'require|number|gt:start_time',
        'num' => 'require|number|max:11',
        'point' => 'number|egt:0',
        'status' => 'in:0,1',
        'add_time' => 'require|number|gt:0',
    ];
	
	protected $message = [
        'id.require' => 'ID不能为空',
        'id.number' => 'ID必须是数字',
        'id.gt' => 'ID格式不正确',
        'name.require' => '优惠券名称不能为空',
        'name.max' => '优惠券名称不能超过60个字符',
        'money.require' => '优惠券金额不能为空',
        'money.regex' => '优惠券金额格式不正确',
        'money.gt' => '优惠券金额必须大于0',
        'min_amount.require' => '满多少使用不能为空',
        'min_amount.regex' => '满多少使用格式不正确',
        'min_amount.egt' => '金额必须小于最低金额',
        'start_time.require' => '开始时间不能为空',
        'start_time.number' => '开始时间格式不正确',
        'start_time.gt' => '开始时间格式不正确',
        'end_time.require' => '结束时间不能为空',
        'end_time.number' => '结束时间格式不正确',
        'end_time.gt' => '开始时间必须小于结束时间',
        'num.require' => '优惠券数量不能为空',
        'num.number' => '优惠券数量必须是数字',
        'num.max' => '优惠券数量格式不正确',
        'point.number' => '兑换优惠券所需积分必须是数字',
        'point.egt' => '兑换优惠券所需积分格式不正确',
        'status.in' => '状态：0可用，1不可用',
        'add_time.require' => '添加时间不能为空',
        'add_time.number' => '添加时间格式不正确',
        'add_time.gt' => '添加时间格式不正确',
    ];

    protected $scene = [
        'add' => ['name', 'money', 'min_amount', 'start_time', 'end_time', 'num', 'point', 'status', 'add_time'],
        'edit' => ['name', 'money', 'min_amount', 'start_time', 'end_time', 'num', 'point', 'status'],
        'del' => ['id'],
    ];
}