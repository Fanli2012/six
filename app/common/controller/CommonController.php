<?php
declare (strict_types=1);

namespace app\common\controller;

use think\App;
use think\exception\ValidateException;
use think\Validate;
// 下面2行，为了使用旧版的 success error redirect 跳转
use think\exception\HttpResponseException;
use think\facade\Request;

/**
 * 控制器基础类
 */
abstract class CommonController
{
    /**
     * Request实例
     * @var \think\Request
     */
    protected $request;

    /**
     * 应用实例
     * @var \think\App
     */
    protected $app;

    /**
     * 是否批量验证
     * @var bool
     */
    protected $batchValidate = false;

    /**
     * 控制器中间件
     * @var array
     */
    protected $middleware = [];

    /**
     * 构造方法
     * @access public
     * @param  App $app 应用对象
     */
    public function __construct(App $app)
    {
        $this->app = $app;
        $this->request = $this->app->request;

        // 控制器初始化
        $this->initialize();
    }

    // 初始化
    protected function initialize()
    {
    }

    /**
     * 验证数据
     * @access protected
     * @param  array $data 数据
     * @param  string|array $validate 验证器名或者验证规则数组
     * @param  array $message 提示信息
     * @param  bool $batch 是否批量验证
     * @return array|string|true
     * @throws ValidateException
     */
    protected function validate(array $data, $validate, array $message = [], bool $batch = false)
    {
        if (is_array($validate)) {
            $v = new Validate();
            $v->rule($validate);
        } else {
            if (strpos($validate, '.')) {
                // 支持场景
                [$validate, $scene] = explode('.', $validate);
            }
            $class = false !== strpos($validate, '\\') ? $validate : $this->app->parseClass('validate', $validate);
            $v = new $class();
            if (!empty($scene)) {
                $v->scene($scene);
            }
        }

        $v->message($message);

        // 是否批量验证
        if ($batch || $this->batchValidate) {
            $v->batch(true);
        }

        return $v->failException(true)->check($data);
    }

    // 以下为新增，为了使用旧版的 success error 跳转 start
    /**
     * 操作成功跳转的快捷方法
     * @access protected
     * @param  mixed $msg 提示信息
     * @param  string $url 跳转的URL地址
     * @param  mixed $data 返回的数据
     * @param  integer $wait 跳转等待时间
     * @param  array $header 发送的Header信息
     * @return void
     */
    protected function success($msg = '', string $url = null, $data = '', int $wait = 1, array $header = [])
    {
        if (is_null($url) && isset($_SERVER["HTTP_REFERER"])) {
            $url = $_SERVER["HTTP_REFERER"];
        } elseif ($url) {
            $url = (strpos($url, '://') || 0 === strpos($url, '/')) ? $url : app('route')->buildUrl($url);
        }

        $result = [
            'code' => 1,
            'msg' => $msg,
            'data' => $data,
            'url' => $url,
            'wait' => $wait,
        ];

        $type = $this->getResponseType();
        if ($type == 'html') {
            $response = view(app()->getRootPath() . 'view/common/tpl/dispatch_jump.tpl', $result);
        } else if ($type == 'json') {
            $response = json($result);
        }
        throw new HttpResponseException($response);
    }

    /**
     * 操作错误跳转的快捷方法
     * @access protected
     * @param  mixed $msg 提示信息
     * @param  string $url 跳转的URL地址
     * @param  mixed $data 返回的数据
     * @param  integer $wait 跳转等待时间
     * @param  array $header 发送的Header信息
     * @return void
     */
    protected function error($msg = '', string $url = null, $data = '', int $wait = 3, array $header = [])
    {
        if (is_null($url)) {
            $url = 'javascript:history.back(-1);';
            if ($this->request) {
                $url = $this->request->isAjax() ? '' : 'javascript:history.back(-1);';
            }
        } elseif ($url) {
            $url = (strpos($url, '://') || 0 === strpos($url, '/')) ? $url : $this->app->route->buildUrl($url);
        }

        $result = [
            'code' => 0,
            'msg' => $msg,
            'data' => $data,
            'url' => $url,
            'wait' => $wait,
        ];

        $type = $this->getResponseType();
        if ($type == 'html') {
            $response = view(app()->getRootPath() . 'view/common/tpl/dispatch_jump.tpl', $result);
        } else if ($type == 'json') {
            $response = json($result);
        }
        throw new HttpResponseException($response);
    }

    /**
     * 获取当前的response输出类型
     * @access protected
     * @return string
     */
    protected function getResponseType()
    {
		if ($this->request) {
			return $this->request->isJson() || $this->request->isAjax() ? 'json' : 'html';
		}
		return 'html';
    }
    // 以上为新增，为了使用旧版的 success error redirect 跳转 end
}
