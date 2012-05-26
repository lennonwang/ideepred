<?php
/**
 * 后台信息管理入口
 * 
 * @version $Id$
 * @author purpen
 * 
 */
class Admin_Action_Appearance extends Admin_Action_Entry {
    protected $_model_class='Common_Model_User';
    //项目模板根目录
    protected $_project_template_name = 'eshop';
    
    private $_name = null;
    /**
     * 
     * @return Common_Model_User
     */
    public function wiredModel(){
        return parent::wiredModel();
    }
    //~~~~~~~~~~~~~~Action implements~~~~~~~~~~
    /**
     * default action method
     */
    public function execute(){
        return $this->defaultEntery();
    }
    /**
     * 显示模板列表
     * @return string
     */
    public function findTplList(){
    	
    	//获取主题文件
    	$template_dir = Anole_Config::get('smarty.template_dir');
    	$template_dir .= '/'.$this->_project_template_name;

    	$files = Anole_Util_File::getDirFiles($template_dir);
    	//print_R($files);

    	//默认获取第一个文件的内容
    	$content = Anole_Util_File::readFile($template_dir.'/'.$files[0]);
    	
    	$this->putContext('files', $files);
    	$this->putContext('content', $content);
    	
    	return $this->smartyResult('admin.appearance.template');
    }
    /**
     * 获取模板内容
     * @return string
     */
    public function edit(){
    	$name = $this->getName();
    	$content = Anole_Util_File::readFile($name);
    	
    	$this->putContext('content', $content);
    	return $this->jqueryResult('admin.appearance.edit');
    }
    
    
    public function setName($v){
    	$this->_name = $v;
    	return $this;
    }
    public function getName(){
    	return $this->_name;
    }
}
/**vim:sw=4 et ts=4 **/
?>