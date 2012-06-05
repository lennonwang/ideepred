<?php
/**
 * Table:keydict mapping class 
 * 
 * This class is auto generated by gen-model task
 */
abstract class Common_Model_Table_Keydict extends Anole_ActiveRecord_Base {
    
    /**
     * mapping table name
     * 
     * @var string
     */
    protected $_table_name='keydict';
    
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
  'parent_id' => 
  array (
    'name' => 'parent_id',
    'type' => 'N',
    'length' => '11',
  ),
  'cnname' => 
  array (
    'name' => 'cnname',
    'type' => 'S',
    'length' => '100',
  ),
  'enname' => 
  array (
    'name' => 'enname',
    'type' => 'S',
    'length' => '100',
  ),
  'likename' => 
  array (
    'name' => 'likename',
    'type' => 'S',
    'length' => -1,
  ),
  'left_ref' => 
  array (
    'name' => 'left_ref',
    'type' => 'N',
    'length' => '11',
  ),
  'right_ref' => 
  array (
    'name' => 'right_ref',
    'type' => 'N',
    'length' => '11',
  ),
  'state' => 
  array (
    'name' => 'state',
    'type' => 'S',
    'length' => '1',
  ),
  'updated_on' => 
  array (
    'name' => 'updated_on',
    'type' => 'S',
    'length' => -1,
  ),
);
    
        /**
     * 设置属性'id'的值
     *
     * @param  integer $value
     * 
     * @return Keydict
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
     * @return Keydict
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
     * 设置属性'cnname'的值
     *
     * @param  string $value
     * 
     * @return Keydict
     */
    public function setCnname($value){
        $this->set('cnname',$value);
        return $this;
    }
    /**
     * 获取属性:'cnname'的值
     * 
     * @return string
     */
    public function getCnname(){
        return $this->get('cnname');
    }
        /**
     * 设置属性'enname'的值
     *
     * @param  string $value
     * 
     * @return Keydict
     */
    public function setEnname($value){
        $this->set('enname',$value);
        return $this;
    }
    /**
     * 获取属性:'enname'的值
     * 
     * @return string
     */
    public function getEnname(){
        return $this->get('enname');
    }
        /**
     * 设置属性'likename'的值
     *
     * @param  string $value
     * 
     * @return Keydict
     */
    public function setLikename($value){
        $this->set('likename',$value);
        return $this;
    }
    /**
     * 获取属性:'likename'的值
     * 
     * @return string
     */
    public function getLikename(){
        return $this->get('likename');
    }
        /**
     * 设置属性'left_ref'的值
     *
     * @param  integer $value
     * 
     * @return Keydict
     */
    public function setLeftRef($value){
        $this->set('left_ref',$value);
        return $this;
    }
    /**
     * 获取属性:'left_ref'的值
     * 
     * @return integer
     */
    public function getLeftRef(){
        return $this->get('left_ref');
    }
        /**
     * 设置属性'right_ref'的值
     *
     * @param  integer $value
     * 
     * @return Keydict
     */
    public function setRightRef($value){
        $this->set('right_ref',$value);
        return $this;
    }
    /**
     * 获取属性:'right_ref'的值
     * 
     * @return integer
     */
    public function getRightRef(){
        return $this->get('right_ref');
    }
        /**
     * 设置属性'state'的值
     *
     * @param  string $value
     * 
     * @return Keydict
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
        /**
     * 设置属性'updated_on'的值
     *
     * @param  string $value
     * 
     * @return Keydict
     */
    public function setUpdatedOn($value){
        $this->set('updated_on',$value);
        return $this;
    }
    /**
     * 获取属性:'updated_on'的值
     * 
     * @return string
     */
    public function getUpdatedOn(){
        return $this->get('updated_on');
    }
    }
/**vim:sw=4 et ts=4 **/
?>