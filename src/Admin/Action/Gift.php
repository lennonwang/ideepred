<?php
/**
 * Admin_Action_Gift
 * 
 * @author purpen
 * @version $Id$
 */
class Admin_Action_Gift extends Admin_Action_Entry {
    protected $_model_class='Common_Model_Gift';
    
    public $_main_menu = 'product';
    
    private $_state = 1;
    
    /**
     * authentication object
     *
     * @var Anole_Auth_Authentication
     */
    protected $_authentication;
    /**
     * authorizedresource interface
     *
     * @return array
     */
    public function getPrivilegeMap(){
        return array(
            '*'=>array(
                'privilege'=>Anole_Auth_AuthenticationResource::PRIV_CUSTOM,
                'custom'=>'validateAdministrator'
            ),
            'execute'=>array(
                'privilege'=> Anole_Auth_AuthenticationResource::PRIV_CUSTOM,
                'custom'=>'validateViewPower'
            ),
            'display'=>array(
                'privilege'=> Anole_Auth_AuthenticationResource::PRIV_CUSTOM,
                'custom'=>'validateViewPower'
            ),
            'edit'=>array(
                'privilege'=> Anole_Auth_AuthenticationResource::PRIV_CUSTOM,
                'custom'=>'validateEditPower'
            ),
            'save'=>array(
                'privilege'=> Anole_Auth_AuthenticationResource::PRIV_CUSTOM,
                'custom'=>'validateEditPower'
            ),
            'remove'=>array(
                'privilege'=> Anole_Auth_AuthenticationResource::PRIV_CUSTOM,
                'custom'=>'validateDeletePower'
            ),
            'checking'=>array(
                'privilege'=> Anole_Auth_AuthenticationResource::PRIV_CUSTOM,
                'custom'=>'validateCheckPower'
            ));
    }
    /**
     * 当前Resource的唯一标识,与ACL中的resource应对应
     */
    public function getResourceId(){
        return 'gift';
    }
    /**
     * 设置当前用户的Authentication
     *
     * @param Anole_Auth_Authentication $authentication
     */
    public function _setAuthentication(Anole_Auth_Authentication $authentication){
        $this->_authentication = $authentication;
    }
    
    /**
     * 
     * @return Common_Model_Gift
     */
    public function wiredModel(){
        return parent::wiredModel();
    }
    //~~~~~~~~~~~~~~Action implements~~~~~~~~~~
    /**
     * default action method
     */
    public function execute(){
        return $this->display();
    }
    
    public function display(){
    	$model = $this->wiredModel();
        $condition = 'state=?';
        $vars = array($this->_state);
        
        $records = $model->countIf($condition,$vars);
        $total = ceil($records/$this->_size);
        $page = min($total, $this->_page);
        
        $options = array(
            'condition'=>$condition,
            'vars'=>$vars,
            'order'=>'id DESC',
            'page'=>$page,
            'size'=>$this->_size
        );
        $model->find($options);
        
        $this->putContext('gifts', $model);
        $this->putContext('records', $records);
        $this->putContext('total', $total);
        $this->putContext('page', $page);
        $this->putContext('state',$this->_state);
        
        //set menu style
        $this->putMenu();
        
    	return $this->smartyResult('admin.gift.list');
    }
    
    /**
     * modify gift message
     * 
     * @return string
     */
    public function edit(){
        $model = $this->wiredModel();
        
        $edit_mode = 'create';
        if(!empty($this->_id)){
            $edit_mode = 'update';
            $model->findById($this->_id);
        }
        $this->putContext('gift', $model);
        $this->putContext('edit_mode', $edit_mode);
        
        //set menu style
        $this->putMenu();
        
        return $this->smartyResult('admin.gift.edit');
    }
    
