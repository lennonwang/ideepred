<?php
/**
 * 商品上货申请及记录
 *
 * @author purpen
 * @version $Id$
 */
class Admin_Action_Purchase extends Admin_Action_Entry {
    protected $_model_class='Common_Model_Purchase';
    
    private $_product_id = null;
    
    private $_status = 1;
    
    public function setProductId($val){
    	$this->_product_id = $val;
    	return $this;
    }
    public function getProductId(){
    	return $this->_product_id;
    }
    
    public function setStatus($val){
    	$this->_status = $val;
    	return $this;
    }
    public function getStatus(){
    	return $this->_status;
    }
    /**
     * 
     * @return Common_Model_Purchase
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
     * 商品补货列表
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
        $status = $this->getStatus();
        
        $vars = array();
         echo "status::::$status";
        if(!is_null($status)){
            $condition = 'status=?';
            $vars = array($status);
        }else{
            $condition = null;
        }
        
        //get total page
        $records = $model->countIf($condition,$vars);
        $total = ceil($records/$size);
        $page = min($total, $page);
        
        $options = array(
           'condition'=>$condition,
           'vars'=>$vars,
           'order'=>'created_on ASC',
           'page'=>$page,
           'size'=>$size
        );
        
        $purchase_list = $model->find($options)->getResultArray();
        
        if(!empty($purchase_list)){
        	$product_model = new Common_Model_Product();
        	for($i=0;$i<count($purchase_list);$i++){
        		$options = array(
        		    'select'=>'title,id,thumb',
        		    'condition'=>'id=?',
        		    'vars'=>array($purchase_list[$i]['product_id'])
        		);
        		$purchase_list[$i]['product'] = $product_model->findFirst($options)->getResultArray();
        	}
        }
        
        $this->putContext('purchase_list', $purchase_list);
        
        $this->putContext('records', $records);
        $this->putContext('total',$total);
        $this->putContext('page', $page);
        $this->putContext('status',$status);
        
        $start = ($page - 1)*$size + 1;
        $end = min($page*$size, $records);
        $this->putContext('start', $start);
        $this->putContext('end',$end);
        
        //计算总数
        $all_records = $model->countIf();
        $published_records = $model->countIf('status=?',array(2));
        $unpublished_records = $model->countIf('status=?',array(1));
        $deny_records = $model->countIf('status=?',array(-1));
        
        $this->putContext('all_records',$all_records);
        $this->putContext('published_records',$published_records);
        $this->putContext('unpublished_records',$unpublished_records);
        $this->putContext('deny_records',$deny_records);
        
        
        $page_list = Common_Util_Pager::XE_NewPager(array('page'=>$page,'total'=>$total));
        $this->putContext('page_list', $page_list);
        
        return $this->smartyResult('admin.purchase.list');
    }
    /**
     * 更新产品数量
     * 
     * @return string
     */
    public function updateQuantity($product_id=null){
		if(!$this->isLogged()){
            return $this->_redirectLogin();
        }
    	if(is_null($product_id)){
    		$product_id = $this->getProductId();
    	}
    	
    	$product = new Common_Model_Product();
    	$options = array(
    	   'select'=>'title,id',
    	   'condition'=>'id=?',
    	   'vars'=>array($product_id)
    	);
    	$product_row = $product->findFirst($options)->getResultArray();
    	
    	$this->putContext('product', $product_row);
    	unset($product);
        
    	return $this->smartyResult('admin.purchase.edit');
    }
    /**
     * 新增商品数量
     * 
     * @return string
     */
    public function edit(){
		if(!$this->isLogged()){
            return $this->_redirectLogin();
        }
    	$model = $this->wiredModel();
        
        $id = $this->getId();
        if(empty($id)){
            return $this->_hintResult('缺少参数，请仔细核查操作步骤！');
        }
        $purchase = $model->findById($id)->getResultArray();
        
        $product_id = $purchase['product_id'];
        $this->putContext('purchase', $purchase);
        
        return $this->updateQuantity($product_id);
    }
    /**
     * 保存记录
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
            
        }catch(Common_Model_Exception $e){
            $msg = "validate failed:".$e->getMessage();
            self::warn($msg, __METHOD__);
            return $this->_jqErrorTip($msg);
        }catch(Anole_ActiveRecord_Exception $e){
            $msg = "save advertise failed:".$e->getMessage();
            self::warn($msg, __METHOD__);
            return $this->_jqErrorTip($msg);
        }
        
        $this->putContext('purchase_id', $_id);
        $this->putContext('edit_mode', $edit_mode);
        
        return $this->jqueryResult('admin.purchase.edit_ok');
    }
    /**
     * 审核
     * 
     * @return string
     */
    public function check(){
		if(!$this->isLogged()){
            return $this->_redirectLogin();
        }
        $id = $this->getId();
        if(empty($id)){
            //error page
            return $this->_hintResult('删除的Id为空!');
        }
        try{
            if(!is_array($id)){
                $id = array($id);
            }
            $model = $this->wiredModel();
            for($i=0;$i<count($id);$i++){
            	$cid = $id[$i];
            	$model->setIsNew(false);
            	$model->setId($cid);
            	$model->save();
            }
        }catch(Anole_ActiveRecord_Exception $e){
            self::warn("check ad db failed: ".$e->getMessage(), __METHOD__);
            return $this->_jqErrorTip($e->getMessage());
        }catch(Common_Model_Exception $e){
            self::warn("check excute failed: ".$e->getMessage(), __METHOD__);
            return $this->_jqErrorTip($e->getMessage());
        }
        $this->putContext('ids', $id);
        $this->putContext('edit_mode','check');
        
        return $this->jqueryResult('admin.purchase.edit_ok');
    }
    
    /**
     * 删除
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
            return $this->_hintResult('删除的Id为空!');
        }
        try{
            if(!is_array($id)){
                $id = array($id);
            }
            $model = $this->wiredModel();
            $model->destroy($id);
        }catch(Anole_ActiveRecord_Exception $e){
            self::warn("Destory ad db failed: ".$e->getMessage(), __METHOD__);
            return $this->_jqErrorTip($e->getMessage());
        }catch(Common_Model_Exception $e){
            self::warn("Destory excute failed: ".$e->getMessage(), __METHOD__);
            return $this->_jqErrorTip($e->getMessage());
        }
        $this->putContext('ids', $id);
        $this->putContext('edit_mode','delete');
        
        return $this->jqueryResult('admin.purchase.edit_ok');
    }
    
}
/**vim:sw=4 et ts=4 **/
?>