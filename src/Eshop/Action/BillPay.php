<?php
/**
 * 快钱支付接口类
 *
 * @author purpen
 * @version $Id$
 */
class Eshop_Action_BillPay extends Eshop_Action_Common {
    protected $_model_class='Common_Model_Orders';
    
    /**
     * 订单编号
     * 
     * @var string
     */
    private $_order_ref = null;
    /**
     * 提示信息
     * 
     * @var string
     */
    private $_msg = null;
    
    /************快钱配置参数******************/
    /**
     * 人民币网关账户号
     * 请登录快钱系统获取用户编号，用户编号后加01即为人民币网关账户号。
     * 
     * @var string
     */
    public $merchantAcctId = "1001723993401";
    /**
     * 人民币网关密钥
     * 区分大小写.请与快钱联系索取
     * 
     * @var string
     */
    public $key = "E875U39MJYYZK3ZM";
    /**
     * 字符集.固定选择值。可为空。只能选择1、2、3.默认值为1
     * 1代表UTF-8; 2代表GBK; 3代表gb2312
     * 
     * @var string
     */
    public $inputCharset = "1";
    /**
     * 服务器接受支付结果的后台地址.与[pageUrl]不能同时为空。必须是绝对地址。
     * 快钱通过服务器连接的方式将交易结果发送到[bgUrl]对应的页面地址，在商户处理完成后输出的<result>
     * 如果为1，页面会转向到<redirecturl>对应的地址。
     * 如果快钱未接收到<redirecturl>对应的地址，快钱将把支付结果GET到[pageUrl]对应的页面。
     * 
     * @var string
     */
    public $bgUrl = "/app/eshop/bill_pay/receive";
    /**
     * 网关版本.固定值
     * 快钱会根据版本号来调用对应的接口处理程序。
     * 本代码版本号固定为v2.0
     * 
     * @var string
     */
    public $version = "v2.0";
    /**
     * 语言种类.固定选择值。只能选择1、2、3
     * 1代表中文；2代表英文
     * 
     * @var int
     */
    public $language = "1";
    /**
     * 签名类型.固定值,1代表MD5签名,当前版本固定为1
     * 
     * @var string
     */
    public $signType = "1";
    /**
     * 支付人姓名,可为中文或英文字符
     * 
     * @var string
     */
    public $payerName = "guest";
    /**
     * 支付人联系方式类型.固定选择值
     * 只能选择1,1代表Email
     * 
     * @var int
     */
    public $payerContactType = "1";
    /**
     * 支付人联系方式,只能选择Email或手机号
     * 
     * @var string
     */
    public $payerContact = "";
    /**
     * 商户订单号,由字母、数字、或[-][_]组成
     * 
     * @var string
     */
    public $orderId = null;
    /**
     * 订单金额,以分为单位，必须是整型数字
     * 比方2，代表0.02元
     * 
     * @var float
     */
    public $orderAmount = "2";
    /**
     * 订单提交时间,14位数字。年[4位]月[2位]日[2位]时[2位]分[2位]秒[2位]
     * 如；20080101010101
     * 
     * @var datetime
     */
    public $orderTime = null;
    /**
     * 商品名称,可为中文或英文字符
     * 
     * @var string
     */
    public $productName = '创意产品';
    /**
     * 商品数量,可为空，非空时必须为数字
     * 
     * @var int
     */
    public $productNum = "1";
    /**
     * 商品代码,可为字符或者数字
     * 
     * @var string
     */
    public $productId = "";
    /**
     * 商品描述
     * 
     * @var string
     */
    public $productDesc = "";
    /**
     * 扩展字段1,在支付结束后原样返回给商户
     * 
     * @var string
     */
    public $ext1 = "";
    /**
     * 扩展字段2,在支付结束后原样返回给商户
     * 
     * @var string
     */
    public $ext2 = "";
    /**
     * 支付方式.固定选择值,只能选择00、10、11、12、13、14
     * 00：组合支付（网关支付页面显示快钱支持的各种支付方式，推荐使用）
     * 10：银行卡支付（网关支付页面只显示银行卡支付）.
     * 11：电话银行支付（网关支付页面只显示电话支付）.
     * 12：快钱账户支付（网关支付页面只显示快钱账户支付）.
     * 13：线下支付（网关支付页面只显示线下支付方式）
     * 
     * @var string
     */
    public $payType = "00";
    /**
     * 同一订单禁止重复提交标志,固定选择值： 1、0
     * 1代表同一订单号只允许提交1次；0表示同一订单号在没有支付成功的前提下可重复提交多次。默认为0建议实物购物车结算类商户采用0；虚拟产品类商户采用1;
     * 
     * @var string
     */
    public $redoFlag = "0";
    /**
     * 快钱的合作伙伴的账户号
     * 合作伙伴在快钱的用户编号,如未和快钱签订代理合作协议，不需要填写本参数
     * 
     * @var string
     */
    public $pid = "10017239934";
    /**
     * 将变量值不为空的参数组成字符串
     * 
     * @param string $returnStr
     * @param string $paramId
     * @param string $paramValue
     * @return string
     */
    public function appendParam($returnStr,$paramId,$paramValue){
        if($returnStr != ""){
            if($paramValue != ""){
                $returnStr .= "&".$paramId."=".$paramValue;
            }
        }else{
            if($paramValue != ""){
                $returnStr = $paramId."=".$paramValue;
            }
        }
        return $returnStr;
    }
    /**
     * 生成加密签名串
     * 
     * @return string
     */
    public function getBillSignMsg(){
        $signMsgVal=$this->appendParam($signMsgVal,"inputCharset",$this->inputCharset);

        $signMsgVal=$this->appendParam($signMsgVal,"bgUrl",$this->bgUrl);

        $signMsgVal=$this->appendParam($signMsgVal,"version",$this->version);

        $signMsgVal=$this->appendParam($signMsgVal,"language",$this->language);

        $signMsgVal=$this->appendParam($signMsgVal,"signType",$this->signType);

        $signMsgVal=$this->appendParam($signMsgVal,"merchantAcctId",$this->merchantAcctId);

        $signMsgVal=$this->appendParam($signMsgVal,"payerName",$this->payerName);

        $signMsgVal=$this->appendParam($signMsgVal,"payerContactType",$this->payerContactType);

        $signMsgVal=$this->appendParam($signMsgVal,"payerContact",$this->payerContact);

        $signMsgVal=$this->appendParam($signMsgVal,"orderId",$this->orderId);

        $signMsgVal=$this->appendParam($signMsgVal,"orderAmount",$this->orderAmount);

        $signMsgVal=$this->appendParam($signMsgVal,"orderTime",$this->orderTime);

        $signMsgVal=$this->appendParam($signMsgVal,"productName",$this->productName);

        $signMsgVal=$this->appendParam($signMsgVal,"productNum",$this->productNum);

        $signMsgVal=$this->appendParam($signMsgVal,"productId",$this->productId);

        $signMsgVal=$this->appendParam($signMsgVal,"productDesc",$this->productDesc);

        $signMsgVal=$this->appendParam($signMsgVal,"ext1",$this->ext1);

        $signMsgVal=$this->appendParam($signMsgVal,"ext2",$this->ext2);

        $signMsgVal=$this->appendParam($signMsgVal,"payType",$this->payType);    

        $signMsgVal=$this->appendParam($signMsgVal,"redoFlag",$this->redoFlag);

        $signMsgVal=$this->appendParam($signMsgVal,"pid",$this->pid);

        $signMsgVal=$this->appendParam($signMsgVal,"key",$this->key);

        $signMsg= strtoupper(md5($signMsgVal));
        
        return $signMsg;
    }
    /**
     * 
     * @return Common_Model_Orders
     */
    public function wiredModel(){
        return parent::wiredModel();
    }
    //~~~~~~~~~~~~~~Action implements~~~~~~~~~~
    /**
     * default action method
     */
    public function execute(){
        return $this->payment();   
    }
    
