<?php 
/**
 * 清除已清除的产品的标签关联
 * 
 * @author purpen
 * @version $Id$
 */
require_once '../init_config.php';

try{
    $size = 100;
    $page = 1;
    $c_sql = 'SELECT * FROM tag_rel WHERE ref_type=?';
    $d_sql = 'DELETE FROM tag_rel WHERE ref_id=? AND ref_type=?';
    
    $product = new Common_Model_Product();
    while(True){
        $tag_ref = Anole_ActiveRecord_Base::getDba()->query($c_sql,$size,$page,array(Common_Model_Constant::TAG_REF_PRODUCT));
        $max = count($tag_ref);
        if($max == 0){
            break;
        }
        for($i=0;$i<$max;$i++){
        	$ref_id = $tag_ref[$i]['ref_id'];
        	$ref_type = $tag_ref[$i]['ref_type'];
        	$product->findById($ref_id);
        	if(!$product->count()){
        		echo "clear ref_id[$ref_id] and ref_type[$ref_type].\n";
        		Anole_ActiveRecord_Base::getDba()->execute($d_sql,array($ref_id,Common_Model_Constant::TAG_REF_PRODUCT));
        	}
        }
        if($max < $size){
            break;
        }
        echo "update page[$page] and size[$max] is done.\n";
        
        $page++;
    }
    
    echo "update all done.\n";
    
    unset($product);
    
}catch(Anole_Exception $e){
    echo "update tag_ref count fail: ".$e->getMessage()."\n";
}
/**vim:sw=4 et ts=4 **/
?>