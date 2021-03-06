<?php
/**
 * Table:detail mapping class 
 * 
 * This class is auto generated by gen-model task
 */
abstract class Common_Model_Table_Detail extends Anole_ActiveRecord_Base {
    
    /**
     * mapping table name
     * 
     * @var string
     */
    protected $_table_name='detail';
    
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
    'length' => '11',
  ),
  'user_id' => 
  array (
    'name' => 'user_id',
    'type' => 'N',
    'length' => '11',
  ),
  'orders_id' => 
  array (
    'name' => 'orders_id',
    'type' => 'N',
    'length' => '11',
  ),
  'product_id' => 
  array (
    'name' => 'product_id',
    'type' => 'S',
    'length' => '11',
  ),
  'size' => 
  array (
    'name' => 'size',
    'type' => 'S',
    'length' => '10',
  ),
  'price' => 
  array (
    'name' => 'price',
    'type' => 'N',
    'length' => -1,
  ),
  'discount' => 
  array (
    'name' => 'discount',
    'type' => 'N',
    'length' => -1,
  ),
  'true_price' => 
  array (
    'name' => 'true_price',
    'type' => 'N',
    'length' => -1,
  ),
  'quantity' => 
  array (
    'name' => 'quantity',
    'type' => 'N',
    'length' => '4',
  ),
  'created_on' => 
  array (
    'name' => 'created_on',
    'type' => 'S',
    'length' => -1,
  ),
);
    
        /**
     * 设置属性'id'的值
     *
     * @param  integer $value
     * 
     * @return Detail
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
     * 设置属性'user_id'的值
     *
     * @param  integer $value
     * 
     * @return Detail
     */
    public function setUserId($value){
        $this->set('user_id',$value);
        return $this;
    }
    /**
     * 获取属性:'user_id'的值
     * 
     * @return integer
     */
    public function getUserId(){
        return $this->get('user_id');
    }
        /**
     * 设置属性'orders_id'的值
     *
     * @param  integer $value
     * 
     * @return Detail
     */
    public function setOrdersId($value){
        $this->set('orders_id',$value);
        return $this;
    }
    /**
     * 获取属性:'orders_id'的值
     * 
     * @return integer
     */
    public function getOrdersId(){
        return $this->get('orders_id');
    }
        /**
     * 设置属性'product_id'的值
     *
     * @param  string $value
     * 
     * @return Detail
     */
    public function setProductId($value){
        $this->set('product_id',$value);
        return $this;
    }
    /**
     * 获取属性:'product_id'的值
     * 
     * @return string
     */
    public function getProductId(){
        return $this->get('product_id');
    }
        /**
     * 设置属性'size'的值
     *
     * @param  string $value
     * 
     * @return Detail
     */
    public function setSize($value){
        $this->set('size',$value);
        return $this;
    }
    /**
     * 获取属性:'size'的值
     * 
     * @return string
     */
    public function getSize(){
        return $this->get('size');
    }
        /**
     * 设置属性'price'的值
     *
     * @param  integer $value
     * 
     * @return Detail
     */
    public function setPrice($value){
        $this->set('price',$value);
        return $this;
    }
    /**
     * 获取属性:'price'的值
     * 
     * @return integer
     */
    public function getPrice(){
        return $this->get('price');
    }
        /**
     * 设置属性'discount'的值
     *
     * @param  integer $value
     * 
     * @return Detail
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
     * 设置属性'true_price'的值
     *
     * @param  integer $value
     * 
     * @return Detail
     */
    public function setTruePrice($value){
        $this->set('true_price',$value);
        return $this;
    }
    /**
     * 获取属性:'true_price'的值
     * 
     * @return integer
     */
    public function getTruePrice(){
        return $this->get('true_price');
    }
        /**
     * 设置属性'quantity'的值
     *
     * @param  integer $value
     * 
     * @return Detail
     */
    public function setQuantity($value){
        $this->set('quantity',$value);
        return $this;
    }
    /**
     * 获取属性:'quantity'的值
     * 
     * @return integer
     */
    public function getQuantity(){
        return $this->get('quantity');
    }
        /**
     * 设置属性'created_on'的值
     *
     * @param  string $value
     * 
     * @return Detail
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
    }
/**vim:sw=4 et ts=4 **/
?>