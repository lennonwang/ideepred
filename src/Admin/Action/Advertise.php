<?php
/**
 * 系统自建广告系统
 *
 * @version $Id$
 * @author purpen
 */
class Admin_Action_Advertise extends Admin_Action_Entry {
	
    protected $_model_class='Common_Model_Advertise';
    
    public $_main_menu = 'article';
    
    private $_state = null;
    
    private $_rand_sign_id = null;
    
    /**
     * 
     * @return Common_Model_Advertise
     */
    public function wiredModel(){
        return parent::wiredModel();
    }
    //~~~~~~~~~~~~~~Action implements~~~~~~~~~~
    /**
     * default action method
     */
    public function execute(){
        return $this->display();   
    }
    
    /**
     * 显示广告列表
     */
    public function display(){
		if(!$this->isLogged()){
            return $this->_redirectLogin();
        }
        $model = $this->wiredModel();
        
        $page = $this->getPage();
        $size = $this->_size;
        $state = $this->getState();
        
        $vars = array();
        if(!is_null($state)){
        	$condition = 'state=?';
        	$vars = array($state);
        }else{
        	$condition = null;
        }
        
        //get total page
        $records = $model->countIf($condition,$vars);
        $total = ceil($records/$size);
        $page = min($total, $page);
        
        $options = array(
           'condition'=>$condition,
           'vars'=>$vars,
           'order'=>'created_on DESC',
           'page'=>$page,
           'size'=>$size
        );
        
        $model->find($options);
        
        $this->putContext('advertise_list', $model);
        
        $this->putContext('records', $records);
        $this->putContext('total',$total);
        $this->putContext('page', $page);
        $this->putContext('state',$state);
        
        $start = ($page - 1)*$size + 1;
        $end = min($page*$size, $records);
        $this->putContext('start', $start);
        $this->putContext('end',$end);
        
        $page_list = Common_Util_Pager::XE_NewPager(array('page'=>$page,'total'=>$total));
        $this->putContext('page_list', $page_list);
        
        return $this->smartyResult('admin.advertise.list');
    }
    
    /**
     * 添加或编辑广告
     * 
     * @return string
     */
    public function edit(){
		if(!$this->isLogged()){
            return $this->_redirectLogin();
        }
        $model = $this->wiredModel();
        
        $id = $this->getId();
        $edit_mode = 'create';
        if(!empty($id)){
            $advertise = $model->findById($id)->getResultArray();
            $edit_mode = 'edit';
            
            //获取附件列表
            $asset = new Common_Model_Asset();
            $asset->fetchAssetList($id,Common_Model_Constant::ADVERTISE);
            
            $this->putContext('asset_list',$asset);
        }
        
        $rand_sign = $this->_genRandsign();
        $this->putContext('rand_sign',$rand_sign);
        
        //获取已使用过的编号
        $options = array(
            'select'=>' DISTINCT number, alias ',
            'condition'=>' state=? AND type=? ',
            'vars'=>array(1,1)
        );
        $number_list = $model->find($options)->getResultArray();
        $this->putContext('number_list', $number_list);
        
        $this->putContext('advertise', $advertise);
        $this->putContext('edit_mode', $edit_mode);
        
        return $this->smartyResult('admin.advertise.edit');
    }
    
    /**
     * upload advertise
     * 
     * @return string
     */
    public function save(){
		if(!$this->isLogged()){
            return $this->_redirectLogin();
        }
        $model = $this->wiredModel();
        $id = $this->getId();

        //保存广告信息
        if(empty($id) || $id < 0){
            $model->setIsNew(true);
            $model->setId(null);
            
            $edit_mode = 'create';
        }else{
            $model->setIsNew(false);
            $model->setId($id);
            
            $edit_mode = 'edit';
        }
        try{
            $model->setUpdatedOn(Common_Util_Date::getNow());
            $model->save(); 
            
            $_id = $model->getId();
            
	        //产品添加成功后，更新附件类别
	        $rand_sign_id = $this->getRandSignId();
	        if(!empty($rand_sign_id)){
	            $sql = 'UPDATE `asset` SET parent_id=? WHERE parent_id=? AND parent_type=?';
	            $model->getDba()->execute($sql,array($_id,$rand_sign_id,Common_Model_Constant::ADVERTISE));
	            self::debug("UPDATE asset belongs is ok!!", __METHOD__);
	        }
            
        }catch(Common_Model_Exception $e){
        	$msg = "validate failed:".$e->getMessage();
        	self::warn($msg, __METHOD__);
            return $this->_jqErrorTip($msg);
        }catch(Anole_ActiveRecord_Exception $e){
            $msg = "save advertise failed:".$e->getMessage();
            self::warn($msg, __METHOD__);
            return $this->_jqErrorTip($msg);
        }
        
        $this->putContext('advertise_id', $_id);
        $this->putContext('edit_mode',$edit_mode);
        
        return $this->jqueryResult('admin.advertise.edit_ok');
    }
    
    /**
     * 发布单个广告
     * 
     * @return string
     */
    public function checking(){
		if(!$this->isLogged()){
            return $this->_redirectLogin();
        }
        $model = $this->wiredModel();
        $id = $this->getId();
        if(empty($id)){
            //error page
            return $this->_hintResult('发布广告的Id为空!');
        }
        try{
            $state = $this->getState();
            
            $model->setId($id);
            $model->setIsNew(false);
            $model->setState($state);
            
            $model->save();
        }catch(Anole_ActiveRecord_Exception $e){
            self::warn("Checking ad failed:".$e->getMessage(), __METHOD__);
            return $this->_jqErrorTip($e->getMessage());
        }catch(Common_Model_Exception $e){
            self::warn("Checking ad failed:".$e->getMessage(), __METHOD__);
            return $this->_jqErrorTip($e->getMessage());
        }
        
        $this->putContext('id', $id);
        $this->putContext('state',$state);
        $this->putContext('edit_mode', 'publish');
        
        return $this->jqueryResult('admin.advertise.edit_ok');
    }
    
    /**
     * 删除某广告
     * 
     * @return string
     */
    public function delete(){
		if(!$this->isLogged()){
            return $this->_redirectLogin();
        }
        $id = $this->getId();
        if(empty($id)){
            //error page
            return $this->_hintResult('删除广告的Id为空!');
        }
        try{
        	if(!is_array($id)){
        		$id = array($id);
        	}
            $model = $this->wiredModel();
            $model->destroy($id);
        }catch(Anole_ActiveRecord_Exception $e){
            self::warn("Destory ad db failed: ".$e->getMessage(), __METHOD__);
            return $this->_jqErrorTip($e->getMessage());
        }catch(Common_Model_Exception $e){
            self::warn("Destory excute failed: ".$e->getMessage(), __METHOD__);
            return $this->_jqErrorTip($e->getMessage());
        }
        $this->putContext('ids', $id);
        $this->putContext('edit_mode','delete');
        
        return $this->jqueryResult('admin.advertise.edit_ok');
    }
    
    public function setState($state){
        $this->_state = $state;
        return $this;
    }
    public function getState(){
        return $this->_state;
    }
    
    public function setRandSignId($v){
        $this->_rand_sign_id = $v;
        return $this;
    }
    public function getRandSignId(){
        return $this->_rand_sign_id;
    }
    
}
/**vim:sw=4 et ts=4 **/
?>