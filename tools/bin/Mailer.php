<?php
/**
 * iDeepRed邮件提醒系统
 * 
 * @author purpen
 * @version $Id$
 */
require_once '../init_config.php';

try{
	//select need to send the posts
	$postoffice = new Common_Model_Postoffice();
	$pre_week_time=date("Y-m-d",mktime(0,0,0,date("m"),date("d")-17,date("Y")));
	echo "pre_week_time ".$pre_week_time.'...';
	$options = array(
	    'condition'=>'state=? and created_on >=? ',
	    'vars'=>array(Common_Model_Postoffice::DEFAULT_STATE,$pre_week_time),
	    'page'=>1,
	    'size'=>5,
	    'order'=>'created_on'
	);
	$postoffice->find($options);
	if(!$postoffice->count()){
		echo "postoffice not mail...\n";
		exit();
	}
	echo "postoffice count::".$postoffice->count();
	 
	//lock these posts
	echo "start to lock these posts...\n";
	$ids = array();
	$holders = array();
	foreach($postoffice as $post){
		$ids[] = $post['id'];
		$holders[] = '?';
	}
	$vars = array_merge((array)Common_Model_Postoffice::LOCK_STATE,(array)$ids);
	$usql = 'UPDATE postoffice SET state=? WHERE id IN ('.implode(', ', $holders).')';
    Anole_ActiveRecord_Base::getDba()->execute($usql,$vars);
    echo "lock these posts and done...\n";
    
	echo "start to send the mails...\n";
	$holders = array(); #empty holders
    foreach($postoffice as $post){
        try{
            $is_ok = Anole_Util_Mail::send($post['mailto'],$post['subject'],stripslashes($post['body']),$post['from'],$post['from_name']);
            if($is_ok){
            	$okids[] = $post['id'];
                $holders[] = '?';
            }else{
            	$usql = 'UPDATE postoffice SET state=? WHERE id=?';
                Anole_ActiveRecord_Base::getDba()->execute($usql,array(Common_Model_Postoffice::FAIL_STATE,$post['id']));
            }
        }catch(Anole_Exception $e){
            continue;
        }
    }
    
    //clear sucess posts
    echo "start to clear thest posts...\n";
   //  $dsql = 'DELETE FROM postoffice WHERE id IN ('.implode(', ', $holders).')';
    $dsql = 'UPDATE postoffice SET state=2 WHERE id IN ('.implode(', ', $holders).')';
    Anole_ActiveRecord_Base::getDba()->execute($dsql,$okids);
    
    echo "send the mails and done.\n";
}catch(Anole_Exception $e){
	echo "sender mail fail: ".$e->getMessage()."\n";
}
/**vim:sw=4 et ts=4 **/
?>