<?php 
namespace app\mobile\controller;

use think\Controller;
use think\Session; 
use app\mobile\logic\CartLogic;
use app\mobile\logic\TeamLogic;


class Cart extends Controller{

	public function index(){

		$is_login = false;
		$goods_info = [];
		$cart_a = [];

		if (Session::get('user_info')) {
			$is_login = true;
		}

		$active_id = input('active_id');//
		$active_type = input('active_type');
		$found_id = input('found_id');//团的ID

		if (input('goods_id')) {
			//立即购买
			if (!$is_login) {
				$this->success("没有登陆","user/login");
			}

			if ($active_id > 0 && $active_type == 1) {
				// 拼团活动
				 $teamLogic = new TeamLogic();
				 $goods_info = $teamLogic->getInfo($active_id );
				 $goods_info['goods_price'] = $goods_info['team_price'];

			}else{
				// 正常商品
				$goods_info = db('goods')->field('id,goods_name,goods_price,goods_thumb')->where("id=".input('goods_id'))->find();

				$goods_info['goods_id'] =$goods_info['id'];
			}
			
			
			$goods_info['goods_num'] =1;

		}else{

			//获取自己的
			$cartLogic = new CartLogic();
			$cart_a = db('cart')->where($cartLogic->getUserStatus())->select();
		}

		$this->assign("active_id",$active_id);
		$this->assign("active_type",$active_type);
		$this->assign("found_id",$found_id);

		$this->assign('cart_list',json_encode($cart_a));
		$this->assign("goods_info",json_encode($goods_info));
		$this->assign("is_login",$is_login);

		return $this->fetch();
	}

	//删除购物车商品
	public function delCart(){
		$id = input('id');

		$cartLogic = new CartLogic(); 

		return $cartLogic->delCart($id);
	}
	// 获取所有收货地址
	public function getAddressList(){
		$user_info = session::get('user_info');
		if(!$user_info){
			$this->error("请登录后再操作！");
		}

		$cartLogic = new CartLogic(); 

		return $cartLogic->getAddressList();
	}
	// 添加收货地址
	public function addAddress(){


		$username = input('username');
		$phone = input('phone');
		$address = input('address');

		if($username && $phone && $address){
			$cartLogic = new CartLogic(); 
		
			return $cartLogic->addAddress($username,$phone,$address);
		}
		
		
	}

	// 获取默认地址
	public function getDefaultAddress()
	{
		$cartLogic = new CartLogic(); 
		
		return $cartLogic->getDefaultAddress();
	}

	// 设置默认收货地址
	public function setDefaultAddress(){
		

		$cartLogic = new CartLogic(); 
		
		return $cartLogic->setDefaultAddress(input('id'));
	
	}

	// 改变数量
	public function changeNum(){

		$id = input("id");
		//需要强制转为int
		$goods_num = (int)input("goods_num");

		$cartLogic = new CartLogic(); 

		if ($id<=0 ) {
			return json(['status'=>0,'msg'=>'参数错误']);
		}

		if ($goods_num>0) {

			$rtn_info = $cartLogic->changeNum($id,$goods_num);
			
		}else{

			$rtn_info = $cartLogic->changeNum($id,1);
		}		

		return $rtn_info;
	}

}
 




 ?>
