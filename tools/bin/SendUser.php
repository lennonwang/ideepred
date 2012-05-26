<?php 
/**
 * 100jia群发邮件
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
        'condition'=>'state=?',
        'vars'=>array(1),
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
        foreach($user as $u){
        	$email = $u['account'];
        	$username = $u['username'];
        	
        	$body = "<h3>亲爱的{$username}:</h3>";
            $body .= "<p>首批纪念Michael Jackson贴纸已新鲜出炉了，六位受邀艺术家风格迥异，佳作纷呈。</p>";
            $body .= "<p>此次生产的六幅作品兼具实用价值与收藏价值于一炉， 热爱创意生活的你，快快收入吧~用我们的方式，纪念不朽的流行音乐之王！</p>";
            $body .= "<p>购买地址：<a href=\"http://www.instyles.com.cn/app/greare/product/search?d=0&query=Michael%20Jackson\" target=\"_blank\"/>http://www.instyles.com.cn/app/greare/product/search?d=0&query=Michael%20Jackson</a></p>";
            $body .= Greare_Util_Notify::getEmailTips();
            
            $subject = "100jia购物提醒【MJ纪念贴纸抢鲜出炉】";
            
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