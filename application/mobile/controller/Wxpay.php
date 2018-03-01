<?php
namespace app\mobile\controller;
use think\Controller;
use think\Session;  
use wxpay\UnifiedOrder_pub as UnifiedOrder;
use wxpay\JsApi_pub as JaApi;

class Wxpay extends Controller
{
	protected $wx_config=[
        'wechat_appid'=>'wxb2ec49658f641e8d',//微信公众号身份的唯一标识。审核通过后，在微信发送的邮件中查看
        'wechat_mchid'=>'1496714342',//受理商ID，身份标识 商户号
        'wechat_appkey'=>'PpOEas0GHmRhi5izoMcsz25w9TOKzrdX',//商户支付密钥Key。审核通过后，在微信发送的邮件中查看
        'wechat_appsecret'=>'19cfa460296d1d65886b59f0e106d946',//JSAPI接口中获取openid，审核后在公众平台开启开发模式后可查看

        //证书路径,注意应该填写绝对路径  不用证书也是能支付的
        'sslcert_path'=>'',
        'sslkey_path'=> '',
    ];

    protected $notify_url = "/mobile/order/haspay";   //自己定义
    protected $open_id = "1111111"; //用户唯一标识，每个公众号
    protected $order_table_param=[
        'table'=>'order',      //订单表名称
        'no_field'=>'order_sn',     //订单号 字段名字
        'state_field'=> 'pay_status',//订单支付状态值字段名
        'amount_field'=>'order_amount',//订单金额值字段名
        'pay_ok'=> '1', //订单已支付状态值
        'pay_no'=> '0',  // 订单未支付状态值
    ];

 	 public function _initialize(){

        ini_set('date.timezone','Asia/Shanghai');
        config($this->wx_config);
        //已登陆的设置openid  本人微信登录是在控制器里完成
        if (Session::has('open_id','html5')) $this->open_id=Session::get('open_id','html5');
    }

     protected function unifiedOrder($data=[]){
        $unifiedOrder = new UnifiedOrder();
        $unifiedOrder->setParameter("openid",$this->open_id); 			// openid
        $unifiedOrder->setParameter("body",'商品订单号'+$data['order_sn']); 		// 商品描术
        $unifiedOrder->setParameter("out_trade_no",$data['order_sn'].'_'.$unifiedOrder->createNoncestr(6));  // 商户订单号
        $unifiedOrder->setParameter("total_fee",$data['order_amount']*100);    // 总金额
        $unifiedOrder->setParameter("notify_url",$this->notify_url);  // 通知地址 $this->notify_url自己定义
        $unifiedOrder->setParameter("trade_type","JSAPI");      // 交易类型
        return $unifiedOrder->getPrepayId();
    }
	
	 protected function getParameters($unified_order=''){
        $jsApi= new JaApi();
        $jsApi->setPrepayId($unified_order);
        $jsApiParameters = $jsApi->getParameters();
        return $jsApiParameters;
    }

     public function payByOrderNo($order_sn='2017020453102495',$param=[]){
        $param=$this->order_table_param;
        $order_info=db($param['table'])
            ->field(' '. $param['no_field'].' , '.$param['amount_field'].' ')
            ->where($param['state_field'],'=','0')
            ->where(['order_sn'=>$order_sn])
            ->find();

        if (!$order_info) return ['code'=>1010,'msg'=>'订单不存在或者已经是完成状态'];

        $data=[
            'order_sn'=>$order_sn,
            'order_amount'=>$order_info['order_amount'],
        ];
        $unified_order = $this->unifiedOrder($data);  //统一下单
        $this->unified_order=$unified_order;
        $jsApiParameters=$this->getParameters($unified_order);
        return ['code'=>1001,'order_sn'=>$order_sn,'jsApiParameters'=>$jsApiParameters,'order_amount'=>$order_info['order_amount'],'open_id'=>$this->open_id];
    } 
	 

}
?>