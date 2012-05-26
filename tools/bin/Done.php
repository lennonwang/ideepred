<?php
/**
 * 新花样监测数据脚本
 *
 * @author purpen
 * @version $Id$
 */
require_once '../init_config.php';

/**
 * 系统自动处理过期订单 
 *
 * 过期时间：3天
 *
 * @return void
 */
function updateExpireOrder(){
	try{

		echo "Start to validate expired order...\n";
		$orders = new Common_Model_Orders();
			
		$now = Greare_Util_Date::getNow();
		$end = Greare_Util_Date::dateTimeAddMinus('d',3,$now);
		echo "End date $end ...\n";
			
		$usql = 'UPDATE orders SET status=? WHERE status=? AND created_on < ?';
			
		$vars = array(Common_Model_Constant::ORDER_EXPIRED,Common_Model_Constant::ORDER_WAIT_PAYMENT,$end);
			
		$orders->getDba()->execute($usql,$vars);
			
		echo "Update expired order done...\n";
	}catch(Anole_Exception $e){
		echo "Done order fail: ".$e->getMessage()."\n";
	}
}

/***
 * 系统自动实现推荐
 * 
 * @return void
 */
function autoStick(){
	//update old to remvoe stick
	$usql = 'UPDATE work SET stick=? WHERE stick=?';
	Anole_ActiveRecord_Base::getDba()->execute($usql,array(0,1));

	//select new to stick
	$designer = new Common_Model_Designer();
	$options = array(
        'select'=>'id',
        'condition'=>'work_count>?',
        'vars'=>array(0),
        'page'=>1,
        'size'=>5,
        'order'=>'rand()'
     );
     $desingers = $designer->find($options)->getResultArray();
     if(count($desingers)){
         $options = array(
            'select'=>'id',
            'condition'=>'designer_id=?',
            'page'=>1,
            'order'=>'rand()'
         );
         $work_ids = array();
         foreach($desingers as $dgr){
            $work = new Common_Model_Work();
            
            $options['vars'] = array($dgr['id']);
            $work->findFirst($options);

            $work->setId($work['id']);
            $work->setIsNew(false);
            $work->setStick(1);
            $work->save();

            unset($work);
         }
     }
     unset($designer);
     
     echo "auto update ok!\n";
     
     //remove cache  
     $cache_key = 'idx_wks';
     $group = 'WORK';
     Anole_Cache_Manager::remove($cache_key,$group);
}
/**
 * 更新实名注册的用户
 * 
 * @return string
 */
function checkRealityUser(){
	//update sql
	$uSql = 'UPDATE user SET is_reality=? WHERE id=?';
	$size = 100;
	
	$user = new Common_Model_User();
	$options = array(
	    'size'=>$size
	);
	$page = 1;
	while(1){
		$options['page'] = $page;
		$user->find($options);
		$max = $user->count();
		if($max < 1){
			break;
		}
		foreach($user as $u){
			$meta = $u['meta'];
			$reality_name = $meta['real_name'];
			$mobie = $meta['mobie'];
			print "$reality_name -- $mobie\n";
			if(!empty($reality_name) && !empty($mobie)){
				$id = $u['id'];
				Anole_ActiveRecord_Base::getDba()->execute($uSql,array(1,$id));
			}
		}
		if($max < $size){
			break;
		}
		$page++;
	}
}

#脚本执行
updateExpireOrder();

autoStick();

#checkRealityUser();

/**vim:sw=4 et ts=4 **/
?>