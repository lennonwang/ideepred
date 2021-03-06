<?php
/**
 * Table:point mapping class 
 * 
 * This class is auto generated by gen-model task
 */
abstract class Common_Model_Table_Point extends Anole_ActiveRecord_Base {
    
    /**
     * mapping table name
     * 
     * @var string
     */
    protected $_table_name='point';
    
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
  'type' => 
  array (
    'name' => 'type',
    'type' => 'S',
    'length' => '1',
  ),
  'value' => 
  array (
    'name' => 'value',
    'type' => 'N',
    'length' => -1,
  ),
  'balance' => 
  array (
    'name' => 'balance',
    'type' => 'N',
    'length' => -1,
  ),
  'description' => 
  array (
    'name' => 'description',
    'type' => 'S',
    'length' => '200',
  ),
  'created_on' => 
  array (
    'name' => 'created_on',
    'type' => 'T',
    'length' => -1,
  ),
);
    
        /**
     * 设置属性'id'的值
     *
     * @param  integer $value
     * 
     * @return Point
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
     * @return Point
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
     * 设置属性'type'的值
     *
     * @param  string $value
     * 
     * @return Point
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
     * 设置属性'value'的值
     *
     * @param  integer $value
     * 
     * @return Point
     */
    public function setValue($value){
        $this->set('value',$value);
        return $this;
    }
    /**
     * 获取属性:'value'的值
     * 
     * @return integer
     */
    public function getValue(){
        return $this->get('value');
    }
        /**
     * 设置属性'balance'的值
     *
     * @param  integer $value
     * 
     * @return Point
     */
    public function setBalance($value){
        $this->set('balance',$value);
        return $this;
    }
    /**
     * 获取属性:'balance'的值
     * 
     * @return integer
     */
    public function getBalance(){
        return $this->get('balance');
    }
        /**
     * 设置属性'description'的值
     *
     * @param  string $value
     * 
     * @return Point
     */
    public function setDescription($value){
        $this->set('description',$value);
        return $this;
    }
    /**
     * 获取属性:'description'的值
     * 
     * @return string
     */
    public function getDescription(){
        return $this->get('description');
    }
        /**
     * 设置属性'created_on'的值
     *
     * @param  date $value
     * 
     * @return Point
     */
    public function setCreatedOn($value){
        $this->set('created_on',$value);
        return $this;
    }
    /**
     * 获取属性:'created_on'的值
     * 
     * @return date
     */
    public function getCreatedOn(){
        return $this->get('created_on');
    }
    }
/**vim:sw=4 et ts=4 **/
?>