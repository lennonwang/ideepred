<?php
/**
 * 用户对产品评分、评价
 *
 * @version $Id$
 * @author purpen
 */
class Eshop_Action_Ratings extends Eshop_Action_Common {
    protected $_model_class='Common_Model_Ratings';
    
    private $_rate = null;
    /**
     * 
     * @return Common_Model_Ratings
     */
    public function wiredModel(){
        return parent::wiredModel();
    }
    //~~~~~~~~~~~~~~Action implements~~~~~~~~~~
    /**
     * default action method
     */
    public function execute(){
        return $this->postrating();
    }
    
    /**
     * 产品评分
     * 
     * @return string
     */
    public function postrating(){
        $rating = $this->wiredModel();
        
        $target_id = $this->getId();
        $rate = $this->getRate();
        
        //获取产品名称
        if(!empty($target_id)){
            $product = new Common_Model_Product();
            $product->findById($id,$options=array('select'=>'id,title'));
            $target_title = $product['title'];
        }
        $ip = $this->getContext()->getRequest()->getClientIp();
        try{
            $rating->setIsNew(true);
            $rating->setId(null);
            $rating->setTargetId($target_id);
            $rating->setTargetTitle($target_title);
            $rating->setPoint($rate);
            $rating->setIp($ip);
            
            $rating->save();
            
            //计算平均分
            $options = array(
                'select'=>'sum(point) as total_point,count(*) as total_people',
                'condition'=>'target_id=?',
                'vars'=>array($target_id)
            );
            $rate = $rating->findFirst($options);
            if(!empty($rate)){
                $rate_people = $rate['total_people'];
                $rate_avg = sprintf('%.1f',(float)$rate['total_point']/$rate_people);
            }
            $rate_max = range(1,5);
        }catch(Anole_ActiveRecord_Exception $e){
        	$msg = 'Rating for the product is failing.'.$e->getMessage();
            self::warn($msg, __METHOD__);
            return $this->_jqErrorTip($msg);
        }
        
        $this->putContext('rate_max', $rate_max);
        $this->putContext('rate_avg', $rate_avg);
        $this->putContext('rate_avg_ceil', ceil($rate_avg));
        $this->putContext('rate_people', $rate_people);
        $this->putContext('target_id', $target_id);
        
        
        return $this->jQueryResult('eshop.common.rating_ok');
    }
    
    public function setRate($v){
    	$this->_rate=$v;
    	return $this;
    }
    public function getRate(){
    	return $this->_rate;
    }
}
/**vim:sw=4 et ts=4 **/
?>