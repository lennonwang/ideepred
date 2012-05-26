<?php
/**
 * 更新标签的计数
 * 
 * @author purpen
 * @version $Id$
 */
require_once '../init_config.php';

try{
	$tag = new Common_Model_Tag();
	$size = 100;
	$page = 1;
	$c_sql = 'SELECT count(*) as cnt FROM tag_rel WHERE tag_id=? AND ref_type=? group by tag_id';
    $u_sql = 'UPDATE tag SET ref_count=? WHERE id=?';
    
    
    $options = array(
        'page'=>$page,
        'size'=>$size
    );
    while(True){
        $options['page'] = $page;
        $tags = $tag->find($options)->getResultArray();
        $max = count($tags);
        if($max == 0){
            break;
        }
        for($i=0;$i<$max;$i++){
        	$tag_id = $tags[$i]['id'];
        	$cnt_ary = Anole_ActiveRecord_Base::getDba()->query($c_sql,1,1,array($tag_id,Common_Model_Constant::TAG_REF_PRODUCT));
        	if(!empty($cnt_ary)){
        		$ref_count = $cnt_ary[0]['cnt'];
        		echo "update tag[$tag_id] and count[$ref_count].\n";
        		//update ref count
                Anole_ActiveRecord_Base::getDba()->execute($u_sql,array($ref_count,$tag_id));
        	}else{
        		echo "update tag[$tag_id] and count[0].\n";
        	}
        }
        if($max < $size){
            break;
        }
        
        echo "update page[$page] and size[$max] is done.\n";
        
        $page++;
    }
    
	echo "update all done.\n";
	
	unset($tag);
	
}catch(Anole_Exception $e){
	echo "update tag count fail: ".$e->getMessage()."\n";
}
/**vim:sw=4 et ts=4 **/
?>