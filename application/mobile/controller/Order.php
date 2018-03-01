<?php 
namespace app\mobile\controller;

use think\Controller;
use think\Session; 
use app\mobile\logic\OrderLogic;
use app\common\logic\OrderLogic as commonOrderlogic;


class Order extends Base{

	public function add(){

		$goods_list = json_decode(input('selected_list'),true);
		$default_address = json_decode(input('default_address'),true);
		$is_buy_directly = input('is_buy_directly');

		if(!$goods_list || !$default_address){
			$this->error("数据请求出错!");
		}


		$order_logic = new  OrderLogic();
		$order_logic->addOrder($goods_list,$default_address,$is_buy_directly);

	}

	public function lists(){

		$type = input('type');
		$where_sql  = "";

		if (isset($type)) {
			 $where_sql =" and order_status =".$type;
		}

		// $o_list = db('order')
		// 	->where("user_id=".$this->user_id.$where_sql)
		// 	->select();
		$o_list = db('order')->alias('o')
				->field('o.*, u.username')
				->join('user u',"o.user_id = u.id and o.user_id = ".$this->user_id.$where_sql)
				 ->order('create_time desc')
				->select();

		$this->assign("o_list",$o_list);


		$commonOrderlogic = new commonOrderlogic();	
		$order_status = $commonOrderlogic->getOrderStatus();
		$pay_status = $commonOrderlogic->getPayStatus();

		if(!isset($type)){
			$type = 666;
		}
		$this->assign("order_status",$order_status);
		$this->assign('pay_status', $pay_status);
		$this->assign("type", $type);

		return $this->fetch();
	}
	

	//发微信支付
	public function wxpay()
	{
		$order_sn = input("order_sn");

		$data = controller("wxpay")->payByOrderNo($order_sn);

 		$this->assign('amount',$data['order_amount']);
        $this->assign('order_sn',$order_sn);
        $this->assign("jsApiParameters" ,$data['jsApiParameters']);
        $this->assign('openid',$data['open_id']);
		return $this->fetch();
	}

	// 支付后的回调行为
	// ****手动触发,,上线后会自动被微信接口触发
	public function haspay()
	{
		$rtnD = input();
		if ($rtnD['success']) {
			$out_trade_no =  $rtnD['out_trade_no'];
			// 状态未付款
			db('order')->where('order_sn="'.$out_trade_no.'" and pay_status = 0')->update(['pay_status'=>1,'order_status'=>1,'pay_time'=>time()]);
			// 减少商品库存
			return ['status'=>1];
		}
		return ['status'=>0];

	}


	// 取消订单
	public function cancelOrder(){

		$order_id = input('order_id');
		db('order')->where('id='.$order_id)->delete();
		db('order_goods')->where('order_id='.$order_id)->delete();

		return $this->redirect("lists");

	}

	// 确认收货
	public function confimReceive()
	{
		$order_id = input('order_id');

		$now_date= date("Y/m/d h:i",time());

		$data_arr = [
			'order_status'=>4,
			'update_time'=>$now_date,
			'confirm_time'=>$now_date
		];

		db('order')->where('id='.$order_id)->update($data_arr);
		
		$this->assign('order_id',$order_id);

		// 商品列表
		$g_lists = db('order_goods')->where('order_id='.$order_id)->select();
		$this->assign('g_lists',$g_lists);

		$this->redirect("comment?id=".$order_id);

	}
	 
	 // 评论
 	public function comment(){

 		$order_id = input('order_id');

	  	// 商品列表
		$g_lists = db('order_goods')->where('order_id='.$order_id)->select();

		$this->assign('order_id',$order_id);
		$this->assign('g_lists',$g_lists[0]);

		return $this->fetch("order/comment");

  	} 

	 // 评论
	public function addComment(){	
		try{
			$order_id = input('order_id');		
			$g_lists = db('order_goods')->where('order_id='.$order_id)->select();
			$this->assign('order_id',$order_id);		
			$this->assign('g_lists',$g_lists[0]);
				  
			$add_data=[
				'comment_text'=>input('comment_text'),
				'order_id'=>input('order_id'),
				'goods_id'=>input('goods_id'),
				'quality_pf'=>input('quality_pf'),
				'speed_pf'=>input('speed_pf'),
				'attitude_pf'=>input('attitude_pf'),
				'user_id'=>$this->user_id,
	
			];
			db('goods_comment')->insert($add_data);

			$now_date= date("Y/m/d h:i",time());

			db('order')->where('id='.$order_id)
						->update(['order_status'=>8,'comment_time'=>$now_date,'update_time'=>$now_date]);
		}catch(\Exception $e){
			$this->error("评价失败，系统出错!");
		}
			
		$this->success("评价成功!");

	} 
	 


}
 




 ?>
