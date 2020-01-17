<?php

namespace app\admin\controller;

use learn\basic\admin\BaseController;
use think\facade\App;
use think\facade\Lang;
use think\facade\Session;

/**
 * 控制器基础类
 */
abstract class AuthController extends BaseController
{
    /**
     * 当前登陆管理员信息
     * @var
     */
    protected $adminInfo;

    /**
     * 当前登陆管理员ID
     * @var int
     */
    protected $adminId;

    /**
     * 当前管理员权限
     * @var array
     */
    protected $auth = [];

    /**
     * 无需登录的方法,同时也就不需要鉴权了
     * @var array
     */
    protected $noNeedLogin = [];

    /**
     * 无需鉴权的方法,但需要登录
     * @var array
     */
    protected $noNeedRight = [];

    /**
     * 当前模块
     * @var string
     */
    private $module = "";

    /**
     * 当前控制器
     * @var string
     */
    private $controller = "";

    /**
     * 当前方法名
     * @var string
     */
    private $action = "";

    /**
     * 初始化
     */
    protected function initialize()
    {
        parent::initialize(); // TODO: Change the autogenerated stub
        $this->module = App::getInstance()->http->getName();
        $this->controller = $this->request->controller();
        $this->action = $this->request->action();
        $this->checkAuth();
        $this->loadlang($this->controller);
    }

    /**
     * 检验权限
     */
    protected function checkAuth()
    {
        // 不需要登录
        if (in_array($this->action,$this->noNeedLogin)) return true;
        // 验证登录
        if (!self::isActive()) return $this->redirect('/admin/login/login');
    }

    /**
     * 加载语言文件
     * @param string $name
     */
    protected function loadlang($name)
    {
        Lang::load(App::getRootPath() . 'app/' . $this->module . '/lang/' . Lang::getLangSet() . '/' . $name . '.php');
    }

    /**
     * 验证登录
     * @return bool
     */
    protected static function isActive()
    {
        var_dump(Session::get('adminId'));
        return Session::has('adminId') && Session::has('adminInfo');
    }
}
