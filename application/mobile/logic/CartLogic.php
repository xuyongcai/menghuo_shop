<?php 
namespace app\mobile\logic;

use think\Model;
use think\Session;

class CartLogic extends Model{

	private $session_id; 
	private $user_id; 

	public function __construct(){

		$this->session_id = session_id();
		if (Session::get('user_info')) {
			$this->user_id = Session::get('user_info')['user_id'];
		}

	}

	//删除购物车商品
	public function delCart($id){

		if ($id) {
			db('cart')->where("id=".$id)->delete();
		}
	}

	/**
	 * 获取用户有没有登录
	 * @return string 条件语句
	 */
	public function getUserStatus(){


		//判断登陆否
		if(empty($this->user_id)){
			//未登录
			$where_sql = " session_id = '".$this->session_id."' and user_id = 0";
		}else{

			$where_sql = " user_id = ".$this->user_id;
		}

		return $where_sql;
	}

	// 获取所有收货地址
	public function getAddressList(){

		return db('user_address')->where("user_id=".$this->user_id)->select();
	}
	// 添加收货地址
	public function addAddress($username,$phone,$address){
		$data = [
			'user_id' => $this->user_id,
			'username' => $username,
			'phone' => $phone,
			'address' => $address
		];
		return db('user_address')->insert($data);
	}

	// 获取默认地址
	   public function getDefaultAddress()
	  {
	  	// var_dump($this->user_id);
	  	return db('user_address')->where("user_id=".$this->user_id." and is_default = 1")->find();
	  }

	 // 设置默认收货地址
	public function setDefaultAddress($addr_id){
		
		// 把之前的默认设为0
		db('user_address')->where("user_id=".$this->user_id." and is_default=1")->update(['is_default'=>0]);

		db('user_address')->where("id=".$addr_id)->update(['is_default'=>1]);
		
	}


	/**
	  * 改变商品数量
	  * @param  int $id 购物车ID
	  * @param  int $goods_num 用户要买的数量
	  * @return [type]        [description]
	  */
	 public function changeNum($id,$goods_num)
	 {
	 	$where_sql = $this->getUserStatus();

	    db("cart")->where("id=".$id." and ".$where_sql)->update(['goods_num'=>$goods_num]);

	    return ['status'=>1,'msg'=>'修改成功','data'=>['goods_num'=>$goods_num]];
	 }


	  // 关联未登录前的购物车
	public function tongbuCart($user_id) {
		// 把同一件商品进行合并

  	  	// 1/查询未被关联的商品
		$cart_list = db('cart')
		  	  ->field("id,goods_id,goods_num")
		  	  ->where("session_id='".$this->session_id."' and user_id = 0")
		  	  ->select();


	 	foreach ($cart_list  as $key => $value) {
	  	  
  	  	 	$info = db("cart")
		  	  	 ->field("id,goods_id,goods_num")
		  	  	 ->where("user_id=$user_id and goods_id=".$value['goods_id'])
		  	  	 ->find();
	  	  	
		  	if ($info) {
		  		//如果已经关联的商品中有未关联的，那么就改变数量
  	  	 		//数量：之前的量+未关联的数量 
  	  	 	  	db('cart')
	  	  	 	  	->where("id=".$info['id'])
	  	  	 	  	->update(['goods_num'=>$value['goods_num']+$info['goods_num']]);

  	  	 	 	 // 把重复的删掉
  	  	 	   	db('cart')
  	  	 	  	 	->where("id=".$value['id'])
  	  	 	  	 	->delete();

		  	}else{
	  	  	 	// 如果之前不存在的，那么就直接进行关联
  	  	 		 db('cart')
  	  	 		 	->where("session_id='".$this->session_id."' and user_id = 0 and id=".$value['id'])
  	  	 		 	->update(['user_id'=>$user_id]);
	  	  	 }
  	  	}
	  	 

	}



}




 ?>