    /**
     * 选定快钱进行支付
     * 
     * @return string
     */
    public function payment(){
        $reference = $this->getOrderRef();
        if(empty($reference)){
            return $this->_hintResult('操作不当，订单号丢失！',true);
        }
        $model = new Common_Model_Orders();
        $options = array(
            'condition'=>'reference=?',
            'vars'=>array($reference)
        );
        $model->findFirst($options);
        if(!$model->count()){
            return $this->_hintResult('很抱歉，系统不存在该订单！',true);
        }
        $status = $model['status'];
        //验证此订单是否已经付款
        if($status != Common_Model_Constant::ORDER_WAIT_PAYMENT){
            return $this->_hintResult("订单[$reference]已付款！",false);
        }
        //start to pay
        $pay_money = $model['pay_money']*100; //输入以分为单位的金额
        $pay_time = Common_Util_Date::mkTimestamp($model['created_on']);
        //设置参数
        $this->orderId = $reference;
        $this->orderAmount = $pay_money;
        $this->orderTime = date('YmdHis',$pay_time);
        
        $signMsg = $this->getBillSignMsg();
        
        $this->putContext('inputCharset',$this->inputCharset);
        $this->putContext('bgUrl',$this->bgUrl);
        $this->putContext('version',$this->version);
        $this->putContext('language',$this->language);
        $this->putContext('signType',$this->signType);
        $this->putContext('signMsg',$signMsg);
        $this->putContext('merchantAcctId',$this->merchantAcctId);
        $this->putContext('payerName',$this->payerName);
        $this->putContext('payerContactType',$this->payerContactType);
        $this->putContext('payerContact',$this->payerContact);
        $this->putContext('productName',$this->productName);
        $this->putContext('productNum',$this->productNum);
        $this->putContext('productId',$this->productId);
        $this->putContext('productDesc',$this->productDesc);
        $this->putContext('ext1',$this->ext1);
        $this->putContext('ext2',$this->ext2);
        $this->putContext('payType',$this->payType);
        $this->putContext('redoFlag', $this->redoFlag);
        $this->putContext('pid',$this->pid);
        
        $this->putContext('orderId',$reference);
        $this->putContext('orderAmount', $pay_money);
        $this->putContext('orderTime', $this->orderTime);
        
        return $this->smartyResult('eshop.shopping.billpay');
    }
    
