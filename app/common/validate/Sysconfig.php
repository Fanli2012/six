<?php

namespace app\common\validate;

class Sysconfig extends Base
{
    protected function initialize()
    {
        parent::initialize();
    }

    // 验证规则
    protected $rule = [
        'id' => 'require|number|gt:0',
        'varname' => 'require|max:60|check_varname',
        'info' => 'require|max:100',
        'value' => '',
    ];
    
    protected $message = [
        'id.require' => 'ID不能为空',
        'id.number' => 'ID必须是数字',
        'id.gt' => 'ID格式不正确',
        'varname.require' => '变量名不能为空',
        'varname.max' => '变量名不能超过60个字符',
        'info.require' => '变量值不能为空',
        'info.max' => '变量值不能超过100个字符',
        'value.require' => '变量说明不能为空',
    ];

    protected $scene = [
        'add' => ['varname', 'info'],
        'edit' => ['varname', 'info'],
        'del' => ['id'],
    ];

    /**
     * 变量名验证
     * 参数依次为验证数据，验证规则，全部数据(数组)，字段名
     */
    protected function check_varname($value, $rule, $data, $field)
    {
        if (preg_match("/^CMS_[A-Z_]+$/", $value)) {
            return true;
        }

        return '变量名格式不正确';
    }

}