<?php
/**
 * 用户订单管理
 * 
 * @version $Id$
 * @author purpen
 */
class Admin_Action_Orders extends Admin_Action_Entry {
    protected $_model_class='Common_Model_Orders';
    
    private $_status = null;
    /**
     * 查询订单关键词
     * 
     * @var string
     */
    private $_query = null;
    
    private $_pid = null;
    
    /**
     * 购买产品的数量
     * 
     * @var string
     */
    private $_quantity = 1;
    
    private $_detail_id = null;
    
    private $_edit_step = null;
    
    private $_start_date = null;
    private $_end_date = null;
    
    private $_freight = null;
    
    /**
     * 
     * @return Common_Model_Orders
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
     * 订单列表
     * 
     * @return string
     */
    public function display(){
		if(!$this->isLogged()){
            return $this->_redirectLogin();
        }
    	$model = $this->wiredModel();
    	
    	$query = $this->getQuery();
    	$status = $this->getStatus();
    	$page = $this->getPage();
    	$size = $this->_size;
    	
    	$start_date = $this->getStartDate();
    	$end_date = $this->getEndDate();
        
    	$conditions = array();
    	$vars = array();
    	
    	if(!empty($status)){
    	    $conditions[] = 'status=?';
    	    // 已取消订单的状态
    	    if($status == -2){
    	        $vars[] = 0;
    	    }else{
    	        $vars[] = $status;
    	    }
    	}
        if(!empty($query)){
        	$conditions[] = '((name LIKE ?) OR (reference LIKE ?) OR (mobie LIKE ?))';
        	$vars[] = "%$query%";
			$vars[] = "%$query%";
			$vars[] = "%$query%";
        }
        if(!empty($start_date)){
            $conditions[] = 'created_on >= ?';
            $vars[] = $start_date;
        }
        if(!empty($end_date)){
            $conditions[] = 'created_on <= ?';
            $vars[] = $end_date;
        }
        
    	if(!empty($conditions)){
    	    $condition = implode(' AND ', $conditions);
    	}else{
    	    $condition = null;
    	}
        
        //get records
        $records = $model->countIf($condition,$vars);
        $total = ceil($records/$size);
        $page = min($total,$page);
        
        //get current page
        $options = array(
           'condition'=>$condition,
           'vars'=>$vars,
           'order'=>'updated_on DESC,created_on DESC',
           'page'=>$page,
           'size'=>$size
        );
        $model->find($options);
        
        $this->putContext('orders', $model);
        
        $start = max(($page - 1)*$size + 1, 0);
        $end = min($page*$size, $records);
        
        $page_list = Common_Util_Pager::XE_NewPager(array('page'=>$page,'total'=>$total));
        $this->putContext('page_list', $page_list);
        $this->putContext('start', $start);
        $this->putContext('end',$end);
        $this->putContext('records', $records);
        $this->putContext('total', $total);
        $this->putContext('page', $page);
        
        $this->putContext('status', $status);
        $this->putContext('query', $query);
        $this->putContext('start_date', $start_date);
        $this->putContext('end_date', $end_date);
        
        //计算各个状态的订单
        $all_records = $model->countIf();
        $wait_records = $model->countIf('status=?',array(Common_Model_Constant::ORDER_WAIT_PAYMENT));
        $ready_records = $model->countIf('status=?',array(Common_Model_Constant::ORDER_READY_GOODS));
        $send_records  = $model->countIf('status=?',array(Common_Model_Constant::ORDER_SENDED_GOODS));
        $published_records = $model->countIf('status=?',array(Common_Model_Constant::ORDER_PUBLISHED));
        $canceled_records = $model->countIf('status=?',array(Common_Model_Constant::ORDER_CANCELED));
        $expired_records = $model->countIf('status=?',array(Common_Model_Constant::ORDER_EXPIRED));
        
        $this->putContext('all_records', $all_records);
        $this->putContext('wait_records', $wait_records);
        $this->putContext('ready_records', $ready_records);
        $this->putContext('send_records', $send_records);
        $this->putContext('published_records', $published_records);
        $this->putContext('canceled_records',$canceled_records);
        $this->putContext('expired_records',$expired_records);
        
        return $this->smartyResult('admin.orders.list');
    }
    
    
    /**
     * 更新订单的状态
     * 
     * @return string
     */
    public function updateStatus(){
        $id = $this->getId();
        $status = $this->getStatus();
        $edit_step = $this->getEditStep();
        if(empty($id) || is_null($status)){
            return $this->_jqErrorTip("更新订单条件不足.",'#changelist');
        }
        $model = $this->wiredModel();
        try{
            $model->setId($id);
            $model->setIsNew(false);
            $model->setStatus($status);
            $model->save();
        }catch(Anole_Exception $e){
            return $this->_jqErrorTip($e->getMessage(),'#changelist');
        }
        
        $this->putContext('id', $id);
        $this->putContext('edit_step', $edit_step);
        
        return $this->jqueryResult('admin.orders.status_result');
    }
    
