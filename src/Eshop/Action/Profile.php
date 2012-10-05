<?php
/**
 * eshop会员信息管理
 *
 * @varsion $Id$
 * @author purpen
 */
class Eshop_Action_Profile extends Eshop_Action_Common {
    protected $_model_class='Common_Model_User';
    
    private $_account = null;
    private $_password = null;
    private $_username = null;
    private $_old_password = null;
    private $_remember = 0;
	private $_checkcode = null;
    
    private $_next_url = null;
    
    public $_size = 20;
    
    //用户验证邮件  密匙
    private $_activation;
    
    
    public function setActivation($activation){
        $this->_activation = $activation;
        return $this;
    }
    public function getActivation(){
        return $this->_activation;
    }
    
    public function setAccount($account){
        $this->_account = $account;
        return $this;
    }
    public function getAccount(){
        return $this->_account;
    }
    public function setUsername($username){
        $this->_username = $username;
        return $this;
    }
    public function getUsername(){
        return $this->_username;
    }
    
    public function setPassword($password){
        $this->_password = $password;
        return $this;
    }
    public function getPassword(){
        return $this->_password;
    }
    
    public function setOldPassword($password){
        $this->_old_password = $password;
        return $this;
    }
    public function getOldPassword(){
        return $this->_old_password;
    }
    
    public function setRemember($remember){
        $this->_remember = $remember;
        return $this;
    }
    public function getRemember(){
        return $this->_remember;
    }
    
    public function setNextUrl($url){
        $this->_next_url = $url;
        return $this;
    }
    public function getNextUrl(){
        if(empty($this->_next_url)){
            $this->_next_url = Common_Util_Url::getBackUrl();
            //reset empty
            Common_Util_Url::setBackUrl(null);
        }
        return $this->_next_url;
    }

	public function setCheckcode($v){
		$this->_checkcode = $v;
		return $this;
	}
	public function getCheckcode(){
		return $this->_checkcode;
	}
    /**
     * 
     * @return Common_Model_User
     */
    public function wiredModel(){
        return parent::wiredModel();
    }
    //~~~~~~~~~~~~~~Action implements~~~~~~~~~~
    /**
     * default action method
     */
    public function execute(){
        return $this->manage();
    }
    /**
     * 个人管理中心
     * 
     * @return string
     */
    public function manage(){
    	return $this->tradingOrder();
    }
	/**
	 * 个人订单中心
	 */
	public function tradingOrder(){
		if(!$this->isLogged()){
		    $back_url = $this->getContext()->getRequest()->getRequestUri();
		    return $this->_redirectLogin($back_url);
		}
		$user_id = Anole_Util_Cookie::getUserID();
		$page = $this->getPage();
		$size = $this->_size;

		$order_model = new Common_Model_Orders();

		$condition = 'user_id=?';
		$vars = array($user_id);

		//获取记录数
		$records = $order_model->countIf($condition,$vars);
		$total = ceil($records/$size);
		$page  = min($total, $page);

		$options = array(
			'condition'=>$condition,
			'vars'=>$vars,
			'page'=>$page,
			'size'=>$size,
			'order'=>'created_on DESC'
		);
		$order_list = $order_model->find($options)->getResultArray();

		$this->putContext('records', $records);
		$this->putContext('total', $total);
		$this->putContext('page', $page);

		$this->putContext('order_list', $order_list);
		$this->putContext('all_payment_method', $order_model->findPaymentMethods());
		
		$this->putSharedParam();
		$this->putContext('sub_nav','order');
    	return $this->smartyResult('eshop.account.manage');
	}
	/**
	 * 查看订单详情
	 */
	public function viewOrder(){
		if(!$this->isLogged()){
			$back_url = $this->getContext()->getRequest()->getRequestUri();
			return $this->_redirectLogin($back_url);
		}
		$id = $this->getId();
		$order_model = new Common_Model_Orders();
		$order_row = $order_model->findById($id)->getResultArray();
		
		
		$order_user_id = $order_row['userId'];
		if(!$this->isUserOwner($order_user_id)){ 
			return $this->_redirectNoAuth();
		}
		 
		$model_product = new Common_Model_Product();
        
		$product_list = $model_product->findOrderProductList($id);
		for($i=0;$i<count($product_list);$i++){
			$product = $product_list[$i];
			self::debug("id:::".$product['id']." value::".$product['quantity']); 
		}
		
		$this->putContext('plist', $product_list);
		$this->putContext('order_row', $order_row);
		
		//获取送货方式
        $transfer_methods = $order_model->findTransferMethods();
        $this->putContext('transfer_methods', $transfer_methods);
        //获取付款方式列表
        $payment_methods = $order_model->findPaymentMethods();
        $this->putContext('payment_methods', $payment_methods);
        //获取送货时间列表
        $transfer_times = $order_model->findTransferTime();
        $this->putContext('transfer_times', $transfer_times);
		
		$this->putSharedParam();
		$this->putContext('sub_nav','order');
    	return $this->smartyResult('eshop.account.view_detail');
	}
	
