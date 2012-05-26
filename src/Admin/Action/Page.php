<?php
/**
 * 自定义页面管理，继承于内容数据表。
 * 
 * @author purpen
 * @version $Id$
 */
class Admin_Action_Page extends Admin_Action_Entry {
    protected $_model_class='Common_Model_Content';
    
    private $_rand_sign_id = null;
    
    private $_page_template = null;
    
    public $_size = 20;
    
    private $_status = null;
    
    /**
     * 
     * @return Common_Model_Content
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
     * 页面列表
     * 
     * @return string
     */
    public function display(){
        if(!$this->isLogged()){
            return $this->_redirectLogin();
        }
        $model = $this->wiredModel();
        
        $status = $this->getStatus();
        $page = $this->getPage();
        $size = $this->_size;
        
        $conditions = array();
        $vars = array();
        
        //页面类型
        $conditions[] = 'post_type=?';
        $vars[] = Common_Model_Content::PAGE_TYPE;
        
        if(!is_null($status)){
            $conditions[] = 'status=?';
            $vars[] = $status;
        }
        if(!empty($conditions)){
            $condition = implode(' AND ',$conditions);
        }else{
            $condition = null;
        }
        
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
        
        if($status == Common_Model_Content::CHECKED_STATUS){
            $order = 'published_on DESC';
        }else{
            $order = 'created_on DESC';
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
        
        $this->putContext('articles', $article_list);
        $this->putContext('status', $status);
        
        $this->putContext('records', $records);
        $this->putContext('total', $total);
        $this->putContext('page', $page);
        
        //获取每个状态的记录数
        $all_records         = $model->countIf('post_type=?',array(Common_Model_Content::PAGE_TYPE));
        $published_records   = $model->countIf('status=? AND post_type=?',array(1,Common_Model_Content::PAGE_TYPE));
        $unpublished_records = $model->countIf('status=? AND post_type=?',array(0,Common_Model_Content::PAGE_TYPE));
        
        $this->putContext('all_records', $all_records);
        $this->putContext('published_records', $published_records);
        $this->putContext('unpublished_records', $unpublished_records);
        
        $this->putMenu();
        
        return $this->smartyResult('admin.page.list');
    }
    
    /**
     * 发表资讯
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
            
            $article = $model->findById($id)->getResultArray();
            
            //获取附件列表
            $asset_list = $model->findRelationModel('assets',array(),$id);
            $this->putContext('asset_list', $asset_list);
            
        }
        
        $this->putContext('article', $article);
        
        $rand_sign = $this->_genRandsign();
        $this->putContext('rand_sign',$rand_sign);
        $this->putContext('edit_mode', $edit_mode);
        
        $this->putMenu();

        return $this->smartyResult('admin.page.edit');
    }
    
    /**
     * 保存页面内容
     * 
     * @return string
     */
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
            $model->setCreatedBy($user_id);
            $edit_mode = 'create';
        }else{
            $model->setIsNew(False);
            $model->setId($id);
            $edit_mode = 'edit';
        }
        try{
            //页面标识
        	$model->setPostType(Common_Model_Content::PAGE_TYPE);
        	
            //添加meta
            $page_template = $this->getPageTemplate();
            $model->addMeta('_page_template',$page_template);
            
            $model->save();
            
            $_id = $model->getId();
            
            //文章添加成功后，更新附件类别
            $rand_sign_id = $this->getRandSignId();
            if(!empty($rand_sign_id)){
                $sql = 'UPDATE `asset` SET parent_id=? WHERE parent_id=? AND parent_type=?';
                $model->getDba()->execute($sql,array($_id,$rand_sign_id,Common_Model_Constant::ARTICLE_SOURCE));
                self::debug("UPDATE asset belongs is ok!!", __METHOD__);
            }
        }catch(Common_Model_Exception $e){
            self::warn("validate failed:".$e->getMessage(), __METHOD__);
            $msg = "validate failed:".$e->getMessage();
            return $this->_jqErrorTip($msg);
        }catch(Anole_ActiveRecord_Exception $e){
            self::warn("database failed:".$e->getMessage(), __METHOD__);
            $msg = "database failed:".$e->getMessage();
            return $this->_jqErrorTip($msg);
        }
        
        $this->putContext('article_id', $_id);
        $this->putContext('edit_mode', $edit_mode);
        
        return $this->jqueryResult('admin.page.edit_ok');
    }
    
    /**
     * 单条或批量删除
     * 
     * @return string
     */
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
        
        return $this->jqueryResult('admin.page.edit_ok');    
    }
    
    public function setStatus($status){
        $this->_status = $status;
        return $this;
    }
    public function getStatus(){
        return $this->_status;
    }
    
    public function setRandSignId($v){
        $this->_rand_sign_id = $v;
        return $this;
    }
    public function getRandSignId(){
        return $this->_rand_sign_id;
    }
    
    public function setPageTemplate($v){
        $this->_page_template = $v;
        return $this;
    }
    public function getPageTemplate(){
        return $this->_page_template;
    }
    
}
/**vim:sw=4 et ts=4 **/
?>