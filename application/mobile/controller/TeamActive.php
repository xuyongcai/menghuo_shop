<?php 
namespace app\mobile\controller;
use think\Controller;
use think\Session; 
use app\mobile\logic\CartLogic;
use app\mobile\logic\TeamLogic;
use app\mobile\logic\FoundLogic;

class TeamActive extends Controller{

	public function index(){

		$team_id = input('team_id');
		if(!$team_id){
       		$this->error("该拼团不存在", "index/index");
        }

		$teamLogic = new TeamLogic();
		$team_active = $teamLogic->getInfo($team_id);

		$goods_id = $team_active['goods_id'];
        $commont_list=db('goods_comment')
        			->where("goods_id=$goods_id")
					->order('create_time desc')
					->paginate(5)->toArray()['data'];
					
		$this->assign('commont_list', json_encode($commont_list));	
		$this->assign('team_active',json_encode($team_active)); 
		

		// 获取当前拼团已有的开团列表
		$foundLogic = new FoundLogic();
		$found_list = $foundLogic->getList($team_id);

		$is_found = $teamLogic->is_found($team_id);
   		$is_follow = $teamLogic->is_follow($team_id);

   		if($found_list == "error"){
       		$this->error("数据请求出错!");
        }
       
        if($team_active == "error"){
       		$this->error("该拼团不存在", "index/index");
        }

		$this->assign('is_follow', json_encode($is_follow));
       	$this->assign('is_found', json_encode($is_found));
       	$this->assign('user_id', $teamLogic->user_id); //当前登录的用户ID
		$this->assign('found_list', json_encode($found_list));
		
		// var_dump($found_list);

		return $this->fetch();

	}

	public function getInfo()
	{
		$goods_id = input('id');
		// var_dump($goods_id);
		$info = db('goods')->field('goods_description')->where("id=$goods_id")->find();

		return json(['info'=>$info['goods_description']]);
		 
	}






}


 ?>