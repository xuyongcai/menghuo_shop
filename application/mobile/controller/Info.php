<?php 
namespace app\mobile\controller;

use think\Controller;
use think\captcha\Captcha;
use think\Session; 
/**
* 
*/
class Info extends Base{

	private $user_info = [];

	function __construct(){
		parent::__construct();
		$this->user_info = Session::get("user_info");

	}

	public function setting(){

		// var_dump($this->user_info);
		// Session::delete('user_info');
		$info = db('user')
				->where("id",$this->user_info["user_id"])
				->find();

		$this->assign("user_info",json_encode($info));

		return $this->fetch();
	}

	// 修改用户字段值
	public function change_value(){
		$key = input('key');
		$value = input('value');
		if(!isset($key) || !isset($value)){
			$this->error("数据出错!");
		}
		
		try{
			$id = $this->user_id;
			db('user')->where(['id'=>$id])->update([$key=>$value]);

			$user_info = db('user')->field("id user_id,username user_name")->where(['id'=>$id])->find();
			Session::set("user_info", $user_info);
			
		}catch(\Exception $e){
			$this->error("数据操作出错!");
		}
		
		$this->success("修改 $key 成功!");
		
	}
		
	public function editByColumn(){

		$column = input('column');
		// var_dump($column);

	 	$value = input('value');

 		db("user")->where("id=".$this->user_info['user_id'])->update([$column=>$value]);
	}

	// 进入收货地址
	public function address(){

		$info = db('user_address')
				->where("user_id",$this->user_info["user_id"])
				->select();
		
	 	$this->assign("info",json_encode($info));

 		return $this->fetch();
	}

	// 保存收货地址信息
	public function saveAddress(){

		$add_data = [
			"user_id"=>$this->user_info["user_id"],
			"username"=>$this->user_info["user_name"],
			"phone"=>input("phone"),
			"address"=>input("address"),
			"is_default"=>input("is_default")
		];

		db('user_address')->insert($add_data);

		// vuejs的json，可以不用json_encode()
 		return json(['data'=>$add_data]);
	}

	// 编辑收货地址信息
	public function updateAddress(){

	 	$id = input("id");
	 	$update_data = [
	 		"phone"=>input("phone"),
			"address"=>input("address"),
			"is_default"=>input("is_default")
	 	];

	 	db('user_address')->where(['id'=>$id,"user_id"=>$this->user_info['user_id']])-> update($update_data);

	}

	// 删除收货地址信息
	public function delAddress(){
		$id = input("id");
		if($id>0){
			db('user_address')->where(['id'=>$id,"user_id"=>$this->user_info['user_id']])->delete();
		}
	}



}


 ?>