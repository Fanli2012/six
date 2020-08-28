<?php

namespace app\common\validate;

use app\common\lib\Helper;
use app\common\lib\Validator;

class Shop extends Base
{
    // 验证规则
    protected $rule = [
        'id' => 'require|number|gt:0',
        'email' => 'require|max:20|email',
        'user_name' => 'require|max:60',
        'password' => 'require|max:20|checkPWD',
        'old_password' => 'require|max:20',
        're_password' => 'require|max:20|confirm:password',
        'pay_password' => 'max:20',
        'introduction' => 'max:100',
        'mobile' => 'require|max:20|checkPhone',
        'status' => 'number|in:0,1,2,3',
        'openid' => 'max:100',
        'consumption_money' => 'regex:/^\d{0,10}(\.\d{0,2})?$/',
        'annual_fee' => 'regex:/^\d{0,10}(\.\d{0,2})?$/',
        'cover_img' => 'max:250',
        'proxy_id' => 'number',
        'province_id' => 'number',
        'city_id' => 'number',
        'district_id' => 'number',
        'address' => 'max:150',
        'point_lng' => 'regex:/^\d{0,4}(\.\d{0,6})?$/',
        'point_lat' => 'regex:/^\d{0,4}(\.\d{0,6})?$/',
        'head_img' => 'max:250',
        'wechat' => 'max:20',
        'qq' => 'max:20',
        'company_name' => 'max:100',
        'business_license_img' => 'max:250',
        'industry_id' => 'number',
        'click' => 'number|egt:0',
        'website' => 'max:100',
        'contact' => 'max:30',
        'contact_information' => 'max:30',
        'business_license_no' => 'max:20',
        'zipcode' => 'max:10',
        'fax' => 'max:20',
        'expire_time' => 'number|egt:0',
        'main_product' => 'max:100',
        'zhiwu' => 'max:20',
        'qrcode' => 'max:150',
        'category_id' => 'require|number|gt:0',
        'captcha' => 'require|checkCaptcha',
        'smscode' => 'require|checkSmsCode',
        'smstype' => 'require|number|egt:0',
        'signature' => 'max:60',
        'add_time' => 'require|number|gt:0',
        'update_time' => 'require|number|gt:0',
    ];
	
	protected $message = [
        'id.require' => 'ID不能为空',
        'id.number' => 'ID必须是数字',
        'id.gt' => 'ID格式不正确',
        'email.require' => '邮箱不能为空',
        'email.max' => '邮箱不能超过30个字符',
        'email.email' => '邮箱格式不正确',
        'user_name.require' => '用户名不能为空',
        'user_name.max' => '用户名不能超过60个字符',
        'password.require' => '密码不能为空',
        'password.max' => '密码不能超过20个字符',
        'old_password.require' => '密码不能为空',
        'old_password.max' => '密码不能超过20个字符',
        're_password.require' => '确认密码不能为空',
        're_password.max' => '确认密码不能超过20个字符',
        're_password.confirm' => '密码与确认密码不一致',
        'pay_password.max' => '支付密码不能超过20个字符',
        'introduction.max' => '简介不能超过100个字符',
        'mobile.require' => '手机号不能为空',
        'mobile.max' => '手机号不能超过20个字符',
        'status.number' => '用户状态必须是数字',
        'status.in' => '用户状态，0待审，1正常，2锁定',
        'openid.max' => 'openid不能超过100个字符',
        'consumption_money.regex' => '累计消费金额只能带2位小数的数字',
        'annual_fee.regex' => '年费只能带2位小数的数字',
        'cover_img.max' => '封面不能超过250个字符',
        'proxy_id.number' => '代理商id必须是数字',
        'province_id.number' => '省id必须是数字',
        'city_id.number' => '市id必须是数字',
        'district_id.number' => '区id必须是数字',
        'address.max' => '详细地址不能超过150个字符',
        'point_lng.regex' => '经度格式不正确',
        'point_lat.regex' => '纬度格式不正确',
        'head_img.max' => '头像不能超过250个字符',
        'wechat.max' => '微信号不能超过20个字符',
        'qq.max' => 'QQ不能超过20个字符',
        'company_name.max' => '公司名称不能超过100个字符',
        'business_license_img.max' => '营业执照不能超过250个字符',
        'industry_id.number' => '行业id必须是数字',
        'click.number' => '点击量必须是数字',
        'click.egt' => '点击量格式不正确',
        'website.max' => '官网不能超过100个字符',
        'contact.max' => '联系人不能超过30个字符',
        'contact_information.max' => '联系方式不能超过30个字符',
        'business_license_no.max' => '营业执照号不能超过20个字符',
        'zipcode.max' => '邮编不能超过10个字符',
        'fax.max' => '传真不能超过20个字符',
        'expire_time.number' => '过期时间格式不正确',
        'expire_time.egt' => '过期时间格式不正确',
        'main_product.max' => '主营产品或服务不能超过100个字符',
        'zhiwu.max' => '职务不能超过20个字符',
        'qrcode.max' => '二维码不能超过150个字符',
        'category_id.require' => '类目不能为空',
        'category_id.number' => '类目必须是数字',
        'category_id.gt' => '类目格式不正确',
        'captcha.require' => '图形验证码不能为空',
        'smscode.require' => '短信验证码不能为空',
        'smstype.require' => '短信验证码类型不能为空',
        'smstype.number' => '短信验证码类型格式不正确',
        'smstype.egt' => '短信验证码类型格式不正确',
        'signature.max' => '签名不能超过60个字符',
        'add_time.require' => '添加时间不能为空',
        'add_time.number' => '添加时间格式不正确',
        'add_time.gt' => '添加时间格式不正确',
        'update_time.require' => '更新时间不能为空',
        'update_time.number' => '更新时间格式不正确',
        'update_time.gt' => '更新时间格式不正确',
    ];

