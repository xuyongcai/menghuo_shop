<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
function idAsKey($arr,$column){

	$rtn_arr = [];

	foreach ($arr as $key => $value) {
		
		$rtn_arr[$value[$column]] = $value;
	}
	return $rtn_arr;
}


// 树状结构
// 奶粉
// 		山羊奶
// 		牛奶
//  玩具
//  	奥特曼
//  	小驴汤米
function setCategoryTree($data){
	
	$tree_a = [];
	foreach ($data as $key => $value) {
		
		if($value['parent_id'] == 0){
			$value['child_menu']=[];
			$tree_a[$value['id']] = $value;
		}else{
			//二级分类
			$tree_a[$value['parent_id']]['child_menu'][$value['id']] = $value;

		}
	}
	return $tree_a;
}


// 'data:image/jpeg;base64,iVBORw0KGgoAAAANSUhEUgAAAFoAAAA7CAYAAAD7AJ39AAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAADcdSURBVHhebZz1dyTZneXl7iKVoMRMKWZmLKlEpRJjiZmZlaIjSjFzMXT3jNc93lmvYecMeOzudrftMc2Mmd32eOGfuHu/L1Llnj37wzuRGalMKT9x437v98ULmeTkZuL+gxwUFuWhqDAPZaUFqKoqwcOHFWhsfIjW1ga0tzWis6sVvX2d6O/vRF9vOwYHujE2OozxiWGsri3hy1/5Cr75wUf46Fsf45Nvfxff/Zfv4Xvf/yF++KN/w7/++Kf48U9/iZ/94tf4xa9/h1/99g/47e//hN99+h/4w5/+J/74H/8Lf/rz/8EH3/oEW7tbmF/UY2FlFps769g52Mbe8R5OH53j9PEFTi5PcXR+hMOTA5zx+dmTRzh/+'...
function base64_upload($base64) {
    $base64_image = str_replace(' ', '+', $base64);
    //post的数据里面，加号会被替换为空格，需要重新替换回来，如果不是post的数据，则注释掉这一行
    if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64_image, $result)){
        //匹配成功
        if($result[2] == 'jpeg'){
            $image_name = uniqid().'.jpg';
            //纯粹是看jpeg不爽才替换的
        }else{
            $image_name = uniqid().'.'.$result[2];
        }
        
        //文件存储路径(相对路径需要和下面的路径相同)
        $image_file = ROOT_PATH."./public/uploads/images/{$image_name}";

        //服务器文件存储路径
        if (file_put_contents($image_file, base64_decode(str_replace($result[1], '', $base64_image)))){
            return '/public/uploads/images/'.$image_name;
        }else{
            return false;
        }
    }else{
        return false;
    }
}

use think\Request;
function set_menu_class($controller){
    if(Request::instance()->controller() == ucfirst($controller)){
        return "btn-primary";
    }else{
        return "btn-success";
    }
}
function set_mobile_class($controller){
    if(Request::instance()->controller() == ucfirst($controller)){
        return "icon_cur";
    }else{
        return "";
    }
}