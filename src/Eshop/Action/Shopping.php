<?php
/**
 * 购买流程及支付流程
 *
 * @version $Id$
 * @author purpen
 */
class Eshop_Action_Shopping extends Eshop_Action_OrderParams {
    protected $_model_class='Common_Model_Orders';
    
    private $_pid = null;
    
    /**
     * 订单编号
     * 
     * @var string
     */
    private $_order_ref = null;
    /**
     * 购买产品的数量
     * 
     * @var string
     */
    private $_quantity = 1;
    /**
     * 产品型号
     * @var string
     */
    private $_size = null;
    
    /**
     * 订单提交的步骤
     * 
     * @var string
     */
    private $_step = 'address'; //payment,transfer,invoice,notice,all
    
    private $_next_step = null;
    
    /**
     * 省份id
     * 
     * @var string
     */
    private $_province_id = null;
    /**
     * 城市id
     * 
     * @var string
     */
    private $_city_id = null;
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
        return $this->cart();   
    }
    
    /**
     * 完整购物车页面
     * 
     * @return string
     */
    public function cart(){
        $back_url = Common_Util_Url::getBackUrl();
        if(empty($back_url)){
            $back_url = Common_Util_Url::app_root_url();
        }
        
        $cart = new Common_Util_Cart();
        
        $products = $cart->com_list;
        $total_money = $cart->getTotalAmount();
        $items_count = $cart->getItemCount();
        
        $this->putContext('products',$products);
        $this->putContext('total_money', $total_money);
        $this->putContext('items_count', $items_count);
        
        $this->putContext('back_url', $back_url);

		$this->putSharedParam();
        
        return $this->smartyResult('eshop.shopping.cart');
    }
    
    /**
     * 加入到购物车
     * 
     * @return string
     */
    public function buy(){
        $back_url = $this->getContext()->getRequest()->getReferer();
        Common_Util_Url::setBackUrl($back_url);
        
        $com_sku = $this->getId();
        $quantity = $this->getQuantity();
        $com_size = $this->getSize();
        
        self::debug("Product[$com_sku] and quantity[$quantity] and size[$com_size]", __METHOD__);
        
        $cart = new Common_Util_Cart();
        $cart->addItem($com_sku,$com_size);
        $cart->setItemQuantity($com_sku,$com_size,$quantity);
        
        //重置到cookie
        $cart->set();
        
        return $this->redirectResult('/app/eshop/shopping/cart');
    }
    /**
     * 增加产品的数量
     * 
     * @return string
     */
    public function buyMore(){
        $com_sku = $this->getId();
        $quantity = $this->getQuantity();
        $com_size = $this->getSize();
        
        self::debug("Product[$sku] and quantity[$quantity] and size[$com_size]", __METHOD__);
        
        $cart = new Common_Util_Cart();
        $cart->setItemQuantity($com_sku,$com_size,$quantity);
        //重置到cookie
        $cart->set();
        
        $product = $cart->findItem($com_sku,$com_size);
        $total_money = $cart->getTotalAmount();
        $items_count = $cart->getItemCount();
        
        $this->putContext('items_count', $items_count);
        $this->putContext('total_money', $total_money);
        $this->putContext('p',$product);
        
        return $this->jqueryResult('eshop.shopping.more');
    }
    
    
    /**
     * 从购物车中删除某商品
     * 
     * @return string
     */
    public function remove(){
        $com_sku = $this->getId();
        $com_size = $this->getSize();
        
        $cart = new Common_Util_Cart();
        
        $cart->delItem($com_sku,$com_size);
        //重置到cookie
        $cart->set();
		
        $total_money = $cart->getTotalAmount();
        $items_count = $cart->getItemCount();
        
        $this->putContext('items_count', $items_count);
        $this->putContext('total_money', $total_money);
        $this->putContext('sku', $com_sku);
        
        if($cart->com_item <= 0){
            return $this->jqueryResult('eshop.shopping.clear');
        }
        
        return $this->jqueryResult('eshop.shopping.del_ok');
    }
    
    /**
     * 清空购物车
     * 
     * @return string
     */
    public function clear(){
        $cart = new Common_Util_Cart();
        $cart->clearCookie();
        
        return $this->jqueryResult('eshop.shopping.clear');
    }
    
  
    /**
     * 填写订单信息
     *
     * @return string
     */
    public function checkout(){
    	if(!Anole_Util_Cookie::hasUserLogged()){
    		$back_url = $this->getContext()->getRequest()->getRequestUri();
    		Common_Util_Url::setBackUrl($back_url);
    		return $this->redirectResult('/app/eshop/profile/login');
    	}
    	$uid = Anole_Util_Cookie::getUserID();
    	//$user_data = Greare_Util_Dataset::getUserById($uid);
    
    	$step = $this->getStep();
    	$next_step = $this->getNextStep();
    	self::debug("[check_out]::step:[$step]\t..next_step:[$next_step]", __METHOD__);
    	$cart = new Common_Util_Cart();
    	if(empty($cart->com_list)){
    		//没有购物，不可以去结算
    		$url = Common_Util_Url::app_root_url();
    		return $this->_hintResult('您购物车里还没有选择商品,不能去结算!', true, $url);
    	}
    
    	$model = new Common_Model_OrdersData();
    	//预设临时订单编号
    	$reference = Common_Util_Shop::getOrderReference();
    	self::debug("get exist reference[$reference]..", __METHOD__);
    	// if(is_null($reference)){
    	//     $reference = Common_Util_Shop::_genOderReference();
    	//     Common_Util_Shop::setOrderReference($reference);
    	//  }
    	//检测是否已存在临时订单信息
    	$condition = 'reference=? AND expire > ?';
    	$vars = array($reference, Common_Util_Date::getUnixTimestamp());
    	$value = array();
    
    	$model->findFirst(array('condition'=>$condition,'vars'=>$vars));
    	if(!is_null($reference) &&  $model->count() ){
    		$value = unserialize($model['data']);
    	}else{
    		//查看用户是否有默认配送地址
    		$addbooks = new Common_Model_Addbooks();
    		self::debug("!!! checkout user[$uid] addbook", __METHOD__);
    		$options = array(
    				'condition'=>'user_id=?',
    				'vars'=>array($uid),
    				'order'=>'is_default DESC,id DESC'
    		);
    		$addinfo = $addbooks->findFirst($options)->getResultArray();
    
    		$default_value = unserialize($this->getDefaultData());;
    		//订单的默认设置
    		$value = array_merge($default_value,$addinfo);
    
    		$model->setIsNew(true);
    		$model->setId(null);
    		$reference = Common_Util_Shop::_genOderReference();
    		$model->setReference($reference);
    		$model->setData(serialize($value));
    		$model->save();
    		Common_Util_Shop::setOrderReference($reference);
    		self::debug('insert orders temp data done...', __METHOD__);
    	}
    	$areas = new Common_Model_Areas();
    	//get all province
    	$options = array(
    			'condition'=>'type=?',
    			'vars'=>array('p'),
    			'order'=>'id ASC'
    	);
    	$provinces = $areas->find($options)->getResultArray();
    	$this->putContext('provinces', $provinces);
    	//get all city
    	if(isset($value['province']) && $value['province'] > 0){
    		$options2 = array(
    				'condition'=>'parent_id=? AND type=?',
    				'vars'=>array($value['province'], 'c'),
    				'order'=>'id DESC'
    		);
    		$citys = $areas->find($options2)->getResultArray();
    		$this->putContext('citys', $citys);
    	}
    
    	$this->putContext('data', $value);
    
    	//获取用户注册信息
    	$user = new Common_Model_User();
    	$user_row = $user->findById($uid)->getResultArray();
    	$this->putContext('user_data', $user_row);
    	unset($user);
    
    	$this->putContext('step', $step);
    	$this->putContext('next_step',$next_step);
    
    	// $this->putSharedParam();
    	$this->doProcess();
    	return $this->smartyResult('eshop.shopping.checkout_payment');
    	// return $this->smartyResult('eshop.shopping.checkout_address');
    }
    
    /**
     * 设置订单的扩展参数
     * 
     * @return void
     */
    protected function _setExtraParams($province=null){
        $order = new Common_Model_Orders();
        //获取付款方式列表
        $payment_methods = $order->findPaymentMethods();
        $this->putContext('payment_methods', $payment_methods);
		
        //获取送货方式
        $transfer_methods = $order->findTransferMethods();
		if(!empty($province)){
			// $order->validateExpressFees($province);
			self::debug("[order]!!!!!!!!!!!".$province);
			$order->validateExpressFeesByKey('a',$province);
			$transfer_methods['a']['freight'] = $order->getFees();
			$order->validateExpressFeesByKey('b',$province);
			$transfer_methods['b']['freight'] = $order->getFees();
		}
        $this->putContext('transfer_methods', $transfer_methods);
        //获取送货时间列表
        $transfer_times = $order->findTransferTime();
        $this->putContext('transfer_times', $transfer_times);
        //获取发票内容类型
        $invoice_category = $order->findInvoiceCategory();
        $this->putContext('invoice_category', $invoice_category);
        
        //获取城市地址
        $areas = new Common_Model_Areas();
        //get all province
        $options = array(
        		'condition'=>'type=?',
        		'vars'=>array('p'),
        		'order'=>'id ASC'
        );
        $provinces = $areas->find($options)->getResultArray();
        $this->putContext('provinces', $provinces);
        //get all city
        if(isset($value['province']) && $value['province'] > 0){
        	$options2 = array(
        			'condition'=>'parent_id=? AND type=?',
        			'vars'=>array($value['province'], 'c'),
        			'order'=>'id DESC'
        	);
        	$citys = $areas->find($options2)->getResultArray();
        	$this->putContext('citys', $citys);
        }
        unset($order);
    }
  
    
    /**
     * 订单支付和确认页面
     * 
     * @return string
     */
    public function doPayment(){
        if(!Anole_Util_Cookie::hasUserLogged()){
            $back_url = $this->getContext()->getRequest()->getRequestUri();
            Common_Util_Url::setBackUrl($back_url);
            return $this->redirectResult('/app/eshop/profile/login');
        }
    	$this->doProcess($step);

    	$next_step = $this->getNextStep();
        if(!empty($next_step)){
            return $this->redirectResult($next_step);
        }
         $this->putSharedParam(); 
         
         //加载确认页面需要线上的信息
         $cart = new Common_Util_Cart();
         if(empty($cart->com_list)){
         	//没有购物，不可以去结算
         	$url = Common_Util_Url::app_root_url();
         	return $this->_hintResult('您购物车里还没有选择商品,不能去结算!', true, $url);
         }
         self::debug('validate done....', __METHOD__);
         $products = $cart->com_list;
         $total_money = $cart->getTotalAmount();
         $items_count = $cart->getItemCount(); 
         $this->putContext('products',$products);
         $this->putContext('total_money',$total_money); 
         //get pay money
         $reference = Common_Util_Shop::getOrderReference(); 
         $model = new Common_Model_OrdersData();
         $condition = 'reference=? AND expire > ?';
         $vars = array($reference,Common_Util_Date::getUnixTimestamp());
         
         $model->findFirst(array('condition'=>$condition,'vars'=>$vars));
         $data = array();
         $_id = null;
         if($model->count()){
         	$data = @unserialize($model['data']);
         }
         $order = new Common_Model_Orders(); 
         $order->validateExpressFeesByKey($data['transfer'],$data['province']);
         $transfer = $order->findTransferMethods($data['transfer']);
         $freight  = $order->getFees(); 
         //促销活动优惠金额
         $sale_amount = $this->validate_user_sale($total_money); 
         //实付金额
         $pay_money = $total_money + $freight - $sale_amount; 
         $this->putContext('pay_money', $pay_money);
         $this->putContext('freight', $freight);
         $this->putContext('sale_amount', $sale_amount);
         
         unset($order);
         unset($model);
         
        return $this->smartyResult('eshop.shopping.checkout_confirm');
    }
    /**
     * 验证注册用户，是否符合促销活动要求
     * 
     * @return void
     */
    protected function validate_user_sale($total_money) {
        //3月7号关闭促销活动
        $sale_amount = 0;
        return $sale_amount;
        //3月份注册，并3月份购买的用户，总额减少20元
        $date = date('Y-m-d', time());
        $start_date = '2011-03-01';
        $end_date   = '2011-04-01';
        
        if(($date >= $start_date) && ($date < $end_date)){
            $uid = Anole_Util_Cookie::getUserID();
            $condition = 'id=? AND created_on >= ? AND created_on < ?';
            $vars = array($uid,$start_date,$end_date);
            
            $user = new Common_Model_User();
            $info = $user->findFirst(array('condition'=>$condition,'vars'=>$vars))->getResultArray();
            if(empty($info)){
                return;
            }
            $sale_amount = 20;
        }
        //验证订单总额，是否超过优惠金额
        if($total_money <= $sale_amount){
            $sale_amount = 0;
        }
        
        
        return $sale_amount;
    }
   
    
    /**
     * 确认订单信息
     * 
     * @return string
     */
    public function doOrderOk(){
        $this->doProcess(); 
        $next_step = $this->getNextStep();
        if(!empty($next_step)){
            return $this->redirectResult($next_step);
        } 
        return $this->doConfirm();
    }
    /**
     * 处理订单信息，并保存到临时表中
     * 
     * @return sting
     */
    public function doProcess(){
        $model = new Common_Model_OrdersData();
        
        $reference = Common_Util_Shop::getOrderReference();
        if(is_null($reference)){
            $reference = Common_Util_Shop::_genOderReference();
            Common_Util_Shop::setOrderReference($reference);
        }
        try{
            $condition = 'reference=? AND expire > ?';
            $vars = array($reference,Common_Util_Date::getUnixTimestamp());
            
            $model->findFirst(array('condition'=>$condition,'vars'=>$vars));
            $data = array();
            $_id = null;
            if($model->count()){
                $_id = $model['id'];
                $data = @unserialize($model['data']);
            }
            if($_id > 0){ //更新信息
                $model->setIsNew(false);
                $model->setId($_id);
            }else{
                $model->setIsNew(true);
                $model->setId(null);
                $model->setReference($reference);
            }
            $_data = $this->getAllData();
            $value = array_merge($data,$_data);
                
            $model->setData(serialize($value));
            
            $model->save();
        }catch(Common_Model_Exception $e){
            self::warn("validate shopping failed:".$e->getMessage(), __METHOD__);
        }catch(Anole_ActiveRecord_Exception $e){
            self::warn("save shopping failed:".$e->getMessage(), __METHOD__);
        }
        //获取快递区域
		$province = $value['province'];
        $this->putContext('data', $value);
        
        $this->_setExtraParams($province);
    }
    
    
    /**
     * 确认订单详细信息
     * 保存至正式数据库Order表
     * @return string
     */
    public function doConfirm(){
        $reference = Common_Util_Shop::getOrderReference();
        if(is_null($reference)){
            //没有临时订单编号，说明为非法操作。
            self::warn('reference is Null on the confirm order!', __METHOD__);
            return $this->jsonResult(301, '请认真填写订单信息！');
        }
        $cart = new Common_Util_Cart();
        if(empty($cart->com_list)){
            //没有购物，不可以去结算
            return $this->jsonResult(301, '您的购物车中没有商品！');
        }
        $model = new Common_Model_OrdersData();
        $condition = 'reference=? AND expire > ?';
        $vars = array($reference,time());
        $value = array();
        
        $model->findFirst(array('condition'=>$condition,'vars'=>$vars));
        if(!$model->count()){
            //没有填写订单信息，返回重新填写
            return $this->jsonResult(301, '订单信息不完整，请补充！');
        }
        $value = unserialize($model['data']);
        
        $user_id = Anole_Util_Cookie::getUserID();
        $context = $this->getContext();
        $ip = $context->getRequest()->getClientIp();
        try{
            
            $orders = new Common_Model_Orders();
            //获取配送方式及运费
		//	$orders->validateExpressFees($value['province']);
			$orders->validateExpressFeesByKey($value['transfer'],$value['province']);
            $transfer = $orders->findTransferMethods($value['transfer']);
            $freight = $orders->getFees();
            self::debug("[PaymentConfirm]:transfer::".$data['transfer']."\t province::".$data['province']."|freight:::".$freight, __METHOD__);
            $orders->setIsNew(true);
            $orders->setId(null);
            $orders->setReference($reference);
            $orders->setUserId($user_id);
            
            $total_money = $cart->getTotalAmount();
            foreach($cart->com_list as $com){
            	$sale_price = $com['sale_price'];
            	$price = $com['price'];
            	$product_id = $com['sku'];
            	$quantity = $com['quantity'];
            	$com_size = $com['size'];
            	
            	//保存订单明细信息
                $orders->AddOrderDetails($user_id,$product_id,$sale_price,$price,$quantity,$com_size);
            }
            
            //促销活动优惠金额
            $sale_amount = $this->validate_user_sale($total_money);
            
            //实付金额
            $pay_money = $total_money + $freight - $sale_amount;
            self::debug("[PaymentConfirm]::".$pay_money."\t total_money::".$total_money."|freight:::".$freight, __METHOD__);
            $orders->setFreight($freight);
            $orders->setTotalMoney($total_money);
            $orders->setCardMoney($sale_amount);
            $orders->setPayMoney($pay_money);
            
            $orders->setName($value['name']);
            $orders->setEmail($value['email']);
            $orders->setProvince($value['province']);
            $orders->setCity($value['city']);
            $orders->setArea($value['area']);
            $orders->setAddress($value['address']);
            $orders->setZip($value['zip']);
            $orders->setMobie($value['mobie']);
            $orders->setTelephone($value['telephone']);
            
            $orders->setIsInvoice($value['is_invoice']);
            $orders->setInvoiceTitle($value['invoice_title']);
            $orders->setInvoiceCaty($value['invoice_caty']);
            $orders->setInvoiceContent($value['invoice_content']);
            $orders->setInvoiceType($value['invoice_type']);
            
            $orders->setSummary($value['summary']);
            
            $orders->setTransfer($value['transfer']);
            $orders->setTransferTime($value['transfer_time']);
            
            $orders->setPaymentMethod($value['payment_method']);
            
            $date = date('Y-m-d H:i:s');
            $orders->setCreatedOn($date);
            $orders->setIp($ip);
            //设置订单状态
            if($value['payment_method'] == 'c'){ //货到付款
                $orders->setStatus(Common_Model_Constant::ORDER_WAIT_CHECK);
            }else{
                $orders->setStatus(Common_Model_Constant::ORDER_WAIT_PAYMENT);
            }
            
            $orders->save();
            
            $order_id = $orders->getId();
            
            //清空购物车
            $cart->clearCookie();
            
            //清除订单临时数据
            $model->destroyAll('reference=?',array($reference));
            
            //清除订单编号的session
            Common_Util_Shop::clearOrderReference();
            
            $msg = '订单处理完成';
            
            //自动为用户添加地址薄
            $addbook = new Common_Model_Addbooks();
            $addbook->createAddress($user_id,$value);
            
            //发送下订单成功通知
            $username = Anole_Util_Cookie::getUsername();
            //$user_data = Greare_Util_Dataset::getUserById($user_id);
            if(!empty($user_data)){
                $pay_method = $orders->findPaymentMethods($value['payment_method']);
            }
            
        }catch(Common_Model_Exception $e){
            self::warn("validate order failed: ".$e->getMessage(), __METHOD__);
            $msg = $e->getMessage();
            return $this->jsonResult(502, $msg);
        }catch(Anole_ActiveRecord_Exception $e){
            self::warn("save order failed: ".$e->getMessage(), __METHOD__);
            $msg = "订单某些必填数据还没填写,请补充完整后提交。";
            return $this->jsonResult(502, $msg);
        }
        
        $this->putContext('msg', $msg);
        $this->putContext('order_ref', $reference);
		
        $this->putSharedParam();
		
        return $this->jsonResult();
    }
    
    
    /**
     * 成功提交订单
     * 
     * @return string
     */
    public function doSuccess(){
        $model = $this->wiredModel();
        $order_ref = $this->getOrderRef();
        if(empty($order_ref)){
            return $this->_hintResult('操作不当，请先看使用帮助！',true);
        }
        
        $options = array(
            'condition'=>'reference=?',
            'vars'=>array($order_ref)
        );
        $model->findFirst($options);
        
        $pm_key = $model['payment_method'];
        $payment_method = $model->findPaymentMethods($pm_key);
        
        $this->putContext('order_ref', $order_ref);
        $this->putContext('pm_key',$pm_key);
        $this->putContext('payment_method', $payment_method);
        $this->putContext('order', $model);

		$this->putSharedParam();
		
		//成功提交订单后，发送提醒邮件<异步进程处理>
        $datetime = Common_Util_Date::getNow();
        $to = array('purpen.w@gmail.com');
        $subject = 'whshop订单提醒';
        $body = "客户订单[$order_ref]于 $datetime 已成功下单，请及时查看处理～"; 
        
        for($i=0;$i<count($to);$i++){
            $sender = new Common_Model_Postoffice();
            $sender->setIsNew(true);
            $sender->setMailto($to[$i]);
            $sender->setSubject($subject);
            $sender->setBody($body);
            $sender->setMailfrom('100jia.cc@gmail.com');
            $sender->setFromName('100jia');
            $sender->setCreatedOn($datetime);
            $sender->setState(Common_Model_Postoffice::DEFAULT_STATE);
            $sender->save();
        }
		
		
        return $this->smartyResult('eshop.shopping.checkout_success');
    }
    
    /**
     * 修改订单信息
     * 
     * @return string
     */
    public function modify(){
        $model = new Common_Model_OrdersData();
        $step = $this->getStep();
        $next_step = $this->getContext()->getRequest()->getReferer();
        
        $reference = Common_Util_Shop::getOrderReference();
        if(is_null($reference)){
            $reference = Common_Util_Shop::_genOderReference();
            Common_Util_Shop::setOrderReference($reference);
        }
        $uid = Anole_Util_Cookie::getUserID();
        
        $condition = 'reference=? AND expire > ?';
        $vars = array($reference,Common_Util_Date::getUnixTimestamp());
        $value = array();
        
        $model->findFirst(array('condition'=>$condition,'vars'=>$vars));
        if($model->count()){
            $value = unserialize($model['data']);
        }
        
        if($step == 'address'){
            $current_province_id = isset($value['province']) ? isset($value['province']) : null;
            $current_city_id = isset($value['city']) ? isset($value['city']) : null;
            
            $areas = new Common_Model_Areas();
            //get all province
            $options = array(
                'condition'=>'type=?',
                'vars'=>array('p'),
                'order'=>'id ASC'
            );
            $provinces = $areas->find($options)->getResultArray();
            $this->putContext('provinces', $provinces);
          
            
            //get all city
            if(isset($value['province']) && $value['province'] > 0){
            	$options2 = array(
            			'condition'=>'parent_id=? AND type=?',
            			'vars'=>array($value['province'], 'c'),
            			'order'=>'id DESC'
            	);
            	$citys = $areas->find($options2)->getResultArray();
            	$this->putContext('citys', $citys);
            }
              
            //$user_data = Greare_Util_Dataset::getUserById($uid);
            $this->putContext('user_data', $user_data);
            
            $tpl = 'checkout_address';
        }elseif($step == 'payment'){
            $tpl = 'checkout_payment';
        }elseif($step == 'notice'){
            $tpl = 'checkout_notice';
        }elseif($step == 'invoice'){
            $tpl = 'checkout_invoice';
        }else{
            //skip
            return $this->_hintResult('操作不当，请重试！',true);
        }
        self::debug("modify[$step] and tpl[$tpl]", __CLASS__);
        $this->putContext('data', $value);
        $this->putContext('next_step', $next_step);
        
        $this->_setExtraParams();
        
        return $this->smartyResult('eshop.shopping.'.$tpl);
    }
    
    /**
     * 关闭修改订单信息的表单
     * 
     * @return string
     */
    public function close(){
        $model = new Common_Model_OrdersData();
        
        $reference = Common_Util_Shop::getOrderReference();
        if(is_null($reference)){
            $reference = Common_Util_Shop::_genOderReference();
            Common_Util_Shop::setOrderReference($reference);
        }
        $condition = 'reference=? AND expire > ?';
        $vars = array($reference,time());
        $value = array();
        
        $model->findFirst(array('condition'=>$condition,'vars'=>$vars));
        if($model->count()){
            $value = unserialize($model['data']);
        }
        
        $step = $this->getStep();
        if($step == 'address'){
            $tpl = 'checkout_address_ok';
        }elseif($step == 'payment'){
            $tpl = 'checkout_payment_ok';
        }elseif($step == 'invoice'){
            $tpl = 'checkout_invoice_ok';
        }elseif($step == 'notice'){
            $tpl = 'checkout_notice_ok';
        }else{
            //skip
            return $this->_hintResult('操作不当，请重试！',true);
        }
        $this->putContext('data', $value);
        
        $this->_setExtraParams();
        
        return $this->jqueryResult('eshop.shopping.'.$tpl);
    }
    
    /**
     * 修改配送省份
     * 
     * @return string
     */
    public function changeProvince(){
        if(empty($this->_province_id)){
            return $this->_hintResult('操作不当，请重试！',true);
        }
        $areas = new Common_Model_Areas();
        //get all province
        $options = array(
            'condition'=>'type=?',
            'vars'=>array('p'),
            'order'=>'id ASC'
        );
        $provinces = $areas->find($options)->getResultArray();
        //get all city
        $options = array(
            'condition'=>'parent_id=? AND type=?',
            'vars'=>array($this->_province_id, 'c'),
            'order'=>'id DESC'
        );
        $citys = $areas->find($options)->getResultArray();
        
        $this->putContext('citys', $citys);
        $this->putContext('provinces', $provinces);
        $this->putContext('province_id',$this->_province_id);
        $this->putContext('city_id',$this->_city_id);
        
        unset($areas);
        
        return $this->jqueryResult('eshop.shopping.city');
    }
    
    /**
     * 修改配送城市
     * 
     * @return string
     */
    public function changeCity(){}
    
    
    /*****************参数辅助方法******************/
    public function setSize($v){
        $this->_size = $v;
        return $this;
    }
    public function getSize(){
        return $this->_size;
    }
    public function setPid($pid){
        $this->_pid = $pid;
        return $this;
    }
    public function getPid(){
        return $this->_pid;
    }
    
    public function setQuantity($quantity){
        $this->_quantity = $quantity;
        return $this;
    }
    public function getQuantity(){
        return $this->_quantity;
    }
    
    public function setStep($step){
        $this->_step = $step;
        return $this;
    }
    public function getStep(){
        return $this->_step;
    }
    
    public function setNextStep($step){
    	$this->_next_step = $step;
    	return $this;
    }
    public function getNextStep(){
    	return $this->_next_step;
    }
    
    public function setOrderRef($ref){
        $this->_order_ref = $ref;
        return $this;   
    }
    public function getOrderRef(){
        return $this->_order_ref;
    }
    
    public function setCityId($id){
        $this->_city_id = $id;
        return $this;
    }
    public function getCityId(){
        return $this->_city_id;
    }
    
    public function setProvinceId($id){
        $this->_province_id = $id;
        return $this;
    }
    public function getProvinceId(){
        return $this->_province_id;
    }
}
/**vim:sw=4 et ts=4 **/
?>