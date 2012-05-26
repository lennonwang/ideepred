<?php
/**
 * Table:link mapping class 
 * 
 * This class is auto generated by gen-model task
 */
abstract class Common_Model_Table_Link extends Anole_ActiveRecord_Base {
    
    /**
     * mapping table name
     * 
     * @var string
     */
    protected $_table_name='link';
    
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
    'length' => '25',
  ),
  'url' => 
  array (
    'name' => 'url',
    'type' => 'S',
    'length' => '100',
  ),
  'sort' => 
  array (
    'name' => 'sort',
    'type' => 'N',
    'length' => '4',
  ),
  'created_at' => 
  array (
    'name' => 'created_at',
    'type' => 'S',
    'length' => -1,
  ),
);
    
        /**
     * 设置属性'id'的值
     *
     * @param  integer $value
     * 
     * @return Link
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
     * @return Link
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
     * 设置属性'url'的值
     *
     * @param  string $value
     * 
     * @return Link
     */
    public function setUrl($value){
        $this->set('url',$value);
        return $this;
    }
    /**
     * 获取属性:'url'的值
     * 
     * @return string
     */
    public function getUrl(){
        return $this->get('url');
    }
        /**
     * 设置属性'sort'的值
     *
     * @param  integer $value
     * 
     * @return Link
     */
    public function setSort($value){
        $this->set('sort',$value);
        return $this;
    }
    /**
     * 获取属性:'sort'的值
     * 
     * @return integer
     */
    public function getSort(){
        return $this->get('sort');
    }
        /**
     * 设置属性'created_at'的值
     *
     * @param  string $value
     * 
     * @return Link
     */
    public function setCreatedAt($value){
        $this->set('created_at',$value);
        return $this;
    }
    /**
     * 获取属性:'created_at'的值
     * 
     * @return string
     */
    public function getCreatedAt(){
        return $this->get('created_at');
    }
    }
/**vim:sw=4 et ts=4 **/
?>