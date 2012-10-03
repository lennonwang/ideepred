<?php
/**
 * 系统所有附件库
 *
 * @version $Id$
 * @author purpen
 */
class Admin_Action_Asset extends Admin_Action_Entry implements Anole_Dispatcher_Action_Interface_UploadSupport {
    protected $_model_class='Common_Model_Asset';
    
    public $_main_menu = 'product';
    
    private $_parent_id = null;
    
    private $_parent_type = null;
    
    /**
     * 目标的临时id
     * 
     * @var int
     */
    private $_target_id = null;
    /**
     * 第三方partent_id
     * 
     * @var int
     */
    const THIRD_PICTURE = 1;
    /**
     * 是否加水印
     * 
     * @var bool
     */
    const WATER_MARK = false;
    
    private $_upload_files = array();
    /**
     * Support Upload File Interface
     *
     * @param array $files
     */
    public function setUploadFiles($files){
        $this->_upload_files = $files;
    }
    /**
     * 
     * @return Common_Model_Asset
     */
    public function wiredModel(){
        return parent::wiredModel();
    }
    //~~~~~~~~~~~~~~Action implements~~~~~~~~~~
    /**
     * default action method
     */
    public function execute(){
        return $this->listing();
    }
    
    /**
     * 附件列表
     * 
     * @return string
     */
    public function listing(){
    	$model = $this->wiredModel();
        
        $parent_id = $this->getParentId();
        $parent_type = $this->getParentType();
        $page = $this->getPage();
        $size = $this->_size;
        if(!empty($parent_id)){
        	$conditions[] = 'parent_id=?';
        	$vars[] = $parent_id;
        }
        if(!empty($parent_type)){
        	$conditions[] = 'parent_type=?';
        	$vars[] = $parent_type;
        }
        if(!empty($conditions)){
        	$condition = implode(' AND ',$conditions);
        }else{
        	$condition = null;
        }
        //get total page
        $records = $model->countIf($condition,$vars);
        $total = ceil($records/$size);
        $page = min($total, $page);
        
        $options = array(
            'condition'=>$condition,
            'vars'=>$vars,
            'page'=>$page,
            'size'=>$size,
            'order'=>'created_on DESC'
        );
        $assets = $model->find($options);
        
        $this->putContext('assets', $assets);
        $this->putContext('records', $records);
        $this->putContext('total',$total);
        $this->putContext('page', $page);
        
        $start = ($page - 1)*$size + 1;
        $end = min($page*$size, $records);
        $this->putContext('start', $start);
        $this->putContext('end',$end);
        
        $page_list = Common_Util_Pager::XE_NewPager(array('page'=>$page,'total'=>$total));
        $this->putContext('page_list', $page_list);
        
    	return $this->smartyResult('admin.assets.list');
    }
    /**
     * 获取存储域
     * 
     * @param $parent_id
     * @return string
     */
    public function getCustomDomain($parent_type){
    	switch ($parent_type){
    		case Common_Model_Constant::PRODUCT_THUMB:
    			$domain = Common_Model_Constant::PRODUCT_DOMAIN;
    			break;
    		case Common_Model_Constant::PRODUCT_WHOLE:
    			$domain = Common_Model_Constant::PRODUCT_DOMAIN;
                break;
			case Common_Model_Constant::PRODUCT_SOURCE:
    			$domain = Common_Model_Constant::PRODUCT_DOMAIN;
                break;
    		case Common_Model_Constant::ADVERTISE:
    			$domain = Common_Model_Constant::ADVERTISE_DOMAIN;
    			break;
    		case Common_Model_Constant::ARTICLE_SOURCE;
    		    $domain = Common_Model_Constant::ARTICLE_DOMAIN;
    		    break;
    		case Common_Model_Constant::CATEGORY_THUMB:
    			$domain = Common_Model_Constant::DEFAULT_DOMAIN;
    			break;
    		case Common_Model_Constant::STORE_SHOW:
    			$domain = Common_Model_Constant::STORE_DOMAIN;
    			break;
    		case Common_Model_Constant::STORE_THUMB:
                $domain = Common_Model_Constant::STORE_DOMAIN;
                break;
    		default:
    			$domain = Common_Model_Constant::DEFAULT_DOMAIN;
    			break;
    	}
    	return $domain;
    }
    /**
     * 批量上传附件
     * 
     * @return string
     */
    public function uploadify(){
        $asset = $this->wiredModel();
        
        $files = $this->_upload_files;
        if(!empty($files)){
	        $parent_id = $this->getParentId();
	        
	        //编辑所属对象时存在目标Id
	        $target_id = $this->getTargetId();
	        if(!empty($target_id)){
	            $parent_id = $target_id;
	        }
	        
	        $parent_type = $this->getParentType();
	        if(empty($parent_type)){
	            $parent_type = Common_Model_Constant::PRODUCT_WHOLE;
	        }
        	$domain = $this->getCustomDomain($parent_type);
        	self::warn("upload file and domain[$domain]、parent_id[$parent_id]、parent_type[$parent_type]...", __METHOD__);
            foreach($files as $f){
                try{
                	$asset->setCustomDomain($domain);
                	
                    $asset->setIsNew(true);
                    $asset->setId(null);
                    
                    $asset->setParentType($parent_type);
                    
                    $asset->setParentId($parent_id);
                    
                    $file_ary = getimagesize($f['path']);
                    $asset->setWidth(isset($file_ary[0]) ? $file_ary[0] : 1);
                    $asset->setHeight(isset($file_ary[1]) ? $file_ary[1] : 1);
                    $asset->setInputName($f['id']);
                    $asset->setPosition(10);
                    $asset->setTmpFile($f['path']);
                    $asset->setBytes($f['size']);
                    $asset->setFileName($f['name']);
                    $mime = Anole_Util_File::getMimeContentType($f['name']);
                    $asset->setMime($mime);
                    //设置水印,先只给产品图片加水印
                    if($parent_type == Common_Model_Constant::PRODUCT_SOURCE){
                        $asset->setWaterMark(self::WATER_MARK);
                    }
                    
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
    /**
     * 获取新上传的附件列表
     * 
     * @return string
     */
    public function fetchAssets(){
        $model = $this->wiredModel();
        
        $parent_id = $this->getParentId();
        $parent_type = $this->getParentType();
        $target_id = $this->getTargetId();
        
        $conditions = array();
        $vars = array();
        
        if(!empty($target_id)){
            $parent_id = $target_id;
        }
        
        if(!empty($parent_id)){
        	$conditions[] = 'parent_id=?';
        	$vars[] = $parent_id;
        }
        if(!empty($parent_type)){
        //	$asset_type = ereg_replace('_',',',$parent_type);
			$asset_type = preg_replace('/_/',',',$parent_type);
        	$conditions[] = 'parent_type IN ('.$asset_type.')';
        }
        if(!empty($conditions)){
        	$condition = implode(' AND ',$conditions);
        }else{
        	$condition = null;
        }
        self::debug("condition[$condition]", __METHOD__);
        $options = array(
            'condition'=>$condition,
            'vars'=>$vars,
            'order'=>'parent_type ASC,id ASC'
        );
        try{
        	$domain = $this->getCustomDomain($parent_type);
        	$model->setCustomDomain($domain);
            $assets = $model->find($options);
        }catch(Exception $e){
            self::warn("fetch [$parent_id] [$parent_type] assets error...",__METHOD__);
        }
        
        $this->putContext('assets', $assets);
        
        //alias
        if($domain == 'advertise'){
        	$domain = 'advertise';
        }elseif ($domain == 'asset'){
        	$domain = 'assets';
        }
        
        return $this->jQueryResult('admin.'.$domain.'.fetch_asset');
    }
    /**
     * 编辑附件信息
     * 
     * @return string
     */
    public function edit(){
    	$model = $this->wiredModel();
    	
    	$edit_mode = 'create';
    	$id = $this->getId();
    	if(!empty($id)){
    		$edit_mode = 'edit';
    		$model->findById($id);
    	}
    	
    	$rand_sign = $this->_genRandsign();
        $this->putContext('rand_sign', $rand_sign);
        $this->putContext('edit_mode', $edit_mode);
        
        $this->putContext('asset', $model);
    	
    	return $this->smartyResult('admin.assets.edit');
    }
    
    /**
     * 选择某一个为显示缩略图
     * 
     * @return string
     */
    public function assignThumb(){
        $model = $this->wiredModel();
        
        $id = $this->getId();
        try{
            self::debug("assign[$id] thumb.", __METHOD__);
            
            //产品缩略图标识parent_type = 4;model直接注入参数
            //保存前先更新旧缩略图标识
            $parent_type = $this->getParentType();
            $parent_id = $this->getParentId();
            
            $model->setIsNew(false);
            $model->setId($id);
            $model->save();
            
            
            //如果是产品正面大图
            if($parent_type == Common_Model_Constant::PRODUCT_THUMB){
                $asset = $model->findById($id)->getResultArray();
                $path = $asset['path'];
                $domain = $asset['domain'];
                
                $parent_id = $asset['parent_id'];
                
                $file = basename($path);
                $ext = Anole_Util_File::getFileExtension($file);
                
                //生产缩略图150x150
                $thumb_path = "font/{$parent_id}.{$ext}";
                if(file_exists(Common_Util_Storage::getAssetPath($domain,$thumb_path))){
                    Common_Util_Storage::deleteAsset($domain,$thumb_path);
                }
                $thumb = Common_Util_Asset::resizePhoto($path,$thumb_path,220,210,$domain,2);
                //更新产品的缩略图到数据库
                $update_sql = 'UPDATE `product` SET thumb=? WHERE id=?';
                $model->getDba()->execute($update_sql,array($thumb_path,$parent_id));
                
                //删除旧缩略图107x107
                $thumb107x = Common_Util_Asset::buildThumbPathBySize($thumb_path);
                self::debug("thumb[107] [$thumb107x]!", __METHOD__);
                if(file_exists(Common_Util_Storage::getAssetPath($domain,$thumb107x))){
                    Common_Util_Storage::deleteAsset($domain,$thumb107x);
                }
                $thumb128x = Common_Util_Asset::buildThumbPathBySize($thumb_path,128,128);
                if(file_exists(Common_Util_Storage::getAssetPath($domain,$thumb128x))){
                    Common_Util_Storage::deleteAsset($domain,$thumb128x);
                }
                
                //生产缩略图50x50
                $thumb_path = "thumb/{$parent_id}.{$ext}";
                $thumb = Common_Util_Asset::resizePhoto($path,$thumb_path,50,50,$domain,2);
            }
            
        }catch(Exception $e){
            $msg = '更新产品缩略图出错：'.$e->getMessage();
            self::warn($msg, __METHOD__);
            return $this->_jqErrorTip($msg);
        }

		$this->putContext('asset_id', $id);
		$this->putContext('parent_type', $parent_type);
        
        return $this->jQueryResult('admin.product.thumb_ok');
    }
    /**
     * alias delete
     * 
     * @return string
     */
    public function remove(){
    	return $this->delete();
    }
    /**
     * 单个或批量删除附件
     * 
     * @return string
     */
    public function delete(){ 
        if(empty($this->_id)){
            //error page
            return $this->_jqErrorTip('删除附件的Id为空!');
        }
        $model = $this->wiredModel();
        
        //split id string
        $id = $this->getId();
        try{
	        if(!is_array($id)){
	            $id = array($id);
	        }
            
            $model->destroy($id);
            
        }catch(Anole_ActiveRecord_Exception $e){
            self::warn("Destory asset failed: ".$e->getMessage(), __METHOD__);
            return $this->_jqErrorTip($e->getMessage());
        }catch(Anole_Exception $e){
            self::warn("Destory excute failed: ".$e->getMessage(), __METHOD__);
            return $this->_jqErrorTip($e->getMessage());
        }
        $this->putContext('ids', $id);
        
        return $this->jqueryResult('admin.system.del_asset_ok');  
    }
    
    public function setParentId($v){
        $this->_parent_id = $v;
        return $this;
    }
    public function getParentId(){
        return $this->_parent_id;
    }
    
    public function setParentType($v){
        $this->_parent_type = $v;
        return $this;
    }
    public function getParentType(){
        return $this->_parent_type;
    }
    
    public function setTargetId($v){
        $this->_target_id = $v;
        return $this;
    }
    public function getTargetId(){
        return $this->_target_id;
    }
    
}
/**vim:sw=4 et ts=4 **/
?>