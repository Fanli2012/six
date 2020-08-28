<?php

namespace app\common\validate;

class Category extends Base
{
    // 验证规则
    protected $rule = [
        'id' => 'require|number|gt:0',
        'parent_id' => 'number|egt:0',
        'name' => 'require|max:30',
        'seotitle' => 'max:150',
        'keywords' => 'max:60',
        'description' => 'max:250',
        'listorder' => 'number|egt:0',
        'litpic' => 'max:150',
        'add_time' => 'require|number|gt:0',
        'update_time' => 'require|number|gt:0',
    ];

    protected $message = [
        'id.require' => 'ID不能为空',
        'id.number' => 'ID必须是数字',
        'id.gt' => 'ID格式不正确',
        'parent_id.require' => '父级ID必须是数字',
        'parent_id.egt' => '父级ID格式不正确',
        'name.require' => '类目名称不能为空',
        'name.max' => '类目名称不能超过30个字符',
        'seotitle.max' => 'SEO标题不能超过150个字符',
        'keywords.max' => '关键词不能超过60个字符',
        'description.max' => '描述不能超过250个字符',
        'listorder.number' => '排序必须是数字',
        'listorder.egt' => '排序格式不正确',
        'litpic.max' => '封面或缩略图不能超过150个字符',
        'add_time.require' => '添加时间不能为空',
        'add_time.number' => '添加时间格式不正确',
        'add_time.gt' => '添加时间格式不正确',
        'update_time.require' => '更新时间不能为空',
        'update_time.number' => '更新时间格式不正确',
        'update_time.gt' => '更新时间格式不正确',
    ];

    protected $scene = [
        'add' => ['parent_id', 'name', 'seotitle', 'keywords', 'description', 'listorder', 'litpic'],
        'edit' => ['id', 'parent_id', 'name', 'seotitle', 'keywords', 'description', 'listorder', 'litpic'],
        'del' => ['id'],
    ];

    /**
     * 类目名称验证
     * 参数依次为验证数据，验证规则，全部数据(数组)，字段名
     */
    protected function checkCategoryNameUnique($value, $rule, $data, $field)
    {
		$where[] = ['name', '=', $value];
		$where[] = ['id', '<>', $data['id']];
        $res = model('Category')->getOne($where);
        if ($res) {
            return '该类目名称已经存在';
        }
        return true;
    }
}