<?php 
namespace app\mobile\controller;

use think\Controller;
use think\captcha\Captcha;
use think\Session; 
use app\mobile\logic\CartLogic;
/**
* 
*/
class User extends Base{

	public function index(){
		$user_info = Session::get('user_info');

		if($user_info){

			 $this->redirect('home');
		}else{
			$this->redirect('login');
		}

	}

	public function home(){
		$user_info = Session::get('user_info');

		$o_c_list = db('order')
			->field("count(*) o_num,order_status")
			->where("user_id=".$this->user_id)
			->group("order_status")
			->select();

			// var_dump($o_c_list);

		$o_c_list = idASkey($o_c_list,'order_status');
		$info = db('user')->where("id=".$this->user_id)->find();	

		$this->assign("o_c_list",$o_c_list);
		$this->assign('info',json_encode($info));	

		return $this->fetch();

	}
	
	public function login(){
		return $this->fetch();
	}
	public function register(){
		return $this->fetch();		
	}

	public function doLogin(){
		//独立验证器
		$user_yz = validate("user");
		// var_dump($user_yz);
		// exit();
		if(!$user_yz->scene("login")->check(input())){
			$this->error($user_yz->getError());
		}

		$username = input('username');
		$password = input('password');
		$result_id = db("user")->where(["username"=>$username,"password"=>$password])->field("id")->find();

		if(empty($result_id)){
			$this->error("账号密码错误","login");
		}

		// 用户信息存储到会话里
		Session::set('user_info',['user_id'=>$result_id["id"],'user_name'=>$username]);

		 // 购物车的逻辑		
		// var_dump($result_id);
		$cartLogic = new CartLogic();
		$cartLogic->tongbuCart($result_id['id']);
		

		$this->success("登陆成功","home");

	}

	public function doRegister(){
		// 独立的验证器
		
		$user_yz = validate("user");
		// print_r(input());exit();
		if(!$user_yz->scene('register')->check(input())){
			$this->error($user_yz->getError());
		}

		$add_data = [
			'username'=>input('username'),
			'password'=>md5(input('password')),
		];

		db("user")->insert($add_data);

		Session::set('user_info',[
			'user_name'=>input('username'),
			'user_id'=>db("user")->getLastInsID()
		]);

		$this->success("注册成功！","user/home");



	}

	//退出
	public function logout(){

		Session::delete("user_info");
		$this->success("退出成功","user/login");
		 
	}

	
	
}


 ?>