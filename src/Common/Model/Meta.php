<?php
/**
 * 存贮系统的扩展信息
 * 
 * @version $Id$
 * @author purpen
 */
class Common_Model_Meta extends Common_Model_Table_Meta {
    
    //关系映射表
    protected $_relation_map = array(
    );
    /**
     * 默认的magic field
     */
    protected $_magic_field = array();
    /**
     * @return Common_Model_Meta
     */
    public static function getModel($data=array(),$class=__CLASS__){
        return parent::getModel($data,$class);
    }
    
    public function validate(){
        if($this->isNew()){
            $fields = array('owner_id', 'name', 'domain');
        }else{
            $fields = array('id');
        }
    	if(!$this->validateRequird($fields)){
    		return false;
    	}
    	return true;
    }
    

}
/**vim:sw=4 et ts=4 **/
?>