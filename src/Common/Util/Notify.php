<?php
/**
 * 系统辅助方法
 * 
 * @author purpen
 * @version $Id$
 */ 
class Common_Util_Notify extends Anole_Object {
    /**
     * 注册激活帐号邮件
     *
     * @param string $account
     * @param string $activation
     * @return void
     */
     public static function sendRegistActiveEmail($account, $activation,$extend_info=null){
        $subject = "iDeepRed物提醒【注册确认】";
        $url = Common_Util_Url::app_root_url()."/app/eshop/profile/activate_email?activation=$activation";
        
        $body  = "<h3>亲爱的 $account ,欢迎加入深红俱乐部！</h3> <p>你可以在浏览器中输入或复制下列地址来激活: ";
        $body .= "<a href=".$url." target='_blank'>$url</a>。 ";
        $body .= "通过验证后，您将享受深红给您提供的各项服务.</p>";
        $body .= self::getEmailTips();
        if(!empty($extend_info)){
            $body .= $extend_info;
        }
        
        $postoffice = new Common_Model_Postoffice();
        $postoffice->receive($account,$subject,$body);
        
        unset($postoffice);
    }
    
    public static function sendOrderSuccessNotify($order_ref,$order_id){
    	//成功提交订单后，发送提醒邮件<异步进程处理>
    	$datetime = Common_Util_Date::getNow();
    	$to = array('lennon.wang@163.com');
    	$subject = "深红-订单提醒-[$order_ref]于 $datetime 已下单成功";
    	$url = Common_Util_Url::app_root_url()."/app/admin/orders/view/id/$order_id";
    	$body = "客户订单[$order_ref]于 $datetime 已成功下单，";
    	$body .= "<a href=".$url." target='_blank'>请及时查看处理～</a>。 ";
    	for($i=0;$i<count($to);$i++){
    		$sender = new Common_Model_Postoffice();
    		$sender->setIsNew(true);
    		$sender->setMailto($to[$i]);
    		$sender->setSubject($subject);
    		$sender->setBody($body);
    		$sender->setMailfrom('ideepred@gmail.com');
    		$sender->setFromName('ideepred');
    		$sender->setCreatedOn($datetime);
    		$sender->setState(Common_Model_Postoffice::DEFAULT_STATE);
    		self::warn("sendOrderSuccessNotify : ".$to[$i]);
    		$sender->save();
    	}
    }
    
    public static function sendPaymentSuccessNotify($order_id){
    	//成功提交订单后，发送提醒邮件<异步进程处理>
    	$datetime = Common_Util_Date::getNow();
    	$to = array('lennon.wang@163.com');
    	$subject = "深红-订单提醒[$order_id]于 $datetime 已支付成功";
    	$url = Common_Util_Url::app_root_url()."/app/admin/orders/view/id/$order_id";
    	$body = "客户订单[$order_id]于 $datetime 已成功成功，";
    	$body .= "<a href=".$url." target='_blank'>请及时查看处理～</a>。 ";
    	for($i=0;$i<count($to);$i++){
    		$sender = new Common_Model_Postoffice();
    		$sender->setIsNew(true);
    		$sender->setMailto($to[$i]);
    		$sender->setSubject($subject);
    		$sender->setBody($body);
    		$sender->setMailfrom('ideepred@gmail.com');
    		$sender->setFromName('ideepred');
    		$sender->setCreatedOn($datetime);
    		$sender->setState(Common_Model_Postoffice::DEFAULT_STATE);
    		self::warn("sendPaymentSuccessNotify : ".$to[$i]);
    		$sender->save();
    	}
    }
    
    /**
     * 获取email共用提示信息
     * 
     * @return string
     */
    public static function getEmailTips(){
        $tips = "<p>---------------------------------------------------------</p>";
        $tips .= "<p>本邮件由深红俱乐部自动发送，请勿直接回复.</p>";
        $tips .= "<p>如果您有任何疑问或建议，请<a href='http://www.ideepred.com' target='_blank'>联系我们</a></p>";
        $tips .= "<p>深红(<a href='http://www.ideepred.com' target='_blank'>www.ideepred.com</a>)</p>";
        
        return $tips;
    }
}
/**vim:sw=4 et ts=4 **/
?>