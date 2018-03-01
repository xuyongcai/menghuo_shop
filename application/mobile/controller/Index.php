<?php

namespace app\mobile\controller;

use think\Controller;


class Index extends Controller{

    public function index(){

    	// 为api而生
		// app、小程序需要数据
		// 返回 return 
        return $this->fetch();
    }

    // public function getHotGoods(){

    // 	$list = db('goods')->order('id desc')->paginate(8);

    // 	return $list;
    // }
    public function getHotGoods(){
        $list = db('team_active')->alias('ta')
                            ->field('ta.id team_id, g.id id, g.goods_name, g.goods_price, g.goods_thumb')
                            ->join('goods g', 'ta.goods_id = g.id')
                            ->order('g.create_time desc')
                            ->paginate(8);
        return $list;
    }

}



?>