<?php

namespace app\common\logic;

use think\facade\Validate;
use app\common\validate\Admin as AdminValidate;
use think\exception\ValidateException;
use app\common\lib\ReturnData;
use app\common\model\Admin;

class AdminLogic extends BaseLogic
{
    protected function initialize()
    {
        parent::initialize();
    }

    public function getModel()
    {
        return new Admin();
    }

    public function getValidate()
    {
        return validate(AdminValidate::class);
    }

    //列表
    public function getList($where = array(), $order = '', $field = '*', $offset = 0, $limit = 15)
    {
        $res = $this->getModel()->getList($where, $order, $field, $offset, $limit);

        if ($res['list']) {
            foreach ($res['list'] as $k => $v) {
                //$res['list'][$k] = $this->getDataView($v);
            }
        }

        return $res;
    }

    //分页html
    public function getPaginate($where = array(), $order = '', $field = '*', $limit = 15)
    {
        $res = $this->getModel()->getPaginate($where, $order, $field, $limit);

        $res = $res->each(function ($item, $key) {
            //$item = $this->getDataView($item);
            return $item;
        });

        return $res;
    }

    //全部列表
    public function getAll($where = array(), $order = '', $field = '*', $limit = '')
    {
        $res = $this->getModel()->getAll($where, $order, $field, $limit);

        /* if($res)
        {
            foreach($res as $k=>$v)
            {
                //$res[$k] = $this->getDataView($v);
            }
        } */

        return $res;
    }

    //详情
    public function getOne($where = array(), $field = '*')
    {
        $res = $this->getModel()->getOne($where, $field);
        if (!$res) {
            return false;
        }

        //$res = $this->getDataView($res);

        return $res;
    }

    //添加
    public function add($data = array(), $type = 0)
    {
        if (empty($data)) {
            return ReturnData::create(ReturnData::PARAMS_ERROR);
        }

        try {
            $this->getValidate()->scene('add')->check($data);
        } catch (ValidateException $e) {
            // 验证失败 输出错误信息
            return ReturnData::create(ReturnData::PARAMS_ERROR, null, $e->getError());
        }

        if (!isset($data['add_time'])) {
            $data['add_time'] = $data['update_time'] = time();
        }

        //判断用户名
        if (isset($data['name']) && !empty($data['name'])) {
            if ($this->getModel()->getOne(['name' => $data['name'], 'delete_time' => 0])) {
                return ReturnData::create(ReturnData::PARAMS_ERROR, null, '用户名已经存在');
            }
        }

        //判断手机号码
        if (isset($data['mobile']) && !empty($data['mobile'])) {
            if ($this->getModel()->getOne(['mobile' => $data['mobile'], 'delete_time' => 0])) {
                return ReturnData::create(ReturnData::PARAMS_ERROR, null, '手机号码已经存在');
            }
        }

        //判断邮箱
        if (isset($data['email']) && !empty($data['email'])) {
            if ($this->getModel()->getOne(['email' => $data['email'], 'delete_time' => 0])) {
                return ReturnData::create(ReturnData::PARAMS_ERROR, null, '邮箱已经存在');
            }
        }

        $data['pwd'] = md5($data['pwd']);

        $res = $this->getModel()->add($data, $type);
        if (!$res) {
            return ReturnData::create(ReturnData::FAIL);
        }

        return ReturnData::create(ReturnData::SUCCESS, $res);
    }

