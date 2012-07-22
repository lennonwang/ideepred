<?php
/**
 * 帮助中心
 * 对应数据表 content
 * @version $Id$
 * @author purpen
 */
class Eshop_Action_Helper extends Eshop_Action_Common {
    protected $_model_class='Common_Model_Content';
    
	private $_name = null;
    /**
     * 
     * @return Common_Model_Comment
     */
    public function wiredModel(){
        return parent::wiredModel();
    }
    //~~~~~~~~~~~~~~Action implements~~~~~~~~~~
    /**
     * default action method
     */
    public function execute(){
		$name = $this->getName();
		if(empty($name)){
			$msg = '非常抱歉，您请求的页面不存在或已被删除！';
			return $this->_hintResult($msg,true);
		}
		$model = $this->wiredModel();
		$options = array(
			'condition'=>'name=?',
			'vars'=>array($name)
		);
		$row = $model->findFirst($options)->getResultArray();
		
		$this->putContext('hpage', $row);
		$this->putContext('hpage_body', $row['body']);
		
		$this->putSharedParam();
		
        return $this->smartyResult('eshop.help.detail');
    }
	/**
	 * 公司介绍
	 */
	public function introduce(){
		$name = $this->getName();
		if(empty($name)){
			$msg = '非常抱歉，您请求的页面不存在或已被删除！';
			return $this->_hintResult($msg,true);
		}
		$model = $this->wiredModel();
		$options = array(
			'condition'=>'name=?',
			'vars'=>array($name)
		);
		$row = $model->findFirst($options)->getResultArray();
		
		$this->putContext('hpage', $row);
		$this->putContext('hpage_body', $row['body']);
		
		$this->putSharedParam();
		
		return $this->smartyResult('eshop.company');
	}
	/**
	 * 输出文本格式
	 */
	public function shtm($design_str){
		$str = trim($design_str); // 取得字串同时去掉头尾空格和空回车
		//$str=str_replace("<br>","",$str); // 去掉<br>标签
		//$str="<p>".trim($str); // 在文本头加入<p>
		$str = str_replace("\r\n","<br>",$str); // 用p标签取代换行符
		//$str.="</p>\n"; // 文本尾加入</p>
		$str = str_replace("<p></p>","",$str); // 去除空段落
		$str = str_replace("\n","",$str); // 去掉空行并连成一行
		$str = str_replace("</p>","</p>\n",$str); //整理html代码
		return $str;
	}

    public function setName($v){
		$this->_name = $v;
		return $this;
	}
	public function getName(){
		return $this->_name;
	}

}
/**vim:sw=4 et ts=4 **/
?>