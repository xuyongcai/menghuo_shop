<?php 
namespace app\admin\controller;
use think\Controller;
use \think\Session;


class Team extends Controller{


	public function index(){

		//查询所有拼团
		$lists = db("team_active")->paginate(5);

		$info = json_encode($lists);
		$this->assign("info",$info);

		return $this->fetch();
	}

	// 获取所有拼团
	public function getTeam()
	{
		$list  = db('team_active')->paginate(5);
 
		return json($list);

	}
	


	// 增加拼团结点
	public function addTeam(){

		$name = input("name");
		$goods_name = input("goods_name");
		$goods_id = input("goods_id");
		$people_num = input("people_num");
		$team_price = input("team_price");
		// var_dump($goods_name);


		if( empty($name) || empty($people_num) || empty($team_price) ){
			$this->error("参数错误","index");
		}

		$now_date= date("Y/m/d h:i",time());

		$add_data = [
			"name"=>$name,
			"goods_name"=>$goods_name,
			"goods_id"=>$goods_id,
			"people_num"=>$people_num,
			"team_price"=>$team_price,
			"create_time" => $now_date,
    		"update_time" => $now_date,
		];

		
		$result = db('team_active')->insert($add_data);

		if($result>0){//成功时，$result为1
           
           return json(['data'=>$add_data]);       
        } else {
            
            $this->error('新增失败',"index");
        }

	}

	// 编辑拼团信息
	public function updateTeam(){

		$id = input("id");
		$name = input("name");
		$goods_name = input("goods_name");
		$goods_id = input("goods_id");
		$people_num = input("people_num");
		$team_price = input("team_price");




		if(!isset($id) || !isset($name) || !isset($people_num) || !isset($team_price)){

			$this->error("参数错误","index");
		}

	 	$now_date= date("Y/m/d h:i",time());

	 	$update_data = [
			"name"=>$name,
			"goods_name"=>$goods_name,
			"goods_id"=>$goods_id,
			"people_num"=>$people_num,
			"team_price"=>$team_price,
    		"update_time" => $now_date,
	 	];
	 	var_dump($id);
		var_dump($goods_name);

	 	db('team_active')->where(['id'=>$id])->update($update_data);

	 	return $update_data;
	}

	// 删除拼团信息
	public function delTeam(){

		$id = input("id");

		if($id>0){
			db('team_active')->where(['id'=>$id])->delete();
		}else{
			$this->error('删除失败',"index");
		}
	}



	


	// // 修改拼团名称
	// public function setTeamName($id,$new_name){

	// 	$user_info = Session::get('user_info');
	// 	if(empty($user_info)){
	// 		$this->error("没有登陆","admin/index/index");
	// 	}


	// 	$team_active = new team_active();

 //    	$now_date= date("Y/m/d h:i",time());

	// 	$result = $team_active->save([
	// 	    'name'  => $new_name,
	// 		'update_time'=>$now_date
	// 	],['id' => $id]);

	// 	if($result){
 //            //设置成功后跳转页面的地址，默认的返回页面是$_SERVER['HTTP_REFERER']
 //            $this->success('新增成功','goods/index');
 //        } else {
 //            //错误页面的默认跳转页面是返回前一页，通常不需要设置
 //            $this->error('新增失败');
 //        }


	// }

	// // 获取拼团用户名
	// public function getUsername(){

	// 	$id = input('id');

	// 	$user_name = db('user')->where('id',$id)->value('username');
 
	// 	return json($user_name);
	// }

	// // 获取拼团商品信息
	public function getGoods(){

		$list  = db('goods')
			->field("id,goods_name 商品名称,goods_price 商品价格")
			->order("id desc")
			->paginate(5);

		return json($list);
	}
	
	
	

}


 ?>