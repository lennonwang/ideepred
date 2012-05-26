<?php
/**
 * Admin_Action_Goods
 *
 * @version:$Id$
 * @author: purpen
 * 
 * 管理除产品外的第三方商品
 * 
 */
class Admin_Action_Goods extends Admin_Action_Entry implements Anole_Dispatcher_Action_Interface_UploadSupport {
    protected $_model_class='Common_Model_Product';
    
    public $_main_menu = 'product';
    
    private $_state = 0;
    
    private $_number = null;
    
    private $_upload_files = array();
    
    private $_orderby = 1;
    
    private $_asset_id = null;
    /**
     * Support Upload File Interface
     *
     * @param array $files
     */
    public function setUploadFiles($files){
        $this->_upload_files = $files;
    }
    
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
            'uploadify'=>array(
                'privilege'=>Anole_Auth_AuthenticationResource::PRIV_NONE
            ),
            'execute'=>array(
                'privilege'=> Anole_Auth_AuthenticationResource::PRIV_CUSTOM,
                'custom'=>'validateViewPower'
            ),
            'display'=>array(
                'privilege'=> Anole_Auth_AuthenticationResource::PRIV_CUSTOM,
                'custom'=>'validateViewPower'
            ),
            'favorited'=>array(
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
        return 'product';
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
     * @return Common_Model_Product
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
        
        $state = $this->getState();
        if(!is_null($state)){
            $conditions[] = 'state=?';
            $vars[] = $state;
        }
        
        $conditions[] = 'sortid=?';
        $vars[] = 2;
        
        if(!empty($conditions)){
            $condition = implode(' AND ', $conditions);
        }
        
        $records = $model->countIf($condition,$vars);
        $total = ceil($records/$this->_size);
        $page = min($total, $this->_page);
        
        $_orderby = $this->getOrderby();
        if($_orderby == 3){
            $order = 'buy_count DESC';
        }elseif($_orderby == 2){
            $order = 'view_count DESC';
        }else{
            $order = 'updated_on DESC';
        }
        $options = array(
            'condition'=>$condition,
            'vars'=>$vars,
            'order'=>$order,
            'page'=>$page,
            'size'=>$this->_size
        );
        $model->find($options);
        
        $this->putContext('products', $model);
        $this->putContext('records', $records);
        $this->putContext('total', $total);
        $this->putContext('page', $page);
        $this->putContext('state',$this->_state);
        
        $this->putContext('order_by', $_orderby);
        
        //set menu style
        $this->putMenu();
        
        
        return $this->smartyResult('admin.goods.list');
    }
    
    /**
     * modify product info
     * 
     * @return string
     */
    public function edit(){
        $model = $this->wiredModel();
        $edit_mode = 'create';
        
        //get all category
        $category = new Common_Model_Category();
        $options = array(
            'select'=>'id,name,title,type,parent_id',
            'condition'=>'type=?',
            'vars'=>array(3),
            'order'=>'updated_on DESC,total DESC'
        );
        $categorys = $category->find($options)->getResultArray();
        
        if(!empty($this->_id)){
            $model->findById($this->_id);
            $edit_mode = 'update';
            
            //get pictures
            $assets = $this->_fetchGoodsAssets($this->_id);
            
            $this->putContext('assets', $assets);
        }
        $this->putContext('product', $model);
        $this->putContext('edit_mode', $edit_mode);
        
        $this->putContext('categorys', $categorys);
        unset($category);
        
        //set menu style
        $this->putMenu();
        
        return $this->smartyResult('admin.goods.edit');
    }
    /**
     * 批量上传商品的展示图
     * 
     * @return string
     */
    public function uploadify(){
        self::debug('upload[1] start...', __METHOD__);
        if(!empty($this->_upload_files)){
            
            $asset = new Common_Model_Asset();
                
            foreach($this->_upload_files as $f){
                try{
                    $asset->setIsNew(true);
                    $asset->setId(null);
                    
                    $asset->setDomain(Common_Model_Constant::PRODUCT_DOMAIN);
                    $asset->setParentType(Common_Model_Constant::PRODUCT_WHOLE);
                    $asset->setParentId($this->_id);
                    
                    $file_ary = getimagesize($f['path']);
                    $asset->setWidth(isset($file_ary[0]) ? $file_ary[0] : 1);
                    $asset->setHeight(isset($file_ary[1]) ? $file_ary[1] : 1);
                    $asset->setInputName($f['id']);
                    
                    $asset->setTmpFile($f['path']);
                    $asset->setBytes($f['size']);
                    $asset->setFileName($f['name']);
                    $mime = Anole_Util_File::getMimeContentType($f['name']);
                    $asset->setMime($mime);
                    
                    
                    $asset->save();
                }catch(Anole_ActiveRecord_Exception $e){
                    self::warn("execute db failed:".$e->getMessage(), __METHOD__);
                }catch(Anole_Exception $e){
                    self::warn("save asset failed:".$e->getMessage(), __METHOD__);
                }
            }
        }
        
        return $this->rawResult(200);
    }
    
