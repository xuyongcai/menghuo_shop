<?php 
namespace app\admin\controller;
use think\Controller;
use \think\Session;

class Goods extends Controller{

	
	public function index(){

		//查询所有品类(分类)
		$lists = db('goods')->alias('g')
				->field('g.id,g.category_id,g.category_name,g.goods_name,g.goods_price,c.name')
				->join('category c','c.id = g.category_id','left')
				->order('g.id desc')//desc是降序，asc升序，默认asc
				->paginate(5);

		$info = json_encode($lists);
		$this->assign("info",$info);

		return $this->fetch();
	}

	 // 获取分页列表
	public function getLists()
	{
		$lists = db('goods')->alias('g')
			->field('g.id,g.category_id,g.category_name,g.goods_name,g.goods_price,c.name')
			->join('category c','c.id = g.category_id','left')
			->order('g.id desc')
			->paginate(5);
 		  
 		  // var_dump($lists);
		return json($lists);

	}


	// 获取所有分类
	public function getCategory(){
			//查询所有品类(分类)
		$lists = db("category")->select();

		return json(setCategoryTree($lists));
	}


	// 增加品类结点
	public function addGoods(){

		$goods_name = input("goods_name");
		$category_id = input("category_id");
		$goods_price = input("goods_price");
		$goods_description=input("goods_description");

		// $goods_thumb = base64_upload(input("goods_thumb"));
		// 保存图片(多张)
	 	$goods_thumb_a = json_decode(input('goods_thumb'),true) ;

	 	if($goods_thumb_a){
	 		foreach ($goods_thumb_a as $key => $value) {
	 			$goods_thumb_a[$key] = base64_upload($value);

	 		}
	 	}
	 	$goods_thumb = $goods_thumb_a[0];
	 	$goods_thumbs = json_encode($goods_thumb_a);

		

		if( !isset($goods_name) || !isset($category_id) ){
			$this->error("参数错误","index");
		}

		$now_date= date("Y/m/d h:i",time());

		$add_data = [
			"goods_name"=>$goods_name,
			"category_id"=>$category_id,
			"goods_price"=>$goods_price,
			"goods_thumb" => $goods_thumb,
			"goods_thumbs" => $goods_thumbs,
			"goods_description"=>$goods_description,
			"create_time" => $now_date,
    		"update_time" => $now_date,
		];

		
		$result = db('goods')->insert($add_data);

		if($result>0){//成功时，$result为1
           
           return json(['data'=>$add_data]);       
        } else {
            
            $this->error('新增失败',"index");
        }

	}

	// 编辑品类信息
	public function updateGoods(){

		$id = input("id");
		$goods_name = input("goods_name");
		$goods_price = input("goods_price");
		$goods_description=input("goods_description");

		$category_id = input("category_id");

		if( !isset($goods_name) || !isset($category_id) ){
			$this->error("参数错误","index");
		}

	 	$now_date= date("Y/m/d h:i",time());

	 	$update_data = [
	 		"goods_name"=>$goods_name,
	 		"goods_price"=>$goods_price,
	 		"goods_description"=>$goods_description,
			"category_id"=>$category_id,
			"update_time" => $now_date
	 	];


	 	// // 保存图片(单张)
	 	// if (input('old_goods_thumb') != input('goods_thumb')) {

	 	// 	$update_data['goods_thumb'] = base64_upload(input('goods_thumb'));
	 	// }


	 	// var_dump(input('goods_thumb'));
	 	// 保存图片(多张)
	 	if (input('old_goods_thumb') != input('goods_thumb')) {

		 	$goods_thumb_a = json_decode(input('goods_thumb'),true) ;

		 	// var_dump($goods_thumb_a);
		 	if($goods_thumb_a){
		 		foreach ($goods_thumb_a as $key => $value) {
		 			$goods_thumb_a[$key] = base64_upload($value);

		 		}
		 	}
		 	// var_dump($id);
		 	$update_data['goods_thumb'] = $goods_thumb_a[0];
		 	$update_data['goods_thumbs'] = json_encode($goods_thumb_a);
	 	}

	 	

	 	db('goods')->where(['id'=>$id])-> update($update_data);

	 	return $update_data;

	}

	// 删除品类信息
	public function delGoods(){

		$id = input("id");

		if($id>0){
			db('goods')->where(['id'=>$id])->delete();
		}else{
			$this->error('删除失败',"index");
		}
	}


	/**
	  * 多张图片保存
	  * @return array 图片路径
	  */
	public function saveImages(){

	  	// 保存图片		  
	 	$save_file = "/public/uploads/images/".time().rand(1000,9999).'.jpg';

	 	$image = \think\Image::open($_FILES['file_info']['tmp_name'])->save(ROOT_PATH.$save_file);

	 	if (input('num') == 0) {
	 	 		$image->thumb(200,200)->save(ROOT_PATH.$save_file.'_200x200.jpg');
		 }
		return $save_file;
		
	}

	public function getInfo(){

		$goods_id = input('id');
		$info = db('goods')->field('goods_description,goods_thumbs')->where("id=$goods_id")->find();

		return json(['info'=>$info['goods_description'],'goods_thumbs'=>$info['goods_thumbs']]);
		 
	}


}


 ?>