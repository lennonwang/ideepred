<?php
/**
 * 管理产品的分类信息
 * 
 * @version $Id$
 * @author purpen
 */
class Admin_Action_Category extends Admin_Action_Entry {
	
    protected $_model_class='Common_Model_Category';
    
    public $_id = null;
    
    public $_page = 1;
    
    public $_size = 10;
    
    private $_rand_sign_id = null;
    /**
     * 
     * @return Common_Model_Category
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
     * 显示所有的分类
     * 
     * @return string
     */
    public function display(){
		if(!$this->isLogged()){
            return $this->_redirectLogin();
        }
    	$model = $this->wiredModel();
    	
        $all_category = $model->findAllCategory();
        $this->putContext('all_category', $all_category);
    	
    	return $this->smartyResult('admin.category.list');
    }
    /**
     * 修改分类信息
     * 
     * @return string
     */
    public function edit(){
		if(!$this->isLogged()){
            return $this->_redirectLogin();
        }
        $model = $this->wiredModel();
        
        $id = $this->getId();
        $is_open_thumb = Anole_Config::get('envar.category_thumb');
        $edit_mode = 'create';
        if(!empty($id)){
        	$edit_mode = 'edit';
        	$current_category = $model->findById($id)->getResultArray();
        	
        	//获取分类级别
        	if(strlen($current_category['code']) == 4){
        		$type = 2;
        	}elseif(strlen($current_category['code']) == 1){
        		$type = 1;
        	}else{
        		$type = 3;
        	}
        	$this->putContext('type', $type);
        	
	        if($is_open_thumb == 'open'){
	            $rand_sign = $this->_genRandsign();
	            $this->putContext('rand_sign',$rand_sign);
	            
	            $asset = new Common_Model_Asset();
	            //获取分类缩略图
	            $options = array(
	                'condition'=>'parent_id=? AND parent_type=?',
	                'vars'=>array($id, Common_Model_Constant::CATEGORY_THUMB)
	            );
	            $asset->findFirst($options);
	            if($asset->count()){
	                $asset_url = $asset['asset_url'];
	                $category_thumb = $asset->getResultArray();
	                $category_thumb['asset_url'] = $asset_url;
	                
	                $this->putContext('category_thumb', $category_thumb);
	            }
	            unset($asset);
	        }
        }
        $all_category = $model->findAllCategory();
        $this->putContext('all_category', $all_category);
        
        $this->putContext('edit_mode', $edit_mode);
        $this->putContext('is_open_thumb', $is_open_thumb);
        
        $this->putContext('category', $current_category);
        
        return $this->smartyResult('admin.category.edit');
    }
    /**
     * 保存分类信息
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
                $sql = 'UPDATE `asset` SET parent_id=? WHERE parent_id=? AND parent_type=?';
                $model->getDba()->execute($sql,array($id,$rand_sign_id,Common_Model_Constant::CATEGORY_THUMB));
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
    	
    	$this->putContext('category_id', $id);
    	$this->putContext('edit_mode', $edit_mode);
    	
    	return $this->jqueryResult('admin.category.edit_ok');
    }
    
    /**
     * 删除某个分类
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
            return $this->_hintResult('删除分类的Id为空!');
        }
        try{
            $model = $this->wiredModel();
            $model->destroy($id);
        }catch(Common_Model_Exception $e){
            self::warn("Destory ad db failed: ".$e->getMessage(), __METHOD__);
            return $this->_jqErrorTip($e->getMessage());
        }catch(Anole_ActiveRecord_Exception $e){
            self::warn("Destory excute failed: ".$e->getMessage(), __METHOD__);
            return $this->_jqErrorTip($e->getMessage());
        }
        $this->putContext('ids', $id);
        $this->putContext('edit_mode','delete');
        
        return $this->jqueryResult('admin.category.edit_ok');
    }
    
    
    /***********Action的辅助方法***************/
    public function setId($value){
    	$this->_id = $value;
    	return $this;
    }
    public function getId(){
    	return $this->_id;
    }
    public function setPage($value){
    	$this->_page = $value;
    	return $this;
    }
    public function getPage(){
    	return $this->_page;
    }
    public function setSize($value){
    	$this->_size = $value;
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
    
}
/**vim:sw=4 et ts=4 **/
?>