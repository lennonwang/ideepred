<?php
/**
 * Admin_Action_ProductFeatures
 *
 */
class Admin_Action_ProductFeatures extends Anole_Dispatcher_Action_ModelDriven {
    protected $_model_class='Common_Model_ProductFeatures';
    /**
     * 
     * @return Common_Model_ProductFeatures
     */
    public function wiredModel(){
        return parent::wiredModel();
    }
    //~~~~~~~~~~~~~~Action implements~~~~~~~~~~
    /**
     * default action method
     */
    public function execute(){
        
    }
}
/**vim:sw=4 et ts=4 **/
?>