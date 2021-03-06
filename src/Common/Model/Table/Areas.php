<?php
/**
 * Table:areas mapping class 
 * 
 * This class is auto generated by gen-model task
 */
abstract class Common_Model_Table_Areas extends Anole_ActiveRecord_Base {
    
    /**
     * mapping table name
     * 
     * @var string
     */
    protected $_table_name='areas';
    
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
  'parent_id' => 
  array (
    'name' => 'parent_id',
    'type' => 'N',
    'length' => '4',
  ),
  'name' => 
  array (
    'name' => 'name',
    'type' => 'S',
    'length' => '25',
  ),
  'type' => 
  array (
    'name' => 'type',
    'type' => 'S',
    'length' => '2',
  ),
  'state' => 
  array (
    'name' => 'state',
    'type' => 'S',
    'length' => '1',
  ),
);
    
        /**
     * 设置属性'id'的值
     *
     * @param  integer $value
     * 
     * @return Areas
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
     * 设置属性'parent_id'的值
     *
     * @param  integer $value
     * 
     * @return Areas
     */
    public function setParentId($value){
        $this->set('parent_id',$value);
        return $this;
    }
    /**
     * 获取属性:'parent_id'的值
     * 
     * @return integer
     */
    public function getParentId(){
        return $this->get('parent_id');
    }
        /**
     * 设置属性'name'的值
     *
     * @param  string $value
     * 
     * @return Areas
     */
    public function setName($value){
        $this->set('name',$value);
        return $this;
    }
    /**
     * 获取属性:'name'的值
     * 
     * @return string
     */
    public function getName(){
        return $this->get('name');
    }
        /**
     * 设置属性'type'的值
     *
     * @param  string $value
     * 
     * @return Areas
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
     * 设置属性'state'的值
     *
     * @param  string $value
     * 
     * @return Areas
     */
    public function setState($value){
        $this->set('state',$value);
        return $this;
    }
    /**
     * 获取属性:'state'的值
     * 
     * @return string
     */
    public function getState(){
        return $this->get('state');
    }
    }
/**vim:sw=4 et ts=4 **/
?>