<?php
/**
 * 产品的附加属性
 *
 * @version $Id$
 * @author purpen
 */
class Admin_Action_Features extends Admin_Action_Entry {
    protected $_model_class='Common_Model_Features';
    
    public $_main_menu = 'product';
    
    private $_parent_id = 0;
    
    private $_category_id = 0;
    
    /**
     * 
     * @return Common_Model_Features
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
     * display list
     * 
     * @return string
     */
    public function display(){
		if(!$this->isLogged()){
            return $this->_redirectLogin();
        }
        $model = $this->wiredModel();
        
        $category = new Common_Model_Category();
        
        $page = $this->getPage();
        $size = $this->_size;
        
        $records = $model->countIf();
        $total = ceil($records/$size);
        $page = min($page,$total);
        
        $options = array(
            'page'=>$page,
            'size'=>$size,
            'order'=>'id ASC',
        );
        $features = $model->find($options)->getResultArray();
        $max = count($features);
        
        for($i=0;$i<$max;$i++){
            $parent_id = $features[$i]['id'];
            $category_id = $features[$i]['parent_id'];
            $features[$i]['category'] = $category->findById($category_id)->getResultArray();
        }
        unset($model);
        
        $this->putContext('features_list', $features);
        
        $start = ($page - 1)*$size + 1;
        $end = min($page*$size, $records);
        
        $page_list = Common_Util_Pager::XE_NewPager(array('page'=>$page,'total'=>$total));
        $this->putContext('page_list', $page_list);
        $this->putContext('start', $start);
        $this->putContext('end',$end);
        $this->putContext('records', $records);
        $this->putContext('total', $total);
        $this->putContext('page', $page);
        
        $all_category = $category->findAllCategory();
        $this->putContext('all_category',$all_category);
        
        
        return $this->smartyResult('admin.features.list');
    }
    
    
    /**
     * modify features
     * 
     * @return string
     */
    public function edit(){
		if(!$this->isLogged()){
            return $this->_redirectLogin();
        }
        $model = $this->wiredModel();
        
        $parent_id = $this->getParentId();
        
        $edit_mode = 'create';
        if(!empty($this->_id)){
            $model->findById($this->_id);
            $edit_mode = 'edit';
        }
        $this->putContext('feature', $model);
        $this->putContext('edit_mode', $edit_mode);
        
        $category = new Common_Model_Category();
        $all_category = $category->findAllCategory();
        $this->putContext('all_category',$all_category);
        
        return $this->smartyResult('admin.features.edit');
    }
    
    /**
     * save info
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
            $model->setIsNew(true);
            $model->setId(null);
            
            $edit_mode = 'create';
        }else{
            $model->setIsNew(false);
            $model->setId($id);
            
            $edit_mode = 'edit';
        }
        try{
            $model->save();
            
            $_id = $model->getId();
            
            $feature = $model->findById($_id);
            
        }catch(Common_Model_Exception $e){
            self::warn("save feature failed:".$e->getMessage(), __METHOD__);
            return $this->_jqErrorTip($e->getMessage());
        }catch(Anole_ActiveRecord_Exception $e){
            self::warn("save feature failed:".$e->getMessage(), __METHOD__);
            return $this->_jqErrorTip($e->getMessage());
        }
        
        $this->putContext('edit_mode', $edit_mode);
        $this->putContext('feature_id', $_id);
        $this->putContext('feature', $feature);
        
        return $this->jqueryResult('admin.features.edit_ok');
    }
    
    /**
     * 单个或批量删除
     *
     * @return string
     */
    public function remove(){
		if(!$this->isLogged()){
            return $this->_redirectLogin();
        }
        if(empty($this->_id)){
            //error page
            return $this->_hintResult('删除类别的Id为空!');
        }
        //split id string
        $_ids = preg_split('/,/',$this->_id);
        try{
            $model = $this->wiredModel();
            $model->destroy($_ids);
        }catch(Anole_ActiveRecord_Exception $e){
            self::warn("Destory db failed: ".$e->getMessage(), __METHOD__);
            return $this->_jqErrorTip($e->getMessage());
        }catch(Common_Model_Exception $e){
            self::warn("Destory failed: ".$e->getMessage(), __METHOD__);
            return $this->_jqErrorTip($e->getMessage());
        }
        $this->putContext('ids', $_ids);
        
        return $this->jqueryResult('admin.features.del_ok');
    }
    /**
     * 获取相关的属性值
     * 
     * @return string
     */
    public function fetchFeature(){
		if(!$this->isLogged()){
            return $this->_redirectLogin();
        }
        $model = $this->wiredModel();
        //id形式：2,3,56
        $id = $this->getId();
        $category_ids = preg_split('/,/',$id);
        
        if(!empty($category_ids)){
            $vars = array();
            if (count($category_ids) == 1){
                $condition = 'parent_id=?';
                $vars = array($category_ids[0]);
            }else{
                $condition = 'parent_id IN ('.implode(',',$category_ids).')';
            }
            $options = array(
                'condition'=>$condition,
                'vars'=>$vars,
                'order'=>'parent_id ASC'
            );
            $features_list = $model->find($options);
        }
        
        $this->putContext('features_list',$features_list);
        
        return $this->jQueryResult('admin.product.features');
    }
    
    public function setId($id){
        $this->_id = $id;
        return $this;
    }
    public function getId(){
        return $this->_id;
    }
    
    public function setParentId($v){
    	$this->_parent_id = $v;
    	return $this->_parent_id;
    }
    public function getParentId(){
    	return $this->_parent_id;
    }
    
    public function setCategoryId($v){
    	$this->_category_id = $v;
    	return $this;
    }
    public function getCategoryId(){
    	return $this->_category_id;
    }
    
}
/**vim:sw=4 et ts=4 **/
?>