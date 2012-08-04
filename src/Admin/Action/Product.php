<?php
/**
 * 商品管理
 *
 * @version $Id$
 * @author purpen
 */
class Admin_Action_Product extends Admin_Action_Entry {
    protected $_model_class='Common_Model_Product';
    
    private $_state = null;
    
    private $_rand_sign_id = null;
    
    private $_stick = null;
    
    private $_query = null;
    
    private $_catcode = null;
    
    private $_markshop = null;
    
    private $_store_id = null;
    
    /**
     * 
     * @return Common_Model_Product
     */
    public function wiredModel(){
        return parent::wiredModel();
    }
    //~~~~~~~~~~~~~~Action implements~~~~~~~~~~
    /**
     * default action method
     */
    public function execute(){
        return $this->fetchList();
    }
    
    /**
     * 管理产品列表
     * 
     * @return string
     */
    public function fetchList(){
		if(!$this->isLogged()){
            return $this->_redirectLogin();
        }
        $model = $this->wiredModel(); 
        $page = $this->getPage();
        $size = $this->_size;
        $query = $this->getQuery();
        $catcode = $this->getCatcode();
        $store_id = $this->getStoreId();
        
        $state = $this->getState();
        
        $conditions = array();
        $vars = array();
        
        if(!is_null($state)){
        	$conditions[] = 'state=?';
        	$vars[] = $state;
        }
        if(!empty($query)){
			//从标题/标签中搜索
        	$conditions[] = '(title LIKE ?) OR (tags LIKE ?)';
        	$vars[] = "%$query%";
			$vars[] = "%$query%";
        }
        if(!empty($catcode)){
        	$conditions[] = 'LEFT(`catcode`,'.strlen($catcode).')=?';
        	$vars[] = $catcode;
        }
        if(!empty($store_id)){
            $conditions[] = 'category_id=?';
            $vars[] = $store_id;
        }
        if(!empty($conditions)){
        	$condition = implode(' AND ', $conditions);
        }else{
        	$condition = null;
        }
        $records = $model->countIf($condition,$vars);
        $total   = ceil($records/$size);
        $page    = min($total,$page);
        
        $options = array(
            'condition'=>$condition,
            'vars'=>$vars,
            'page'=>$page,
            'size'=>$size,
            'order'=>'created_on DESC'
        );
        $product_list = $model->find($options);
        
        $start = ($page - 1)*$size + 1;
        $end = min($page*$size, $records);
        
        $page_list = Common_Util_Pager::XE_NewPager(array('page'=>$page,'total'=>$total));
        $this->putContext('page_list', $page_list);
        $this->putContext('start', $start);
        $this->putContext('end',$end);
        $this->putContext('records', $records);
        $this->putContext('total', $total);
        $this->putContext('page', $page);
        
        $this->putContext('product_list', $product_list);
        
        
        //计算总数
        $all_records = $model->countIf();
        $published_records = $model->countIf('state=?',array(1));
        $unpublished_records = $model->countIf('state=?',array(0));
        
        $this->putContext('all_records',$all_records);
        $this->putContext('published_records',$published_records);
        $this->putContext('unpublished_records',$unpublished_records);
        
        //所有的分类
        $category = new Common_Model_Category();
        $all_category = $category->findAllCategory();
        $this->putContext('all_category',$all_category);
        unset($category);
        
        //所有品牌
        $store = new Common_Model_Store();
        $options = array(
            'order'=>'stick DESC'
        );
        $store_list = $store->find($options)->getResultArray();
        $this->putContext('store_list', $store_list);
        
        $this->putContext('query', $query);
        $this->putContext('catcode', $catcode);
        $this->putContext('store_id', $store_id);
        
        return $this->smartyResult('admin.product.list');
    }
    
    /**
     * 获取产品所属的分类
     * 
     * @param $product_id
     * @return array
     */
    public function findProductCategory($product_id){
        $belong_category = array();
        $category = new Common_Model_Category();
        //获取所属分类
        $sql = 'SELECT category_id FROM `product_category` WHERE product_id=?';
        self::debug("product[$product_id] 's categorys.", __METHOD__);
        $product_category = $category->findBySql($sql,array('vars'=>array($product_id)))->getResultArray();
        
        for($i=0;$i<count($product_category);$i++){
            $selected_category[] = $product_category[$i]['category_id'];
            self::debug('selected category '.$product_category[$i]['category_id'], __METHOD__);
        }
        
        if(!empty($selected_category)){
            $options = array(
                'select'=>'id,name',
                'condition'=>'id IN ('.implode(',', $selected_category).')'
            );
            $belong_category = $category->find($options)->getResultArray();
        }
        
        return $belong_category;
    }
    
