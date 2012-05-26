<?php
/**
 * 促销活动（赠品、返利、打折、满就送等活动类型）
 *
 * @author purpen
 * @version $Id$
 */
class Admin_Action_Marketing extends Admin_Action_Entry {
    protected $_model_class='Common_Model_Marketing';
    
    private $_status = 0;
    
    
    /**
     * 
     * @return Common_Model_Marketing
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
     * 显示所有的促销活动列表
     */
    public function display(){
		if(!$this->isLogged()){
            return $this->_redirectLogin();
        }
        $model = $this->wiredModel();
        
        $page = $this->getPage();
        $size = $this->_size;
        $status = $this->getStatus();
        
        $vars = array();
        if(!is_null($status)){
        	$condition = 'status=?';
        	$vars = array($status);
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
        
        $marketing_list = $model->find($options)->getResultArray();
        
        $this->putContext('marketing_list', $marketing_list);
        
        $this->putContext('records', $records);
        $this->putContext('total',$total);
        $this->putContext('page', $page);
        $this->putContext('status',$status);
        
        $start = ($page - 1)*$size + 1;
        $end = min($page*$size, $records);
        $this->putContext('start', $start);
        $this->putContext('end',$end);
        
        $page_list = Common_Util_Pager::XE_NewPager(array('page'=>$page,'total'=>$total));
        $this->putContext('page_list', $page_list);
        
        $publishing_records = $model->countIf('status=?', array(1));
        $published_records = $model->countIf('status=?', array(-1));
        $unpublished_records = $model->countIf('status=?', array(0));
        
        $this->putContext('publishing_records', $publishing_records);
        $this->putContext('published_records', $published_records);
        $this->putContext('unpublished_records', $unpublished_records);
        
        return $this->smartyResult('admin.marketing.list');
    }
    
    /**
     * 添加或编辑活动
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
            $marketing = $model->findById($id)->getResultArray();
            $edit_mode = 'edit';
        }
        
        $this->putContext('marketing', $marketing);
        $this->putContext('edit_mode', $edit_mode);
        
        return $this->smartyResult('admin.marketing.edit');
    }
    
    /**
     * 保存活动
     * 
     * @return string
     */
    public function save(){
		if(!$this->isLogged()){
            return $this->_redirectLogin();
        }
        $model = $this->wiredModel();
        $id = $this->getId();
        $admin_id = Anole_Util_Cookie::getAdminID();
        //保存广告信息
        if(empty($id) || $id < 0){
            $model->setIsNew(true);
            $model->setId(null);
            $model->setCreatedBy($admin_id);
            $edit_mode = 'create';
        }else{
            $model->setIsNew(false);
            $model->setId($id);
            
            $edit_mode = 'edit';
        }
        try{
            $model->save(); 
            
            $_id = $model->getId();
        }catch(Common_Model_Exception $e){
        	$msg = "validate failed:".$e->getMessage();
        	self::warn($msg, __METHOD__);
            return $this->_jqErrorTip($msg);
        }catch(Anole_ActiveRecord_Exception $e){
            $msg = "save advertise failed:".$e->getMessage();
            self::warn($msg, __METHOD__);
            return $this->_jqErrorTip($msg);
        }
        
        $this->putContext('marketing_id', $_id);
        $this->putContext('edit_mode',$edit_mode);
        
        return $this->jqueryResult('admin.marketing.edit_ok');
    }
    
    /**
     * 审核促销活动
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
            return $this->_hintResult('审核促销活动的Id为空!');
        }
        try{
            $status = $this->getStatus();
            
            $model->setId($id);
            $model->setIsNew(false);
            $model->setStatus($status);
            
            $model->save();
        }catch(Anole_ActiveRecord_Exception $e){
            self::warn("Checking ad failed:".$e->getMessage(), __METHOD__);
            return $this->_jqErrorTip($e->getMessage());
        }catch(Common_Model_Exception $e){
            self::warn("Checking ad failed:".$e->getMessage(), __METHOD__);
            return $this->_jqErrorTip($e->getMessage());
        }
        
        $this->putContext('id', $id);
        $this->putContext('status',$status);
        $this->putContext('edit_mode', 'publish');
        
        return $this->jqueryResult('admin.marketing.edit_ok');
    }
    
    /**
     * 删除促销活动
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
            return $this->_hintResult('删除促销活动的Id为空!');
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
        
        return $this->jqueryResult('admin.marketing.edit_ok');
    }
    
    
    public function setStatus($v){
        $this->_status = $v;
        return $this;
    }
    public function getStatus(){
        return $this->_status;
    }
}
/**vim:sw=4 et ts=4 **/
?>