    /**
     * 快钱支付接受结果
     * 
     * @return string
     */
    public function receive(){
        //获取人民币网关账户号
        $merchantAcctId = $this->getMerchantAcctId();
        //设置人民币网关密钥
        //区分大小写
        $key = $this->key;
        //获取网关版本.固定值
        ///快钱会根据版本号来调用对应的接口处理程序。
        ///本代码版本号固定为v2.0
        $version = $this->getVersion();
        //获取语言种类.固定选择值。
        ///只能选择1、2、3
        ///1代表中文；2代表英文
        ///默认值为1
        $language = $this->getlanguage();
        //签名类型.固定值
        ///1代表MD5签名
        ///当前版本固定为1
        $signType = $this->getSignType();
        //获取支付方式
        $payType = $this->getPayType();
        //获取银行代码
        $bankId = $this->getBankId();
        
        //获取商户订单号
        $orderId = $this->getOrderId();
        //获取订单提交时间
        $orderTime = $this->getOrderTime();
        //获取原始订单金额
        $orderAmount = $this->getOrderAmount();
        
        //获取快钱交易号
        $dealId = $this->getDealId();
        //获取银行交易号
        ///如果使用银行卡支付时，在银行的交易号。如不是通过银行支付，则为空
        $bankDealId = $this->getBankDealId();
        //获取在快钱交易时间
        $dealTime = $this->getDealTime();
        
        //获取实际支付金额
        $payAmount = $this->getPayAmount();
        //获取交易手续费,单位为分
        $fee = $this->getFee();
        
        //获取扩展字段1
        $ext1 = $this->getExt1();
        //获取扩展字段2
        $ext2 = $this->getExt2();
        
        //获取处理结果
        ///10代表 成功; 11代表 失败
        $payResult = $this->getPayResult();
        //获取错误代码
        $errCode = $this->getErrCode();
        
        //获取加密签名串
        $signMsg = $this->getSignMsg();
        
        //生成加密串。必须保持如下顺序。
        $merchantSignMsgVal = $this->appendParam($merchantSignMsgVal,"merchantAcctId",$merchantAcctId);
        $merchantSignMsgVal = $this->appendParam($merchantSignMsgVal,"version",$version);
        $merchantSignMsgVal = $this->appendParam($merchantSignMsgVal,"language",$language);
        $merchantSignMsgVal = $this->appendParam($merchantSignMsgVal,"signType",$signType);
        $merchantSignMsgVal = $this->appendParam($merchantSignMsgVal,"payType",$payType);
        $merchantSignMsgVal = $this->appendParam($merchantSignMsgVal,"bankId",$bankId);
        $merchantSignMsgVal = $this->appendParam($merchantSignMsgVal,"orderId",$orderId);
        $merchantSignMsgVal = $this->appendParam($merchantSignMsgVal,"orderTime",$orderTime);
        $merchantSignMsgVal = $this->appendParam($merchantSignMsgVal,"orderAmount",$orderAmount);
        $merchantSignMsgVal = $this->appendParam($merchantSignMsgVal,"dealId",$dealId);
        $merchantSignMsgVal = $this->appendParam($merchantSignMsgVal,"bankDealId",$bankDealId);
        $merchantSignMsgVal = $this->appendParam($merchantSignMsgVal,"dealTime",$dealTime);
        $merchantSignMsgVal = $this->appendParam($merchantSignMsgVal,"payAmount",$payAmount);
        $merchantSignMsgVal = $this->appendParam($merchantSignMsgVal,"fee",$fee);
        $merchantSignMsgVal = $this->appendParam($merchantSignMsgVal,"ext1",$ext1);
        $merchantSignMsgVal = $this->appendParam($merchantSignMsgVal,"ext2",$ext2);
        $merchantSignMsgVal = $this->appendParam($merchantSignMsgVal,"payResult",$payResult);
        $merchantSignMsgVal = $this->appendParam($merchantSignMsgVal,"errCode",$errCode);
        $merchantSignMsgVal = $this->appendParam($merchantSignMsgVal,"key",$key);
        $merchantSignMsg = md5($merchantSignMsgVal);
        
        //初始化结果及地址
        $rtnOk = 0;
        $rtnUrl = "";
        
        //进行数据处理，并跳转回显示支付结果的页面
        //首先进行签名字符串验证
        self::debug("Get signMsg[$signMsg] and build signMsg[$merchantSignMsg].", __METHOD__);
        if(strtoupper($signMsg) == strtoupper($merchantSignMsg)){
            switch($payResult){
                case "10":
                    $rtnOk = 1;
                    $msg = "";
                    try{
                        //注意：只有strtoupper($signMsg)==strtoupper($merchantSignMsg)，且payResult=10，才表示支付成功！
                        //同时将订单金额与提交订单前的订单金额进行对比校验。
                        $order = new Common_Model_Orders();
                        $options = array(
                           'condition'=>'reference=?',
                           'vars'=>array($orderId)
                        );
                        $order->findFirst($options);
                        
                        if($order->count()){
                            $_id = $order['id'];
                            $pay_money = $order['pay_money'];
                            $status = $order['status'];
                            //验证此订单是否已经付款
                            if($status < Common_Model_Constant::ORDER_READY_GOODS){
                                //设置订单状态为已配货中
                                $order->setReadyGoods($_id);
                                self::debug("更新订单状态完成。",__METHOD__);
                            }else{
                                self::warn("此订单[$orderId]已支付成功！",__METHOD__);
                            }
                            
                        }else{
                            $msg = "此订单号[$orderId]不存在!";
                            self::warn("此订单号[$orderId]不存在!",__METHOD__);
                        }
                        unset($order);
                        
                    }catch(Anole_ActiveRecord_Exception $e){
                        self::warn("Update Order Status Error:".$e->getMessage(), __METHOD__);
                        $msg = $e->getMessage();
                    }catch(Anole_Exception $e){
                        self::warn("Set Order Status Exception:".$e->getMessage(), __METHOD__);
                        $msg = $e->getMessage();
                    }
                    $rtnUrl = Common_Util_Url::billBackShow($orderId,$payAmount,$msg);
                    break;
                default:
                    $rtnOk = 1;
                    $msg = "支付标识[$payResult]不匹配。";
                    $rtnUrl = Common_Util_Url::billBackShow($orderId,$payAmount,$msg);
                    break;
            }
        }else{
            self::warn("签名字符串验证不正确。", __METHOD__);
            $rtnOk = 1;
            $msg = "签名字符串验证不正确。";
            $rtnUrl = Common_Util_Url::billBackShow($orderId,$payAmount,$msg);
        }
        
        //报告处理结果
        $report = "<result>$rtnOk</result><redirecturl>$rtnUrl</redirecturl>";
        
        return $this->rawResult($report);
    }
    /**
     * 显示支付结果
     * 
     * @return string
     */
    public function show(){
        $order_ref = $this->getOrderRef();
        $payAmount = $this->getPayAmount()/100;
        $msg = $this->getMsg();
        
        $this->putContext('payAmount', $payAmount);
        $this->putContext('order_ref', $order_ref);
        $this->putContext('msg', $msg);
        
        return $this->smartyResult('eshop.shopping.pay_result');
    }
    
