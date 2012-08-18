<?php
/**
 * Model Common_Model_User
 * 
 * @version $Id$
 * @author purpen
 */
class Common_Model_User extends Common_Model_Table_User {
    
    //关系映射表
    protected $_relation_map = array(
        'metas'=>array(
            'type'=>self::HAS_MANY,
            'class'=>'Common_Model_Meta',
            'foreign_key'=>'owner_id'
        )
    );
    /**
     * 用户默认未激活状态
     * 
     * @var int
     */
    const STATE_DEFAULT = 0;
    /**
     * 设置用户激活用户
     * 
     * @var int
     */
    const STATE_ACTIVE = 1;
    /**
     * 初始赠送积分
     * 注:用户email激活后赠送
     * 
     * @var int
     */
    const PRESENT_POINT = 20;
    
    const META_DOMAIN = 'user';
    /**
     * 普通会员
     * 
     * @var int
     */
    const LEVEL_RGP = 1;
    /**
     * vip会员
     * 
     * @var int
     */
    const LEVEL_VIP = 2;
    /**
     * svip会员
     * 
     * @var int
     */
    const LEVEL_SVIP = 3;
    
    
    protected $_meta_domain = self::META_DOMAIN;
    
    protected $_metas = array();
    
    
    /**
     * 默认的magic field
     */
    protected $_magic_field = array(
        'meta'=>'_loadMetaArray',
        'headpic'=>'_fetchHeadpic'
    );
    
    private $_permissions = array();
    /**
     * @return Common_Model_User
     */
    public static function getModel($data=array(),$class=__CLASS__){
        return parent::getModel($data,$class);
    }
    
    public function beforeValidation(){
    	if($this->isNew()){
    		$this->setCreatedOn(date('Y-m-d H:i:s'));
    		$this->setState(self::STATE_DEFAULT);
    		$this->setLevel(self::LEVEL_RGP);
    	}
    	$this->setUpdatedOn(date('Y-m-d H:i:s'));
    	
    	return true;
    }
    /**
     * 验证输入数据
     * 
     * @see src/Anole/ActiveRecord/Anole_ActiveRecord_Base#validate()
     */
    public function validate(){
        if($this->isNew()){
        	$fields = array('account','username','password');	
        }else{
        	$fields = array('id');
        }
        if(!$this->validateRequird($fields)){
        	return False;
        }
        if($this->isNew()){
        	if($this->checkExistByAccount()){
        		return False;
        	}
        	if($this->checkExistByName()){
        		return False;
        	}
        }
        return true;
    }
    
    public function afterValidation(){
    	//encrypt before save
    	if($this->isNew()){
	    	$passwd = $this->getPassword();
	        if(!empty($passwd)){
	            $_passwd = $this->_encryptPasswd($passwd);
	            $this->setPassword($_passwd);
	        }
    	}
    	
    	//add metas
    	if(empty($this->_metas)){
    		return;
    	}
    	//从数据库中获取字段
    	$db_metas = $this->getMetas($this->_meta_domain,null,$id);
    	$db_meta_id = array();
    	foreach($db_metas as $m){ 
    		$db_meta_id[$m['name']] = $m['id']; 
    	} 
    	foreach($this->_metas as $domain=>$metas){
    		foreach($metas as $name=>$value){  
    			if($db_meta_id[$name]>0){ 
    				$this->addRelationModelData('metas', array('id'=>$db_meta_id[$name],'domain'=>$domain,'name'=>$name,'value'=>serialize($value)));
    			}else{
    				$this->addRelationModelData('metas', array('domain'=>$domain,'name'=>$name,'value'=>serialize($value)));
    			}
    		}
    	}
    	return true;
    }
    /**
     * After save 事件
     */
    public function afterSave(){
    	//destoryDependedModel
    }
    
