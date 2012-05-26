<?php 
/**
 * 新花样群发邮件
 * 
 * @author purpen
 * @version $Id$
 */
require_once '../init_config.php';

try{
	$postoffice = new Common_Model_Postoffice();
	$user = new Common_Model_User();
	$size = 100;
	
	$options = array(
	    'size'=>$size
	);
	$page = 1;
	while(True){
		$options['page'] = $page;
		$user->find($options);
		$max = $user->count();
		if($max == 0){
			break;
		}
		foreach($user as $person){
			$username = $person['username'];
			$email = $person['account'];
			
			$body = '<p>在寒风中我们即将结束2009年，在这一年，请记住弥足珍贵的各种各样的瞬间画面，无论快乐的悲伤的，并让我们憧憬即将来临的2010年！小样们～新年快乐！！</p>
<p>您的支持是我们前进的动力！新花样将在新的一年里再接再励！</p>

<p><img class="alignnone size-full wp-image-1228" title="instyles-newyear-card" src="http://blog.instyles.com.cn/wp-content/uploads/2009/12/instyles-newyear-card.jpg" alt="instyles-newyear-card" width="500" height="750" /></p>
<p>[新花样--中国最大的创意贴纸营销平台]<br />
<a href="http://www.instyles.com.cn" target="_blank">http://www.instyles.com.cn</a><br />
2009年12月30日</p>';
			$body .= Greare_Util_Notify::getEmailTips();
			
			$subject = "新花样祝福小样们新年快乐";
			
			$postoffice->receive($email,$subject,$body);
		}
		if($max < $size){
			break;
		}
		$page++;
	}
	unset($user);
	
	unset($postoffice);
	
	echo "Send done...\n";
	
}catch(Anole_Exception $e){
	echo "insert mail fail: ".$e->getMessage()."\n";
}
/**vim:sw=4 et ts=4 **/
?>