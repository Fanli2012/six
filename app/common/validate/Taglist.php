<?php

namespace app\common\validate;

class Taglist extends Base
{
    // 验证规则
    protected $rule = [
        'id' => 'require|number|gt:0',
        'tag_id' => 'require|number|gt:0',
        'article_id' => 'require|number|gt:0',
    ];
	
	protected $message = [
        'id.require' => 'ID不能为空',
        'id.number' => 'ID必须是数字',
        'id.gt' => 'ID格式不正确',
        'tag_id.require' => 'Tag ID不能为空',
        'tag_id.number' => 'Tag ID必须是数字',
        'tag_id.gt' => 'Tag ID格式不正确',
        'article_id.require' => '文章ID不能为空',
        'article_id.number' => '文章ID必须是数字',
        'article_id.gt' => '文章ID格式不正确',
    ];

    protected $scene = [
        'add' => ['tag_id', 'article_id'],
        'edit' => ['tag_id', 'article_id'],
        'del' => ['id'],
    ];
}