<?php
namespace app\admin\controller;
use app\common\logic\OrderLogic;

// 拼团订单管理
class OrderTeam extends \think\Controller
{
	public function index()
	{ 
		 
		$lists = db('order')->alias('o')
			->field('o.order_sn,o.order_status,o.pay_status,o.total_amount,o.id order_id,tf.id found_id, tf.create_time, tf.user_id, tf.team_id, tf.join_num, tf.need_num, tf.price, tf.status,o.shipping_code,o.shipping_name') 
			->join('team_found tf','o.id = tf.order_id')
			->order('order_id desc')
			->where("active_type=1")
			->paginate(5);

			// var_dump($lists);

		$info = json_encode($lists);
		$this->assign("info",$info);

		$oLogic = new OrderLogic();

		$this->assign('order_status', json_encode($oLogic->getOrderStatus()));
		$this->assign('pay_status', json_encode($oLogic->getPayStatus()));

		return $this->fetch();
	}
	 // 获取分页列表
	public function getLists()
	{
		$lists = db('order')->alias('g')
			->where("active_type=1")
			->order('id desc')
			->paginate(5);
 		  
		return json($lists);

	}
	 public function getGoods()
	 {
	 	 $oLogic = new OrderLogic();
	 	 $o_id = input('order_id');
	 	 $goods_l = $oLogic->getGoods($o_id);

	 	 return $goods_l;
	 }

	 // 编辑信息
	 public function update()
	 {
	 	$order_id = input("edit_info.order_id");
	 	$now_date= date("Y/m/d h:i",time());

	 	$update_data = [
	 		"order_status"=>input("edit_info.order_status"),
	 		"shipping_code"=>input("edit_info.shipping_code"),
	 		"shipping_name"=>input("edit_info.shipping_name"),
	 		"update_time"=>$now_date,
	 	];


	 	// 若是发货需改变shipping_status
	   if ($update_data['order_status'] == 3) {
			db('order')->where('id='.$order_id)->update(['shipping_status'=>1,'shipping_time'=>$now_date]);
	   }
	 	db('order')->where("id=".$order_id)->update($update_data);

	 }
	  // 删除信息
	 public function del()
	 {
	 	 $id = input('id');
	 	 if ($id>0) {
	 	 	db('order')->where("id=".$id)->delete();
	 	 }
	 }
	

	 /**
	  * 拼团确认操作
	  * @return [type] [description]
	  */
	 public function confirm()
	 {
	 	$found_id = input('found_id');
	 	$order_id = input('order_id');
	 	// 这个团的状态
	 	db('team_found')
	 		->where("id=".$found_id)->update(['status'=>2]);
	 	// 这个团的所有参团信息改成已成团
	 	db('team_follow')
	 		->where("found_id=".$found_id)->update(['status'=>2]);
	 		// order订单状态
	 	// 团长的订单
 		db('order')
	 		->where("id=".$order_id)->update(['order_status'=>1]);	
	 	// 团员的订单
	 }

	 public function team_people()
	 {
	 	 $found_id = input('found_id');
	 	 $team_found_info = db('team_found')->alias('tf')
		 	 ->field('tf.*,u.username,o.order_sn,o.order_status,o.pay_status,o.total_amount')
		 	 ->join('user u','tf.user_id=u.id')
		 	 ->join('order o','o.id=tf.order_id')
		 	  ->where("tf.id=".$found_id)
		 	  ->find();

	 	 // 多个团员
	 	 $team_follow_list = db('team_follow')->alias('tf')
				 	 ->field('tf.*,u.username,o.order_sn,o.order_status,o.pay_status,o.total_amount')
		 	 		->join('order o','o.id=tf.order_id')
				 	 ->join('user u','tf.follow_user_id=u.id')
				 	  ->where("found_id=".$found_id)->select();

	 	 $this->assign("team_found_info",$team_found_info);
	 	 $this->assign("team_follow_list",$team_follow_list);
		return $this->fetch();

	 }
}