    /**
     * 上传或编辑产品信息
     * 
     * @return string
     */
    public function edit(){
		if(!$this->isLogged()){
            return $this->_redirectLogin();
        }
        $model = $this->wiredModel();
        
        $product = array();
        $edit_mode = 'create';
        
        $category = new Common_Model_Category();
        $all_category = $category->findAllCategory();
        
        $id = $this->getId();
        if(!empty($id)){
        	$edit_mode = 'edit';
        	
            $product = $model->findById($id)->getResultArray();
            
            //获取附件列表
            $asset_list = $model->findRelationModel('assets',array('order'=>'parent_type ASC,id ASC'),$id);
            $this->putContext('asset_list', $asset_list);
            
            
            //获取产品的属性
            $features = new Common_Model_Features();
            $meta = new Common_Model_Meta();
            $options = array(
                'condition'=>'owner_id=? AND domain=?',
                'vars'=>array($id, Common_Model_Constant::PRODUCT_DOMAIN)
            );
            $meta_list = $meta->find($options)->getResultArray();
            
            if(!empty($meta_list)){
                for($i=0;$i<count($meta_list);$i++){
                    $tmp_id = $meta_list[$i]['tmp_id'];
                    $meta_list[$i]['feature'] = $features->findById($tmp_id)->getResultArray();
                }
            }
            
            unset($meta);
            unset($features);
            
            $this->putContext('meta_list', $meta_list);
        }
        
        $rand_sign = $this->_genRandsign();
        $this->putContext('rand_sign',$rand_sign);
        $this->putContext('edit_mode', $edit_mode);
        
        //所有的分类
        $this->putContext('all_category',$all_category);
        $this->putContext('product', $product);
        unset($category);
        
        //获取所有品牌店铺
        $store = new Common_Model_Store();
        $options2 = array(
            'condition'=>'state=?',
            'vars'=>array(1)
        );
        $all_store = $store->find($options2)->getResultArray();
        $this->putContext('all_store', $all_store);
        unset($store);  
        $this->putContext('wine_country_array',Common_Util_ProductProUtil::getWineGrapeCountryArray());
				$this->putContext('wine_area_array',Common_Util_ProductProUtil::getWineGrapeAreaArray()); 
				$this->putContext('wine_level_array',Common_Util_ProductProUtil::getWineLevelArray());
				
        $this->putContext('grape_breed_array',Common_Util_ProductProUtil::getWineGrapeBreedArray()); 
				
        $this->putContext('wine_year_array',Common_Util_ProductProUtil::getWineYearArray());
        $this->putContext('wine_sugar_array',Common_Util_ProductProUtil::getWineSugarArray());
        $this->putContext('wine_occasion_array',Common_Util_ProductProUtil::getWineOccasionArray());
        $this->putContext('wine_craft_array',Common_Util_ProductProUtil::getWineCraftArray());
        
        $grape_breed_sel_array = preg_split('/,/',$product['grape_breed']); 
        $this->putContext('grape_breed_sel_array',$grape_breed_sel_array);
        return $this->smartyResult('admin.product.edit');
    }
    
    /**
     * 保存产品的信息
     * 
     * @return string
     */
    public function save(){
		if(!$this->isLogged()){
            return $this->_redirectLogin();
        }
        $model = $this->wiredModel();
        self::debug("save model content!!!!!!!!!!!!!!!!!!!:".$model->getContent());
        $id = $this->getId();
        
        try{
	        if(empty($id) || $id < 0){
	            $model->setIsNew(true);
	            $edit_mode = 'create';
	            $model->setId(null);
	        }else{
	            $model->setIsNew(false);
	            $model->setId($id);
	            $edit_mode = 'edit';
	        }
	        // add by wangjia
            $grape_breed = $_POST["grape_breed"];   
            self::debug("grape_breed11111:".$grape_breed);
			if(isset($grape_breed)){
				$grape_breed=implode(",", $grape_breed);
			}
			if(!empty($grape_breed)){
				 $grape_breed =  ",".$grape_breed.",";
			}
			self::debug("grape_breed22222:".$grape_breed);
	        $model->setGrapeBreed($grape_breed);
	        
	        
            $model->save();
            $id = $model->getId();
	        
	        //产品添加成功后，更新附件类别
	        $rand_sign_id = $this->getRandSignId();
	        if(!empty($rand_sign_id)){
	            $sql = 'UPDATE `asset` SET parent_id=? WHERE parent_id=? AND (parent_type=? OR parent_type=?)';
	            $model->getDba()->execute($sql,array($id,$rand_sign_id,Common_Model_Constant::PRODUCT_WHOLE,Common_Model_Constant::PRODUCT_THUMB));
	            self::debug("UPDATE asset belongs is ok!!", __METHOD__);
	        }
	        
	        //产品添加成功后，更新产品属性
	        if(!empty($rand_sign_id)){
	            $sql = 'UPDATE `meta` SET owner_id=? WHERE owner_id=? AND domain=?';
	            $model->getDba()->execute($sql,array($id,$rand_sign_id,Common_Model_Constant::PRODUCT_DOMAIN));
	            self::debug("Update meta is ok!!");
	        }
        }catch(Common_Model_Exception $e){
            $msg = 'Product Erorr: '.$e->getMessage();
            self::warn("Product Erorr: msg[$msg]...", __CLASS__);
            return $this->_jqErrorTip($msg);
        }catch(Anole_ActiveRecord_Exception $e){
        	$msg = 'Database Product Erorr: '.$e->getMessage();
        	return $this->_jqErrorTip($msg);
        }
        $this->putContext('product_id',$id);
        $this->putContext('edit_mode', $edit_mode);
        
        return $this->jqueryResult('admin.product.edit_ok');
    }
    /**
     * 发布某个产品或批量产品
     * 
     * @return string
     */
    public function published(){
		if(!$this->isLogged()){
            return $this->_redirectLogin();
        }
    	$model = $this->wiredModel();
        
        $id = $this->getId();
        $id = preg_split('/,/',$id);
        if(!is_array($id)){
            $id = array($id);
        }
        try{
        	$stick = $this->getStick();
        	self::debug("publish product stick[$stick]...", __METHOD__);
            foreach($id as $pid){
                $model->setId($pid);
                $model->setIsNew(false);
                $model->setStick($stick);
                $model->save();
            }
        }catch(Anole_ActiveRecord_Exception $e){
            self::warn("Publish product Error: ".$e->getMessage(), __METHOD__);
            $this->_jqErrorTip("Publish product Error: ".$e->getMessage());
        }
        $this->putContext('ids', $id);
        $this->putContext('stick', $stick);
        $this->putContext('edit_mode', 'publish');
        
        return $this->jqueryResult('admin.product.edit_ok');
    }
    
