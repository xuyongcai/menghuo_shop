<?php 
namespace app\admin\controller;
use think\Controller;
use think\captcha\Captcha;
use think\Request;
use \think\Session;


class User extends Base
{
	public function index(){

		
		$this->login();
	}
	public function login(){

		return $this->fetch();
	}

	public function home(){

		if(!$this->check_power()){
			$this->error('权限不够!');
		}
			
		$admin_list = db("admin")->select();
		$admin = Session::get('admin_info');
		unset($admin['password']);
		$this->assign('admin', $admin);
		$this->assign("admin_list", json_encode($admin_list));
		return $this->fetch();
	}

	public function doLogin(){
		$username = input("username");
		$password = input("password");
		$captcha_code = input("captcha");

		$captcha = new Captcha();
		if(!$captcha->check($captcha_code)){
			$this->error("验证码错误");
		}
		// where(['username'=>$username,'password'=>$password])->
		$result = db("admin")->field('id,power')
			->where([
				'username'=>input('username'), 
				'password'=>md5(input('password'))
			])
			->find();

		if(!empty($result)){
			
			Session::set('admin_info',[
				"admin_id"=>$result["id"],
				"admin_name"=>$username,
				"power"=>$result["power"],
			]);

			$this->success("登陆成功",'user/home');
			
		}else{
			$this->error("账号密码错误");
		}
		
	}

	public function register(){
		return $this->fetch();
	}
	//注册验证
	public function doRegister(){

		if(!empty(input("username")) && !empty(input("password")) && !empty(input("question"))
		 && !empty(input("answer")) && !empty(input("phone")) ){
			// 用户传过来的表单都是不可信的
			$username = input("username");
			$password = input("password");
			$question = input("question");
			$answer = input("answer");
			$phone = input("phone");

			// 不能多次使用'$this->model("admin")',需将其放在变量中

		 	$add_data = [
				"username"=>$username,
				"password"=>md5($password),
				"question"=>$question,
				"answer"=>$answer,
				"phone"=>$phone,
			];

			//返回id
			$result = db("admin")->insert($add_data);

			// var_dump($result);
			if($result<=0){
				$this->error("注册失败","register");
			}

			$result_id = db("admin")->where('username', $username)->field('id')->find();
			var_dump($username);
			//用户信息存入会话
			Session::set("admin_info",[
				"admin_id"=>$result_id["id"],
				"admin_name"=>$username,
				"power"=>0,
			]);
			
			$this->success("注册成功","home");
			
		}else{
			$this->error("注册失败","register");
		}
	}
	//	注销
	public function logout(){
		Session::delete('admin_info');
		$this->success("注销成功", 'user/login');
	}

	// 管理员添加
	public function add(){
		if(!$this->check_power()){
			$this->error('权限不够!');
		}

		$captcha_code = input('captcha');
		$captcha = new Captcha();
		if(!$captcha->check($captcha_code)){
			return json_encode(['status'=>'error', 'msg'=>'验证码验证失败']);
		}

		if(!empty(input("username")) && !empty(input("password")) && !empty(input("power")) ){

			$admin_data=[
				'username'=>input('username'),
				'password'=>md5(input('password')),
				'power'=>input('power')
			];
			
			db('admin')->insert($admin_data);
			
			return json_encode(['status'=>'success', 'user'=>$admin_data]);

		}else{
			return json_encode(['status'=>'error', 'msg'=>'用户名或密码不能为空！']);
		}	
		
	}
	
	// 管理员删除
	public function del(){
		$id = input('id');
		if(!$id){
			return json_encode(['status'=>'error', 'msg'=>'发送的id为空,删除失败!', 'id'=>$id]);
		}
		
		db('admin')->where(['id'=>$id])->delete();
		return json_encode(['status'=>'success']);
		
	}
	

	private function check_power(){
		$admin_info = Session::get('admin_info');
		return $admin_info['power'] == 1 ? true : false;
	}

		
}

 ?>