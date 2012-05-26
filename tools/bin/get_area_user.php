<?php 
/**
 * 获取某一地区的用户信息
 * 
 * @author purpen
 * @version $Id$
 */
require_once '../init_config.php';

try{
    $size = 100;
    $page = 1;
    $c_sql = 'SELECT * FROM user';
    
    $user = new Common_Model_User();
    
    $handle = fopen('bj_user.txt', 'a+');
    while(True){
    	$options = array(
    	   'page'=>$page,
    	   'size'=>$size
    	);
    	$user->find($options);
        $max = $user->count();
        if($max == 0){
            break;
        }
        foreach($user as $u){
        	$meta = $u['meta'];
        	$address = isset($meta['address']) ? $meta['address'] : null;
        	if(empty($address)){
        		continue;
        	}
        	echo "$address\n";
        	if(preg_match('/北京/i',$address)){
        		$name = $meta['real_name'];
        		$phone = $meta['mobie'];
        		$qq = $meta['qq'];
        		
        		$sex = ($u['sex'] == 'm') ? '男' : '女';
        		
        		$line = "{$name}-{$phone}-{$address}-{$sex}-{$qq}\n";
        		
        		if(!fwrite($handle,$line)){
        			print "不能写入文件";
        			exit;
        		}
        	}
        }
        if($max < $size){
            break;
        }
        echo "get page[$page] and size[$max] is done.\n";
        
        $page++;
    }
    fclose($handle);
    
    echo "get all done.\n";
    
    unset($user);
    
}catch(Anole_Exception $e){
    echo "get user count fail: ".$e->getMessage()."\n";
}
/**vim:sw=4 et ts=4 **/
?>