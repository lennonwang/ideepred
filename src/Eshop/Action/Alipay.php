<?php
/**
 * 支付宝接口类(即时到帐)
 *
 * @author purpen
 * @version $Id$
 */
class Eshop_Action_Alipay extends Eshop_Action_Common {
    protected $_model_class='Common_Model_Orders';
    
	/************支付宝配置参数******************/
    /*
     * public $aliapy_config = array(
		'partner' => '2088702162489557',
		'key' => 'k9gnpm4nfd1qmrzyq3y4nzwj31m6fjc5', //zhifub
		'seller_email' => '988238@qq.com',
		'return_url' => 'http://www.whshop.com.cn/app/eshop/alipay/direct_notify',
		'notify_url' => 'http://www.whshop.com.cn/app/eshop/alipay/secrete_notify',
		'sign_type'  => 'MD5',
		'input_charset' => 'utf-8',
		'transport' => 'http'
	);
     */
	public $aliapy_config = array(
		'partner' => '2088701875778767',
		'key' => '1v2rhj8dir0soo2mpwr0bdqpgaa6nvwb', //zhifub
		'seller_email' => '67484675@qq.com',
		'return_url' => 'http://t.ideepred.com/app/eshop/alipay/direct_notify',
		'notify_url' => 'http://t.ideepred.com/app/eshop/alipay/secrete_notify',
		'sign_type'  => 'MD5',
		'input_charset' => 'utf-8',
		'transport' => 'http'
	);
    /**
     * 订单编号
     * 
     * @var string
     */
    private $_order_ref = null;
    /**
     * 网站商品的展示地址,可以为空
     * 
     * @var string
     */
    public $show_url = "http://t.ideepred.com/";
    
    /**
     * 
     * @return Common_Model_Orders
     */
    public function wiredModel(){
        return parent::wiredModel();
    }
    //~~~~~~~~~~~~~~Action implements~~~~~~~~~~
    /**
     * default action method
     */
    public function execute(){
        return $this->payment();   
    }
    /**
     * 选定支付宝进行支付
     * 
     * @return string
     */
    public function payment(){
        $reference = $this->getOrderRef();
        if(empty($reference)){
            return $this->_hintResult('操作不当，订单号丢失！',true);
        }
        $model = new Common_Model_Orders();
        $options = array(
            'condition'=>'reference=?',
            'vars'=>array($reference)
        );
        $model->findFirst($options);
        if(!$model->count()){
            return $this->_hintResult('很抱歉，系统不存在该订单！',true);
        }
        $status = $model['status'];
        //验证此订单是否已经付款
        if($status != Common_Model_Constant::ORDER_WAIT_PAYMENT){
            return $this->_hintResult("订单[$reference]已付款！",false);
        }
        //start to pay
        $subject = "iDeepRed Wines";
        $body = "IDeepRed.com Eshop";

		$price	= $model['total_money'];	//订单总金额，显示在支付宝收银台里的“应付总额”里

		$logistics_fee		= $model['freight'];				//物流费用，即运费。
		$logistics_type		= "EXPRESS";			//物流类型，三个值可选：EXPRESS（快递）、POST（平邮）、EMS（EMS）
		$logistics_payment	= "SELLER_PAY";			//物流支付方式，两个值可选：SELLER_PAY（卖家承担运费）、BUYER_PAY（买家承担运费）

		$quantity			= "1";					//商品数量，建议默认为1，不改变值，把一次交易看成是一次下订单而非购买一件商品。

		//买家收货信息（推荐作为必填）
		//该功能作用在于买家已经在商户网站的下单流程中填过一次收货信息，而不需要买家在支付宝的付款流程中再次填写收货信息。
		//若要使用该功能，请至少保证receive_name、receive_address有值
		//收货信息格式请严格按照姓名、地址、邮编、电话、手机的格式填写
		$receive_name		= $model['name'];
		$receive_address	= $model['address'];
		$receive_zip		= !empty($model['zip']) ? $model['zip'] : '100015';
		$receive_phone		= $model['telephone'];
		$receive_mobile		= $model['mobie'];
		
        //支付宝传递参数
		$parameter = array(
			"service"			=> "create_partner_trade_by_buyer",
			"payment_type"		=> "1",

			"partner"			=> trim($this->aliapy_config['partner']),
			"_input_charset"	=> trim(strtolower($this->aliapy_config['input_charset'])),
		    "seller_email"		=> trim($this->aliapy_config['seller_email']),
		    "return_url"		=> trim($this->aliapy_config['return_url']),
		    "notify_url"		=> trim($this->aliapy_config['notify_url']),

		    "out_trade_no"		=> $reference,
			
		    "subject"			=> $subject,
		    "body"				=> $body,
		    "price"				=> $price,
			"quantity"			=> $quantity,

			"logistics_fee"		=> $logistics_fee,
			"logistics_type"	=> $logistics_type,
			"logistics_payment"	=> $logistics_payment,

			"receive_name"		=> $receive_name,
			"receive_address"	=> $receive_address,
			"receive_zip"		=> $receive_zip,
			"receive_phone"		=> $receive_phone,
			"receive_mobile"	=> $receive_mobile,

	        "show_url"			=> $this->show_url
		);
		
        $alipay = new Common_Util_AlipayService($this->aliapy_config);
        $url = $alipay->create_partner_trade_by_buyer($parameter);
        
        return $this->redirectResult($url);
    }
    