	/**
	 * 没有权限
	 */
	public function noAuth(){
		if(!$this->isLogged()){
			$back_url = $this->getContext()->getRequest()->getRequestUri();
			return $this->_redirectLogin($back_url);
		}   
		$this->putSharedParam(); 
		return $this->smartyResult('eshop.common.no_auth');
	}
	
	/**
     * 用户取消订单
     */
	public function canceled(){
		if(!$this->isLogged()){
		    $back_url = $this->getContext()->getRequest()->getRequestUri();
		    return $this->_redirectLogin($back_url);
		}
		$user_id = Anole_Util_Cookie::getUserID();
		$id = $this->getId();
		
		$order_model = new Common_Model_Orders();
		//检测该订单
		if(!$order_model->countIf('id=? AND user_id=?', array($id,$user_id))){
			$msg = '抱歉，您请求的订单不存在或已被删除！';
			$this->putContext('msg', $msg);
			return $this->jqueryResult('eshop.account.cancel_ok');
		}
		
		$order_model->setOrderCanceled($id);
		
		//取消订单，会恢复库存
		$model_product = new Common_Model_Product();
		$model_product->findOrderProductList($id);
		for($i=0;$i<count($model_product);$i++){
			$product = $model_product[$i];
			self::debug("[do_cancel]\t id:::".$product['id']." value::".$product['quantity']);
			$model_product ->updateProductCount($product['id'],$product['quantity']);
		}
		
		$msg = '您请求的订单已取消!';
		$this->putContext('msg', $msg);
		
		return $this->jqueryResult('eshop.account.cancel_ok');
	}
	
	/**
     * 用户完成订单
     */
	public function finished(){
		if(!$this->isLogged()){
		    $back_url = $this->getContext()->getRequest()->getRequestUri();
		    return $this->_redirectLogin($back_url);
		}
		$user_id = Anole_Util_Cookie::getUserID();
		$id = $this->getId();
		
		$order_model = new Common_Model_Orders();
		//检测该订单
		if(!$order_model->countIf('id=? AND user_id=?', array($id,$user_id))){
			$msg = '抱歉，您请求的订单不存在或已被删除！';
			$this->putContext('msg', $msg);
			return $this->jqueryResult('eshop.account.cancel_ok');
		}
		
		$order_model->setOrderPublished($id);
		
		$msg = '您的订单已完成，感谢您的光临!';
		$this->putContext('msg', $msg);
		
		return $this->jqueryResult('eshop.account.cancel_ok');
	}
	
