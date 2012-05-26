<?php 
/**
 * 获取某一地区的用户信息
 * 
 * @author purpen
 * @version $Id$
 */
require_once '../init_config.php';

function crop($thumb_id,$path_id,$type=1){
	try{
		//start to crop
		$magick_wand = NewMagickWand();
        
        if(!MagickReadImage($magick_wand,$thumb_id)){
            return false;
        }
        $oriHeight = MagickGetImageHeight($magick_wand);
        $oriWidth = MagickGetImageWidth($magick_wand);
        
        if($type == Common_Model_Constant::PRODUCT_THUMB){
        	$width = 176;
	        $heigth = 132;
	            
	        $x = ceil(($oriWidth - $width)/2);
	        $y = 0;
        }elseif($type == Common_Model_Constant::PRODUCT_WHOLE){
        	$width = 528;
	        $heigth = 350;
	        
	        $x = ceil($oriWidth - $width - 40);
	        $y = 0;
        }else{
        	//skip
        }
         
        MagickCropImage($magick_wand,$width,$heigth, $x,$y);
        
        $image_blob = MagickGetImageBlob($magick_wand);
            
        Common_Util_Storage::storeData(Common_Model_Constant::PRODUCT_DOMAIN,$path_id,$image_blob);
            
        DestroyMagickWand($magick_wand);
        
	}catch(Exception $e){
		echo "Error: ".$e->getMessage()."\n";
	}
}

try{
    $size = 50;
    $page = 1;
    
    $product = new Common_Model_Product();
    
    $asset = new Common_Model_Asset();
    
    while(True){
        $options = array(
            'page'=>$page,
            'size'=>$size,
            'order'=>'created_on DESC'
        );
        $product->find($options);
        $max = $product->count();
        if($max == 0){
            break;
        }
        foreach($product as $p){
            $id = $p['id'];
            //缩略图
            $type = Common_Model_Constant::PRODUCT_THUMB;
            //大图
            //$type = Common_Model_Constant::PRODUCT_WHOLE;
            $asset->fetchAssetList($id,$type);
	        if(!$asset->count()){
	        	continue;
	        }
	        $path_id = $asset[0]['path'];
	        $thumb_id = Common_Util_Storage::getAssetPath(Common_Model_Constant::PRODUCT_DOMAIN,$path_id);
	        
	        crop($thumb_id,$path_id,$type);
	        
	        echo "crop[$thumb_id] is done .\n";
        }
        if($max < $size){
            break;
        }
        echo "get page[$page] and size[$max] is done.\n";
        
        $page++;
    }
    echo "get all done.\n";
    
    unset($product);
    
}catch(Anole_Exception $e){
    echo "crop product fail: ".$e->getMessage()."\n";
}
/**vim:sw=4 et ts=4 **/
?>