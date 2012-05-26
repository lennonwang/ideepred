<?php
/**
 * Table:favorite mapping class 
 * 
 * This class is auto generated by gen-model task
 */
abstract class Common_Model_Table_Favorite extends Anole_ActiveRecord_Base {
    
    /**
     * mapping table name
     * 
     * @var string
     */
    protected $_table_name='favorite';
    
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
  'product_id' => 
  array (
    'name' => 'product_id',
    'type' => 'N',
    'length' => '11',
  ),
  'tags' => 
  array (
    'name' => 'tags',
    'type' => 'S',
    'length' => '75',
  ),
  'notes' => 
  array (
    'name' => 'notes',
    'type' => 'S',
    'length' => '245',
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
     * @return Favorite
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
     * @return Favorite
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
     * 设置属性'product_id'的值
     *
     * @param  integer $value
     * 
     * @return Favorite
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
     * 设置属性'tags'的值
     *
     * @param  string $value
     * 
     * @return Favorite
     */
    public function setTags($value){
        $this->set('tags',$value);
        return $this;
    }
    /**
     * 获取属性:'tags'的值
     * 
     * @return string
     */
    public function getTags(){
        return $this->get('tags');
    }
        /**
     * 设置属性'notes'的值
     *
     * @param  string $value
     * 
     * @return Favorite
     */
    public function setNotes($value){
        $this->set('notes',$value);
        return $this;
    }
    /**
     * 获取属性:'notes'的值
     * 
     * @return string
     */
    public function getNotes(){
        return $this->get('notes');
    }
        /**
     * 设置属性'created_on'的值
     *
     * @param  string $value
     * 
     * @return Favorite
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