<?php
class Common_Util_Shop extends Anole_Object {
    
    const NUMBER_STRING = '1234567890';
    
    const LETTER_STRING = 'qwertyuiopasdfghjklzxcvbnm';
    
    public static function setOrderReference($v){
        Anole_Session_Context::getContext()->set('_XES_OREF_',$v);
    }
    
    public static function getOrderReference(){
        return Anole_Session_Context::getContext()->get('_XES_OREF_');
    }
    
    public static function clearOrderReference(){
        Anole_Session_Context::getContext()->set('_XES_OREF_',null);
    }
    
    /**
     * 获取代号代替的支付方式
     * 
     * @param string $key
     * @return string
     */
    public static function getPaymentMethodName($key){
        $payment_methods = array(
            'a'=>'在线支付',
            'b'=>'邮局汇款',
            'c'=>'货到付款'
        );
        return isset($payment_methods[$key]) ? $payment_methods[$key] : 'No Payment Method';
    }
    /**
     * 分割数量与型号描述
     * 
     * @param string $qunatity
     * @return array
     */
    public static function qtsexplode($qunatity){
        return explode('-', $qunatity);
    }
    /**
     * 根据一定的规则生产订单编号
     * 
     * @return sting
     */
    public static function _genOderReference(){
		$order = new Common_Model_Orders();
		$has_exist = true;
		while($has_exist){
			$order_code = date('ymd').self::_randString(4,self::NUMBER_STRING);
			if(!$order->countIf('reference=?',array($order_code))){
				$has_exist = false;
			    break;
			}
		}
		unset($order);
        return $order_code;
    }
    
    /**
     * 产生一个特定长度的字符串
     * 
     * @param int $len
     * @param string $chars
     * @return string
     */
    public static function _randString($len, $chars='higklmntusc0b1d2j3v4p5f6e7w8a9xyzoqr'){
        $string = '';
        for($i=0;$i<$len;$i++){
            $pos = rand(0, strlen($chars)-1);
            $string .= $chars{$pos};
        }
        return $string;
    }
}
?>