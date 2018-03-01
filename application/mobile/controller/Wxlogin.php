<?php
namespace app\mobile\controller;
use think\Controller;
use mikkle\tp_wechat\WechatApi;

class User extends WechatApi
{
	 protected $options=[
		'token'=>'*****',
		'appid'=>'******************',
		'appsecret'=>'*********************************',
		'encodingaeskey'=>'******************************',
		];
		protected $valid = false; //网站第一次匹配 true 1为匹配
		protected $isHook = false; //是否开启钩子
}
?>