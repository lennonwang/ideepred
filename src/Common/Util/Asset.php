<?php
/**
 * 附件工具类
 * 
 * @author purpen
 * @version $Id$
 */
class Common_Util_Asset extends Anole_Object {
    /**
     * 删除符合条件的旧附件
     * @param $parent_id
     * @param $parent_type
     * @return Common_Model_Asset
     */
    public static function destoryOldAsset($parent_id,$parent_type,$domain='asset'){
    	$asset = new Common_Model_Asset();
    	
        if(is_null($parent_id) || is_null($parent_type)){
            self::warn("parent_id or parent_type is Null!", __METHOD__);
            return;
        }
        $condition = 'parent_id=? AND parent_type=?';
        $vars = array($parent_id,$parent_type);
        
        $assets = $asset->find(array('condition'=>$condition,'vars'=>$vars))->getResultArray();
        if(!empty($assets)){
        	foreach($assets as $a){
        		self::debug("Set Domain[$domain]....", __METHOD__);
        		$asset->setDomain($domain);
        		$asset->destroy($a['id']);
        	}
        }
    }
    /**
     * 调整产品照片的大小
     * @return string
     */
    public static function resizePhoto($path_id,$thumb_path,$w,$h,$domain='asset',$type=2){
        
        $local_path = Common_Util_Storage::getAssetPath($domain,$path_id);
        if(empty($local_path)){
            self::warn("Path_id[$path_id] isn't exist!", __METHOD__);
            return false;
        }
        $imgBlob = Anole_Util_Image::makeThumb($local_path,$w,$h,'',$type,2);
        if(empty($imgBlob)){
            self::warn("Make thumb Blob is Null!", __METHOD__);
            return false;
        }
        Common_Util_Storage::storeData($domain,$thumb_path,$imgBlob);
        
    }
    /**
     * 制作缩略图
     * 
     * @param string $path_id
     * @param int $w
     * @param int $h
     * @param string $domain
     * @param int $type //生成缩略图的形式   1:按原图比例无裁剪缩图    2:按照缩略图比例对原图裁剪缩图 3:按照固定宽度缩图 4:按照固定高度缩图
     * @param int $mark
     * 
     * @return mixed
     */
    public static function makeThumb($path_id,$w=100,$h=100,$domain='asset',$type=1,$mark=0){
    	
        $temp = md5($path_id);
        
        //原图存储目录
        $path = dirname($path_id); 
        $file = basename($path_id);
        $ext = Anole_Util_File::getFileExtension($file);
        self::info("Path_id[$path_id] path===$path file=====$file", __METHOD__);
        $local_path = Common_Util_Storage::getAssetPath($domain,$path_id); 
        if(empty($local_path)){
        	self::warn("Path_id[$path_id] isn't exist!", __METHOD__);
        	return false;
        }
        //list($awidth,$aheight,$fot,$atr) = getimagesize($local_path);
        
        //缩略图存储目录path
        $thum_id = "thump/".$path."/".$temp."_".$type."_".$w."_".$h.'.'.$ext;
        //如果有,直接返回缩略图地址,否则开始生成缩略图
        $local_thumb = Common_Util_Storage::getAssetPath($domain,$thum_id);
        if(is_null($local_thumb)){
        	$imgBlob = Anole_Util_Image::makeThumb($local_path,$w,$h,'',$type,2,$mark);
        	if(empty($imgBlob)){
        		self::warn("Make thumb Blob is Null!", __METHOD__);
        		return false;
        	}
        	Common_Util_Storage::storeData($domain,$thum_id,$imgBlob);
			
        }else{
        	self::debug("Thumb[$local_thumb] has exist!", __METHOD__);
        }
		if(is_null($local_thumb)){
			$local_thumb = Common_Util_Storage::getAssetPath($domain,$thum_id);
		}
        list($thumb_width,$thumb_height,$thumb_fot,$thumb_atr) = getimagesize($local_thumb);
        $url = Common_Util_Storage::getAssetUrl($domain,$thum_id);
        
        $thumb['width']   =  $thumb_width;
        $thumb['height']  =  $thumb_height;
        $thumb['format']  =  $thumb_fot;
        $thumb['atr']     =  $thumb_atr;
        $thumb['url']     =  $url;
        
        
        return $thumb;
    }
    /**
     * 获取缩略图的存储路径
     * 
     * @return string
     */
    public static function buildThumbPathBySize($path_id,$w=107,$h=107,$domain='product',$type=2){
        $temp = md5($path_id);
        
        //原图存储目录
        $path = dirname($path_id); 
        $file = basename($path_id);
        $ext = Anole_Util_File::getFileExtension($file);
        
        //缩略图存储目录path
        $thum_id = "thump/".$path."/".$temp."_".$type."_".$w."_".$h.'.'.$ext;
        
        return $thum_id;
    }
    /**
     * 生产水印图存储路径
     * 
     * @param $org_path
     * @return string
     */
    public static function buildWateImagePath($org_path){
        $temp = md5($org_path);
        
        //原图存储目录
        $path = dirname($org_path); 
        $file = basename($org_path);
        $ext = Anole_Util_File::getFileExtension($file);
        //水印图存储目录path
        $waterimg_id = "watermark/".$path."/".$temp."_rb.".$ext;
        
        return $waterimg_id;
    }
	/**
     * 获取水印图
     * 
     * @return string
     */
    public static function fetchWatetImage($domain,$path_id){
        //水印图存储目录path
        $waterimg_id = self::buildWateImagePath($path_id);
        $local_waterimg = Common_Util_Storage::getAssetPath($domain,$waterimg_id);
        self::debug("get [$path_id] water image[$local_waterimg]!\n", __METHOD__);
        if(file_exists($local_waterimg)){
            return Common_Util_Storage::getAssetUrl($domain,$waterimg_id);
        }else{
            return Common_Util_Storage::getAssetUrl($domain,$path_id);
        }
    }
    /**
     * 给图片添加水印
     * 
     * @param $path_id
     * @param $domain
     * 
     * @return string
     */
    public static function makeDraw($path_id,$domain='asset',$water_image=null){
        $local_path = Common_Util_Storage::getAssetPath($domain,$path_id);
        if(empty($local_path)){
            self::warn("Path_id[$path_id] isn't exist!", __METHOD__);
            return false;
        }
        //水印图存储目录path
        $waterimg_id = self::buildWateImagePath($path_id);
        $local_waterimg = Common_Util_Storage::getAssetPath($domain,$waterimg_id);
        if(!file_exists($local_waterimg)){
            $image_blob = Anole_Util_Image::drawPicture($local_path,'',2,$water_image);
	        if(empty($image_blob)){
	            self::warn("Make thumb Blob is Null!", __METHOD__);
	            return false;
	        }
	        Common_Util_Storage::storeData($domain,$waterimg_id,$image_blob);
        }
        
    }
    
    /**
     * 获取目标附件或缩略图地址
     * 
     * @param int $parent_id
     * @param int $parent_type
     * 
     * @return string
     */
    public static function fetchAssetUrl($parent_id,$parent_type){
    	if(empty($parent_id) || empty($parent_type)){
    		return null;
    	}
    	$asset = new Common_Model_Asset();
    	$options = array(
    	    'condition'=>'parent_id=? AND parent_type=?',
    	    'vars'=>array($parent_id,$parent_type),
    	    'order'=>'created_on DESC'
    	);
    	$asset->findFirst($options);
    	if($asset->count()){
    		return $asset['asset_url'];
    	}
    	return null;
    }
}
/**vim:sw=4 et ts=4 **/
?>