<?php 
/**
 * 从产品单个所属分类转化为产品多个分类
 * 
 * @author purpen
 * @version $Id$
 */
require_once '../init_config.php';

function changeManyCategory(){
	try{
	    $size = 50;
	    $page = 1;
	    
	    $product = new Common_Model_Product();
	    
	    $category = new Common_Model_Category();
	    
	    $update_sql = 'INSERT INTO product_category (product_id,category_id) VALUES (?,?)';
	    
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
	            $category_id = $p['category_id'];
	            
	            if(!empty($id) && !empty($category_id)){
	                $category->getDba()->execute($update_sql,array($id,$category_id));
	            }
	            
	            echo "insert data[product_id=>$id,category_id=>$category_id].\n";
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
	    echo "change product fail: ".$e->getMessage()."\n";
	}
}

function checkHasChild(){
    try{
        $size = 50;
        $page = 1;
        
        $category = new Common_Model_Category();
        
        $update_sql = 'UPDATE category SET parent_id=? WHERE id=?';
        
        while(True){
            $options = array(
                'page'=>$page,
                'size'=>$size
            );
            $categorys = $category->find($options)->getResultArray();
            $max = count($categorys);
            if($max == 0){
                break;
            }
            foreach($categorys as $cate){
                $id = $cate['id'];
                
                if($category->countIf('parent_id=?',array($id))){
                	$category->getDba()->execute($update_sql,array(0, $id));
                	
                	echo "update category [$id],parent_id=>0].\n";
                }
                
            }
            if($max < $size){
                break;
            }
            echo "get page[$page] and size[$max] is done.\n";
            
            $page++;
        }
        echo "get all done.\n";
        
        unset($category);
        
    }catch(Anole_Exception $e){
        echo "change product fail: ".$e->getMessage()."\n";
    }
}

//changeManyCategory();

checkHasChild();

/**vim:sw=4 et ts=4 **/
?>