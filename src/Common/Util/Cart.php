<?php
/**
 * 购物车的工具类
 * 
 * 采用cookie的方式实现购物车的过程,cookie字符串记录产品的id与购买数量.
 * 
 * @author purpen
 * @version $Id$
 */
class Common_Util_Cart extends Anole_Object {
    
    const LIFE_TIME = 864000; //10day
    
    public $com_item=null;
    public $com_list=null;
    public $comlist_count=null;
    
    public function __construct(){
    	$this->com_item = 0;
    	$this->comlist_count = 0;
    	
    	$this->get();
    }
    /**
     * 将购买的商品设置到购物车cookie
     * 
     * @param $data
     * @return void
     */
    public function set(){
        
        $ttl = time()+self::LIFE_TIME;
        
        $value = $this->buildData();
        self::debug("Cart[$value]!", __METHOD__);
        $this->setCookie($value,$ttl);
    }
    /**
     * 获取购物车里的商品
     * 
     * @param bool $raw
     * @return mixed
     */
    public function get(){
        $data = $this->getCookie();
        self::debug("Cart[$data] from Cookie!", __METHOD__);
        $this->parseData($data);
    }
    /**
     * 清空购物车
     * 
     * @return void
     */
    public function emptyCart(){
        unset($this->com_item);
        unset($this->com_list);
        unset($this->comlist_count);
        
        $this->clearCookie();
    }
    /**
     * 清空cookie
     * 
     * @return void
     */
    public function clearCookie(){
        @setcookie('_ESHEOP_USER_CCK_','',time()-self::LIFE_TIME,'/');
    }
    /**
     * 设置cookie
     * 
     * @param string $key
     * @param string $value
     * @param $ttl
     * @return void
     */
    public function setCookie($value,$ttl){
         setcookie('_ESHEOP_USER_CCK_',$value,$ttl,'/');
    }
    /**
     * 获取cookie的值
     * 
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function getCookie($default=null){
        return isset($_COOKIE['_ESHEOP_USER_CCK_']) ? $_COOKIE['_ESHEOP_USER_CCK_'] : $default;
    }
    
    /**
     * 将数组转化成字符串
     * 
     * @param $data
     * @return string
     */
    public function buildData(){
        $result = array();
        if(empty($this->com_list)){
        	return;
        }
        foreach($this->com_list as $item){
        	$result[] = "{$item['sku']},{$item['size']},{$item['quantity']}";
        }
        //购物车商品数不能超过100个
        if(count($result) > 100){
        	array_splice($result,-100);
        }
        return implode('[]',$result);
    }
    /**
     * 将字符串转化成数组
     * 
     * @param $data
     * @return array
     */
    public function parseData($data){
        if(!empty($data)){
            $result = explode('[]',$data);
            
            for($i=0;$i<count($result);$i++){
                $item = $result[$i];
                list($com_sku,$com_size,$com_num) = explode(",",$item);
                if(!empty($com_sku) && !empty($com_size) && !empty($com_num)){
                	$this->addItem($com_sku,$com_size);
                	$this->setItemQuantity($com_sku,$com_size,$com_num);
                }
            }
            
        }
    }
    /**
     * 添加明细项到购物车中
     * 
     * @param $com_sku
     * @param $com_size
     * @return void
     */
    public function addItem($com_sku,$com_size){
        $com_has_exist = 0;
        if($this->com_item > 0){
            for($i=0;$i<$this->com_item;$i++){
                if($this->com_list[$i]['sku'] == $com_sku && $this->com_list[$i]['size'] == $com_size){
                    $this->com_list[$i]['quantity']++;
                    $com_has_exist = 1;
                }   
            }
        }
        
        if($com_has_exist != 1){
            $product = new Common_Model_Product();
            $options = array(
                'select'=>'id,title,market_price,sale_price,thumb'
            );
            $row = $product->findById($com_sku,$options)->getResultArray();
            if(!empty($row)){
            	$true_price = $row['sale_price'];
                $this->com_list[] = array('sku'=>$com_sku,'size'=>$com_size,'quantity'=>1,'price'=>$true_price,'sale_price'=>$row['sale_price'],'title'=>$row['title'],'thumb'=>$row['thumb']);
                $this->com_item++;
            }
            unset($product);
        }
    }
    /**
     * 从购物车中删除某项
     * 
     * @param $com_sku
     * @param $com_size
     * @return void
     */
    public function delItem($com_sku,$com_size){
    	if($this->com_item <= 0){
    		return;
    	}
        for($i=0;$i<$this->com_item;$i++){
            if($this->com_list[$i]['sku'] == $com_sku && $this->com_list[$i]['size'] == $com_size){
            	$this->com_item--;
            	unset($this->com_list[$i]);
            }
        }
        //检测购物车是否为空
        if($this->com_item <= 0){
            unset($this->com_item);
            unset($this->com_list);
            unset($this->comlist_count);
            
            $this->clearCookie();
        }
    }
    /**
     * 获取购物车某个商品
     * 
     * @param $com_sku
     * @param $com_size
     * @return void
     */
    public function findItem($com_sku,$com_size){
        if($this->com_item <= 0){
            return;
        }
        for($i=0;$i<$this->com_item;$i++){
            if($this->com_list[$i]['sku'] == $com_sku && $this->com_list[$i]['size'] == $com_size){
                return $this->com_list[$i];
            }
        }
    }
    /**
     * 更新购物车中商品的数量
     * 
     * @param $com_sku
     * @param $com_size
     * @param $com_num
     * @return void
     */
    public function setItemQuantity($com_sku,$com_size,$com_count){
    	if(!empty($com_sku)){
    	    for($i=0;$i<$this->com_item;$i++){
                if($this->com_list[$i]['sku'] == $com_sku && $this->com_list[$i]['size'] == $com_size){
                    if ($com_count <= 0){ //如果数量为负数时,直接清除该商品
                    	$this->com_item--;
                    	unset($this->com_list[$i]);
                    }else{
                    	$this->com_list[$i]['quantity'] = $com_count;
                    }
                }   
            }
    	}
    	//检测购物车是否为空
    	if($this->com_item <= 0){
    		unset($this->com_item);
    		unset($this->com_list);
    		unset($this->comlist_count);
    		
    		$this->clearCookie();
    	}
    }
    /**
     * 获取购物车总金额数
     * 
     * @return float
     */
    public function getTotalAmount(){
    	$total_amount = 0;
    	for($i=0;$i<$this->com_item;$i++){
    		$total_amount += $this->com_list[$i]['quantity']*$this->com_list[$i]['sale_price'];
    	}
        return $total_amount;
    }
    /**
     * 获取购物车商品总数
     * 
     * @return int
     */
    public function getItemCount(){
        for($i=0;$i<$this->com_item;$i++){
            $this->comlist_count += $this->com_list[$i]['quantity'];
        }
        return $this->comlist_count;
    }
    
}
/**vim:sw=4 et ts=4 **/
?>