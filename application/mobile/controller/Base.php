<?php 
namespace app\mobile\controller;

use think\Controller;
use think\Session;
use think\Request;
/**
* 
*/
class Base extends Controller{
	protected $user_id;
	
	function __construct(){
		parent::__construct();
		$controller = Request::instance()->controller();

		//获取行为的方法名
		$action = Request::instance()->action();

		// 所有Info控制器相关操作都需登录
		if( (in_array($controller, ['info','order']) ||in_array($action,['home','setting'])) && !Session::get("user_info")){
			$this->error("没有登陆","user/login");
		}

		$this->user_id = Session::get('user_info')['user_id'];

		if(in_array($action,['login','reg']) && Session::get("user_info")){
			$this->success("已经登陆了","user/home");
		}

	}



}


 ?>