    /**
     * 修改订单快递费用
     * 
     * @return string
     */
    public function modifyFreight(){
        $id = $this->getId();
        $freight = $this->getFreight();
        if(empty($id) || is_null($freight)){
            return $this->_jqErrorTip("更新订单快递费用条件不足.",'#changelist');
        }
        $model = $this->wiredModel();
        try{
            $order_info = $model->findById($id);
            if(empty($order_info)){
                return $this->_jqErrorTip("该订单不存在或被删除",'#changelist');
            }
            //只有等待付款的订单才允许修改快递费用
            if($order_info['status'] != Common_Model_Constant::ORDER_WAIT_PAYMENT){
                return $this->_jqErrorTip("仅等待付款的订单允许修改快递费用",'#changelist');
            }
            
            $pay_money = $order_info['total_money'] + $freight - $order_info['card_money'];
            //更新费用
            $model->setId($id);
            $model->setIsNew(false);
            $model->setPayMoney($pay_money);
            $model->setFreight($freight);
            $model->save();
            
        }catch(Anole_Exception $e){
            return $this->_jqErrorTip($e->getMessage(),'#changelist');
        }
        
        $this->putContext('id', $id);
        $this->putContext('pay_money', $pay_money);
        $this->putContext('freight', $freight);
        
        return $this->jqueryResult('admin.orders.modify_freight_result');
    }
    
    /**
     * 查看订单详细信息
     * 
     * @return string
     */
    public function view(){
		if(!$this->isLogged()){
            return $this->_redirectLogin();
        }
        $model = $this->wiredModel();
        $id = $this->getId();
        
        if(empty($id)){
            //error page    
        }
        $order = $model->findById($id)->getResultArray();
        
        $model_product = new Common_Model_Product();
		$strSQL = 'select A.*,B.id,B.title,B.sale_price,B.catcode,B.category_id,B.thumb,B.unit from `detail` AS A INNER JOIN `product` AS B on A.product_id=B.id ';
        //已审核的产品
        $condition = 'B.state=? AND A.orders_id=?';
        $vars =  array(Common_Model_Product::CHECK_STATE, $id);
		
		if(!empty($condition)){
			$strSQL .= ' WHERE '.$condition;
		}
		$options = array(
			'vars'=>$vars
		);
		$product_list = $model_product->findBySql($strSQL,$options);
		
		$this->putContext('plist', $product_list);
        $this->putContext('order', $order);
        
        //计算各个状态的订单
        $all_records = $model->countIf();
        $wait_records = $model->countIf('status=?',array(Common_Model_Constant::ORDER_WAIT_PAYMENT));
        $ready_records = $model->countIf('status=?',array(Common_Model_Constant::ORDER_READY_GOODS));
        $send_records  = $model->countIf('status=?',array(Common_Model_Constant::ORDER_SENDED_GOODS));
        $published_records = $model->countIf('status=?',array(Common_Model_Constant::ORDER_PUBLISHED));
        $canceled_records = $model->countIf('status=?',array(Common_Model_Constant::ORDER_CANCELED));
        $expired_records = $model->countIf('status=?',array(Common_Model_Constant::ORDER_EXPIRED));
        
        $this->putContext('all_records', $all_records);
        $this->putContext('wait_records', $wait_records);
        $this->putContext('ready_records', $ready_records);
        $this->putContext('send_records', $send_records);
        $this->putContext('published_records', $published_records);
        $this->putContext('canceled_records',$canceled_records);
        $this->putContext('expired_records',$expired_records);
        
        //获取送货方式
        $transfer_methods = $model->findTransferMethods();
        $this->putContext('transfer_methods', $transfer_methods);
        //获取付款方式列表
        $payment_methods = $model->findPaymentMethods();
        $this->putContext('payment_methods', $payment_methods);
        //获取送货时间列表
        $transfer_times = $model->findTransferTime();
        $this->putContext('transfer_times', $transfer_times);
         
        return $this->smartyResult('admin.orders.detail');
    }
    
    
    public function setStatus($s){
        $this->_status = $s;
        return $this;
    }
    public function getStatus(){
        return $this->_status;
    }
    
    public function setQuery($w){
        $this->_query = trim($w);
        return $this;
    }
    public function getQuery(){
        return $this->_query;
    }
    
    public function setPid($pid){
        $this->_pid = $pid;
        return $this;
    }
    public function getPid(){
        return $this->_pid;
    }
    
    public function setQuantity($quantity){
        $this->_quantity = $quantity;
        return $this;
    }
    public function getQuantity(){
        return $this->_quantity;
    }
    
    public function setDetailId($id){
        $this->_detail_id = $id;
        return $this;
    }
    public function getDetailId(){
        return $this->_detail_id;
    }
    
    public function setEditStep($v){
        $this->_edit_step = $v;
        return $this;
    }
    public function getEditStep(){
        return $this->_edit_step;
    }
    
    public function setStartDate($v){
        $this->_start_date = trim($v);
        return $this;
    }
    public function getStartDate(){
        return $this->_start_date;
    }
    
    public function setEndDate($v){
        $this->_end_date = trim($v);
        return $this;
    }
    public function getEndDate(){
        return $this->_end_date;
    }
    
    public function setFreight($v){
        $this->_freight = $v;
        return $this;
    }
    public function getFreight(){
        return $this->_freight;
    }
}
/**vim:sw=4 et ts=4 **/
?>