    public function fetchAssets(){
        $asset = new Common_Model_Asset();
        
        $options = array(
           'condition'=>'parent_id=? AND parent_type=?',
           'order'=>'created_on DESC',
           'vars'=>array($this->_id, Common_Model_Constant::PRODUCT_WHOLE)
        );
        
        $assets = $asset->find($options)->getResultArray();
        if(!empty($assets)){
            for($i=0;$i<count($assets);$i++){
                $assets[$i]['url'] = Common_Util_Storage::getAssetUrl(Common_Model_Constant::PRODUCT_DOMAIN,$assets[$i]['path']);
            }
        }
        $this->putContext('id', $this->_id);
        $this->putContext('assets', $assets);
        
        return $this->jqueryResult('admin.goods.fetch_assets');
    }
    /**
     * 保存产品的信息
     * 
     * @return string
     */
    public function save(){
        $model = $this->wiredModel();
        
        if(empty($this->_id) || $this->_id < 0){
            $model->setIsNew(true);
            $model->setId(null);
            $model->setCreatedBy(Common_Util_User::getUserId());
            
            $edit_mode = 'create';
        }else{
            $model->setIsNew(false);
            $model->setId($this->_id);
            
            $edit_mode = 'update';
        }
        try{
            $model->setUpdatedBy(Common_Util_User::getUserId());
            $model->save();
            
            $_id = $model->getId();
        }catch(Anole_ActiveRecord_Exception $e){
            self::warn("save product failed:".$e->getMessage(), __CLASS__);
            $this->putContext('msg', $e->getMessage());
            return $this->jsonResult(500);
        }
        
        $this->putContext('product_id', $_id);
        $msg = "产品信息保存成功!";
        $this->putContext('msg', $msg);
        
        return $this->jsonResult();
    }
    /**
     * 获取某商品的所有图
     * 
     * @param $id
     * @return array
     */
    protected function _fetchGoodsAssets($id=null){
        $asset = new Common_Model_Asset();
        
        $options = array(
           'condition'=>'parent_id=? AND (parent_type=? or parent_type=?)',
           'order'=>'created_on DESC',
           'vars'=>array($id, Common_Model_Constant::PRODUCT_WHOLE,Common_Model_Constant::PRODUCT_THUMB)
        );
        
        $assets = $asset->find($options)->getResultArray();
        if(!empty($assets)){
            for($i=0;$i<count($assets);$i++){
                $assets[$i]['url'] = Common_Util_Storage::getAssetUrl(Common_Model_Constant::PRODUCT_DOMAIN,$assets[$i]['path']);
            }
        }
        
        return $assets;
    }
    