    /**
     * 支付成功后，后台通知到action
     * 即支付宝中指定的notify_url
     * 
     * @return string
     */
    public function secreteNotify(){
        $alipay = new Common_Util_AlipayNotify($this->aliapy_config);
        $verify_result = $alipay->verifyNotify();
        
        if($verify_result){
			#$out_trade_no	= $_POST['out_trade_no'];	    //获取订单号
		    $trade_no		= $_POST['trade_no'];	    	//获取支付宝交易号
		    $total			= $_POST['price'];				//获取总价格
		
            $order_ref = $_POST['out_trade_no'];
            $payAmount = $_POST['total_fee'];
            
            $receive_name = $_POST['receive_name'];
            $receive_address = $_POST['receive_address'];
            $receive_zip = $_POST['receive_zip'];
            $receive_phone = $_POST['receive_phone'];
            $receive_mobile = $_POST['receive_mobile'];
            
            $trade_status = $_POST['trade_status'];
			$status_array = array('WAIT_SELLER_SEND_GOODS','WAIT_BUYER_CONFIRM_GOODS','TRADE_FINISHED');
            if($trade_status == 'WAIT_BUYER_PAY'){
				# 该判断表示买家已在支付宝交易管理中产生了交易记录，但没有付款
                self::warn("The buyer no pay!", __METHOD__);
				$result = "success";
			}elseif($trade_status == 'WAIT_SELLER_SEND_GOODS'){
                # 该判断表示买家已在支付宝交易管理中产生了交易记录且付款成功，但卖家没有发货
                self::warn("verify_success", __METHOD__);
                try{
                    $order = new Common_Model_Orders();
                    $options = array(
                        'condition'=>'reference=?',
                        'vars'=>array($order_ref)
                    );
                    $order->findFirst($options);
                        
                    if($order->count()){
                        $_id = $order['id'];
                        $pay_money = $order['pay_money'];
                        $status = $order['status'];
                        /*
                        if($pay_money != $payAmount){
                            self::warn("支付金额[$payAmount]与应付金额[$pay_money]不等!", __METHOD__);
                            $result = "fail";
                            return $this->rawResult($result);
                        }*/
                        //验证此订单是否已经付款
                        if($status < Common_Model_Constant::ORDER_READY_GOODS){
                            //设置订单状态为已配货中
                            $order->setReadyGoods($_id);
                            self::debug("更新订单状态完成 -alipay。",__METHOD__);
                        }else{
                            self::warn("此订单[$order_ref]已支付成功！-alipay",__METHOD__);
                        }
                        $result = "success";
                    }else{
                        $msg = "此订单号[$order_ref]不存在!";
                        self::warn("此订单号[$order_ref]不存在!",__METHOD__);
                    }
                }catch(Anole_Exception $e){
                    $result = "fail";
                    self::warn("支付宝支付订单[$order_ref]异常：".$e->getMessage(),__METHOD__);
                }
			}elseif($trade_status == 'WAIT_BUYER_CONFIRM_GOODS'){
				# 该判断表示卖家已经发了货，但买家还没有做确认收货的操作
				try{
                    $order = new Common_Model_Orders();
                    $options = array(
                        'condition'=>'reference=?',
                        'vars'=>array($order_ref)
                    );
                    $order->findFirst($options);
                        
                    if($order->count()){
                        $_id = $order['id'];
                        $pay_money = $order['pay_money'];
                        $status = $order['status'];
                        /*
                        if($pay_money != $payAmount){
                            self::warn("支付金额[$payAmount]与应付金额[$pay_money]不等!", __METHOD__);
                            $result = "fail";
                            return $this->rawResult($result);
                        }*/
                        //验证此订单是否已经付款
                        if($status <= Common_Model_Constant::ORDER_SENDED_GOODS){
                            //设置订单状态为已配货中
                            $order->setSendedGoods($_id);
                            self::debug("更新订单状态为已发货等待确认。 -alipay。",__METHOD__);
                        }else{
                            self::warn("此订单[$order_ref]已支付成功！-alipay",__METHOD__);
                        }
                        $result = "success";
                    }else{
                        $msg = "此订单号[$order_ref]不存在!";
                        self::warn("此订单号[$order_ref]不存在!",__METHOD__);
                    }
                }catch(Anole_Exception $e){
                    $result = "fail";
                    self::warn("支付宝支付订单[$order_ref]异常：".$e->getMessage(),__METHOD__);
                }
				
			}elseif($trade_status == 'TRADE_FINISHED'){
				# 该判断表示买家已经确认收货，这笔交易完成
				try{
                    $order = new Common_Model_Orders();
                    $options = array(
                        'condition'=>'reference=?',
                        'vars'=>array($order_ref)
                    );
                    $order->findFirst($options);
                        
                    if($order->count()){
                        $_id = $order['id'];
                        $pay_money = $order['pay_money'];
                        $status = $order['status'];
                        //验证此订单是否已经付款
                        if($status <= Common_Model_Constant::ORDER_PUBLISHED){
                            //设置订单状态为完成
                            $order->setOrderPublished($_id);
                            self::debug("更新订单状态为已完成。 -alipay。",__METHOD__);
                        }else{
                            self::warn("此订单[$order_ref]已成功！-alipay",__METHOD__);
                        }
                        $result = "success";
                    }else{
                        $msg = "此订单号[$order_ref]不存在!";
                        self::warn("此订单号[$order_ref]不存在!",__METHOD__);
                    }
                }catch(Anole_Exception $e){
                    $result = "fail";
                    self::warn("支付宝支付订单[$order_ref]异常：".$e->getMessage(),__METHOD__);
                }
	
            }else{
                self::warn("支付未完成-alipay", __METHOD__);
                $result = "fail";
            }

        }else{
            //支付失败
            self::warn("verify_failed", __METHOD__);
            $result = "fail";
        }
        
        return $this->rawResult($result);
    }
    
