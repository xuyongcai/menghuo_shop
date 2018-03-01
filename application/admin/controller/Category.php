<?php 
namespace app\admin\controller;
use think\Controller;
use \think\Session;

class Category extends Controller{
	private $all_list;  //接受所有信息

	public function index(){

		//查询所有品类(分类)
		$lists = db("category")->paginate(5);

		$info = json_encode($lists);
		$this->assign("info",$info);

		return $this->fetch();
	}

	// 获取所有分类
	public function getCategory()
	{
		$list  = db('category')->paginate(5);
 
		return json($list);

	}
	
	// 获取一级分类
	public function getFirstCategory(){

		$list = db('category')
				->where("parent_id=0")
				->select();
		
	 	
		// var_dump($list);
 		return json(idAsKey($list,'id'));
	}



	// 增加品类结点
	public function addCategory(){

		$name = input("name");
		$parent_id = input("parent_id");

		if( !isset($name) || !isset($parent_id) ){
			$this->error("参数错误","index");
		}

		$now_date= date("Y/m/d h:i",time());

		$add_data = [
			"name"=>$name,
			"parent_id"=>$parent_id,
			"create_time" => $now_date,
    		"update_time" => $now_date,
    		"status"=>1
		];

		
		$result = db('category')->insert($add_data);

		if($result>0){//成功时，$result为1
           
           return json(['data'=>$add_data]);       
        } else {
            
            $this->error('新增失败',"index");
        }

	}

	// 编辑品类信息
	public function updateCategory(){

		$id = input("id");
		$name = input("name");
		$parent_id = input("parent_id");

		if( !isset($name) || !isset($parent_id) ){
			$this->error("参数错误","index");
		}

	 	$now_date= date("Y/m/d h:i",time());

	 	$update_data = [
	 		"name"=>$name,
			"parent_id"=>$parent_id,
			"update_time" => $now_date
	 	];

	 	db('category')->where(['id'=>$id])-> update($update_data);

	}

	// 删除品类信息
	public function delCategory(){

		$id = input("id");

		if($id>0){
			db('category')->where(['id'=>$id])->delete();
		}else{
			$this->error('删除失败',"index");
		}
	}



	// 获取品类子节点（平级）
	// $parent_id,传父节点
	// 当$id="0"时，就是根节点
	public function getChildrenParallelCategory($parent_id=0){

		$user_info = Session::get('user_info');
		if(empty($user_info)){
			$this->error("没有登陆","admin/index/index");
		}

		$category = new Category();
		// 使用数组查询
		$list = $category::all(['parent_id'=>$parent_id]);

		if(!empty($list)){
          	return $list;
          	// var_dump($list);
            
        } else {
           
            $this->error('没有找到当前分类的子分类');
        }

		// var_dump($list);
		// return $list;

	}



	// 修改品类名称
	public function setCategoryName($id,$new_name){

		$user_info = Session::get('user_info');
		if(empty($user_info)){
			$this->error("没有登陆","admin/index/index");
		}


		$category = new Category();

    	$now_date= date("Y/m/d h:i",time());

		$result = $category->save([
		    'name'  => $new_name,
			'update_time'=>$now_date
		],['id' => $id]);

		if($result){
            //设置成功后跳转页面的地址，默认的返回页面是$_SERVER['HTTP_REFERER']
            $this->success('新增成功','goods/index');
        } else {
            //错误页面的默认跳转页面是返回前一页，通常不需要设置
            $this->error('新增失败');
        }


	}

	// 获取当前id及递归子节点
	// 当$id="0"时，就是根节点
	public function getCategoryAndDeepCategory($id=0){

		$user_info = Session::get('user_info');
		if(empty($user_info)){
			$this->error("没有登陆","admin/index/index");
		}

		
		$list = $this->findChildCategory($id);

		// var_dump($list);
		// if(!empty($list)){
	 //       foreach($list as $key=>$value){
	 //        	// var_dump($value['id']);
		// 	    var_dump($value['id']);
		// 	}
 	// 	}
		return $list;
	}

	//递归算法，算出子节点
	public function findChildCategory($id){

		$category = new Category();

		//查找当前节点
		$node = $category::get(['id'=>$id]);

		if(!empty($node)){

          	 $this->all_list[]=$node; 
        }

        // 查找子节点
        $list = $category::all(['parent_id'=>$id]);

 		if(!empty($list)){
	       foreach($list as $key=>$value){
	        	// var_dump($value['id']);
			    $this->findChildCategory($value['id']); 
			}
 		}
 		//出口
 		return  $this->all_list;
	}

}


 ?>