    //修改
    public function edit($data, $where = array())
    {
        if (empty($data)) {
            return ReturnData::create(ReturnData::SUCCESS);
        }

        try {
            $this->getValidate()->scene('edit')->check($data);
        } catch (ValidateException $e) {
            // 验证失败 输出错误信息
            return ReturnData::create(ReturnData::PARAMS_ERROR, null, $e->getError());
        }

        if (!isset($data['update_time'])) {
            $data['update_time'] = time();
        }

        $admin = $this->getModel()->getOne($where);
        if (!$admin) {
            return ReturnData::create(ReturnData::RECORD_NOT_EXIST);
        }

        //判断用户名
        if (isset($data['name']) && !empty($data['name'])) {
			$where2[] = ['delete_time', '=', 0];
			$where2[] = ['name', '=', $data['name']];
            $where2[] = ['id', '<>', $admin['id']]; //排除自身
            if ($this->getModel()->getOne($where2)) {
                return ReturnData::create(ReturnData::PARAMS_ERROR, null, '用户名已经存在');
            }
        }

        //判断手机号码
        if (isset($data['mobile']) && !empty($data['mobile'])) {
			$where3[] = ['delete_time', '=', 0];
			$where3[] = ['mobile', '=', $data['mobile']];
            $where3[] = ['id', '<>', $admin['id']]; //排除自身
            if ($this->getModel()->getOne($where3)) {
                return ReturnData::create(ReturnData::PARAMS_ERROR, null, '手机号码已经存在');
            }
        }

        //判断邮箱
        if (isset($data['email']) && !empty($data['email'])) {
			$where4[] = ['delete_time', '=', 0];
			$where4[] = ['email', '=', $data['email']];
            $where4[] = ['id', '<>', $admin['id']]; //排除自身
            if ($this->getModel()->getOne($where4)) {
                return ReturnData::create(ReturnData::PARAMS_ERROR, null, '邮箱已经存在');
            }
        }

        if (isset($data['pwd']) && !empty($data['pwd'])) {
            $data['pwd'] = md5($data['pwd']);
        } else {
            unset($data['pwd']);
        }

        $res = $this->getModel()->edit($data, $where);
        if (!$res) {
            return ReturnData::create(ReturnData::FAIL);
        }

        return ReturnData::create(ReturnData::SUCCESS, $res);
    }

    //删除
    public function del($where)
    {
        if (empty($where)) {
            return ReturnData::create(ReturnData::PARAMS_ERROR);
        }

        try {
            $this->getValidate()->scene('del')->check($where);
        } catch (ValidateException $e) {
            // 验证失败 输出错误信息
            return ReturnData::create(ReturnData::PARAMS_ERROR, null, $e->getError());
        }

        $res = $this->getModel()->del($where);
        if (!$res) {
            return ReturnData::create(ReturnData::FAIL);
        }

        return ReturnData::create(ReturnData::SUCCESS, $res);
    }

    /**
     * 登录
     * @param string $data ['name'] 用户名
     * @param string $data ['pwd'] 密码
     * @return array
     */
    public function login($data)
    {
		// 验证数据
		$validate = Validate::rule([
            'name' => 'require|max:30',
            'pwd' => 'require|max:30',
        ])->message([
			'name.require' => '用户名不能为空',
			'name.max' => '用户名不能超过30个字符',
			'pwd.require' => '密码不能为空',
			'pwd.max' => '密码格式不正确',
		]);
		if (!$validate->check($_POST)) {
			return ReturnData::create(ReturnData::FAIL, null, $validate->getError());
		}

        $name = $data['name'];
        $pwd = md5($data['pwd']);

        //用户名/邮箱/手机登录
        $map1 = [
            ['name', '=', $name],
            ['pwd', '=', $pwd],
            ['delete_time', '=', 0],
        ];
        $map2 = [
            ['email', '=', $name],
            ['pwd', '=', $pwd],
            ['delete_time', '=', 0],
        ];
        $map3 = [
            ['mobile', '=', $name],
            ['pwd', '=', $pwd],
            ['delete_time', '=', 0],
        ];

        $admin = db('admin')->whereOr([$map1, $map2, $map3])->withAttr('status_text', function ($value, $data) {
            $admin_status_desc = Admin::$admin_status_desc;
            return $admin_status_desc[$data['status']];
        })->withAttr('role_name', function ($value, $data) {
            return model('AdminRole')->getFieldValue(['id' => $data['role_id']], 'name');
        })->find();

        if (!$admin) {
            return ReturnData::create(ReturnData::FAIL, null, '登录名或密码错误');
        }

        //$admin['role_name'] = model('AdminRole')->getValue(['id'=>$admin['role_id']], 'name');
        //更新登录时间
        $this->getModel()->edit(['login_time' => time()], ['id' => $admin['id']]);

        return ReturnData::create(ReturnData::SUCCESS, $admin);
    }

    /**
     * 数据获取器
     * @param array $data 要转化的数据
     * @return array
     */
    private function getDataView($data = array())
    {
        return getDataAttr($this->getModel(), $data);
    }
}