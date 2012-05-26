<?php
/**
 * 用户交流，留言、评论、咨询、反馈等信息
 *
 * @version $Id$
 * @author purpen
 */
class Eshop_Action_Comment extends Eshop_Action_Common {
    protected $_model_class='Common_Model_Comment';
    
    private $_target_id = null;
    
    private $_type = 1;
    
    private $_user_id = null;
    
    private $_username = null;
    
    private $_content = null;
    
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
        return $this->doComment();
    }
    /**
     * 用户提交信息
     * @return string
     */
    public function doComment(){
        $model = $this->wiredModel();
        try{
        	$content = $this->getContent();
        	//过滤字符
        	$content = Common_Util_FilterCode::filtor($content);
            self::debug("post content[$content].", __METHOD__);
        	
            $model->setId(null);
            $model->setIsNew(true);
            $model->setContent($content);
            $model->save();
            
            $_id = $model->getId();
            
            $type = $this->getType();
            $target_id = $this->getTargetId();
            if($type == 1){
            	$comment_count = $model->countIf('target_id=? AND type=?', array($target_id,$type));
            }
            $comment = $model->findById($_id)->getResultArray();
            
        }catch(Anole_ActiveRecord_Exception $e){
        	$msg = "发表信息出错：".$e->getMessage();
            self::warn($msg,__METHOD__);
            return $this->_jqErrorTip($msg);   
        }
        
        $this->putContext('comment', $comment);
        $this->putContext('comment_count',$comment_count);
        
        return $this->jqueryResult('eshop.comment.post_ok');	
    }
    
    public function setTargetId($v){
        $this->_target_id = $v;
        return $this;
    }
    public function getTargetId(){
        return $this->_target_id;
    }
    
    public function setType($v){
        $this->_type = $v;
        return $this;
    }
    public function getType(){
        return $this->_type;
    }
    public function setUserId($v){
        $this->_user_id = $v;
        return $this;
    }
    public function getUserId(){
        return $this->_user_id;
    }
    public function setUsername($v){
        $this->_username = $v;
        return $this;
    }
    public function getUsername(){
        return $this->_username;
    }
    public function setContent($v){
        $this->_content = $v;
        return $this;
    }
    public function getContent(){
        return $this->_content;
    }
}
/**vim:sw=4 et ts=4 **/
?>