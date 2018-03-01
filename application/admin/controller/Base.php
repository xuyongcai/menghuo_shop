<?php
	namespace app\admin\controller;
	use think\Controller;
	use think\Session;
	use think\Request;
	
	class Base extends Controller{
		
		protected $admin_info;
		function __construct(){
			parent::__construct();
			
			$this->admin_info = Session::get('admin_info');
			$action = Request::instance()->action();
			$controller = Request::instance()->controller();
			
			if(!in_array($action, ['login', 'dologin','register','doregister']) && !$this->admin_info){
				$this->error("请先登录!", "user/login");
			}else if(in_array($action, ['login', 'dologin','register','doregister']) && $this->admin_info){
				$this->error("已经登录，请注销账号再尝试!", "goods/index");
			}
			
		}
		
		
	}
?>