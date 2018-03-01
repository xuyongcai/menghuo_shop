<?php
namespace app\mobile\controller;

use think\Controller;
use app\mobile\logic\CartLogic;
use think\Session;

class Goods extends Controller
{
	
	public function index()
	{
		$goods_id = input('goods_id');
		if(!$goods_id){
				$this->error("链接有误", "index/index");
		}
		$comment_list=db('goods_comment')->alias('gc')
				->field('gc.id,gc.goods_id,gc.comment_text,gc.quality_pf,gc.update_time,u.username')
				->join('user u','u.id = gc.user_id','left')
				->where("goods_id=$goods_id")
				->order('create_time desc')
				->paginate(5)->toArray()['data'];

		$info = db('goods')->field('id,goods_name,goods_price,goods_thumb,goods_thumbs')->where("id=$goods_id")->find();

		$info['goods_thumbs'] = json_decode($info['goods_thumbs'],true);

		// $this->assign('info',$info); 
		$this->assign('info_json',json_encode($info)); 
		$this->assign('comment_list', json_encode($comment_list));

		return $this->fetch();
	}

	public function getInfo()
	{
		$goods_id = input('id');
		if(!$goods_id){
			$this->error("数据请求有误!");
		}

		$info = db('goods')->field('goods_description')->where("id=$goods_id")->find();

		return json(['info'=>$info['goods_description']]);
		 
	}


	public function addCart(){
		
		$add_data = json_decode(input("goods_info"),true);

		// var_dump($add_data);

		$cartLogic = new CartLogic();
		$sql = $cartLogic->getUserStatus();

		$where_sql = "goods_id=".$add_data['id']." and ".$sql;

		$info = db('cart')->where($where_sql)->value('id');

		// 判断有没有存在
		if($info>0){
			
			db('cart')->where($where_sql)->setInc('goods_num');
		}else{
			
			$add_data['goods_id'] = $add_data['id'];
			$add_data['user_id'] = Session::get('user_info')['user_id'];
			unset($add_data['id']);
			// unset($add_data['goods_thumb']);
			unset($add_data['goods_thumbs']);

			$now_date= date("Y/m/d h:i",time());

			$add_data['create_time'] = $now_date;
			$add_data['update_time'] = $now_date;
			$add_data['goods_num'] = 1;
			$add_data['session_id'] = session_id();

			db('cart')->insert($add_data);
		}


	}
	 

}

?>