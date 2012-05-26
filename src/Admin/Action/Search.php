<?php
/**
 * Admin_Action_Search
 *
 */
class Admin_Action_Search extends Admin_Action_Entry {
	
    protected $_model_class='Common_Model_Search';
    
    public $_main_menu = 'keydict';
    
    
/**
     * authentication object
     *
     * @var Anole_Auth_Authentication
     */
    protected $_authentication;
    /**
     * authorizedresource interface
     *
     * @return array
     */
    public function getPrivilegeMap(){
        return array(
            '*'=>array(
                'privilege'=>Anole_Auth_AuthenticationResource::PRIV_CUSTOM,
                'custom'=>'validateAdministrator'
            ));
    }
    /**
     * 当前Resource的唯一标识,与ACL中的resource应对应
     */
    public function getResourceId(){
        return 'keydict';
    }
    /**
     * 设置当前用户的Authentication
     *
     * @param Anole_Auth_Authentication $authentication
     */
    public function _setAuthentication(Anole_Auth_Authentication $authentication){
        $this->_authentication = $authentication;
    }
    
    /**
     * 
     * @return Common_Model_Search
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
    
    public function display(){
        $model = $this->wiredModel();
        
        $options = array(
           'page'=>1,
           'size'=>100,
           'order'=>'ref_count DESC'
        );
        
        $words = $model->find($options)->getResultArray();
        
        $this->putContext('words', $words);
        
        return $this->smartyResult('admin.sowo.list');
    } 
    /**
     * upload designer works
     * 
     * @return string
     */
    public function save(){
        $model = $this->wiredModel();
        if(empty($this->_id) || $this->_id < 0){
            $model->setIsNew(true);
            $model->setId(null);
        }else{
            $model->setIsNew(false);
            $model->setId($this->_id);
        }
        try{
            $model->save(); 
            
            $_id = $model->getId();
            
        }catch(Anole_ActiveRecord_Exception $e){
            self::warn("save search word failed:".$e->getMessage(), __METHOD__);
            $this->putContext('msg', $e->getMessage());
            return $this->jsonResult(500);
        }
        
        $this->putContext('work_id', $_id);
        $msg = "保存成功!";
        $this->putContext('msg', $msg);
        
        return $this->jsonResult();
    }
    
    public function setId($id){
        $this->_id = $id;
        return $this;
    }
    public function getId(){
        return $this->_id;
    }
}
/**vim:sw=4 et ts=4 **/
?>