    /*****************辅助set/get方法**********************/
    public function setOrderRef($ref){
        $this->_order_ref = $ref;
        return $this;   
    }
    public function getOrderRef(){
        return $this->_order_ref;
    }
    
    public function setMerchantAcctId($merchantAcctId){
        $this->merchantAcctId = trim($merchantAcctId);
        return $this;
    }
    public function getMerchantAcctId(){
        return $this->merchantAcctId;
    }
    
    public function setVersion($v){
        $this->version = trim($v);
        return $this;
    }
    public function getVersion(){
        return $this->version;
    }
    
    public function setLanguage($v){
        $this->language = trim($v);
        return $this;
    }
    public function getlanguage(){
        return $this->language;
    }
    
    public function setSignType($v){
        $this->signType = trim($v);
        return $this;
    }
    public function getSignType(){
        return $this->signType;
    }
    
    public function setPayType($v){
        $this->payType = trim($v);
        return $this;
    }
    public function getPayType(){
        return $this->payType;
    }
    
    public function setBankId($v){
        $this->bankId = trim($v);
        return $this;
    }
    public function getBankId(){
        return $this->bankId;
    }
    
    public function setOrderId($v){
        $this->orderId = trim($v);
        return $this;
    }
    public function getOrderId(){
        return $this->orderId;  
    }
    
