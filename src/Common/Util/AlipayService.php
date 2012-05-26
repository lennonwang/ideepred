<?php
class Common_Util_AlipayService extends Anole_Object {
	public $aliapy_config;
	/**
	 *支付宝网关地址（新）
	 */
	public $alipay_gateway_new = 'https://mapi.alipay.com/gateway.do?';

	public function __construct($aliapy_config){
		$this->aliapy_config = $aliapy_config;
	}
    public function AlipayService($aliapy_config) {
    	$this->__construct($aliapy_config);
    }
	/**
     * 构造担保交易接口
     * @param $para_temp 请求参数数组
     * @return 表单提交HTML信息
     */
	public function create_partner_trade_by_buyer($para_temp) {
		//设置按钮名称
		#$button_name = "确认";
		//生成表单提交HTML文本信息
		#$html_text = $this->buildForm($para_temp, $this->alipay_gateway_new, "get", $button_name,$this->aliapy_config);

		#return $html_text;
		return $this->buildUrl($para_temp, $this->alipay_gateway_new, "get", $button_name,$this->aliapy_config);
	}
	
	/**
     * 用于防钓鱼，调用接口query_timestamp来获取时间戳的处理函数
	 * 注意：该功能PHP5环境及以上支持，因此必须服务器、本地电脑中装有支持DOMDocument、SSL的PHP配置环境。建议本地调试时使用PHP开发软件
     * return 时间戳字符串
	 */
	public function query_timestamp() {
		$url = $this->alipay_gateway_new."service=query_timestamp&partner=".trim($this->aliapy_config['partner']);
		$encrypt_key = "";

		$doc = new DOMDocument();
		$doc->load($url);
		$itemEncrypt_key = $doc->getElementsByTagName( "encrypt_key" );
		$encrypt_key = $itemEncrypt_key->item(0)->nodeValue;
		
		return $encrypt_key;
	}
	
	/**
     * 构造支付宝其他接口
     * @param $para_temp 请求参数数组
     * @return 表单提交HTML信息/支付宝返回XML处理结果
     */
	public function alipay_interface($para_temp) {
		//获取远程数据
		$html_text = "";
		//请根据不同的接口特性，选择一种请求方式
		//1.构造表单提交HTML数据:（$method可赋值为get或post）
		//$this->buildForm($para_temp, $this->alipay_gateway, "get", $button_name,$this->aliapy_config);
		//2.构造模拟远程HTTP的POST请求，获取支付宝的返回XML处理结果:
		//注意：若要使用远程HTTP获取数据，必须开通SSL服务，该服务请找到php.ini配置文件设置开启，建议与您的网络管理员联系解决。
		//$this->sendPostInfo($para_temp, $this->alipay_gateway, $this->aliapy_config);
		
		return $html_text;
	}
	
	/*-----------------------------------AlipaySubmit---------------------------/
	/**
     * 生成要请求给支付宝的参数数组
     * @param $para_temp 请求前的参数数组
     * @param $aliapy_config 基本配置信息数组
     * @return 要请求的参数数组
     */
	public function buildRequestPara($para_temp,$aliapy_config) {
		//除去待签名参数数组中的空值和签名参数
		$para_filter = $this->paraFilter($para_temp);

		//对待签名参数数组排序
		$para_sort = $this->argSort($para_filter);

		//生成签名结果
		$mysign = $this->buildMysign($para_sort, trim($aliapy_config['key']), strtoupper(trim($aliapy_config['sign_type'])));
		
		//签名结果与签名方式加入请求提交参数组中
		$para_sort['sign'] = $mysign;
		$para_sort['sign_type'] = strtoupper(trim($aliapy_config['sign_type']));
		
		return $para_sort;
	}

	/**
     * 生成要请求给支付宝的参数数组
     * @param $para_temp 请求前的参数数组
	 * @param $aliapy_config 基本配置信息数组
     * @return 要请求的参数数组字符串
     */
	public function buildRequestParaToString($para_temp,$aliapy_config) {
		//待请求参数数组
		$para = $this->buildRequestPara($para_temp,$aliapy_config);
		
		//把参数组中所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串
		$request_data = $this->createLinkstring($para);
		
		return $request_data;
	}
	
	/**
     * 实现多种字符编码方式
     * 
     * @param string $input
     * @param string $_output_charset
     * @param string $_input_charset
     * @return string
     */
    public function charset_encode($input,$_output_charset,$_input_charset ="utf-8"){
        $output = "";
        if(!isset($_output_charset)){
            $_output_charset = $this->aliapy_config['input_charset'];
        }
        if($_input_charset == $_output_charset || $input == null){
            $output = $input;
        }elseif(function_exists("mb_convert_encoding")){
            $output = mb_convert_encoding($input,$_output_charset,$_input_charset);
        }elseif(function_exists("iconv")){
            $output = iconv($_input_charset,$_output_charset,$input);
        }else{
            die("Sorry,you have no libs support for charset change.");
        }
        return $output;
    }
	
