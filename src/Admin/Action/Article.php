<?php
/**
 * 购买资讯信息类
 * 
 * @author purpen
 * @version $Id$
 */
class Admin_Action_Article extends Admin_Action_Entry {
    protected $_model_class='Common_Model_Article';
    
    private $_name = null;
    
    private $_status = null;
    
    private $_type = 1;
    private $_content = null;
    
    private $_sort_ids = null;
    
    private $_asset_id = null;
    
    private $_rand_sign_id = null;
    
    private $_stick = null;
    /**
     * 
     * @return Common_Model_Article
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
     * 文章列表
     * 
     * @return string
     */
    public function display(){
    	$model = $this->wiredModel();
    	
    	$status = $this->getStatus();
    	$type = $this->getType();
    	$page = $this->getPage();
    	$size = $this->_size;
    	
    	$conditions = array();
    	$vars = array();
    	if(!is_null($status)){
    		$conditions[] = 'status=?';
    		$vars[] = $status;
    	}
    	if(!empty($type)){
    		$conditions[] = 'type=?';
    		$vars[] = $type;
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
    	
    	//get current data
    	$options = array(
    	   'condition'=>$condition,
    	   'vars'=>$vars,
    	   'order'=>'published_on DESC,id DESC',
    	   'page'=>$page,
    	   'size'=>$this->_size
    	);
    	$article_list = $model->find($options);
    	
    	$this->putContext('articles', $article_list);
    	$this->putContext('status', $status);
    	$this->putContext('type',$type);
    	
    	$this->putContext('records', $records);
    	$this->putContext('total', $total);
    	$this->putContext('page', $page);
    	
    	//获取每个状态的记录数
    	$all_records         = $model->countIf();
    	$published_records   = $model->countIf('status=?',array(1));
    	$unpublished_records = $model->countIf('status=?',array(0));
    	
    	$this->putContext('all_records', $all_records);
    	$this->putContext('published_records', $published_records);
    	$this->putContext('unpublished_records', $unpublished_records);
    	
    	$this->putMenu();
    	
        return $this->smartyResult('admin.article.list');
    }
    /**
     * 分隔文章内容,显示不同的分页
     *
     * @param string $content
     * 
     * @return null
     */
    protected function _splitContent($content=null){
        $ary_content = array();
        $ary_count = 1;
        //新建或内容为空
        if (is_null($content)){
            $ary_content['p_1'] = null;
        }else{
        	$content = stripslashes($content);
        	$pages_content = Common_Util_PageBuilder::splitArtilcePage($content);
            $ary_count = count($pages_content);
            for($i=0;$i<$ary_count;$i++){
            	$ary_content['p_'.($i+1)] = $pages_content[$i];
            }
        }
        $this->putContext('ary_content', json_encode($ary_content));
        $this->putContext('ary_count', $ary_count);
    }
    /**
     * 发表资讯
     * 
     * @return string
     */
    public function edit(){
        $model = $this->wiredModel();
        $edit_mode = 'create';
        $c = null;
        $id = $this->getId();
        if(!empty($id)){
        	$edit_mode = 'edit';
        	
        	$article = $model->findById($id)->getResultArray();
        	
        	$article['sort_ids'] = $model['sort_ids'];
        	
        	$c = $article['content'];
        	
        	//获取附件列表
            $asset_list = $model->findRelationModel('assets',array(),$id);
            $this->putContext('asset_list', $asset_list);
            
        }
        //文章分页显示
        $this->_splitContent($c);
        
        //获取栏目
        $sorts = new Common_Model_Sort();
        $options = array(
            'condition'=>'state=?',
            'vars'=>array(Common_Model_Sort::OPEN_STATE)
        );
        $sorts->find($options);
        
        $this->putContext('sorts', $sorts);
        $this->putContext('article', $article);
        
        $rand_sign = $this->_genRandsign();
        $this->putContext('rand_sign',$rand_sign);
        $this->putContext('edit_mode', $edit_mode);
        
        $this->putMenu();

        return $this->smartyResult('admin.article.edit');
    }
    
    /**
     * 保存购买资讯信息
     * 
     * @return string
     */
    public function save(){
    	$model = $this->wiredModel();
    	
    	$user_id = Anole_Util_Cookie::getUserID();
    	
    	$type = $this->getType();
    	if(empty($this->_id) || $this->_id < 0){
    		$model->setIsNew(True);
    		$model->setId(null);
    		$model->setCreatedBy($user_id);
    		$edit_mode = 'create';
    	}else{
    		$model->setIsNew(False);
    		$model->setId($this->_id);
    		$edit_mode = 'edit';
    	}
    	try{
    		//更新所属的栏目
    		$sort_ids = $this->getSortIds();
    		if(!empty($sort_ids)){
	    		foreach($sort_ids as $sort_id){
	                $model->addBelongSorts($sort_id);
	            }
    		}
    	    
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
    	
    	return $this->jqueryResult('admin.article.edit_ok');
    }
    /**
     * @todo 插入图片到文章中
     *
     * @return string
     */
    public function insertAsset(){
        $this->putContext('asset_ids', $this->getAssetId());
        return $this->smartyResult('admin.article.insert_asset');
    }
    
    /**
     * 单条或批量删除购买信息
     * 
     * @return string
     */
    public function remove(){
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
        
        return $this->jqueryResult('admin.article.edit_ok');    
    }
    
    /**
     * 推荐某条或多条购买信息
     * 
     * @return string
     */
    public function checking(){
        $model = $this->wiredModel();
        $id = $this->getId();
        if(empty($id)){
            //error page
            return $this->_hintResult('审核信息的Id为空!');
        }
        //split id string
        $_ids = preg_split('/,/',$id);
        $admin_id = Anole_Util_Cookie::getAdminID();
        try{
            $stick  = $this->getStick();
            foreach($_ids as $id){
                $model->setId($id);
                $model->setIsNew(false);
                if(!is_null($stick)){
                	$model->setStick($stick);
                }
                $model->setPublishedBy($admin_id);
                $model->setPublishedOn(Common_Util_Date::getNow());
                $model->save();
            }
        }catch(Anole_ActiveRecord_Exception $e){
            self::warn("Checking article failed:".$e->getMessage(), __METHOD__);
            return $this->_jqErrorTip($e->getMessage());
        }
        
        $this->putContext('ids', $_ids);
        $this->putContext('stick',$stick);
        $this->putContext('edit_mode', 'stick');
        
        return $this->jqueryResult('admin.article.edit_ok');
    }
    /**
     * 重建资讯静态页
     * 
     * @return string
     */
    public function rebuild(){
    	$model = $this->wiredModel();
    	$id = $this->getId();
        if(empty($id)){
            //error page
            return $this->_hintResult('重建资讯的Id为空!');
        }
        //split id string
        $_ids = preg_split('/,/',$id);
        try{
        	$status = $this->getStatus();
            foreach($_ids as $id){
                $model->setId($id);
                $model->setIsNew(false);
                $model->setStatus($status);
                $model->save();
            }
        }catch(Anole_ActiveRecord_Exception $e){
            self::warn("rebuild article failed:".$e->getMessage(), __METHOD__);
            return $this->_jqErrorTip($e->getMessage());
        }
        
        $this->putContext('ids', $_ids);
        
        return $this->jqueryResult('admin.article.rebuild_ok');
    }
    /**
     * 标示文章的缩略图
     * 
     * @return string
     */
    public function assignThumb(){
        $model = $this->wiredModel();
        if(empty($this->_id) || empty($this->_asset_id)){
            return $this->_jqErrorTip('文章ID或缩略图ID没有指定','#uploadify_result');
        }
        $model->setIsNew(false);
        $model->setId($this->_id);
        $model->setAssetId($this->_asset_id);
        try{
            $model->save();
        }catch(Common_Model_Exception $e){
            self::warn("validate failed:".$e->getMessage(), __METHOD__);
            return $this->_jqErrorTip('系统故障，请稍后再试','#uploadify_result');
        }
        
        return $this->jqueryResult('admin.article.assign_thumb');
    }
    
    /**
     * 创建专题
     * 
     * @return string
     */
    public function create(){
        $model = $this->wiredModel();
        $edit_mode = 'create';
        if(!empty($this->_id)){
            $edit_mode = 'edit';
            $model->findById($this->_id);
            
            //获取所有附件
            $assets = $model->fetchArticleAssets($this->_id);
            
            $this->putContext('assets', $assets);
            
        }
        //获取栏目
        $sorts = new Common_Model_Sort();
        $options = array(
            'condition'=>'state=?',
            'vars'=>array(Common_Model_Sort::OPEN_STATE)
        );
        $sorts->find($options);
        
        $this->putContext('sorts', $sorts);
        
        $this->putContext('article', $model);
        $this->putContext('edit_mode', $edit_mode);
        
        $this->putMenu();

        return $this->smartyResult('admin.article.edit_topic');
    }
    /**
     * 从编辑上传的topic模板中获取内容
     * 
     * @return string
     */
    public function reload(){
        $name = $this->getName();
        
        $topic_path = Common_Util_Storage::getTopicPath($name);
        $topic_file = $topic_path.'/'.'topic.html';
        if(!file_exists($topic_file)){
            $topic_content = '专题模板文件不存在';
        }else{
            $topic_content = Anole_Util_File::readFile($topic_file);
        }
        
        $this->putContext('topic_content', $topic_content);
        
        return $this->jqueryResult('admin.article.reload');
    }
    
    public function setName($name){
    	$this->_name = $name;
    	return $this;
    }
    public function getName(){
    	return $this->_name;
    }
    
    public function setStatus($status){
    	$this->_status = $status;
    	return $this;
    }
    public function getStatus(){
    	return $this->_status;
    }
    
    public function setType($type){
    	$this->_type = $type;
    	return $this;
    }
    public function getType(){
    	return $this->_type;
    }
    
    public function setContent($content){
    	$this->_content = $content;
    	return $this;
    }
    public function getContent(){
    	return $this->_content;
    }
    
    public function setSortIds($ids){
    	$this->_sort_ids = $ids;
    	return $this;
    }
    public function getSortIds(){
    	return $this->_sort_ids;
    }
    public function setAssetId($id){
    	$this->_asset_id = $id;
    	return $this;
    }
    public function getAssetId(){
    	return $this->_asset_id;
    }
    
    public function setRandSignId($v){
        $this->_rand_sign_id = $v;
        return $this;
    }
    public function getRandSignId(){
        return $this->_rand_sign_id;
    }
    
    public function setStick($v){
        $this->_stick = $v;
        return $this;
    }
    public function getStick(){
        return $this->_stick;
    }
}
/**vim:sw=4 et ts=4 **/
?>