    /**
     * 获取用户对应的级别称谓
     * 
     * @param int $level
     * @return string
     */
    public static function fetchUserLevelName($level){
    	if(is_null($level)){
    		return null;
    	}
    	$level = intval($level);
    	self::debug("user level[$level].", __METHOD__);
    	switch($level){
    		case self::LEVEL_RGP:
    			$name = '普通会员';
    			break;
    		case self::LEVEL_VIP:
    			$name = 'VIP会员';
    			break;
    		case self::LEVEL_SVIP:
    			$name = 'SVIP会员';
    			break;
    		default:
    			$name = '普通会员';
    			break;
    	}
    	return $name;
    }
    /**
     * 通过积分获取对应的级别标识
     * 
     * @param int $point
     * @return int
     */
    public static function fetchLevelByPoint($point){
        if(is_null($point)){
            throw new Common_Model_Exception('User point is NULL');
        }
        if($point >= 0 && $point < 500){
            $level = self::LEVEL_RGP;
        }elseif($point >= 500 && $point < 1000){
            $level = self::LEVEL_VIP;
        }elseif($point >= 1000){
            $level = self::LEVEL_SVIP;
        }else{
            //skip
            self::warn("Point[$point] format is error", __METHOD__);
            throw new Common_Model_Exception("Point[$point] format is error");
        }
        return $level;
    }
    /**
     * 升级会员的级别
     * 
     * @param int $level
     * @return string
     */
    public function upgradeUserLevel($level,$id=null){
    	if(is_null($id)){
    		$id = $this->getId();
    	}
    	if(empty($id)){
    		throw new Common_Model_Exception("upgrade user and id is NULL");
    	}
    	if(empty($level)){
    		throw new Common_Model_Exception("upgrade user and level is NULL");
    	}
    	
    	$this->setIsNew(false);
    	$this->setId($id);
    	$this->setLevel($level);
    	$this->save();
    	
    	return true;
    }
    /**
     * 赠送用户初始积分
     * 
     * @param float $point
     * @return void
     */
    public function presentUserPoint($id=null){
    	if(is_null($id)){
    		$id = $this->getId();
    	}
    	if(empty($id)){
    		throw new Common_Model_Exception('Present point and user id is NULL');
    	}
    	
    	$this->findById($id);
    	if($this->count()){
    		
    		$point = $this->_result['point'] + self::PRESENT_POINT;
    		$sql = 'UPDATE '.$this->tablelize().' SET point=? WHERE id=?';
    		$this->getDba()->execute($sql,array($point,$id));
    		
    		//插入积分明细
    		$type = Common_Model_Point::ACTION_INCOME;
    		$description = "用户激活赠送积分";
    		$model = new Common_Model_Point();
    		$model->writePointLog($id,$type,self::PRESENT_POINT,$point,$description);
    		
    		unset($model);
    	}
    	return true;
    }
    
    /**
     * get user headpic
     * 
     * @return string
     */
    protected function _fetchHeadpic($id=null){
        if(is_null($id)){
            $id = $this->getId();
        }
        if(empty($id)){
            self::warn("get user headpic and id is Null!", __METHOD__);
            return null;
        }
        $asset = new Common_Model_Asset();
        $asset->fetchAssetList($id, Common_Model_Constant::ASSET_HEADPIC);
        if($asset->count()){
            return Common_Util_Storage::getAssetUrl('asset',$asset->_result[0]['path']);
        }
        return null;
    }
    /**
     * 加密 密码
     *
     * @return string
     */
    public function _encryptPasswd($password=null){
    	if(is_null($password)){
    		$password = $this->getPassword();
    	}
    	return hash('sha1', $password);
    }
    /**
     * check the account isn't exist
     *
     * @param string $account
     * @return bool
     */
    public function checkExistByAccount($account=null){
    	if(is_null($account)){
    		$account = $this->getAccount();
    	}
    	if(empty($account)){
    		self::warn("Check user,account is Null!", __METHOD__);
    		throw new Anole_ActiveRecord_Exception("Check user,account is Null!");
    	}
    	if($this->hasIf('account=?', array($account))){
    		self::warn("Account[$account] has exist!", __METHOD__);
    		$this->pushValidateError("Account[$account] has exist!");
    		return true;
    	}
    	return false;
    }
    /**
     * check the name isn't exist
     *
     * @param string $name
     * @return bool
     */
    public function checkExistByName($name=null){
    	if(is_null($name)){
    		$name = $this->getUsername();
    	}
    	if(empty($name)){
    		self::warn("Check user,name is Null!", __METHOD__);
            throw new Anole_ActiveRecord_Exception("Check user,name is Null!");
    	}
    	if($this->hasIf('username=?', array($name))){
    		self::warn("Name[$name] has exist!", __METHOD__);
    		$this->pushValidateError("Name[$name] has exist!");
    		return true;
    	}
    	return false;
    }
    
