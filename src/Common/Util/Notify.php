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
        $subject = "艺柏家购物提醒【注册确认】";
        $url = Common_Util_Url::app_root_url()."/app/eshop/profile/activate_email?activation=$activation";
        
        $body  = "<h3>亲爱的 $account ,欢迎加入艺柏家！</h3> <p>你可以在浏览器中输入或复制下列地址来激活: ";
        $body .= "<a href=".$url." target='_blank'>$url</a>。 ";
        $body .= "通过验证后，您将享受艺柏家给您提供的各项服务.</p>";
        $body .= self::getEmailTips();
        if(!empty($extend_info)){
            $body .= $extend_info;
        }
        
        $postoffice = new Common_Model_Postoffice();
        $postoffice->receive($account,$subject,$body);
        
        unset($postoffice);
    }
    
    /**
     * 获取email共用提示信息
     * 
     * @return string
     */
    public static function getEmailTips(){
        $tips = "<p>---------------------------------------------------------</p>";
        $tips .= "<p>本邮件由艺柏家系统自动发送，请勿直接回复.</p>";
        $tips .= "<p>如果您有任何疑问或建议，请<a href='http://www.100jia.cc' target='_blank'>联系我们</a></p>";
        $tips .= "<p>艺柏家(<a href='http://www.100jia.cc' target='_blank'>www.100jia.cc</a>)-创意百分百 生活艺柏家 </p>";
        
        return $tips;
    }
}
/**vim:sw=4 et ts=4 **/
?>