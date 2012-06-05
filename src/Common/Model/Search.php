<?php
/**
 * Model Common_Model_Search
 * 
 * generated by gen-model task.
 */
class Common_Model_Search extends Common_Model_Table_Search {
    
    //关系映射表
    protected $_relation_map = array(
    );
    
    /**
     * 默认的magic field
     */
    protected $_magic_field = array();
    /**
     * @return Common_Model_Search
     */
    public static function getModel($data=array(),$class=__CLASS__){
        return parent::getModel($data,$class);
    }
    
    public function validate(){
        if($this->isNew()){
            $fields = array('name');   
        }else{
            $fields = array('id');
        }
        if(!$this->validateRequird($fields)){
            self::warn("fields validate failed!", __METHOD__);
            return false;
        }
        return true;
    }
    
    
    public function checkIfExist($name=null){
    	if(is_null($name)){
    		$name = $this->getName();
    	}
    	if(empty($name)){
    		throw new Common_Model_Exception('Search word is Null!');
    	}
    	if($this->countIf('name=?',array($name))){
    		return true;
    	}else{
    		return false;
    	}
    }
    
}
/**vim:sw=4 et ts=4 **/
?>