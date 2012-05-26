<?php
/**
 * Admin_Action_Link
 *
 */
class Admin_Action_Link extends Admin_Action_Entry {
    protected $_model_class='Common_Model_Link';
	public $_size = 1;
    /**
     * 
     * @return Common_Model_Link
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
		if(!$this->isLogged()){
            return $this->_redirectLogin();
        }
        $model = $this->wiredModel();
        
        $page = $this->getPage();
        $size = $this->_size;
        
        $conditions = array();
        $vars = array();
        
        //get total page
        $records = $model->countIf($condition,$vars);
        $total = ceil($records/$size);
        $page = min($total,$page);
        
        $start = ($page - 1)*$size + 1;
        $end = min($page*$size, $records);
        $this->putContext('start', $start);
        $this->putContext('end',$end);
        
        $page_list = Common_Util_Pager::XE_NewPager(array('page'=>$page,'total'=>$total));
        $this->putContext('page_list', $page_list);
        
        if($order_by == 'time'){
            $order = 'created_at DESC';
        }else{
            $order = 'sort ASC';
        }
        //get current data
        $options = array(
           'condition'=>$condition,
           'vars'=>$vars,
           'order'=>$order,
           'page'=>$page,
           'size'=>$this->_size
        );
        $article_list = $model->find($options);
        
        $this->putContext('links', $article_list);
        
        $this->putContext('records', $records);
        $this->putContext('total', $total);
        $this->putContext('page', $page);
        
        $this->putMenu();
        
        return $this->smartyResult('admin.link.list');
	}
	/**
     * 创建友情链接
     * 
     * @return string
     */
    public function edit(){
        if(!$this->isLogged()){
            return $this->_redirectLogin();
        }
        $model = $this->wiredModel();
        $edit_mode = 'create';
        
        $id = $this->getId();
        if(!empty($id)){
            $edit_mode = 'edit';
            
            $link = $model->findById($id)->getResultArray();
        }
        
        $this->putContext('link', $link);
        
        $this->putMenu();

        return $this->smartyResult('admin.link.edit');
    }

	public function save(){
        if(!$this->isLogged()){
            return $this->_redirectLogin();
        }
        $model = $this->wiredModel();
        
        $user_id = Anole_Util_Cookie::getAdminID();
        
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
            
            $_id = $model->getId();
        }catch(Common_Model_Exception $e){
            self::warn("validate failed:".$e->getMessage(), __METHOD__);
            $msg = "validate failed:".$e->getMessage();
            return $this->_jqErrorTip($msg);
        }catch(Anole_ActiveRecord_Exception $e){
            self::warn("database failed:".$e->getMessage(), __METHOD__);
            $msg = "database failed:".$e->getMessage();
            return $this->_jqErrorTip($msg);
        }
        
        $this->putContext('link_id', $_id);
        $this->putContext('edit_mode', $edit_mode);
        
        return $this->jqueryResult('admin.link.edit_ok');
    }

	public function remove(){
        if(!$this->isLogged()){
            return $this->_redirectLogin();
        }
        $id = $this->getId();
        if(empty($id)){
            //error page
            return $this->_hintResult('删除信息的Id为空!');
        }
        //split id string
        $_ids = preg_split('/,/',$id);
        try{
            $model = $this->wiredModel();
            $model->destroy($_ids);
        }catch(Anole_ActiveRecord_Exception $e){
            self::warn("Destory article db failed: ".$e->getMessage(), __METHOD__);
            return $this->_jqErrorTip($e->getMessage());
        }catch(Anole_Exception $e){
            self::warn("Destory excute failed: ".$e->getMessage(), __METHOD__);
            return $this->_jqErrorTip($e->getMessage());
        }
        $this->putContext('ids', $_ids);
        $this->putContext('edit_mode','delete');
        
        return $this->jqueryResult('admin.link.edit_ok');    
    }
	
}
/**vim:sw=4 et ts=4 **/
?>