    /**
     * 支付成功后，直接跳转到action
     * 即支付宝中指定的return_url
     * 
     * @return string
     */
    public function directNotify(){
        $alipay = new Common_Util_AlipayNotify($this->aliapy_config);
        $verify_result = $alipay->verifyReturn();
        
		// $out_trade_no	= $_GET['out_trade_no'];	//获取订单号
	    $trade_no		= $_GET['trade_no'];		//获取支付宝交易号
	    $total_fee		= $_GET['price'];			//获取总价格
        //获取支付宝的反馈参数
        $order_ref = $_GET['out_trade_no'];
        $payAmount = $_GET['price'];
        
        $msg = "";
        if($verify_result){
            //买家付款成功
            self::debug("通过支付宝支付成功！",__METHOD__);
            
            $trade_status = $_GET['trade_status'];
            if($trade_status == 'WAIT_SELLER_SEND_GOODS'){
                try{
                    $order = new Common_Model_Orders();
                    $options = array(
                        'condition'=>'reference=?',
                        'vars'=>array($order_ref)
                    );
                    $order->findFirst($options);
                        
                    if($order->count()){
                        $_id = $order['id'];
                        $status = $order['status'];
                        //验证此订单是否已经付款
                        if($status < Common_Model_Constant::ORDER_READY_GOODS){
                            //设置订单状态为已配货中
                            $order->setReadyGoods($_id);
                            self::debug("更新订单状态完成 -alipay。",__METHOD__);
                        }else{
                            self::warn("此订单[$order_ref]已支付成功！-alipay",__METHOD__);
                        }
                        $result = "success";
                    }else{
                        $msg = "此订单号[$order_ref]不存在!";
                        self::warn("此订单号[$order_ref]不存在!",__METHOD__);
                    }
                }catch(Anole_Exception $e){
                    $result = "fail";
                    self::warn("支付宝支付订单[$order_ref]异常：".$e->getMessage(),__METHOD__);
                }
            }else{
                //支付失败
                self::debug("通过支付宝支付失败！",__METHOD__);
                $msg = "通过支付宝支付失败,请认真检查！";
            }
            
        }else{
            //支付失败
            self::debug("通过支付宝支付失败！",__METHOD__);
            $msg = "通过支付宝支付失败,请认真检查！";
        }
        
        $this->putContext('payAmount', $payAmount);
        $this->putContext('order_ref', $order_ref);
        $this->putContext('msg', $msg);
        
        return $this->smartyResult('eshop.shopping.pay_result');
    }
    
    public function setOrderRef($ref){
        $this->_order_ref = $ref;
        return $this;   
    }
    public function getOrderRef(){
        return $this->_order_ref;
    }
    
}
/**vim:sw=4 et ts=4 **/
?>