    /**
     * check an user isn't administrator
     *
     * @param string $account
     * 
     * @return bool
     */
    public function isAdministrator($account=null){
    	if(is_null($account)){
    		$account = $this->getAccount();
    	}
    	if(empty($account)){
    		self::warn("Account is Null!", __METHOD__);
    		return False;
    	}
    	if(!$this->hasIf('account=? AND role_id > ?', array($account, self::STATE_DEFAULT))){
    		return False;
    	}
    	return True;
    }
    /**
     * check an user isn't administrator by Id
     *
     * @param int $user_id
     * @return bool
     */
    public function isAdministratorById($user_id=null){
    	if(is_null($user_id)){
    		$user_id = $this->getId();
    	}
    	if(empty($user_id)){
    		self::warn("User_id is Null!", __METHOD__);
    		return False;
    	}
    	if(!$this->hasIf('id=? AND role_id>? ', array($user_id,self::STATE_DEFAULT))){
    		return False;
    	}
    	return True;
    }
    /**
     * 加载用户的meta数组
     *
     * @param int $id
     * @return array
     */
    protected function _loadMetaArray($id=null){ 
    	if(is_null($id)){
    		$id = $this->getId();
    	} 
        $metas = $this->getMetas($this->_meta_domain,null,$id);
        $user_meta = array();
        foreach($metas as $m){
            $user_meta[$m['name']] = @unserialize($m['value']);
            $user_meta[$m['name']."_id"] = $m['id'];
            self::debug("[debug]_loadMetaArray::name::".$m['name']."\t value::".$m['value']."\t".$user_meta[$m['name']."_id"]);
        } 
        return $user_meta;
    }
    /**
     * 设置一个meta值当user保存时，这些meta会自动保存
     * 
     * @param string $domain
     * @param string $name
     * @param mixed $value
     * @return Common_Model_User
     */
    public function addMeta($domain,$name,$value){
    	$this->_metas[$domain][$name] = $value;
    	return $this;
    }
    
    /**
     * 获取制定name的meta值
     * 
     * @param string $name
     * @return Common_Model_Meta
     */
    public function getMetas($domain=null,$name=null,$user_id=null){
    	$conditions = array();
    	$vars = array();
    	
    	if(!is_null($domain)){
    		$conditions[] = 'domain=?';
    		$vars[] = $domain;
    	}
    	if(!is_null($name)){
    		$conditions[] = 'name=?';
    		$vars[] = $domain;
    	}
    	if($user_id !== null){
    		$this->setId($user_id);
    	} 
    	if(!empty($conditions)){
    		$condition = implode(' AND ', $conditions);
    		return $this->findRelationModel('metas', array('condition'=>$condition,'vars'=>$vars));
    	}else{
    	    return $this->findRelationModel('metas');
    	}
    }
    /**************User Metas Method*************/
    
    public function setQQ($value){
    	$this->addMeta($this->_meta_domain,'qq',$value);
    	return $this;
    }
    public function getQQ(){
    	$metas = $this->getMetas($this->_meta_domain,'qq');
        return isset($metas[0]['qq']) ? $metas[0]['qq'] : null;
    }
    public function setMsn($value){
    	$this->addMeta($this->_meta_domain,'msn',$value);
        return $this;
    }
    public function getMsn(){
    	$metas = $this->getMetas($this->_meta_domain,'msn');
        return isset($metas[0]['msn']) ? $metas[0]['msn'] : null;
    }
    
