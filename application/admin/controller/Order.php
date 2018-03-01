<?php 
namespace app\admin\controller;
use think\Controller;
use \think\Session;
use app\common\logic\OrderLogic;

class Order extends Controller{
	

	public function index(){

		//查询所有订单
		$lists = db("order")->paginate(5);

		$info = json_encode($lists);
		$this->assign("info",$info);

		$oLogic = new OrderLogic();

		$this->assign('order_status', json_encode($oLogic->getOrderStatus()));
		$this->assign('pay_status', json_encode($oLogic->getPayStatus()));
		
		return $this->fetch();
	}

	// 获取所有订单
	public function getOrder()
	{
		$list  = db('order')->paginate(5);
 
		return json($list);

	}
	


	

	// 编辑订单信息
	public function updateOrder(){

		$id = input("id");
		$order_amount = input("order_amount");
		$phone = input("phone");
		$address = input("address");


		if(!isset($id) || !isset($order_amount) || !isset($phone) || !isset($address)){

			$this->error("参数错误","index");
		}

	 	$now_date= date("Y/m/d h:i",time());

	 	$update_data = [
			"order_amount"=>$order_amount,
			"phone"=>$phone,
			"address"=>$address,
			"update_time" => $now_date
	 	];

	 	db('order')->where(['id'=>$id])-> update($update_data);

	}

	// 删除订单信息
	public function delOrder(){

		$id = input("id");

		if($id>0){
			db('order')->where(['id'=>$id])->delete();
		}else{
			$this->error('删除失败',"index");
		}
	}



	
	// 获取订单用户名
	public function getUsername(){

		$id = input('id');

		$user_name = db('user')->where('id',$id)->value('username');
 
		return json($user_name);
	}
	// 获取订单商品信息
	public function getGoods(){

		$o_id = input('order_id');

		$oLogic = new OrderLogic();
	 	return $oLogic->getGoods($o_id);
		
	}
	
	
	

}


 ?>