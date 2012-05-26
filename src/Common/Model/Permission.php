<?php
/**
 * Model Common_Model_Permission
 * 
 * @version $Id$
 * @author purpen
 */
class Common_Model_Permission extends Common_Model_Table_Permission {
    
    //关系映射表
    protected $_relation_map = array(
    );
    /**
     * 默认的magic field
     */
    protected $_magic_field = array();
    /**
     * @return Common_Model_Permission
     */
    public static function getModel($data=array(),$class=__CLASS__){
        return parent::getModel($data,$class);
    }
    /**
     * validate required fields
     *
     * @return bool
     */
    public function validate(){
    	if($this->isNew()){
    		$fields = array('title','resource','privilege');
    	}else{
    		$fields = array('id');
    	}
    	if(!$this->validateRequird($fields)){
    		return False;
    	}
    	return True;
    }
    
}
/**vim:sw=4 et ts=4 **/
?>