    /**
     * upload new gift
     * 
     * @return string
     */
    public function save(){
        $model = $this->wiredModel();
        if(empty($this->_id) || $this->_id < 0){
            $model->setIsNew(true);
            $model->setId(null);
            
            $edit_mode = 'create';
        }else{
            $model->setIsNew(false);
            $model->setId($this->_id);
            
            $edit_mode = 'update';
        }
        try{
            $model->save(); 
            
            $_id = $model->getId();
            
            //save upload files
            if(!empty($this->_upload_files)){
                $asset = new Common_Model_Asset();
                //set domain value
                $asset->setDomain(Common_Model_Constant::WORK_DOMAIN);
                foreach($this->_upload_files as $f){
                    if($f['id'] == 'show'){ //展示图
                        //修改时，删除旧文件
                        if($edit_mode == 'update'){
                            //clear old show picture
                            Common_Util_Asset::destoryOldAsset($_id,Common_Model_Constant::GIFT_SHOW,Common_Model_Constant::WORK_DOMAIN);
                        }
                        $file_ary = getimagesize($f['path']);
                        $asset->setWidth(isset($file_ary[0]) ? $file_ary[0] : 1);
                        $asset->setHeight(isset($file_ary[1]) ? $file_ary[1] : 1);
                        
                        $asset->setParentType(Common_Model_Constant::GIFT_SHOW);
                    }elseif($f['id'] == 'thumb'){ //缩略图
                        //修改时，删除旧文件
                        if($edit_mode == 'update'){
                            //clear old show picture
                            Common_Util_Asset::destoryOldAsset($_id,Common_Model_Constant::GIFT_THUMB,Common_Model_Constant::WORK_DOMAIN);
                        }
                        $file_ary = getimagesize($f['path']);
                        $asset->setWidth(isset($file_ary[0]) ? $file_ary[0] : 1);
                        $asset->setHeight(isset($file_ary[1]) ? $file_ary[1] : 1);
                        
                        $asset->setParentType(Common_Model_Constant::GIFT_THUMB);
                    }else{
                        continue; //skip
                    }
                    $asset->setIsNew(true);
                    $asset->setId(null);
                    
                    $asset->setParentId($_id);
                    
                    $asset->setInputName($f['id']);
                    $asset->setTmpFile($f['path']);
                    $asset->setBytes($f['size']);
                    $asset->setFileName($f['name']);
                    $mime = Anole_Util_File::getMimeContentType($f['name']);
                    $asset->setMime($mime);

                    try{
                        $asset->save();
                    }catch(Anole_ActiveRecord_Exception $e){
                        $this->putContext('msg', $e->getMessage());
                        return $this->jsonResult();
                    }catch(Anole_Exception $e){
                        $this->putContext('msg', $e->getMessage());
                        return $this->jsonResult();
                    }
                }
            }
        }catch(Anole_ActiveRecord_Exception $e){
            self::warn("save gift failed:".$e->getMessage(), __METHOD__);
            $this->putContext('msg', $e->getMessage());
            return $this->jsonResult(500);
        }
        
        $this->putContext('gift_id', $_id);
        $msg = "礼品信息保存成功!";
        $this->putContext('msg', $msg);
        
        return $this->jsonResult();
    }
    
    /**
     * 单个或批量删除礼品
     * 
     * @return string
     */
    public function remove(){
        if(empty($this->_id)){
            //error page
            return $this->_hintResult('删除礼品的Id为空!');
        }
        //split id string
        $_ids = preg_split('/,/',$this->_id);
        try{
            $model = $this->wiredModel();
            $model->destroy($_ids);
        }catch(Anole_ActiveRecord_Exception $e){
            self::warn("Destory gift db failed: ".$e->getMessage(), __METHOD__);
            return $this->_jqErrorTip($e->getMessage());
        }catch(Anole_Exception $e){
            self::warn("Destory excute failed: ".$e->getMessage(), __METHOD__);
            return $this->_jqErrorTip($e->getMessage());
        }
        $this->putContext('ids', $_ids);
        
        return $this->jqueryResult('admin.gift.del_ok');    
    }
    /**
     * 审核某个或多个礼品
     * 
     * @return string
     */
    public function checking(){
        $model = $this->wiredModel();
        if(empty($this->_id)){
            //error page
            return $this->_hintResult('审核礼品的Id为空!');
        }
        //split id string
        $_ids = preg_split('/,/',$this->_id);
        try{
            $state = $this->getState();
            foreach($_ids as $id){
                $model->setId($id);
                $model->setIsNew(false);
                $model->setState($state);
                $model->save();
            }
        }catch(Anole_ActiveRecord_Exception $e){
            self::warn("Checking gift failed:".$e->getMessage(), __METHOD__);
            return $this->_jqErrorTip($e->getMessage());
        }
        
        $this->putContext('ids', $_ids);
        
        return $this->jqueryResult('admin.gift.del_ok');
    }
    
    public function setId($id){
        $this->_id = $id;
        return $this;
    }
    public function getId(){
        return $this->_id;
    }
    
    public function setPage($page){
        $this->_page = $page;
        return $this;
    }
    public function getPage(){
        return $this->_page;
    }
    public function setState($state){
        $this->_state = $state;
        return $this;
    }
    public function getState(){
        return $this->_state;
    }
}
/**vim:sw=4 et ts=4 **/
?>