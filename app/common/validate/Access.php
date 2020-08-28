<?php

namespace app\common\validate;

class Access extends Base
{
	// 验证规则
    protected $rule = [
        'id' => 'require|number|gt:0',
        'role_id' => 'require|number|gt:0',
        'menu_id' => 'require|number|gt:0',
    ];

    protected $message = [
        'id.require' => 'ID不能为空',
        'id.number' => 'ID必须是数字',
        'id.gt' => 'ID格式不正确',
        'role_id.require' => '角色ID不能为空',
        'role_id.number' => '角色ID必须是数字',
        'role_id.gt' => '角色ID格式不正确',
        'menu_id.require' => '菜单ID不能为空',
        'menu_id.number' => '菜单ID必须是数字',
        'menu_id.gt' => '菜单ID格式不正确',
    ];

    protected $scene = [
        'add' => ['role_id', 'menu_id'],
        'edit' => ['role_id', 'menu_id'],
        'del' => ['id'],
    ];
}