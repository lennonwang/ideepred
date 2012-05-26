<?php
/**
 * Admin_Action_Sort
 *
 */
class Admin_Action_Sort extends Admin_Action_Entry {
    protected $_model_class='Common_Model_Sort';
    
    private $_state = 1;
    
    /**
     * 
     * @return Common_Model_Sort
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
           'condition'=>'state=?',
           'vars'=>array($this->_state),
           'order'=>'updated_on DESC,id DESC'
        );
        $model->find($options);
        
        $this->putMenu();
        
        $this->putContext('sorts', $model);
        $this->putContext('state', $this->_state);
        
        return $this->smartyResult('admin.sort.list');
    }
    
    /**
     * 编辑栏目分类
     * 
     * @return string
     */
    public function edit(){
        $model = $this->wiredModel();
        $conditions = array();
        $vars = array();
        if(!empty($this->_id)){
            $model->findById($this->_id);
            
            $conditions[] = 'id<>?';
            $vars[] = $this->_id;
        }
        //获取一级栏目
        $parent = clone $model;
        $conditions[] = 'parent_id=?';
        $vars[] = 0;
        $conditions[] = 'state=?';
        $vars[] = Common_Model_Sort::OPEN_STATE;
        $condition = implode(' AND ', $conditions);
        
        $options = array(
            'condition'=>$condition,
            'vars'=>$vars
        );
        $parent->find($options);
            
        $this->putContext('parent', $parent);
        
        $this->putContext('sort', $model);
        
        $this->putMenu();
        
        return $this->smartyResult('admin.sort.edit');
    }
    /**
     * 保存栏目信息
     * 
     * @return string
     */
    public function save(){
        $model = $this->wiredModel();
        if(empty($this->_id) || $this->_id < 0){
            $model->setIsNew(True);
            $model->setId(null);
        }else{
            $model->setIsNew(False);
            $model->setId($this->_id);
        }
        try{
            $model->save();
            
            $_id = $model->getId();
        }catch(Common_Model_Exception $e){
            self::warn('validate sort failed:'.$e->getMessage(), __METHOD__);
        }catch(Anole_ActiveRecord_Exception $e){
            self::warn('execute sort failed:'.$e->getMessage(), __METHOD__);
        }
        
        $this->putContext('sort_id', $_id);
        
        return $this->jqueryResult('admin.sort.edit_ok');
    }
    
    /**
     * 删除栏目信息
     * 
     * @return string
     */
    public function remove(){
        if(empty($this->_id)){
            //error page
            return $this->_hintResult('删除类别的Id为空!');
        }
        //split id string
        $_ids = preg_split('/,/',$this->_id);
        try{
            $model = $this->wiredModel();
            $model->destroy($_ids);
        }catch(Common_Model_Exception $e){
            self::warn("Destory excute failed: ".$e->getMessage(), __METHOD__);
            return $this->_jqErrorTip($e->getMessage());
        }catch(Anole_ActiveRecord_Exception $e){
            self::warn("Destory sort db failed: ".$e->getMessage(), __METHOD__);
            return $this->_jqErrorTip($e->getMessage());
        }
        $this->putContext('ids', $_ids);
        
        return $this->jqueryResult('admin.sort.del_ok');
    }
    
    /**
     * 禁用或解禁某个或多个栏目分类
     * 
     * @return string
     */
    public function doing(){
        $model = $this->wiredModel();
        if(empty($this->_id)){
            //error page
            return $this->_hintResult('操作分类的Id为空!');
        }
        //split id string
        $_ids = preg_split('/,/',$this->_id);
        try{
            $state = $this->getState();
            foreach($_ids as $id){
                $model->setId($id);
                $model->setIsNew(false);
                $model->setState($state);
                $model->save();
            }
        }catch(Common_Model_Exception $e){
            self::warn("Doing sort model:".$e->getMessage(), __METHOD__);
            return $this->_jqErrorTip($e->getMessage());
        }catch(Anole_ActiveRecord_Exception $e){
            self::warn("Doing sort failed:".$e->getMessage(), __METHOD__);
            return $this->_jqErrorTip($e->getMessage());
        }
        
        $this->putContext('ids', $_ids);
        
        return $this->jqueryResult('admin.sort.del_ok');
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