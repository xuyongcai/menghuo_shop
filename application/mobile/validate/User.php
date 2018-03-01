<?php 
namespace app\mobile\validate;

use think\Validate;
/**
* 用户验证器
*/
class User extends Validate{

	protected $rule = [
		"username|用户名"=>"require|min:5|unique:user",
		"password|密码"=>"require|length:3,18"
	];
	protected $scene = [
		"register"=>["username","password"],
		"login"=>['username'=>'require|min:5','password']
	];

	
	
}


 ?>