    /**
     * 标注实体店铺商品
     * 
     * @return string
     */
    public function marked(){
        if(!$this->isLogged()){
            return $this->_redirectLogin();
        }
        $model = $this->wiredModel();
        
        $id = $this->getId();
        $id = preg_split('/,/',$id);
        if(!is_array($id)){
            $id = array($id);
        }
        try{
            $is_markshop = $this->getMarkshop();
            self::debug("publish product stick[$stick]...", __METHOD__);
            foreach($id as $pid){
                $model->setId($pid);
                $model->setIsNew(false);
                $model->setMarkshop($is_markshop);
                $model->save();
            }
        }catch(Anole_ActiveRecord_Exception $e){
            self::warn("Publish product Error: ".$e->getMessage(), __METHOD__);
            $this->_jqErrorTip("Publish product Error: ".$e->getMessage());
        }
        $this->putContext('ids', $id);
        $this->putContext('is_markshop', $is_markshop);
        $this->putContext('edit_mode', 'marked');
        
        return $this->jqueryResult('admin.product.edit_ok');
    }
    
    /**
     * 删除某个产品或批量某些产品
     * 
     * @return string
     */
    public function delete(){
		if(!$this->isLogged()){
            return $this->_redirectLogin();
        }
        $model = $this->wiredModel();
        
        $id = $this->getId();
        $id = preg_split('/,/',$id);
        if(!is_array($id)){
            $id = array($id);
        }
        try{
            foreach($id as $pid){
                $model->destroy($pid);
            }
        }catch(Anole_ActiveRecord_Exception $e){
            self::warn("Delete product Error: ".$e->getMessage(), __METHOD__);
            $this->_jqErrorTip("Delete product Error: ".$e->getMessage());
        }
        $this->putContext('ids', $id);
        $this->putContext('edit_mode', 'delete');
        
        return $this->jqueryResult('admin.product.edit_ok');
    }
    
    
    /**
     * 设置state
     * @return int
     */
    public function setState($v){
    	$this->_state = $v;
    	return $this;
    }
    /**
     * 获取state
     * @return int
     */
    public function getState(){
        return $this->_state;
    }
    
    public function setStick($v){
    	$this->_stick = $v;
    	return $this;
    }
    public function getStick(){
    	return $this->_stick;
    }
    
    public function setRandSignId($v){
    	$this->_rand_sign_id = $v;
    	return $this;
    }
    public function getRandSignId(){
    	return $this->_rand_sign_id;
    }
    
    public function setQuery($v){
    	$this->_query = $v;
    	return $this;
    }
    public function getQuery(){
    	return $this->_query;
    }
    
    public function setCatcode($v){
    	$this->_catcode = $v;
    	return $this;
    }
    public function getCatcode(){
    	return $this->_catcode;
    }
    
    public function setMarkshop($v){
        $this->_markshop = $v;
        return $this;
    }
    public function getMarkshop(){
        return $this->_markshop;
    }
    
    public function setStoreId($v){
        $this->_store_id = $v;
        return $this;
    }
    public function getStoreId(){
        return $this->_store_id;
    }
}
/**vim:sw=4 et ts=4 **/
?>