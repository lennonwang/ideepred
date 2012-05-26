<?php
/**
 * Admin_Action_Areas
 *
 */
class Admin_Action_Areas extends Admin_Action_Entry {
    protected $_model_class='Common_Model_Areas';
    
    public $_main_menu = 'system';
    
    private $_state = 1;
    
    /**
     * 
     * @return Common_Model_Areas
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
     * display areas list
     * 
     * @return string
     */
    public function display(){
        $model = $this->wiredModel();
        
        $condition = 'state=?';
        $vars = array($this->_state);
        //get total page
        $records = $model->countIf($condition,$vars);
        $total = ceil($records/$this->_size);
        $page = min($total,$this->_page);
        
        $options = array(
           'condition'=>$condition,
           'vars'=>$vars,
           'order'=>'id DESC',
           'page'=>$page,
           'size'=>$this->_size
        );
        
        $model->find($options);
        
        $this->putContext('areas', $model);
        $this->putContext('records',$records);
        $this->putContext('total', $total);
        $this->putContext('page', $page);
        
        $this->putContext('state',$this->_state);
        
        //set menu style
        $this->putMenu();
        
        return $this->smartyResult('admin.areas.list');
    }
    
    /**
     * modify areas
     * 
     * @return string
     */
    public function edit(){
        $model = $this->wiredModel();
        $edit_mode = 'create';
        if(!empty($this->_id)){
            $area = $model->findById($this->_id)->getResultArray();
            $edit_mode = 'update';
        }
        $this->putContext('area', $area);
        $this->putContext('edit_mode', $edit_mode);
        
        //get parent category
        $options = array(
           'condition'=>'parent_id=?',
           'vars'=>array(0)
        );
        $model->find($options);
        
        $this->putContext('parent', $model);
        
        //set menu style
        $this->putMenu();
        
        return $this->smartyResult('admin.areas.edit');
    }
    
    /**
     * save areas info
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
            self::warn("save areas failed:".$e->getMessage(), __METHOD__);
            return $this->_jqErrorTip($e->getMessage());
        }
        
        $this->putContext('area_id', $_id);
        
        return $this->jqueryResult('admin.areas.edit_ok');
    }
    
    /**
     * 单个或批量删除areas
     *
     * @return string
     */
    public function remove(){
        if(empty($this->_id)){
            //error page
            return $this->_hintResult('删除地域的Id为空!');
        }
        //split id string
        $_ids = preg_split('/,/',$this->_id);
        try{
            $model = $this->wiredModel();
            $model->destroy($_ids);
        }catch(Anole_ActiveRecord_Exception $e){
            self::warn("Destory area db failed: ".$e->getMessage(), __METHOD__);
            return $this->_jqErrorTip($e->getMessage());
        }catch(Common_Model_Exception $e){
            self::warn("Destory excute failed: ".$e->getMessage(), __METHOD__);
            return $this->_jqErrorTip($e->getMessage());
        }
        $this->putContext('ids', $_ids);
        
        return $this->jqueryResult('admin.areas.del_ok');
    }
    
    public function setId($id){
        $this->_id = $id;
        return $this;
    }
    public function getId(){
        return $this->_id;
    }
    
    public function setPage($page){
        $this->_page = $page;
        return $this;
    }
    public function getPage(){
        return $this->_page;
    }
    public function setState($state){
        $this->_state = $state;
        return $this;
    }
    public function getState(){
        return $this->_state;
    }
    
}
/**vim:sw=4 et ts=4 **/
?>