	public function buildUrl($para_temp, $gateway, $method, $button_name, $aliapy_config){
		$base_url = $gateway."_input_charset=".trim(strtolower($aliapy_config['input_charset']));
		//待请求参数数组
		$para = $this->buildRequestPara($para_temp,$aliapy_config);
		while (list ($key, $val) = each ($para)) {
            $sHtml[] = $key.'='.urlencode($this->charset_encode($val,$aliapy_config['input_charset']));
        }
		$base_url .= '&'.implode('&',$sHtml); 
		return $base_url;
	}
    /**
     * 构造提交表单HTML数据
     * @param $para_temp 请求参数数组
     * @param $gateway 网关地址
     * @param $method 提交方式。两个值可选：post、get
     * @param $button_name 确认按钮显示文字
     * @return 提交表单HTML文本
     */
	public function buildForm($para_temp, $gateway, $method, $button_name, $aliapy_config) {
		//待请求参数数组
		$para = $this->buildRequestPara($para_temp,$aliapy_config);
		
		$sHtml = "<form id='alipaysubmit' name='alipaysubmit' action='".$gateway."_input_charset=".trim(strtolower($aliapy_config['input_charset']))."' method='".$method."'>";
		while (list ($key, $val) = each ($para)) {
            $sHtml.= "<input type='hidden' name='".$key."' value='".$val."'/>";
        }

		//submit按钮控件请不要含有name属性
        $sHtml = $sHtml."<input type='submit' value='".$button_name."' style='display:none;'></form>";
		
		$sHtml = $sHtml."<script>document.forms['alipaysubmit'].submit();</script>";
		
		return $sHtml;
	}
	
	/**
     * 构造模拟远程HTTP的POST请求，获取支付宝的返回XML处理结果
	 * 注意：该功能PHP5环境及以上支持，因此必须服务器、本地电脑中装有支持DOMDocument、SSL的PHP配置环境。建议本地调试时使用PHP开发软件
     * @param $para_temp 请求参数数组
     * @param $gateway 网关地址
	 * @param $aliapy_config 基本配置信息数组
     * @return 支付宝返回XML处理结果
     */
	public function sendPostInfo($para_temp, $gateway, $aliapy_config) {
		$xml_str = '';
		
		//待请求参数数组字符串
		$request_data = $this->buildRequestParaToString($para_temp,$aliapy_config);
		//请求的url完整链接
		$url = $gateway . $request_data;
		//远程获取数据
		$xml_data = $this->getHttpResponse($url,trim(strtolower($aliapy_config['input_charset'])));
		//解析XML
		$doc = new DOMDocument();
		$doc->loadXML($xml_data);

		return $doc;
	}
	
	
	/*-------------------------------alipay_core_function----------------------------*/
	/**
	 * 生成签名结果
	 * @param $sort_para 要签名的数组
	 * @param $key 支付宝交易安全校验码
	 * @param $sign_type 签名类型 默认值：MD5
	 * return 签名结果字符串
	 */
	public function buildMysign($sort_para,$key,$sign_type = "MD5") {
		//把数组所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串
		$prestr = $this->createLinkstring($sort_para);
		//把拼接后的字符串再与安全校验码直接连接起来
		$prestr = $prestr.$key;
		//把最终的字符串签名，获得签名结果
		$mysgin = $this->sign($prestr,$sign_type);
		return $mysgin;
	}
	/**
	 * 把数组所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串
	 * @param $para 需要拼接的数组
	 * return 拼接完成以后的字符串
	 */
	public function createLinkstring($para) {
		$arg  = "";
		while (list ($key, $val) = each ($para)) {
			$arg.=$key."=".$val."&";
		}
		//去掉最后一个&字符
		$arg = substr($arg,0,count($arg)-2);

		//如果存在转义字符，那么去掉转义
		if(get_magic_quotes_gpc()){$arg = stripslashes($arg);}

		return $arg;
	}
	/**
	 * 除去数组中的空值和签名参数
	 * @param $para 签名参数组
	 * return 去掉空值与签名参数后的新签名参数组
	 */
	public function paraFilter($para) {
		$para_filter = array();
		while (list ($key, $val) = each ($para)) {
			if($key == "sign" || $key == "sign_type" || $val == "")continue;
			else	$para_filter[$key] = $para[$key];
		}
		return $para_filter;
	}
	/**
	 * 对数组排序
	 * @param $para 排序前的数组
	 * return 排序后的数组
	 */
	public function argSort($para) {
		ksort($para);
		reset($para);
		return $para;
	}
	/**
	 * 签名字符串
	 * @param $prestr 需要签名的字符串
	 * @param $sign_type 签名类型 默认值：MD5
	 * return 签名结果
	 */
	public function sign($prestr,$sign_type='MD5') {
		$sign='';
		if($sign_type == 'MD5') {
			$sign = md5($prestr);
		}elseif($sign_type =='DSA') {
			//DSA 签名方法待后续开发
			die("DSA 签名方法待后续开发，请先使用MD5签名方式");
		}else {
			die("支付宝暂不支持".$sign_type."类型的签名方式");
		}
		return $sign;
	}
	/**
	 * 写日志，方便测试（看网站需求，也可以改成把记录存入数据库）
	 * 注意：服务器需要开通fopen配置
	 * @param $word 要写入日志里的文本内容 默认值：空值
	 */
	public function logResult($word='') {
		$fp = fopen("log.txt","a");
		flock($fp, LOCK_EX) ;
		fwrite($fp,"执行日期：".strftime("%Y%m%d%H%M%S",time())."\n".$word."\n");
		flock($fp, LOCK_UN);
		fclose($fp);
	}

