<?php
/**
 * Table:emailing mapping class 
 * 
 * This class is auto generated by gen-model task
 */
abstract class Common_Model_Table_Emailing extends Anole_ActiveRecord_Base {
    
    /**
     * mapping table name
     * 
     * @var string
     */
    protected $_table_name='emailing';
    
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
  'email' => 
  array (
    'name' => 'email',
    'type' => 'S',
    'length' => '100',
  ),
  'created_on' => 
  array (
    'name' => 'created_on',
    'type' => 'S',
    'length' => -1,
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
     * @return Emailing
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
     * 设置属性'email'的值
     *
     * @param  string $value
     * 
     * @return Emailing
     */
    public function setEmail($value){
        $this->set('email',$value);
        return $this;
    }
    /**
     * 获取属性:'email'的值
     * 
     * @return string
     */
    public function getEmail(){
        return $this->get('email');
    }
        /**
     * 设置属性'created_on'的值
     *
     * @param  string $value
     * 
     * @return Emailing
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
     * 设置属性'state'的值
     *
     * @param  string $value
     * 
     * @return Emailing
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