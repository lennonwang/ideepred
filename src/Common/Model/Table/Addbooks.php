<?php
/**
 * Table:addbooks mapping class 
 * 
 * This class is auto generated by gen-model task
 */
abstract class Common_Model_Table_Addbooks extends Anole_ActiveRecord_Base {
    
    /**
     * mapping table name
     * 
     * @var string
     */
    protected $_table_name='addbooks';
    
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
  'mobie' => 
  array (
    'name' => 'mobie',
    'type' => 'S',
    'length' => '25',
  ),
  'telephone' => 
  array (
    'name' => 'telephone',
    'type' => 'S',
    'length' => '25',
  ),
  'user_id' => 
  array (
    'name' => 'user_id',
    'type' => 'N',
    'length' => '11',
  ),
  'name' => 
  array (
    'name' => 'name',
    'type' => 'S',
    'length' => '25',
  ),
  'province' => 
  array (
    'name' => 'province',
    'type' => 'S',
    'length' => '25',
  ),
  'city' => 
  array (
    'name' => 'city',
    'type' => 'S',
    'length' => '25',
  ),
  'area' => 
  array (
    'name' => 'area',
    'type' => 'S',
    'length' => '30',
  ),
  'address' => 
  array (
    'name' => 'address',
    'type' => 'S',
    'length' => '150',
  ),
  'zip' => 
  array (
    'name' => 'zip',
    'type' => 'S',
    'length' => '25',
  ),
  'email' => 
  array (
    'name' => 'email',
    'type' => 'S',
    'length' => '100',
  ),
  'is_default' => 
  array (
    'name' => 'is_default',
    'type' => 'S',
    'length' => '1',
  ),
);
    
        /**
     * 设置属性'id'的值
     *
     * @param  integer $value
     * 
     * @return Addbooks
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
     * 设置属性'mobie'的值
     *
     * @param  string $value
     * 
     * @return Addbooks
     */
    public function setMobie($value){
        $this->set('mobie',$value);
        return $this;
    }
    /**
     * 获取属性:'mobie'的值
     * 
     * @return string
     */
    public function getMobie(){
        return $this->get('mobie');
    }
        /**
     * 设置属性'telephone'的值
     *
     * @param  string $value
     * 
     * @return Addbooks
     */
    public function setTelephone($value){
        $this->set('telephone',$value);
        return $this;
    }
    /**
     * 获取属性:'telephone'的值
     * 
     * @return string
     */
    public function getTelephone(){
        return $this->get('telephone');
    }
        /**
     * 设置属性'user_id'的值
     *
     * @param  integer $value
     * 
     * @return Addbooks
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
     * 设置属性'name'的值
     *
     * @param  string $value
     * 
     * @return Addbooks
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
     * 设置属性'province'的值
     *
     * @param  string $value
     * 
     * @return Addbooks
     */
    public function setProvince($value){
        $this->set('province',$value);
        return $this;
    }
    /**
     * 获取属性:'province'的值
     * 
     * @return string
     */
    public function getProvince(){
        return $this->get('province');
    }
        /**
     * 设置属性'city'的值
     *
     * @param  string $value
     * 
     * @return Addbooks
     */
    public function setCity($value){
        $this->set('city',$value);
        return $this;
    }
    /**
     * 获取属性:'city'的值
     * 
     * @return string
     */
    public function getCity(){
        return $this->get('city');
    }
        /**
     * 设置属性'area'的值
     *
     * @param  string $value
     * 
     * @return Addbooks
     */
    public function setArea($value){
        $this->set('area',$value);
        return $this;
    }
    /**
     * 获取属性:'area'的值
     * 
     * @return string
     */
    public function getArea(){
        return $this->get('area');
    }
        /**
     * 设置属性'address'的值
     *
     * @param  string $value
     * 
     * @return Addbooks
     */
    public function setAddress($value){
        $this->set('address',$value);
        return $this;
    }
    /**
     * 获取属性:'address'的值
     * 
     * @return string
     */
    public function getAddress(){
        return $this->get('address');
    }
        /**
     * 设置属性'zip'的值
     *
     * @param  string $value
     * 
     * @return Addbooks
     */
    public function setZip($value){
        $this->set('zip',$value);
        return $this;
    }
    /**
     * 获取属性:'zip'的值
     * 
     * @return string
     */
    public function getZip(){
        return $this->get('zip');
    }
        /**
     * 设置属性'email'的值
     *
     * @param  string $value
     * 
     * @return Addbooks
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
     * 设置属性'is_default'的值
     *
     * @param  string $value
     * 
     * @return Addbooks
     */
    public function setIsDefault($value){
        $this->set('is_default',$value);
        return $this;
    }
    /**
     * 获取属性:'is_default'的值
     * 
     * @return string
     */
    public function getIsDefault(){
        return $this->get('is_default');
    }
    }
/**vim:sw=4 et ts=4 **/
?>