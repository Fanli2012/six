<?php

namespace app\common\validate;

use app\common\lib\Helper;
use app\common\lib\Validator;

class VerifyCode extends Base
{
    // 验证规则
    protected $rule = [
        'id' => 'require|number|gt:0',
        'code' => 'require|max:10|number',
        'type' => 'require|number|in:0,1,2,3,4,5,6,7,8,9',
        'mobile' => 'require|max:20|checkPhone',
        'status' => 'number|in:0,1',
        'expire_time' => 'require|number|egt:0',
        'captcha' => 'equire|checkCaptcha',
        'add_time' => 'require|number|gt:0',
    ];
    
    protected $message = [
        'id.require' => 'ID不能为空',
        'id.number' => 'ID必须是数字',
        'id.gt' => 'ID格式不正确',
        'code.require' => '验证码不能为空',
        'code.number' => '验证码格式不正确',
        'code.max' => '验证码不能超过10个字符',
        'type.require' => '验证码类型不能为空',
        'type.number' => '验证码类型格式不正确',
        'type.in' => '0通用，注册，1:手机绑定业务验证码，2:密码修改业务验证码',
        'mobile.require' => '手机号不能为空',
        'mobile.max' => '手机号不能超过20个字符',
        'status.number' => '验证码状态格式不正确',
        'status.in' => '0:未使用 1:已使用',
        'captcha.require' => '验证码不能为空',
        'expire_time.require' => '过期时间不能为空',
        'expire_time.number' => '过期时间格式不正确',
        'expire_time.gt' => '过期时间格式不正确',
        'add_time.require' => '添加时间不能为空',
        'add_time.number' => '添加时间格式不正确',
        'add_time.gt' => '添加时间格式不正确',
    ];

    protected $scene = [
        'add' => ['code', 'type', 'mobile', 'add_time', 'expire_time'],
        'edit' => ['code', 'type', 'mobile', 'add_time', 'expire_time'],
        'del' => ['id'],
        'get_smscode_by_smsbao' => ['mobile', 'type'],
        'check' => ['code', 'mobile', 'type'],
    ];

    /**
     * 手机号码验证
     * 参数依次为验证数据，验证规则，全部数据(数组)，字段名
     */
    protected function checkPhone($value, $rule, $data, $field)
    {
        if (Validator::isMobile($value)) {
            return true;
        }

        return '手机号码格式不正确';
    }

    // 图形验证码验证
    protected function checkCaptcha($value)
    {
        if (!captcha_check($value)) {
            return '图形验证码错误';
        }

        return true;
    }
}