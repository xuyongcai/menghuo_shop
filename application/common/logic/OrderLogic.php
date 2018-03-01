<?php 
namespace app\common\logic;

use think\Model;
use think\Session;


/**
* 公共订单逻辑层
*/
class OrderLogic extends Model{

	public function getOrderStatus(){

		return [
				0 	=>	'待确认',
				-1	=>	'取消订单',
				1	=>	'已确认',
				2	=>	'待发货',
				3	=>	'已发货',
				4	=>	'待评论',
 				6	=>	'已完成',
 				7	=>  '待成团',
 				8	=>	'已评论',
			];

	}

	public function getPayStatus(){
			return [
				0	=>	'未支付',
				1	=>	'已支付'
			];
		}
	

	// 获取订单商品信息
	public function getGoods($order_id){

		return db('order_goods')->where("order_id=".$order_id)->select();

	}


}





 ?>