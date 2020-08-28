<?php

namespace app\common\logic;

use think\facade\Validate;
use app\common\validate\Sysconfig as SysconfigValidate;
use think\exception\ValidateException;
use app\common\lib\ReturnData;
use app\common\model\Sysconfig;

class SysconfigLogic extends BaseLogic
{
    protected function initialize()
    {
        parent::initialize();
    }

    public function getModel()
    {
        return new Sysconfig();
    }

    public function getValidate()
    {
        return new SysconfigValidate();
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

        /* $check = $this->getValidate()->scene('add')->check($data);
        if (!$check) {
            return ReturnData::create(ReturnData::PARAMS_ERROR, null, $this->getValidate()->getError());
        } */

        try {
            validate(SysconfigValidate::class)->scene('add')->check($data);
        } catch (ValidateException $e) {
            // 验证失败 输出错误信息
            return ReturnData::create(ReturnData::PARAMS_ERROR, null, $e->getError());
        }

        //判断名称
        if (isset($data['varname']) && !empty($data['varname'])) {
            if ($this->getModel()->getOne(['varname' => $data['varname']])) {
                return ReturnData::create(ReturnData::PARAMS_ERROR, null, '名称已经存在');
            }
        }

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

        /* $check = $this->getValidate()->scene('edit')->check($data);
        if (!$check) {
            return ReturnData::create(ReturnData::PARAMS_ERROR, null, $this->getValidate()->getError());
        } */
		try {
            validate(SysconfigValidate::class)->scene('edit')->check($data);
        } catch (ValidateException $e) {
            // 验证失败 输出错误信息
            return ReturnData::create(ReturnData::PARAMS_ERROR, null, $e->getError());
        }

        $record = $this->getModel()->getOne($where);
        if (!$record) {
            return ReturnData::create(ReturnData::RECORD_NOT_EXIST);
        }

        //判断名称
        if (isset($data['varname']) && !empty($data['varname'])) {
            $where2[] = ['varname', '=', $data['varname']];
            $where2[] = ['id', '<>', $record['id']]; //排除自身
            if ($this->getModel()->getOne($where2)) {
                return ReturnData::create(ReturnData::PARAMS_ERROR, null, '名称已经存在');
            }
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
            validate(SysconfigValidate::class)->scene('del')->check($where);
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
     * 数据获取器
     * @param array $data 要转化的数据
     * @return array
     */
    private function getDataView($data = array())
    {
        return getDataAttr($this->getModel(), $data);
    }
}