	/**
	 * 在线支付
	 */
	public function ipay(){
	}
	/**
	 * 已买商品记录
	 */
	public function buyed(){
		if(!$this->isLogged()){
		    $back_url = $this->getContext()->getRequest()->getRequestUri();
		    return $this->_redirectLogin($back_url);
		}
		$user_id = Anole_Util_Cookie::getUserID();
		
		$model_product = new Common_Model_Product();
        
		$strSQL = 'select A.*,COUNT( A.quantity ) AS sale_num,B.id,B.title,B.sale_price,B.catcode,B.category_id,B.thumb from `detail` AS A INNER JOIN `product` AS B on A.product_id=B.id ';
        //已审核的产品
        $condition = 'B.state=? AND A.user_id=?';
        $vars =  array(Common_Model_Product::CHECK_STATE, $user_id);
		
		if(!empty($condition)){
			$strSQL .= ' WHERE '.$condition;
		}
		$strSQL .= ' GROUP BY B.id ORDER BY A.created_on DESC';
		
		$options = array(
			'vars'=>$vars
		);
		$product_list = $model_product->findBySql($strSQL,$options)->getResultArray();
		unset($model_product);
		
		$this->putContext('plist', $product_list);
		
		$this->putSharedParam();
		$this->putContext('sub_nav','buyed');
    	return $this->smartyResult('eshop.account.buyed');
	}
	/**
	 * 收藏商品
	 */
	public function favorite(){
		if(!$this->isLogged()){
			$back_url = $this->getContext()->getRequest()->getRequestUri();
		    return $this->_redirectLogin($back_url);
		}
		$user_id = Anole_Util_Cookie::getUserID();
		
		$page = $this->getPage();
		$size = $this->_size;
		$model_product = new Common_Model_Product();
        
		$numSQL = 'select COUNT(*) AS cnt from `favorite` AS A INNER JOIN `product` AS B on A.product_id=B.id ';
		$strSQL = 'select A.*,B.id,B.title,B.sale_price,B.catcode,B.category_id,B.thumb from `favorite` AS A INNER JOIN `product` AS B on A.product_id=B.id ';
        //已审核的产品
        $condition = 'B.state=? AND A.user_id=?';
        $vars =  array(Common_Model_Product::CHECK_STATE, $user_id);
		
		if(!empty($condition)){
			$strSQL .= ' WHERE '.$condition;
			$numSQL .= ' WHERE '.$condition;
		}
		$options = array(
			'vars'=>$vars
		);
		$rows = $model_product->findBySql($numSQL,$options)->getResultArray();
		if(!empty($rows)){
			$records = $rows[0]['cnt'];
			$total = ceil($records/$size);
			$page = min($total,$page);
			
			$this->putContext('records', $records);
			$this->putContext('total', $total);
			$this->putContext('page', $page);
			
			$options['page'] = $page;
			$options['size'] = $size;
		}
		$strSQL .= ' GROUP BY B.id ORDER BY A.created_on DESC';
		
		$product_list = $model_product->findBySql($strSQL,$options)->getResultArray();
		unset($model_product);
		
		$this->putContext('plist', $product_list);
		
		$this->putSharedParam();
		$this->putContext('sub_nav','favorite');
    	return $this->smartyResult('eshop.account.favorite');
	}
	/**
	 * 个人信息
	 */
	public function information(){
		if(!$this->isLogged()){
		    $back_url = $this->getContext()->getRequest()->getRequestUri();
		    return $this->_redirectLogin($back_url);
		}
		$user_id = Anole_Util_Cookie::getUserID();
		$user = new Common_Model_User();
        $user->findById($user_id);  
        $this->putContext('user', $user);
		//self::debug("[debug]user pre:::"."\t".$user->getMetas($this->_meta_domain,"qq"));
		$this->putSharedParam();
		$this->putContext('sub_nav','info');
    	return $this->smartyResult('eshop.account.info');
	}
	/**
     * 更新用户资料
     * 
     * @return string
     */
    public function updateUser(){
    	$model = $this->wiredModel();
    	
    	if(!$this->isLogged()){
		    $back_url = $this->getContext()->getRequest()->getRequestUri();
		    return $this->_redirectLogin($back_url);
		}
        $user_id = Anole_Util_Cookie::getUserID();
        $this->putContext('page', 'info');
		
    	try{
    		$model->setIsNew(false);
            $model->setId($user_id); 
            $model->save();
            
            $_id = $model->getId();
    	}catch(Common_Model_Exception $e){
    		self::warn("validate user record failed:".$e->getMessage(), __METHOD__);
            $this->putContext('msg', $e->getMessage());
            return $this->jqueryResult('eshop.account.info_ok');
    	}catch(Anole_ActiveRecord_Exception $e){
    		self::warn("Save user record failed:".$e->getMessage(), __METHOD__);
            $this->putContext('msg', $e->getMessage());
            return $this->jqueryResult('eshop.account.info_ok');
    	}
    	$msg = "您的信息更新成功!";
        $this->putContext('msg', $msg);
		
        return $this->jqueryResult('eshop.account.info_ok');
    }
	/**
	 * 修改密码
	 */
	public function passwd(){
		if(!$this->isLogged()){
		    $back_url = $this->getContext()->getRequest()->getRequestUri();
		    return $this->_redirectLogin($back_url);
		}
        $user_id = Anole_Util_Cookie::getUserID();
		
		$this->putSharedParam();
		$this->putContext('sub_nav','passwd');
    	return $this->smartyResult('eshop.account.passwd');
	}
	/**
     * 处理用户修改密码
     * @return string
     */
    public function doPasswd(){
    	$user = $this->wiredModel();
    	if(!$this->isLogged()){
		    $back_url = $this->getContext()->getRequest()->getRequestUri();
		    return $this->_redirectLogin($back_url);
		}
        $user_id = Anole_Util_Cookie::getUserID();
        
        if(empty($this->_password) || empty($this->_old_password)){
        	return $this->_hintResult('您的操作不当，请查看帮助！',true);
        }
        $user->findById($user_id);
        $_passwd = $user['password'];
        $passwd = hash('sha1', $this->_old_password);
        if($passwd !== $_passwd){
			$this->putContext('page', 'info');
			$this->putContext('msg', '输入的旧密码不正确,请重试!');
            return $this->jqueryResult('eshop.account.info_ok');
        }
        $new_passwd = hash('sha1',$this->_password);
        try{
        	$user->setIsNew(false);
        	$user->setId($user_id);
        	$user->setPassword($new_passwd);
        	$user->save();
        }catch(Anole_ActiveRecord_Exception $e){
        	self::warn('modify password failed:'.$e->getMessage(), __METHOD__);
			$this->putContext('page', 'info');
			$this->putContext('msg', '系统故障，请稍后重试！');
        	return $this->jqueryResult('eshop.account.info_ok');
        }
		$this->putContext('page', 'info');
		$this->putContext('msg', '密码修改成功！');
        
        return $this->jqueryResult('eshop.account.info_ok');
    }
	/**
	 * 修改用常配货地址
	 */
	public function addbooks(){
		if(!$this->isLogged()){
		    $back_url = $this->getContext()->getRequest()->getRequestUri();
		    return $this->_redirectLogin($back_url);
		}
		$this->putSharedParam(); 
		$user_id = Anole_Util_Cookie::getUserID();
		$model_address = new Common_Model_Addbooks();  
		$condition = 'user_id=?';
    	$vars = array($user_id);
		$options = array(
    	    'condition'=>$condition,
    	    'vars'=>$vars 
    	);
		$addbooks_list = $model_address->find($options)->getResultArray();
		unset($model_product); 
		$this->putContext('addbooks_list', $addbooks_list);
		
		$this->putContext('sub_nav','addbooks');
		

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
		
		
    	return $this->smartyResult('eshop.account.addbooks');
	}
	
	
	/**
	 * 修改常用配货地址
	 */
	public function editAddbooks(){
		if(!$this->isLogged()){
			$back_url = $this->getContext()->getRequest()->getRequestUri();
			return $this->_redirectLogin($back_url);
		}
		$this->putSharedParam();
		$addbooks_id = $this->getId(); 
		$model_addbooks = new Common_Model_Addbooks();
		$addbooks = $model_addbooks->findById($addbooks_id)->getResultArray();
		unset($model_addbooks);
		self::debug("addresssl::::".$addbooks[name]);
		$this->putContext('addbooks', $addbooks);  
		$this->putContext('msg', '修改'.$addbooks[name].'送货地址！');
		$this->putContext('edit_mode', 'edit');  
		return $this->jqueryResult('eshop.account.addbooks_edit');
	}
	
	
	/**
	 * 保存常用配货地址
	 */
	public function saveAddbooks(){
		if(!$this->isLogged()){
			$back_url = $this->getContext()->getRequest()->getRequestUri();
			return $this->_redirectLogin($back_url);
		}

		$id = $_POST['id'];
		$province = $_POST['province'];
		$name = $_POST['name'];
		$city = $_POST['city'];
		$address = $_POST['address'];
		$userId = $_POST['userId'];
		$zip = $_POST['zip'];
		$telephone = $_POST['telephone'];
		$mobie = $_POST['mobie'];
		$email = $_POST['email'];
		$model_addbooks = new Common_Model_Addbooks();
		 if(empty($id) || $id < 0){ 
            $model_addbooks->setId(null);
            $model_addbooks -> setIsNew(true);
		 }else {
		 	$model_addbooks->setId($id);
		 	$model_addbooks -> setIsNew(false);
		 }
		 if(empty($userId) || $userId < 0){
		 	$userId = Anole_Util_Cookie::getUserID();
		 } 
	    $model_addbooks ->setName($name);
		$model_addbooks ->setProvince($province);
	    $model_addbooks ->setCity($city);
	    $model_addbooks ->setZip($zip);
	    $model_addbooks ->setTelephone($telephone);
	    $model_addbooks ->setEmail($email);
	    $model_addbooks ->setAddress($address);   
	    $model_addbooks ->setUserId($userId);
	    $model_addbooks ->setMobie($mobie);    
	    $model_addbooks->save();
		$this->putSharedParam();
		$this->putContext('edit_mode', 'save'); 
		$this->putContext('msg', '保存'.$addbooks[name].'送货地址成功！');
		return $this->jqueryResult('eshop.account.addbooks_edit');
	}
    /**
     * 显示用户注册页面
     * 
     * @return string
     */
    public function register(){
    	$this->putSharedParam();
		$back_url = $this->getNextUrl();
		if(!empty($back_url)){
			Common_Util_Url::setBackUrl($back_url);
		}
    	return $this->smartyResult('eshop.register');
    }
	/**
	 * 输入验证图片
	 */
	public function validateImage(){
		session_start();
		$image = new Anole_Util_ValidateCode();
		$image->outputImage();
		$this->getContext()->setSession('validatecode', $image->check_code);
		self::debug("write to session[".$image->check_code."].", __METHOD__);
		
	}
    /**
     * 保存注册用户
     * 
     * @return string
     */
    public function doRegister(){
    	$model = $this->wiredModel();
        $id = $this->getId();
		$back_url = $this->getNextUrl();
		if(empty($back_url)){
           // $back_url = Common_Util_Url::app_root_url();
        }
		$checkcode = $this->getCheckcode();
		$session_checkcode = $this->getContext()->getSession('validatecode');
		
		if (!strcasecmp($checkcode, $session_checkcode) == 0) {
			self::debug("get checkcode[$checkcode] and session[".$session_checkcode."].", __METHOD__);
		 	return $this->_hintResult('输入的验证码不对，请返回重试！',true,$back_url);
		 }
        if(empty($id) || $id < 0){
            $model->setIsNew(true);
            $model->setId(null);
            $edit_mode = 'create';
        }else{
            $model->setIsNew(false);
            $model->setId($id);
            $edit_mode = 'edit';
        }
        $passwd = $this->getPassword();
        if(empty($passwd)){
            return $this->_hintResult('密码丢失,请确认执行注册的操作步骤是否正确！',true,$back_url);
        }
        try{
        	$model->setRoleId(0);
            $model->save();
            
            $id = $model->getId();
            
            //发送注册验证邮件
            $activation = hash('md5', $id.'_'.microtime());
            $now = date('Y-m-d', time());
            if($now > '2011-03-01' && $now < '2011-03-12'){
                $extend_info = '<p><font color="red">3月份新增注册用户，在本网站购物可以享受立减20元的优惠！还等什么，现在就去挑选吧。</font></p>';
            }else{
                $extend_info = null;
            }
            Common_Util_Notify::sendRegistActiveEmail($this->_account,$activation,$extend_info);
            
            //设置用户激活码
            $current_user = new Common_Model_User();
            $current_user->setIsNew(false);
            $current_user->setId($id);
            $current_user->setActivation($activation);
            $current_user->save();
            
            unset($current_user);
            
        }catch(Common_Model_Exception $e){
        	return $this->_hintResult('存在不合法的数据或数据不完整',true);
        }catch(Anole_ActiveRecord_Exception $e){
            self::warn("Save user record failed:".$e->getMessage(), __METHOD__);
            $this->putContext('msg', $e->getMessage());
            return $this->_hintResult('系统出现异常，请稍后再试!',true,$back_url);
        }catch(Anole_Exception $e){
            self::warn("Save user info failed:".$e->getMessage(), __METHOD__);
            $this->putContext('msg', $e->getMessage());
            return $this->_hintResult('系统出现异常，请稍后再试!',true,$back_url);
        }
        
        $this->putContext('user_id', $id);
        $this->putContext('edit_mode',$edit_mode);
        
     // 暂不需要激活
    //	 $act_msg = '确认信已经发到你的邮箱'.$this->_account.',需要你点击邮件中的链接来激活帐号。';
    	 $act_msg = '恭喜您:'.$this->_account.'，注册成功，可以享受更多服务。';
        $reg_msg = '恭喜您:'.$this->_account.'，注册成功，可以享受更多服务。';
        
        return $this->_hintResult($act_msg,false,$back_url);
    }
    /**
     * 检测帐户
     * 
     * @return string
     */
    public function checkAccount(){
        if(is_null($this->_account)){
            return $this->jsonResult(400, '没有指定账号');
        }
        $user = $this->wiredModel();
        try{
            $ok = $user->countIf('account=?',array($this->_account));
            unset($user);
            
            if($ok == 0){
                return $this->jsonResult();
            }else{
                return $this->jsonResult(400,'该Email已经注册过');
            }
        }catch(Anole_ActiveRecord_Exception $e){
            return $this->jsonResult(500,'系统异常');
        }
    }
    /**
     * 检测昵称
     * 
     * @return string
     */
    public function checkUsername(){
        if(is_null($this->_account)){
            return $this->jsonResult(400,'昵称没有指定');
        }
        $user = $this->wiredModel();
        try{
            $ok = $user->countIf('username=?',array($this->_account));
            unset($user);
            
            if($ok == 0){
                return $this->jsonResult();
            }else{
                return $this->jsonResult(400,'该昵称已经被使用过');
            }
        }catch(Anole_ActiveRecord_Exception $e){
            return $this->jsonResult(500,'系统异常');
        }
    }
    /**
     * 显示用户登陆页面
     * 
     * @return string
     */
    public function login(){
		$this->putSharedParam();
		
		$back_url = $this->getNextUrl();
		if(!empty($back_url)){
			Common_Util_Url::setBackUrl($back_url);
		}
		
    	return $this->smartyResult('eshop.login');
    }
    /**
     * 验证用户登陆
     * 
     * @return string
     */
    public function doLogin(){
    	$account = $this->getAccount();
        $passwd  = $this->getPassword();
        $remember = $this->getRemember();
        
        if(empty($account) || empty($passwd)){
            return $this->jsonResult(400, '用户名或密码为空了!');
        }
        $model = $this->wiredModel();
        $options = array(
            'condition'=>'account=?',
            'vars'=>array($account)
        );
        $model->findFirst($options);
        if(!$model->count()){
            return $this->jsonResult(404, "用户[$account]不存在!");
        }
        //user password isn't right
        $passwd = hash('sha1', $passwd);
        $_passwd = $model['password'];
        if($passwd !== $_passwd){
            return $this->jsonResult(502, '输入的密码不正确,请重试!');
        }
        
        $user_id = $model['id'];
        $username = $model['username'];
        
        //set cookie
        $life_time = 0;
        if($remember == 1){ // 保存一个月
            $life_time = 864000;
        }
        self::debug("Account remember[$remember] and life_time [$life_time]", __METHOD__);
        
        Anole_Util_Cookie::setUserID($user_id,$life_time);
        Anole_Util_Cookie::setUserName($username,$life_time);
        
        $back_url = $this->getNextUrl();
        if(empty($back_url)){
            $back_url = Common_Util_Url::app_root_url();
        }
        
        $this->putContext('next_url', $back_url);
        
        return $this->jsonResult();
    }
	/**
	 * 安全推出
	 */
	public function logout(){
		$next_url = Common_Util_Url::app_root_url();

		Anole_Util_Cookie::clearUser();
		
		return $this->redirectResult($next_url);
	}
	
    /**
     * 用户email验证
     * 
     * @return string
     */
    public function activateEmail(){
        $activation = $this->_activation;
        //激活码丢失
        if(empty($activation)){
            return $this->_hintResult('错误操作，激活码丢失', true);
        }
        $user = $this->wiredModel();
        try{
            $result = $user->findFirst(array('condition'=>'activation=?','vars'=>array($activation)));
            if(!$user->countIf('activation=?',array($activation))){
                return $this->_hintResult('错误的激活码,请确认激活码是否正确。', true);
            }
            //清空用户激活码
            $user->setIsNew(false);
            $user->setId($result['id']);
            $user->setState(Common_Model_User::STATE_ACTIVE);
            $user->setActivation('');
            $user->save();
            
            //赠送初始积分
            $user->presentUserPoint($result['id']);
            
            //邮件验证成功
            $url = Common_Util_Url::app_elogin_url();
            return $this->_hintResult('邮件验证成功！',false, $url);
            
        }catch(Anole_ActiveRecord_Exception $e){
            self::warn("find user error:".$e->getMessage(), __METHOD__);
            return $this->_hintResult('系统服务器出现错误',true);
        }
    }
}
/**vim:sw=4 et ts=4 **/
?>