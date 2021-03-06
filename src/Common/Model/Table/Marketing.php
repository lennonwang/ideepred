<?php
/**
 * Table:marketing mapping class 
 * 
 * This class is auto generated by gen-model task
 */
abstract class Common_Model_Table_Marketing extends Anole_ActiveRecord_Base {
    
    /**
     * mapping table name
     * 
     * @var string
     */
    protected $_table_name='marketing';
    
    /**
     * table fields meta list
     * 
     * @var array
     */
    protected $_attributes = array (
  'id' => 
  array (
    'name' => 'id',
    'type' => 'N',
    'length' => '4',
  ),
  'title' => 
  array (
    'name' => 'title',
    'type' => 'S',
    'length' => '100',
  ),
  'summary' => 
  array (
    'name' => 'summary',
    'type' => 'S',
    'length' => '245',
  ),
  'type' => 
  array (
    'name' => 'type',
    'type' => 'S',
    'length' => '1',
  ),
  'gift_sku' => 
  array (
    'name' => 'gift_sku',
    'type' => 'S',
    'length' => '245',
  ),
  'start_amount' => 
  array (
    'name' => 'start_amount',
    'type' => 'N',
    'length' => -1,
  ),
  'end_amount' => 
  array (
    'name' => 'end_amount',
    'type' => 'N',
    'length' => -1,
  ),
  'start_date' => 
  array (
    'name' => 'start_date',
    'type' => 'D',
    'length' => -1,
  ),
  'end_date' => 
  array (
    'name' => 'end_date',
    'type' => 'D',
    'length' => -1,
  ),
  'discount' => 
  array (
    'name' => 'discount',
    'type' => 'N',
    'length' => -1,
  ),
  'remoney' => 
  array (
    'name' => 'remoney',
    'type' => 'N',
    'length' => -1,
  ),
  'gift_price' => 
  array (
    'name' => 'gift_price',
    'type' => 'N',
    'length' => -1,
  ),
  'status' => 
  array (
    'name' => 'status',
    'type' => 'S',
    'length' => '1',
  ),
  'created_on' => 
  array (
    'name' => 'created_on',
    'type' => 'S',
    'length' => -1,
  ),
  'created_by' => 
  array (
    'name' => 'created_by',
    'type' => 'S',
    'length' => '11',
  ),
);
    
        /**
     * 设置属性'id'的值
     *
     * @param  integer $value
     * 
     * @return Marketing
     */
    public function setId($value){
        $this->set('id',$value);
        return $this;
    }
    /**
     * 获取属性:'id'的值
     * 
     * @return integer
     */
    public function getId(){
        return $this->get('id');
    }
        /**
     * 设置属性'title'的值
     *
     * @param  string $value
     * 
     * @return Marketing
     */
    public function setTitle($value){
        $this->set('title',$value);
        return $this;
    }
    /**
     * 获取属性:'title'的值
     * 
     * @return string
     */
    public function getTitle(){
        return $this->get('title');
    }
        /**
     * 设置属性'summary'的值
     *
     * @param  string $value
     * 
     * @return Marketing
     */
    public function setSummary($value){
        $this->set('summary',$value);
        return $this;
    }
    /**
     * 获取属性:'summary'的值
     * 
     * @return string
     */
    public function getSummary(){
        return $this->get('summary');
    }
        /**
     * 设置属性'type'的值
     *
     * @param  string $value
     * 
     * @return Marketing
     */
    public function setType($value){
        $this->set('type',$value);
        return $this;
    }
    /**
     * 获取属性:'type'的值
     * 
     * @return string
     */
    public function getType(){
        return $this->get('type');
    }
        /**
     * 设置属性'gift_sku'的值
     *
     * @param  string $value
     * 
     * @return Marketing
     */
    public function setGiftSku($value){
        $this->set('gift_sku',$value);
        return $this;
    }
    /**
     * 获取属性:'gift_sku'的值
     * 
     * @return string
     */
    public function getGiftSku(){
        return $this->get('gift_sku');
    }
        /**
     * 设置属性'start_amount'的值
     *
     * @param  integer $value
     * 
     * @return Marketing
     */
    public function setStartAmount($value){
        $this->set('start_amount',$value);
        return $this;
    }
    /**
     * 获取属性:'start_amount'的值
     * 
     * @return integer
     */
    public function getStartAmount(){
        return $this->get('start_amount');
    }
        /**
     * 设置属性'end_amount'的值
     *
     * @param  integer $value
     * 
     * @return Marketing
     */
    public function setEndAmount($value){
        $this->set('end_amount',$value);
        return $this;
    }
    /**
     * 获取属性:'end_amount'的值
     * 
     * @return integer
     */
    public function getEndAmount(){
        return $this->get('end_amount');
    }
        /**
     * 设置属性'start_date'的值
     *
     * @param  date $value
     * 
     * @return Marketing
     */
    public function setStartDate($value){
        $this->set('start_date',$value);
        return $this;
    }
    /**
     * 获取属性:'start_date'的值
     * 
     * @return date
     */
    public function getStartDate(){
        return $this->get('start_date');
    }
        /**
     * 设置属性'end_date'的值
     *
     * @param  date $value
     * 
     * @return Marketing
     */
    public function setEndDate($value){
        $this->set('end_date',$value);
        return $this;
    }
    /**
     * 获取属性:'end_date'的值
     * 
     * @return date
     */
    public function getEndDate(){
        return $this->get('end_date');
    }
        /**
     * 设置属性'discount'的值
     *
     * @param  integer $value
     * 
     * @return Marketing
     */
    public function setDiscount($value){
        $this->set('discount',$value);
        return $this;
    }
    /**
     * 获取属性:'discount'的值
     * 
     * @return integer
     */
    public function getDiscount(){
        return $this->get('discount');
    }
        /**
     * 设置属性'remoney'的值
     *
     * @param  integer $value
     * 
     * @return Marketing
     */
    public function setRemoney($value){
        $this->set('remoney',$value);
        return $this;
    }
    /**
     * 获取属性:'remoney'的值
     * 
     * @return integer
     */
    public function getRemoney(){
        return $this->get('remoney');
    }
        /**
     * 设置属性'gift_price'的值
     *
     * @param  integer $value
     * 
     * @return Marketing
     */
    public function setGiftPrice($value){
        $this->set('gift_price',$value);
        return $this;
    }
    /**
     * 获取属性:'gift_price'的值
     * 
     * @return integer
     */
    public function getGiftPrice(){
        return $this->get('gift_price');
    }
        /**
     * 设置属性'status'的值
     *
     * @param  string $value
     * 
     * @return Marketing
     */
    public function setStatus($value){
        $this->set('status',$value);
        return $this;
    }
    /**
     * 获取属性:'status'的值
     * 
     * @return string
     */
    public function getStatus(){
        return $this->get('status');
    }
        /**
     * 设置属性'created_on'的值
     *
     * @param  string $value
     * 
     * @return Marketing
     */
    public function setCreatedOn($value){
        $this->set('created_on',$value);
        return $this;
    }
    /**
     * 获取属性:'created_on'的值
     * 
     * @return string
     */
    public function getCreatedOn(){
        return $this->get('created_on');
    }
        /**
     * 设置属性'created_by'的值
     *
     * @param  string $value
     * 
     * @return Marketing
     */
    public function setCreatedBy($value){
        $this->set('created_by',$value);
        return $this;
    }
    /**
     * 获取属性:'created_by'的值
     * 
     * @return string
     */
    public function getCreatedBy(){
        return $this->get('created_by');
    }
    }
/**vim:sw=4 et ts=4 **/
?>