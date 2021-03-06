<?php
/**
 * Table:role mapping class 
 * 
 * This class is auto generated by gen-model task
 */
abstract class Common_Model_Table_Role extends Anole_ActiveRecord_Base {
    
    /**
     * mapping table name
     * 
     * @var string
     */
    protected $_table_name='role';
    
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
  'name' => 
  array (
    'name' => 'name',
    'type' => 'S',
    'length' => '30',
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
     * @return Role
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
     * 设置属性'name'的值
     *
     * @param  string $value
     * 
     * @return Role
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
     * 设置属性'state'的值
     *
     * @param  string $value
     * 
     * @return Role
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