<?php
namespace app\mobile\logic;
use think\Model;
use think\Session; 

/**
* 订单逻辑层
*/
class OrderLogic extends Model{

	private $session_id; 
	private $user_id; 

	function __construct(){

		$this->session_id = session_id();
		if (Session::get('user_info')) {
			$this->user_id = Session::get('user_info')['user_id'];
		}
	}

	public function addOrder($goods_list,$default_address,$is_buy_directly){

		$total_price = 0;//总金额
 		foreach ($goods_list as $key => $value) {
 			 $total_price += $value['goods_num']*$value['goods_price']; 
 		}

 		// var_dump($default_address);exit();
 		//total_amount：商品总价 == order_amount：订单总价
 		$add_data = [
 			"order_sn"=>$this->getOrderSn(),
 			"total_amount"=>$total_price,
 			"order_amount"=>$total_price,
 			"phone"=>$default_address['phone'],
 			"address"=>$default_address['address'],
 			"user_id"=>$this->user_id
 		];

 		db("order")->insert($add_data);
 		$order_id = db('order')->getLastInsID();

 		foreach ($goods_list as $key => $value) {
 			$goods_data = [
 				"order_id"=>$order_id,
 				"goods_name"=>$value['goods_name'],
 				"goods_id"=>$value['goods_id'],
 				"goods_price"=>$value['goods_price'],
 			];

 			db("order_goods")->insert($goods_data);


			// 把刚才下单的商品从购物车中清除掉
 			if (!$is_buy_directly) {
 				 db("cart")
 				->where("user_id=".$this->user_id." and goods_id=".$value['goods_id'])
 				->delete();
 			}
 		}

 		return ['status'=>1,'msg'=>'下单成功'];

	}
 	public function getOrderSn()
 	{
 		return date('YmdHis').rand(1000,9999);
 		// 判别是否，就是它已经存在order表的序列号 		
 	}
 


}


?>