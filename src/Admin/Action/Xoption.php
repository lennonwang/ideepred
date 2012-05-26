<?php
/**
 * 设置系统变量
 *
 * @version $Id$
 * @author purpen
 */
class Admin_Action_Xoption extends Admin_Action_Entry {
	
    protected $_model_class='Common_Model_Xoption';
    
    
    /**
     * 
     * @return Common_Model_Xoption
     */
    public function wiredModel(){
        return parent::wiredModel();
    }
    //~~~~~~~~~~~~~~Action implements~~~~~~~~~~
    /**
     * default action method
     */
    public function execute(){
        return $this->general();    
    }
    
    /**
     * 常规选项的设置
     * 
     * @return string
     */
    public function general(){
		if(!$this->isLogged()){
            return $this->_redirectLogin();
        }
        $model = $this->wiredModel();
        
        $option = $model->find()->getResultArray();
        $option_list = array();
        if(!empty($option)){
            for($i=0;$i<count($option);$i++){
                $key = $option[$i]['option_name'];
                $value = $option[$i]['option_value'];
                $option_list[$key] = $value;
            }
        }
        
        $this->putContext('option', $option_list);
        
        return $this->smartyResult('admin.system.general');
    }
    
    /**
     * 保存系统配置
     * 
     * @return string
     */
    public function save(){
		if(!$this->isLogged()){
            return $this->_redirectLogin();
        }
        $model = $this->wiredModel();
        
        $data = $model->getData();
        if(!empty($data)){
            foreach($data as $key=>$value){
                try{
                    //若已存在，则更新，否则创建
                    if($model->hasIf('option_name=?',array($key))){
                        $usql = 'UPDATE `xoption` SET option_value=? WHERE option_name=?';
                        $model->getDba()->execute($usql,array($value,$key)); 
                    }else{
                        $model->setIsNew(true);
                        $model->setId(null);
                        $model->setOptionName($key);
                        $model->setOptionValue($value);
                        $model->save();
                    }
                }catch(Common_Model_Exception $e){
                    self::warn("Update system option[$key] failed!", __METHOD__);
                    continue;
                }
            }
            //更新系统配置文件
            $model->customAfterSave();
        }
        
        return $this->jQueryResult('admin.system.option_ok');
    }
}
/**vim:sw=4 et ts=4 **/
?>