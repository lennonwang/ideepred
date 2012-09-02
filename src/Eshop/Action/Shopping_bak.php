<?php
/**
 * 购买流程及支付流程
 *
 * @version $Id$
 * @author purpen
 */
class Eshop_Action_Shopping extends Eshop_Action_OrderParams {
 
	
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
     * 修改配送地址
     * 
     * @return string
     */
    public function doAddress(){
   		 if(!Anole_Util_Cookie::hasUserLogged()){
            $back_url = $this->getContext()->getRequest()->getRequestUri();
            Common_Util_Url::setBackUrl($back_url);
            return $this->redirectResult('/app/eshop/profile/login');
        }
    	$this->doProcess();
    	
    	$next_step = $this->getNextStep();
        if(!empty($next_step)){
            return $this->redirectResult($next_step);
        }
         $this->putSharedParam(); 
        return $this->smartyResult('eshop.shopping.checkout_payment');
    }
    
    /**
     * 修改备注信息
     * 暂时不需要了，层级太多了
     * @return string
     */
    public function doNotice(){
        $this->doProcess();
        
        $next_step = $this->getNextStep();
        if(!empty($next_step)){
            return $this->redirectResult($next_step);
        }
        
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
		// $order->validateExpressFees($data['province']);
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
    
    
    }
    /**vim:sw=4 et ts=4 **/
?>