    public function setOrderTime($v){
        $this->orderTime = trim($v);
        return $this;
    }
    public function getOrderTime(){
        return $this->orderTime;
    }
    
    public function setOrderAmount($v){
        $this->orderAmount = trim($v);
        return $this;
    }
    public function getOrderAmount(){
        return $this->orderAmount;
    }
    
    public function setDealId($v){
        $this->dealId = trim($v);
        return $this;
    }
    public function getDealId(){
        return $this->dealId;
    }
    
    public function setBankDealId($v){
        $this->bankDealId = trim($v);
        return $this;
    }
    public function getBankDealId(){
        return $this->bankDealId;
    }
    
    public function setDealTime($v){
        $this->dealTime = trim($v);
        return $this;
    }
    public function getDealTime(){
        return $this->dealTime;
    }
    
    public function setPayAmount($payAmount){
        $this->payAmount = trim($payAmount);
        return $this;
    }
    public function getPayAmount(){
        return $this->payAmount;
    }
    
    public function setFee($v){
        $this->fee = trim($v);
        return $this;
    }
    public function getFee(){
        return $this->fee;
    }
    
    public function setExt1($v){
        $this->ext1 = trim($v);
        return $this;
    }
    public function getExt1(){
        return $this->ext1;
    }
    
    public function setExt2($v){
        $this->ext2 = trim($v);
        return $this;
    }
    public function getExt2(){
        return $this->ext2;
    }
    
    public function setPayResult($v){
        $this->payResult = trim($v);
        return $this;
    }
    public function getPayResult(){
        return $this->payResult;
    }
    
    public function setErrCode($v){
        $this->errCode = trim($v);
        return $this;
    }
    public function getErrCode(){
        return $this->errCode;
    }
    
    public function setSignMsg($v){
        $this->signMsg = trim($v);
        return $this;
    }
    public function getSignMsg(){
        return $this->signMsg;
    }
    
    public function setMsg($v){
        $this->_msg = $v;
        return $this;
    }
    public function getMsg(){
        return $this->_msg;
    }
}
/**vim:sw=4 et ts=4 **/
?>