    protected $scene = [
        'add' => ['user_name', 'password', 'introduction', 'status', 'annual_fee', 'cover_img', 'proxy_id', 'province_id', 'city_id', 'district_id', 'address', 'point_lng', 'point_lat', 'head_img', 'company_name', 'business_license_img', 'industry_id', 'click', 'website', 'contact', 'contact_information', 'expire_time', 'signature'],
        'edit' => ['introduction', 'status', 'annual_fee', 'cover_img', 'proxy_id', 'province_id', 'city_id', 'district_id', 'address', 'point_lng', 'point_lat', 'head_img', 'company_name', 'business_license_img', 'industry_id', 'click', 'website', 'contact', 'contact_information', 'expire_time', 'signature'],
        'setting' => ['business_license_no', 'zipcode', 'fax', 'zhiwu', 'qrcode', 'category_id'=>'number|>:0', 'introduction', 'proxy_id', 'province_id', 'city_id', 'district_id', 'address', 'point_lng', 'point_lat', 'head_img', 'company_name', 'business_license_img', 'industry_id', 'click', 'website', 'contact', 'contact_information', 'expire_time', 'signature'],
        'del' => ['id'],
        'mobile_reg' => ['mobile', 'password', 're_password', 'smscode', 'smstype'],
        'email_reg' => ['email', 'password', 're_password', 'smscode', 'smstype'],
        'resetpwd' => ['mobile', 'password', 're_password', 'smscode', 'smstype'],
        'change_password' => ['password', 're_password', 'old_password'],
    ];

    // 图形验证码验证
    protected function checkCaptcha($value)
    {
        if (!captcha_check($value)) {
            return '图形验证码错误';
        }

        return true;
    }

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

    /**
     * 邮箱验证
     * 参数依次为验证数据，验证规则，全部数据(数组)，字段名
     */
    protected function checkEmail($value, $rule, $data, $field)
    {
        if (Validator::isEmail($value)) {
            return true;
        }

        return '邮箱格式不正确';
    }

    // 邮箱验证码验证
    protected function checkEmailCode($value, $rule, $data)
    {
        $verifyCode = model('EmailVerifyCode')->isVerify(['email' => $data['email'], 'type' => $data['smstype'], 'code' => $value]);
        if (!$verifyCode) {
            return '邮箱验证码不正确或已过期';
        }

        return true;
    }

    // 短信验证码验证
    protected function checkSmsCode($value, $rule, $data)
    {
        $verifyCode = model('VerifyCode')->isVerify(['mobile' => $data['mobile'], 'type' => $data['smstype'], 'code' => $value]);
        if (!$verifyCode) {
            return '短信验证码不正确或已过期';
        }

        return true;
    }

    /**
     * 密码验证
     * 参数依次为验证数据，验证规则，全部数据(数组)，字段名
     */
    protected function checkPWD($value, $rule, $data, $field)
    {
        if (Validator::isPWD($value)) {
            return true;
        }

        return '密码格式不正确';
    }

}