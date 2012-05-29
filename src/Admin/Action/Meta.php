<?php
/**
 * Admin_Action_Meta
 *
 */
class Admin_Action_Meta extends Admin_Action_Entry {
    protected $_model_class='Common_Model_Meta';
    
    private $_metakey = null;
    
    private $_metavalue = null;
    
    private $_owner_id = null;
    
    private $_rand_sign_id = null;
    /**
     * 
     * @return Common_Model_Meta
     */
    public function wiredModel(){
        return parent::wiredModel();
    }
    //~~~~~~~~~~~~~~Action implements~~~~~~~~~~
    /**
     * default action method
     */
    public function execute(){
        
    }
    
    /**
     * 添加新meta值
     * 
     * @return string
     */
    public function add(){
        $model = $this->wiredModel();
        $id = $this->getId();
        if(empty($id) || $id < 0){
            $model->setIsNew(True);
            $edit_mode = 'create';
        }else{
            $model->setIsNew(False);
            $edit_mode = 'edit';
        }
        try{
            $metakey = $this->getMetakey();
            $metavalue = $this->getMetavalue();
            $owner_id = $this->getOwnerId();
            $rand_sign_id = $this->getRandSignId(); 
            if(empty($owner_id)){
                $model->setOwnerId($rand_sign_id);
            }else{
                $model->setOwnerId($owner_id);
            } 
            $model->setName($metakey);
            $model->setValue($metavalue);
            $model->setDomain(Common_Model_Constant::PRODUCT_DOMAIN);
            $model->save();
            
            $id = $model->getId();
            
            $meta = $model->findById($id);
            
            //获取meta显示名称
            $tmp_id = $meta['tmp_id'];
            if(!empty($tmp_id)){
                $feature = new Common_Model_Features();
                $meta['feature'] = $feature->findById($tmp_id)->getResultArray();
                unset($feature);
            }
            
            self::warn("save meta[$id] is OK!", __METHOD__);
        }catch(Common_Model_Exception $e){
            $msg = 'Add Meta Erorr: '.$e->getMessage();
            self::warn($msg, __METHOD__);
            return $this->_jqErrorTip($msg);
        }
        
        $this->putContext('edit_mode',$edit_mode);
        $this->putContext('id', $id);
        $this->putContext('meta',$meta);
        
        return $this->jQueryResult('admin.product.meta_ok');
    }
    /**
     * 删除某个meta
     * 
     * @return string
     */
    public function delete(){
        $model = $this->wiredModel();
        
        $id = $this->getId();
        if(!is_array($id)){
            $id = array($id);
        }
        try{
            $model->destroy($id);
        }catch(Exception $e){
            self::warn("Delete Meta Error: ".$e->getMessage(), __METHOD__);
        }
        $this->putContext('ids', $id);
        $this->putContext('edit_mode','delete');
        
        return $this->jQueryResult('admin.product.meta_ok');
    }
    
    
    public function setMetaKey($v){
        $this->_metakey = $v;
        return $this;
    }
    public function getMetaKey(){
        return $this->_metakey;
    }
    public function setMetaValue($v){
        $this->_metavalue = $v;
        return $this;
    }
    public function getMetaValue(){
        return $this->_metavalue;
    }
    
    public function setOwnerId($v){
        $this->_owner_id = $v;
        return $this;
    }
    public function getOwnerId(){
        return $this->_owner_id;
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