	/**
	 * 远程获取数据
	 * 注意：该函数的功能可以用curl来实现和代替。curl需自行编写。
	 * $url 指定URL完整路径地址
	 * @param $input_charset 编码格式。默认值：空值
	 * @param $time_out 超时时间。默认值：60
	 * return 远程输出的数据
	 */
	public function getHttpResponse($url, $input_charset = '', $time_out = "60") {
		$urlarr     = parse_url($url);
		$errno      = "";
		$errstr     = "";
		$transports = "";
		$responseText = "";
		if($urlarr["scheme"] == "https") {
			$transports = "ssl://";
			$urlarr["port"] = "443";
		} else {
			$transports = "tcp://";
			$urlarr["port"] = "80";
		}
		$fp=@fsockopen($transports . $urlarr['host'],$urlarr['port'],$errno,$errstr,$time_out);
		if(!$fp) {
			die("ERROR: $errno - $errstr<br />\n");
		} else {
			if (trim($input_charset) == '') {
				fputs($fp, "POST ".$urlarr["path"]." HTTP/1.1\r\n");
			}
			else {
				fputs($fp, "POST ".$urlarr["path"].'?_input_charset='.$input_charset." HTTP/1.1\r\n");
			}
			fputs($fp, "Host: ".$urlarr["host"]."\r\n");
			fputs($fp, "Content-type: application/x-www-form-urlencoded\r\n");
			fputs($fp, "Content-length: ".strlen($urlarr["query"])."\r\n");
			fputs($fp, "Connection: close\r\n\r\n");
			fputs($fp, $urlarr["query"] . "\r\n\r\n");
			while(!feof($fp)) {
				$responseText .= @fgets($fp, 1024);
			}
			fclose($fp);
			$responseText = trim(stristr($responseText,"\r\n\r\n"),"\r\n");

			return $responseText;
		}
	}
	/**
	 * 实现多种字符编码方式
	 * @param $input 需要编码的字符串
	 * @param $_output_charset 输出的编码格式
	 * @param $_input_charset 输入的编码格式
	 * return 编码后的字符串
	 */
	public function charsetEncode($input,$_output_charset ,$_input_charset) {
		$output = "";
		if(!isset($_output_charset) )$_output_charset  = $_input_charset;
		if($_input_charset == $_output_charset || $input ==null ) {
			$output = $input;
		} elseif (function_exists("mb_convert_encoding")) {
			$output = mb_convert_encoding($input,$_output_charset,$_input_charset);
		} elseif(function_exists("iconv")) {
			$output = iconv($_input_charset,$_output_charset,$input);
		} else die("sorry, you have no libs support for charset change.");
		return $output;
	}
	/**
	 * 实现多种字符解码方式
	 * @param $input 需要解码的字符串
	 * @param $_output_charset 输出的解码格式
	 * @param $_input_charset 输入的解码格式
	 * return 解码后的字符串
	 */
	public function charsetDecode($input,$_input_charset ,$_output_charset) {
		$output = "";
		if(!isset($_input_charset) )$_input_charset  = $_input_charset ;
		if($_input_charset == $_output_charset || $input ==null ) {
			$output = $input;
		} elseif (function_exists("mb_convert_encoding")) {
			$output = mb_convert_encoding($input,$_output_charset,$_input_charset);
		} elseif(function_exists("iconv")) {
			$output = iconv($_input_charset,$_output_charset,$input);
		} else die("sorry, you have no libs support for charset changes.");
		return $output;
	}
}
?>