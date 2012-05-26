<?php
/**
 * 品牌店铺管理
 *
 * @version $Id$
 * @author purpen
 */
class Admin_Action_Store extends Admin_Action_Entry {
    protected $_model_class='Common_Model_Store';
    
    private $_rand_sign_id = null;
    
    private $_payment = null;
    
    private $_state = null;
    
    private $_query = null;
    /**
     * 
     * @return Common_Model_Store
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
     * 所有店铺列表
     * 
     * @return string
     */
    public function display(){
		if(!$this->isLogged()){
            return $this->_redirectLogin();
        }
    	$model = $this->wiredModel();
    	$page = $this->getPage();
        $size = $this->getSize();
        $state = $this->getState();
        $query = $this->getQuery();
        
        $conditions = array();
        $vars = array();
        if(!is_null($state)){
            $conditions[] = 'state=?';
            $vars[] = $state;
        }
        if(!is_null($query)){
        	$conditions[] = 'title LIKE ?';
        	$vars[] = "%$query%";
        }
        
        if(!empty($conditions)){
            $condition = implode(' AND ', $conditions);
        }else{
            $condition = null;
        }
        
        $records = $model->countIf($condition,$vars);
        $total = ceil($records/$size);
        $page = min($total,$page);
        
        $options = array(
            'condition'=>$condition,
            'vars'=>$vars,
            'page'=>$page,
            'size'=>$size,
            'order'=>'id DESC'
        );
        
        $store_list = $model->find($options)->getResultArray();
        if(!empty($store_list)){
        	for($i=0;$i<count($store_list);$i++){
        		$id = $store_list[$i]['id'];
        		$store_list[$i]['category'] = $model->_getCategoryPath($store_list[$i]['catcode']);
        		$store_list[$i]['logo'] = Common_Util_Asset::fetchAssetUrl($id,Common_Model_Constant::STORE_THUMB);
        	}
        }
        
        $this->putContext('store_list', $store_list);
        
        $start = ($page - 1)*$size + 1;
        $end = min($page*$size, $records);
        $this->putContext('start', $start);
        $this->putContext('end',$end);
        
        $page_list = Common_Util_Pager::XE_NewPager(array('page'=>$page,'total'=>$total));
        $this->putContext('page_list', $page_list);
        
        $this->putContext('records', $records);
        $this->putContext('total', $total);
        $this->putContext('page',$page);
    	
        //获取各个状态的个数
        $all_count = $model->countIf();
        $checked_count = $model->countIf('state=?',array(1));
        $unchecked_count = $model->countIf('state=?',array(0));
        
        $this->putContext('all_count', $all_count);
        $this->putContext('checked_count', $checked_count);
        $this->putContext('unchecked_count', $unchecked_count);
        
        return $this->smartyResult('admin.store.list');	
    }
    
    /**
     * 编辑店铺信息
     * 
     * @return string
     */
    public function edit(){
		if(!$this->isLogged()){
            return $this->_redirectLogin();
        }
        $model = $this->wiredModel();
        $store = array();
        $id = $this->getId();
        $edit_mode = 'create';
        if(!empty($id)){
            $edit_mode = 'edit';
            $store = $model->findById($id)->getResultArray();
            
            $asset_list = $model->findRelationModel('assets',array(),$id);
            $this->putContext('asset_list', $asset_list);
            
            $store['payment'] = @unserialize($store['payment']);
        }
        $rand_sign = $this->_genRandsign();
        $this->putContext('rand_sign',$rand_sign);
        
        $this->putContext('edit_mode', $edit_mode);
        
        $this->putContext('store', $store);
        
        $category = new Common_Model_Category();
        $all_category = $category->findAllCategory();
        $this->putContext('all_category',$all_category);
        
        return $this->smartyResult('admin.store.edit');
    }
    
    
    /**
     * 保存信息
     * 
     * @return string
     */
    public function save(){
		if(!$this->isLogged()){
            return $this->_redirectLogin();
        }
        $model = $this->wiredModel();
        
        $id = $this->getId();
        
        if(empty($id) || $id < 0){
            $model->setIsNew(True);
            $model->setId(null);
            $edit_mode = 'create';
        }else{
            $model->setIsNew(False);
            $model->setId($id);
            $edit_mode = 'edit';
        }
        try{
        	
            $model->save();
            
            $id = $model->getId();
            
            //产品添加成功后，更新附件类别
            $rand_sign_id = $this->getRandSignId();
            if(!empty($rand_sign_id)){
                $sql = 'UPDATE `asset` SET parent_id=? WHERE parent_id=? AND (parent_type=? OR parent_type=?)';
                $model->getDba()->execute($sql,array($id,$rand_sign_id,Common_Model_Constant::STORE_THUMB,Common_Model_Constant::STORE_SHOW));
                self::debug("UPDATE asset belongs is ok!!", __METHOD__);
            }
        }catch(Common_Model_Exception $e){
            $msg = "Model Validate Error: ".$e->getMessage();
            self::warn($msg, __METHOD__);
            return $this->_jqErrorTip($msg);
        }catch(Anole_ActiveRecord_Exception $e){
            $msg = "Database Validate Error: ".$e->getMessage();
            self::warn($msg, __METHOD__);
            return $this->_jqErrorTip($msg);
        }
        
        $this->putContext('store_id', $id);
        $this->putContext('edit_mode', $edit_mode);
        
        return $this->jqueryResult('admin.store.edit_ok');
    }
    
    
    /**
     * 删除某个店铺
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
            return $this->_hintResult('删除店铺的Id为空!');
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
        
        return $this->jqueryResult('admin.store.edit_ok');
    }
    
    public function setSize($v){
    	$this->_size = $v;
    	return $this;
    }
    public function getSize(){
    	return $this->_size;
    }
    
    public function setRandSignId($v){
        $this->_rand_sign_id = $v;
        return $this;
    }
    public function getRandSignId(){
        return $this->_rand_sign_id;
    }
    
    public function setPayment($v){
        $this->_payment = $v;
        return $this;
    }
    public function getPayment(){
        return $this->_payment;
    }
    
    public function setState($state){
        $this->_state = $state;
        return $this;
    }
    public function getState(){
        return $this->_state;
    }
    
    public function setQuery($v){
    	$this->_query = $v;
    	return $this;
    }
    public function getQuery(){
    	return $this->_query;
    }
}
/**vim:sw=4 et ts=4 **/
?>