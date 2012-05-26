<?php 
/**
 * 批量加水印
 * 
 * @author purpen
 * @version $Id$
 */
require_once '../init_config.php';

try{
    $size = 50;
	$page = 1;
	$is_end = false;    
    $asset = new Common_Model_Asset();
    
    while(!$is_end){
        $options = array(
            'condition'=>'domain=?',
            'vars'=>array(Common_Model_Constant::PRODUCT_DOMAIN),
            'page'=>$page,
            'size'=>$size
        );
        
        $asset_list = $asset->find($options)->getResultArray();
        if(count($asset_list) <= 0){
            $is_end = true;
            break;
        }
        foreach($asset_list as $p){
            $domain = $p['domain'];
            $path = $p['path'];
            
            $water_image = Anole_Config::get('storage.watermark');
            Common_Util_Asset::makeDraw($path,$domain,$water_image);
            echo "water path[$path] is ok!\n";
        }
        if(count($asset_list) < $size){
            $is_end = true;
            break;
        }
        $page++;
    }
    unset($asset);
}catch(Anole_Exception $e){
    echo "water product photo fail: ".$e->getMessage()."\n";
}
/**vim:sw=4 et ts=4 **/
?>