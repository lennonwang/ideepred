<?php
/**
 * Table:goods mapping class 
 * 
 * This class is auto generated by gen-model task
 */
abstract class Common_Model_Table_Goods extends Anole_ActiveRecord_Base {
    
    /**
     * mapping table name
     * 
     * @var string
     */
    protected $_table_name='goods';
    
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
  'cart_id' => 
  array (
    'name' => 'cart_id',
    'type' => 'N',
    'length' => '11',
  ),
  'product_id' => 
  array (
    'name' => 'product_id',
    'type' => 'N',
    'length' => '11',
  ),
  'title' => 
  array (
    'name' => 'title',
    'type' => 'S',
    'length' => '100',
  ),
  'price' => 
  array (
    'name' => 'price',
    'type' => 'N',
    'length' => -1,
  ),
  'quantity' => 
  array (
    'name' => 'quantity',
    'type' => 'N',
    'length' => '4',
  ),
);
    
        /**
     * 设置属性'id'的值
     *
     * @param  integer $value
     * 
     * @return Goods
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
     * 设置属性'cart_id'的值
     *
     * @param  integer $value
     * 
     * @return Goods
     */
    public function setCartId($value){
        $this->set('cart_id',$value);
        return $this;
    }
    /**
     * 获取属性:'cart_id'的值
     * 
     * @return integer
     */
    public function getCartId(){
        return $this->get('cart_id');
    }
        /**
     * 设置属性'product_id'的值
     *
     * @param  integer $value
     * 
     * @return Goods
     */
    public function setProductId($value){
        $this->set('product_id',$value);
        return $this;
    }
    /**
     * 获取属性:'product_id'的值
     * 
     * @return integer
     */
    public function getProductId(){
        return $this->get('product_id');
    }
        /**
     * 设置属性'title'的值
     *
     * @param  string $value
     * 
     * @return Goods
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
     * 设置属性'price'的值
     *
     * @param  integer $value
     * 
     * @return Goods
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
     * 设置属性'quantity'的值
     *
     * @param  integer $value
     * 
     * @return Goods
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
    }
/**vim:sw=4 et ts=4 **/
?>