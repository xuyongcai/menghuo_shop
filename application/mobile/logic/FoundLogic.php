<?php
namespace app\mobile\logic;
use think\Model;
use think\Session; 

/**
* 拼团的开团逻辑层
*/
class FoundLogic extends Model
{
	/**
	 * 获取开团列表
	 * @param  int $team_id 拼团的ID
	 * @return array          所有的开团列表
	 */
	 public function getList($team_id){
	 
		try{			
			return db('team_found')->alias('tf')
			->field('tf.id, tf.create_time, tf.user_id, tf.need_num, tf.status, u.username')
			->join('user u', "u.id=tf.user_id and tf.team_id = $team_id")
			->select();
			
		}catch(\Exception $e){
			return "error";
		}

	 }

	  public function add($add_data)
	 {
	 	// found_end_time
	 	db('team_found')->insert([
	 		'found_time'=>time(),
	 		'user_id'=>$add_data['user_id'],
	 		'team_id'=>$add_data['active_id'],
	 		'order_id'=>$add_data['order_id']
	 	]);
	 }


	 // 更新人数
	 public function update_num($found_id)
	 {
	 	 // 增加这个团的参团人数
	 	db('team_found')->where('found_id='.$found_id)->setInc("join_num");
	 	// 减少这个团的所需人数
	 	db('team_found')->where('found_id='.$found_id)->setDec("need");
	 }
 
}


?>