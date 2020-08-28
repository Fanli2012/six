<?php

namespace app\common\validate;

use app\common\lib\Helper;
use app\common\lib\Validator;

class UserMoney extends Base
{
    // 验证规则
    protected $rule = [
        'id' => 'require|number|gt:0',
        'user_id' => 'require|number|gt:0',
        'money' => 'require|regex:/^\d{0,10}(\.\d{0,2})?$/',
        'desc' => 'require|max:100',
        'user_money' => 'regex:/^\d{0,10}(\.\d{0,2})?$/',
        'type' => 'require|in:0,1',
        'add_time' => 'require|number|gt:0',
    ];
	
	protected $message = [
        'id.require' => 'ID不能为空',
        'id.number' => 'ID必须是数字',
        'id.gt' => 'ID格式不正确',
        'user_id.require' => '用户ID不能为空',
        'user_id.number' => '用户ID必须是数字',
        'user_id.gt' => '用户ID格式不正确',
        'money.require' => '金额不能为空',
        'money.regex' => '金额格式不正确',
        'desc.require' => '描述不能为空',
        'desc.max' => '描述格式不正确',
        'user_money.regex' => '余额格式不正确',
        'type.require' => '类型不能为空',
        'type.in' => '类型：0增加,1减少',
        'add_time.require' => '添加时间不能为空',
        'add_time.number' => '添加时间格式不正确',
        'add_time.gt' => '添加时间格式不正确',
    ];

    protected $scene = [
        'add' => ['user_id', 'money', 'desc', 'type'],
        'edit' => ['user_id', 'money', 'desc', 'type'],
        'del' => ['user_id'],
    ];
}