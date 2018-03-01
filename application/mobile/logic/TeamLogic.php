<?php
namespace app\mobile\logic;
use think\Model;
use think\Session; 

/**
* 拼团逻辑层
*/
class TeamLogic extends Model{

	public $user_id; 
	function __construct()
	{
		if (Session::get('user_info')) {
			$this->user_id = Session::get('user_info')['user_id'];
		}
	}

 	public function getInfo($team_id){

 		$info = db('goods')->alias('g')
			->join('team_active ta','g.id=ta.goods_id')
			->field('ta.id,ta.name team_name,goods_num,goods_price,team_price,goods_thumb,goods_thumbs,ta.people_num,ta.sales_sum,g.id goods_id')
			->where("ta.id=$team_id and ta.status=1")
			->find();

		$info['goods_thumbs'] = json_decode($info['goods_thumbs'],true);
		$info['goods_name'] = $info['team_name']; 

		return $info;

 	}

 	//是否该团的团长
 	public function is_found($team_id){

 		if ( $this->user_id > 0) {

 		 	return db("team_found")->where("user_id=".$this->user_id." and team_id=$team_id")->count("user_id")
 		 	? true : false;;
	 	}
	 
 	}
 	// 判断用户是否参团
	public function is_follow($team_id){
		if ( $this->user_id > 0) {

			return db('team_follow')
				->where("user_id=".$this->user_id." and team_id=$team_id")
				->find()
				? true : false;
		}
	}
	
}


?>