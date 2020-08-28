<?php

namespace app\common\validate;

class Menu extends Base
{
    // 验证规则
    protected $rule = [
        'id' => 'require|number|gt:0',
        'parent_id' => 'number|egt:0',
        'module' => 'require|alphaDash|max:50',
        'controller' => 'require|alphaDash|max:50',
        'action' => 'require|alphaDash|max:50',
        'data' => 'max:50',
        'type' => 'number|in:0,1',
        'name' => 'require|max:50',
        'icon' => 'max:50',
        'des' => 'max:250',
        'listorder' => 'number|egt:0',
        'status' => 'in:0,1',
    ];
    
    protected $message = [
        'id.require' => 'ID不能为空',
        'id.number' => 'ID必须是数字',
        'id.gt' => 'ID格式不正确',
        'parent_id.number' => '父级ID必须是数字',
        'parent_id.egt' => '父级ID格式不正确',
        'module.require' => '模型不能为空',
        'module.alphaDash' => '模型格式不正确',
        'module.max' => '模型不能超过50个字符',
        'controller.require' => '控制器不能为空',
        'controller.alphaDash' => '控制器格式不正确',
        'controller.max' => '控制器不能超过50个字符',
        'action.require' => '方法不能为空',
        'action.alphaDash' => '方法格式不正确',
        'action.max' => '方法不能超过50个字符',
        'data.max' => '额外参数不能超过50个字符',
        'type.number' => '菜单类型必须是数字',
        'type.in' => '菜单类型，1：权限认证+菜单；0：只作为菜单',
        'name.require' => '名称不能为空',
        'name.max' => '名称不能超过50个字符',
        'icon.max' => '菜单图标不能超过50个字符',
        'des.max' => '备注不能超过250个字符',
        'listorder.number' => '排序必须是数字',
        'listorder.egt' => '排序格式不正确',
        'status.in' => '状态，1显示，0不显示',
    ];

    protected $scene = [
        'add' => ['parent_id', 'module', 'controller', 'action', 'data', 'type', 'name', 'icon', 'des', 'listorder', 'status'],
        'edit' => ['parent_id', 'module', 'controller', 'action', 'data', 'type', 'name', 'icon', 'des', 'listorder', 'status'],
        'del' => ['id'],
    ];
}