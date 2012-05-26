<?php
/**
 * 订单辅助参数
 *
 * @version $Id$
 * @author purpen
 */
class Eshop_Action_OrderParams extends Eshop_Action_Common {
    protected $_model_class='Common_Model_Orders';
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
        
    }
    //address
    private $_name = null;
    private $_email = null;
    private $_province = null;
    private $_city = null;
    private $_area = null;
    private $_address = null;
    private $_zip = null;
    private $_mobie = null;
    private $_telephone = null;
    
    //invoice
    private $_is_invoice = false;
    private $_invoice_title = null;
    private $_invoice_type = null;
    private $_invoice_caty = null;
    private $_invoice_content = null;
    
    //notice
    private $_summary = null;
    
    //payment
    private $_payment_method = null;
    //transfer
    private $_transfer = null;
    private $_transfer_time = null;
    
    
    private $_data = array();
    
    protected $_default_data = array(
        'payment_method'=>'a',
        'transfer'=>'a',
        'transfer_time'=>'a',
        'summary'=>'',
        'invoice_type'=>1,
        'invoice_caty'=>'p',
        'invoice_content'=>'d'
    );
    
    public function set($name,$value){
        $this->_data[$name] = $value;
        return $this;
    }
    public function get($name){
        return isset($this->_data[$name]) ? $this->_data[$name] : null;
    }
    
    public function getAllData(){
        return $this->_data;
    }
    /**
     * 获取默认值
     * 
     * @return string
     */
    public function getDefaultData(){
        return @serialize($this->_default_data);
    }
    //收货人的姓名
    public function setName($name){
        return $this->set('name', $name);
    }
    public function getName(){
        return $this->get('name');
    }
    //收货人的email
    public function setEmail($email){
        return $this->set('email', $email);
    }
    public function getEmail(){
        return $this->get('email');
    }
    //收货人所在的省份
    public function setProvince($province){
        return $this->set('province', $province);
    }
    public function getProvince(){
        return $this->get('province');
    }
    //收货人所在的城市
    public function setCity($city){
        return $this->set('city', $city);
    }
    public function getCity(){
        return $this->get('city');
    }
    //收货人所在的城市区域
    public function setArea($area){
        return $this->set('area', $area);
    }
    public function getArea(){
        return $this->get('area');
    }
    //收货人的具体地址
    public function setAddress($address){
        return $this->set('address', $address);
    }
    public function getAddress(){
        return $this->get('address');
    }
    //收货人的邮编
    public function setZip($zip){
        return $this->set('zip', $zip);
    }
    public function getZip(){
        return $this->get('zip');
    }
    //收货人的手机
    public function setMobie($mobie){
        return $this->set('mobie', $mobie);
    }
    public function getMobie(){
        return $this->get('mobie');
    }
    //收货人的座机电话
    public function setTelephone($telephone){
        return $this->set('telephone', $telephone);
    }
    public function getTelephone(){
        return $this->get('telephone');
    }
    
    //是否需要发票
    public function setIsInvoice($invoice){
        return $this->set('is_invoice', $invoice);
    }
    public function getIsInvoice(){
        return $this->get('is_invoice');
    }
    //发票抬头
    public function setInvoiceTitle($title){
        return $this->set('invoice_title', $title);
    }
    public function getInvoiceTitle(){
        return $this->get('invoice_title');
    }
    
    public function setInvoiceContent($title){
        return $this->set('invoice_content', $title);
    }
    public function getInvoiceContent(){
        return $this->get('invoice_content');
    }
    
    public function setInvoiceType($type){
        return $this->set('invoice_type', $type);
    }
    public function getInvoiceType(){
        return $this->get('invoice_type');
    }
    public function setInvoiceCaty($caty){
        return $this->set('invoice_caty', $caty);
    }
    public function getInvoiceCaty(){
        return $this->get('invoice_caty');
    }
    
    //订单备注
    public function setSummary($summary){
        return $this->set('summary', $summary);
    }
    public function getSummary(){
        return $this->get('summary');
    }
    
    //支付方式
    public function setPaymentMethod($payment){
        return $this->set('payment_method', $payment);
    }
    public function getPaymentMethod(){
        return $this->get('payment_method');
    }
    
    //送货方式
    public function setTransfer($transfer){
        return $this->set('transfer', $transfer);
    }
    public function getTransfer(){
        return $this->get('transfer');
    }
    //送货时间
    public function setTransferTime($time){
        return $this->set('transfer_time', $time);
    }
    public function getTransferTime(){
        return $this->get('transfer_time');
    }
    
}
/**vim:sw=4 et ts=4 **/
?>