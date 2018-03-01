<?php
namespace app\mobile\controller;
use think\Controller;

class Search extends Controller{

   public function index()
   {
       $list = db('category')->select();
       $cate_tree = setCategoryTree($list);
       $this->assign("cate_tree",json_encode($cate_tree));
       return $this->fetch();
   }

   public function search()
   {
      $category_id = input("category_id");
      $cate_sql = "";
      if($category_id){
        $cate_sql = " and category_id = $category_id";
      }
      $value = input("value");
      $sql = "goods_name like '%".$value."%'".$cate_sql;
      $list = db("goods")->where($sql)->select();
      return $list;
   }

   public function sortBytype()
   {
      $category_id = input("category_id");
      $cate_sql = "";
      if($category_id){
        $cate_sql = " and category_id = $category_id";
      }

      $type = input("type");
      $priceType = input("priceType");
      $value = input("value");
      $sql = "goods_name like '%".$value."%'".$cate_sql;

      if($priceType == 1){
        $sql.=" and (goods_price > 0 and goods_price <= 50)";
      }elseif ($priceType == 2) {
        $sql.=" and (goods_price > 50 and goods_price <= 100)";
      }elseif ($priceType == 3) {
        $sql.=" and (goods_price > 100 and goods_price <= 200)";
      }elseif ($priceType == 4){
        $sql.=" and goods_price > 200";
      }

      if($type == 0){
        $list = db("goods")->where($sql)->select();
      }if ($type == 1) {
        $list = db("goods")->where($sql)->order("comment_num desc")->select();
      }elseif($type == 2) {
        $list = db("goods")->where($sql)->order("sales_volume desc")->select();
      }elseif($type == 3){
        $list = db("goods")->where($sql)->order("goods_price desc")->select();
      }elseif($type == 4){
        $list = db("goods")->where($sql)->order("goods_price asc")->select();
      }
      return $list;

   }

   public function lists()
   {
     $category_id = input("category_id");
     $list = db("goods")->where("category_id = $category_id")->select();
     $this->assign("list",json_encode($list));
     $this->assign("category_id",$category_id);
     return $this ->fetch();
   }


}

?>
