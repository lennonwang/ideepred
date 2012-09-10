<?php
/**
 * Table:asset mapping class 
 * 
 * This class is auto generated by gen-model task
 */
abstract class Common_Model_Table_Asset extends Anole_ActiveRecord_Base {
    
    /**
     * mapping table name
     * 
     * @var string
     */
    protected $_table_name='asset';
    
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
  'path' => 
  array (
    'name' => 'path',
    'type' => 'S',
    'length' => '200',
  ),
  'file_name' => 
  array (
    'name' => 'file_name',
    'type' => 'S',
    'length' => '200',
  ),
  'parent_id' => 
  array (
    'name' => 'parent_id',
    'type' => 'N',
    'length' => '11',
  ),
  'bytes' => 
  array (
    'name' => 'bytes',
    'type' => 'N',
    'length' => -1,
  ),
  'mime' => 
  array (
    'name' => 'mime',
    'type' => 'S',
    'length' => '100',
  ),
  'parent_type' => 
  array (
    'name' => 'parent_type',
    'type' => 'S',
    'length' => '1',
  ),
  'width' => 
  array (
    'name' => 'width',
    'type' => 'N',
    'length' => '11',
  ),
  'height' => 
  array (
    'name' => 'height',
    'type' => 'N',
    'length' => '11',
  ),
  'domain' => 
  array (
    'name' => 'domain',
    'type' => 'S',
    'length' => '20',
  ),
  'device_type' => 
  array (
    'name' => 'device_type',
    'type' => 'S',
    'length' => '1',
  ),
  'position' =>
  array (
  		'name' => 'position',
  		'type' => 'N',
  		'length' => '11',
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
     * @return Asset
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
     * 设置属性'path'的值
     *
     * @param  string $value
     * 
     * @return Asset
     */
    public function setPath($value){
        $this->set('path',$value);
        return $this;
    }
    /**
     * 获取属性:'path'的值
     * 
     * @return string
     */
    public function getPath(){
        return $this->get('path');
    }
        /**
     * 设置属性'file_name'的值
     *
     * @param  string $value
     * 
     * @return Asset
     */
    public function setFileName($value){
        $this->set('file_name',$value);
        return $this;
    }
    /**
     * 获取属性:'file_name'的值
     * 
     * @return string
     */
    public function getFileName(){
        return $this->get('file_name');
    }
        /**
     * 设置属性'parent_id'的值
     *
     * @param  integer $value
     * 
     * @return Asset
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
     * 设置属性'bytes'的值
     *
     * @param  integer $value
     * 
     * @return Asset
     */
    public function setBytes($value){
        $this->set('bytes',$value);
        return $this;
    }
    /**
     * 获取属性:'bytes'的值
     * 
     * @return integer
     */
    public function getBytes(){
        return $this->get('bytes');
    }
        /**
     * 设置属性'mime'的值
     *
     * @param  string $value
     * 
     * @return Asset
     */
    public function setMime($value){
        $this->set('mime',$value);
        return $this;
    }
    /**
     * 获取属性:'mime'的值
     * 
     * @return string
     */
    public function getMime(){
        return $this->get('mime');
    }
        /**
     * 设置属性'parent_type'的值
     *
     * @param  string $value
     * 
     * @return Asset
     */
    public function setParentType($value){
        $this->set('parent_type',$value);
        return $this;
    }
    /**
     * 获取属性:'parent_type'的值
     * 
     * @return string
     */
    public function getParentType(){
        return $this->get('parent_type');
    }
        /**
     * 设置属性'width'的值
     *
     * @param  integer $value
     * 
     * @return Asset
     */
    public function setWidth($value){
        $this->set('width',$value);
        return $this;
    }
    /**
     * 获取属性:'width'的值
     * 
     * @return integer
     */
    public function getWidth(){
        return $this->get('width');
    }
        /**
     * 设置属性'height'的值
     *
     * @param  integer $value
     * 
     * @return Asset
     */
    public function setHeight($value){
        $this->set('height',$value);
        return $this;
    }
    /**
     * 获取属性:'height'的值
     * 
     * @return integer
     */
    public function getHeight(){
        return $this->get('height');
    }
        /**
     * 设置属性'domain'的值
     *
     * @param  string $value
     * 
     * @return Asset
     */
    public function setDomain($value){
        $this->set('domain',$value);
        return $this;
    }
    /**
     * 获取属性:'domain'的值
     * 
     * @return string
     */
    public function getDomain(){
        return $this->get('domain');
    }
        /**
     * 设置属性'device_type'的值
     *
     * @param  string $value
     * 
     * @return Asset
     */
    public function setDeviceType($value){
        $this->set('device_type',$value);
        return $this;
    }
    /**
     * 获取属性:'device_type'的值
     * 
     * @return string
     */
    public function getDeviceType(){
        return $this->get('device_type');
    }
    
    /**
     * 设置属性'position'的值
     *
     * @param  integer $value
     *
     * @return Asset
     */
    public function setPosition($value){
    	$this->set('position',$value);
    	return $this;
    }
    /**
     * 获取属性:'position'的值
     *
     * @return integer
     */
    public function getPosition(){
    	return $this->get('position');
    }
    
        /**
     * 设置属性'created_on'的值
     *
     * @param  date $value
     * 
     * @return Asset
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