    public function setRealName($value){
        $this->addMeta($this->_meta_domain,'real_name',$value);
        return $this;
    }
    public function getRealName(){
        $metas = $this->getMetas($this->_meta_domain,'real_name');
        return isset($metas[0]['real_name']) ? $metas[0]['real_name'] : null;
    }
    
    public function setFirstname($value){
        $this->addMeta($this->_meta_domain,'firstname',$value);
        return $this;
    }
    public function getFirstname(){
        $metas = $this->getMetas($this->_meta_domain,'firstname');
        return isset($metas[0]['firstname']) ? $metas[0]['firstname'] : null;
    }
    
    public function setMiddlename($value){
        $this->addMeta($this->_meta_domain,'middlename',$value);
        return $this;
    }
    public function getMiddlename(){
        $metas = $this->getMetas($this->_meta_domain,'middlename');
        return isset($metas[0]['middlename']) ? $metas[0]['middlename'] : null;
    }
    
    public function setSecondname($value){
        $this->addMeta($this->_meta_domain,'secondname',$value);
        return $this;
    }
    public function getSecondname(){
        $metas = $this->getMetas($this->_meta_domain,'secondname');
        return isset($metas[0]['secondname']) ? $metas[0]['secondname'] : null;
    }
    
    public function setAddress($value){
    	$this->addMeta($this->_meta_domain,'address',$value);
    	return $this;
    }
    public function getAddress(){
    	$metas = $this->getMetas($this->_meta_domain,'address');
        return isset($metas[0]['address']) ? $metas[0]['address'] : null;
    }
    public function setMobie($value){
        $this->addMeta($this->_meta_domain,'mobie',$value);
        return $this;
    }
    public function getMobie(){
        $metas = $this->getMetas($this->_meta_domain,'mobie');
        return isset($metas[0]['mobie']) ? $metas[0]['mobie'] : null;
    }
    public function setJob($value){
        $this->addMeta($this->_meta_domain,'job',$value);
        return $this;
    }
    public function getJob(){
        $metas = $this->getMetas($this->_meta_domain,'job');
        return isset($metas[0]['job']) ? $metas[0]['job'] : null;
    }
    public function setBirthday($value){
        $this->addMeta($this->_meta_domain,'birthday',$value);
        return $this;
    }
    public function getBirthday(){
        $metas = $this->getMetas($this->_meta_domain,'birthday');
        return isset($metas[0]['birthday']) ? $metas[0]['birthday'] : null;
    }
    public function setBlog($value){
        $this->addMeta($this->_meta_domain,'blog',$value);
        return $this;
    }
    public function getBlog(){
        $metas = $this->getMetas($this->_meta_domain,'blog');
        return isset($metas[0]['blog']) ? $metas[0]['blog'] : null;
    }
    
    public function setSummary($value){
        $this->addMeta($this->_meta_domain,'summary',$value);
        return $this;
    }
    public function getSummary(){
        $metas = $this->getMetas($this->_meta_domain,'summary');
        return isset($metas[0]['summary']) ? $metas[0]['summary'] : null;
    }
    /**
     * 设置用户使用设备的meta值
     * 
     * @param string $value
     * @return Common_Model_User
     */
    public function setDevices($value){
    	$this->addMeta($this->_meta_domain,'devices', $value);
    	return $this;
    }
    /**
     * 获取用户设备的meta值
     * 
     * @return string
     */
    public function getDevices(){
    	$metas = $this->getMetas($this->_meta_domain,'devices');
    	return isset($metas[0]['value']) ? $metas[0]['value'] : null;
    }
    
    /**
     * 设置用户喜欢的风格
     * 
     * @param string $value
     * @return Common_Model_User
     */
    public function setStyles($value){
    	$this->addMeta($this->_meta_domain,'styles', $value);
    	return $this;
    }
    /**
     * 获取用户喜欢的风格meta值
     * 
     * @return string
     */
    public function getStyles(){
    	$metas = $this->getMetas($this->_meta_domain,'styles');
        return isset($metas[0]['value']) ? $metas[0]['value'] : null;
    }
    
}
/**vim:sw=4 et ts=4 **/
?>