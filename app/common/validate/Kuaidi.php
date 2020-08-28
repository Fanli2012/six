<?php

namespace app\common\validate;

class Kuaidi extends Base
{
    // 验证规则
    protected $rule = [
        'id' => 'require|number|gt:0',
        'name' => 'require|max:30',
        'code' => 'require|max:20',
        'money' => 'require|regex:/^\d{0,10}(\.\d{0,2})?$/',
        'country' => 'max:20',
        'desc' => 'max:150',
        'tel' => 'max:60',
        'website' => 'max:60',
        'listorder' => 'number|max:11',
        'status' => 'in:0,1',
    ];

    protected $message = [
        'id.require' => 'ID不能为空',
        'id.number' => 'ID必须是数字',
        'id.gt' => 'ID格式不正确',
        'name.require' => '快递公司名称不能为空',
        'name.max' => '快递公司名称不能超过30个字符',
        'code.require' => '公司编码不能为空',
        'code.max' => '公司编码不能超过20个字符',
        'money.require' => '快递费不能为空',
        'money.regex' => '快递费只能带2位小数的数字',
        'country.max' => '国家编码不能超过20个字符',
        'desc.max' => '说明不能超过150个字符',
        'tel.max' => '电话不能超过60个字符',
        'website.max' => '官网不能超过60个字符',
        'listorder.number' => '排序必须是数字',
        'listorder.max' => '排序格式不正确',
        'status.in' => '是否显示，0显示',
    ];

    protected $scene = [
        'add' => ['name', 'code', 'money', 'country', 'desc', 'tel', 'website', 'listorder', 'status'],
        'edit' => ['name', 'code', 'money', 'country', 'desc', 'tel', 'website', 'listorder', 'status'],
        'del' => ['id'],
    ];
}