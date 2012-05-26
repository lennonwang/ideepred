<?php
/**
 * 促销活动（赠品、返利、打折、满就送等活动类型）
 * 
 * @version $Id$
 * @author purpen
 */
class Common_Model_Marketing extends Common_Model_Table_Marketing {
    
    /*买就送赠品*/
    const TYPE_GIFT = 1;
    
    //关系映射表
    protected $_relation_map = array(
    );
    /**
     * 默认的magic field
     */
    protected $_magic_field = array();
    /**
     * @return Common_Model_Marketing
     */
    public static function getModel($data=array(),$class=__CLASS__){
        return parent::getModel($data,$class);
    }
    
	/**
     * beforeValidation事件
     * @see src/Anole/ActiveRecord/Anole_ActiveRecord_Base#beforeValidation()
     */
    public function beforeValidation(){
    }
    /**
     * 验证必要的字段值
     * 
     * @return bool
     */
    public function validate(){
        if($this->isNew()){
            $fields = array('title','type');
        }else{
            $fields = array('id');
        }
        if(!$this->validateRequird($fields)){
            return False;
        }
        
        return true;
    }
}
/**vim:sw=4 et ts=4 **/
?>