    /**
     * 单个或批量删除产品
     * 
     * @return string
     */
    public function remove(){
        if(empty($this->_id)){
            //error page
            return $this->_hintResult('删除产品的Id为空!');
        }
        //split id string
        $_ids = preg_split('/,/',$this->_id);
        try{
            $model = $this->wiredModel();
            $model->destroy($_ids);
        }catch(Anole_ActiveRecord_Exception $e){
            self::warn("Destory product db failed: ".$e->getMessage(), __METHOD__);
            return $this->_jqErrorTip($e->getMessage());
        }catch(Anole_Exception $e){
            self::warn("Destory excute failed: ".$e->getMessage(), __METHOD__);
            return $this->_jqErrorTip($e->getMessage());
        }
        $this->putContext('ids', $_ids);
        
        return $this->jqueryResult('admin.goods.del_ok');    
    }
    
    /**
     * 审核某个或多个产品
     * 
     * @return string
     */
    public function checking(){
        $model = $this->wiredModel();
        if(empty($this->_id)){
            //error page
            return $this->_hintResult('审核产品的Id为空!');
        }
        //split id string
        $_ids = preg_split('/,/',$this->_id);
        try{
            $state = $this->getState();
            foreach($_ids as $id){
                $model->setId($id);
                $model->setIsNew(false);
                $model->setState($state);
                $model->setPublishedBy(Common_Util_User::getUserId());
                $model->save();
            }
        }catch(Anole_ActiveRecord_Exception $e){
            self::warn("Checking product failed:".$e->getMessage(), __METHOD__);
            return $this->_jqErrorTip($e->getMessage());
        }
        
        $this->putContext('ids', $_ids);
        
        return $this->jqueryResult('admin.goods.del_ok');
    }
    
    /**
     * 单个或批量删除附件
     * 
     * @return string
     */
    public function removeAssets(){
        if(empty($this->_id)){
            //error page
            return $this->_hintResult('删除附件的Id为空!');
        }
        //split id string
        $_ids = preg_split('/,/',$this->_id);
        try{
            $model = new Common_Model_Asset();
            $model->destroy($_ids);
        }catch(Anole_ActiveRecord_Exception $e){
            self::warn("Destory article asset failed: ".$e->getMessage(), __METHOD__);
            return $this->_jqErrorTip($e->getMessage());
        }catch(Anole_Exception $e){
            self::warn("Destory excute failed: ".$e->getMessage(), __METHOD__);
            return $this->_jqErrorTip($e->getMessage());
        }
        $this->putContext('ids', $_ids);
        
        return $this->jqueryResult('admin.goods.remove_assets');    
    }
    
    /**
     * 标示商品的缩略图
     * 
     * @return string
     */
    public function assignThumb(){
        
        if(empty($this->_id) || empty($this->_asset_id)){
            return $this->_jqErrorTip('商品ID或缩略图ID没有指定','#uploadify_result');
        }
        $model = new Common_Model_Asset();
        try{
            //更新旧状态
	        $usql = 'UPDATE asset SET parent_type=? WHERE parent_id=? AND parent_type=?';
	        $model->getDba()->execute($usql,array(Common_Model_Constant::PRODUCT_WHOLE,$this->_id,Common_Model_Constant::PRODUCT_THUMB)); 
	        
	        //添加新状态
	        $usql2 = 'UPDATE asset SET parent_type=? WHERE id=?';
	        $model->getDba()->execute($usql2,array(Common_Model_Constant::PRODUCT_THUMB,$this->_asset_id));
        }catch(Common_Model_Exception $e){
            self::warn("validate failed:".$e->getMessage(), __METHOD__);
            return $this->_jqErrorTip('系统故障，请稍后再试','#uploadify_result');
        }
        unset($model);
        
        return $this->jqueryResult('admin.goods.assign_thumb');
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
    
    public function setNumber($value){
        $this->_number = $value;
        return $this;
    }
    public function getNumber(){
        return $this->_number;
    }
    public function setOrderby($v){
        $this->_orderby = $v;
        return $this;
    }
    public function getOrderby(){
        return $this->_orderby;
    }
    
    public function setAssetId($id){
        $this->_asset_id = $id;
        return $this;
    }
    public function getAssetId(){
        return $this->_asset_id;
    }
}
/**vim:sw=4 et ts=4 **/
?>