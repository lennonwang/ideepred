<?php
/**
 * 9ibox电子商务系统平台
 * 实现在线购物、支付、管理订单等功能
 * 
 * @version $Id$
 * @author purpen
 */
class Eshop_Action_Index extends Eshop_Action_Common {
	
    protected $_model_class='Common_Model_Product';
    /**
     * url slug
     * 
     * @var string
     */
    private $_slug=null;
    
    private $_size=20;
    //排序方式
    private $_orderby=1;
    //显示方式
    private $_style=1;
    
    private $_name=null;
    
    /**
     * 
     * @return Common_Model_Product
     */
    public function wiredModel(){
        return parent::wiredModel();
    }
    //~~~~~~~~~~~~~~Action implements~~~~~~~~~~
    /**
     * default action method
     */
    public function execute(){
    	// echo "hello deepred!";
        return $this->index();
    }
    /**
     * 系统首页
     * @return string
     */
    public function index(){
    	//获取热门分类
    	$category = new Common_Model_Category();
    	//获取一级分类（频道）
        $category_channel = $category->findFirstCategory();
				$category_menu = array();
        for($i=0;$i<count($category_channel);$i++){
        	$code = $category_channel[$i]['code'];
        	$category_channel[$i]['children'] = $category->findChildrenCategory($code,true,8);
        }
        
    	$product = new Common_Model_Product();
		//实体店商品推荐
		$condition = 'markshop=? AND state=?';
    	$vars = array(1,1);
    	$options = array(
    	    'condition'=>$condition,
    	    'vars'=>$vars,
    	    'page'=>1,
    	    'size'=>15,
    	    'order'=>'marked_on DESC'
    	);
    	$market_product_list = $product->find($options)->getResultArray();
		//本周推荐商品
		$stick_product_list = $product->findStickProductList();
		
		//获取友情链接
		$link_list = $this->_getFriendLinks();
		$this->putContext('link_list', $link_list);
    	
		$this->putContext('market_product_list', $market_product_list);
    	$this->putContext('stick_product_list', $stick_product_list);
    	$this->putContext('category_channel', $category_channel);
    	
    	$this->putSharedParam();

		$this->putContext('current_menu', 'tab_index');
		
    	return $this->smartyResult('eshop.index');
    }
    /**
     * 实体店铺
     */
	public function cityShop(){
	    $name = $this->getName(); 
	    if(empty($name)){
			$name = 'B01';
		}
		$model = new Common_Model_Content();
		$options = array(
			'condition'=>'name=?',
			'vars'=>array($name)
		);
		$row = $model->findFirst($options)->getResultArray();
		
		$this->putContext('hpage', $row);
		$this->putContext('hpage_body', $row['body']);
	    
		$this->putSharedParam();
		
    	return $this->smartyResult('eshop.city-shop');
	}
	/**
	 * 专题列表
	 * 
	 * @return string
	 */
	public function topics(){
	    $this->putSharedParam();
	    return $this->smartyResult('eshop.topic-list');
	}
	/**
	 * 网站地图
	 * 
	 * @return string
	 */
	public function sitemap(){
	    //获取热门分类
    	$category = new Common_Model_Category();
    	//获取一级分类（频道）
        $category_channel = $category->findFirstCategory();
		$category_menu = array();
        for($i=0;$i<count($category_channel);$i++){
        	$code = $category_channel[$i]['code'];
        	$category_channel[$i]['children'] = $category->findChildrenCategory($code,true);
        }
        
	    $this->putContext('category_channel', $category_channel);
	    $this->putSharedParam();
	    
    	return $this->smartyResult('eshop.sitemap');
	}
    /**
     * 获取新浪微博发表的主题
     */
	public function findWeibo(){
		header("Content-type:text/html;charset=utf-8");
		$openapi = new Anole_Util_SinaOpenApi('3759409175');
		$openapi->setUser('iboxcn@sina.cn', '123321');
		
		$url = array('url'=>'statuses/user_timeline','params'=>array('page'=>1,'count'=>7), 'method'=>'GET');
		$content = $openapi->request($url['url'], $url['params'], $url['method']);
		
		return $content;
	}
    
    
    /**
     * 产品类别页,包括各个查询条件
     * 
     * @return string
     */
    public function styleList(){
    	
    	
    }
	/**
     * 获取排序方式
     * 
     * @return string
     */
    protected function _getOrderWay($orderby=1){
    	switch($orderby){
    		case 1:
    			$order_str = 'published_on DESC';
    			break;
    		case 2:
    			$order_str = 'sale_price DESC';
    			break;
    		case 3:
    			$order_str = 'view_count DESC';
    			break;
    		case 4:
    			$order_str = 'sale_count DESC';
    			break;
    		default:
    			$order_str = 'published_on DESC';
                break;
    	}
    	return $order_str;
    }
    /**
     * 产品最新列表
     * 
     * @return string
     */
    public function newestList(){
		$model = new Common_Model_Product();
		$condition = 'state=?';
		$vars = array(1);
		$page  = $this->getPage();
		$size  = $this->getSize();
		$orderby = $this->getOrderBy();
		
		$records = $model->countIf($condition,$vars);
		$total   = ceil($records/$size);
        $page    = min($total,$page);
        
        $prev_page = ($page-1 > 0) ? $page-1 : 1;
        $next_page = ($page+1 < $total) ? $page+1 : $total;

		$options = array(
            'condition'=>$condition,
            'vars'=>$vars,
            'page'=>$page,
            'size'=>$size,
            'order'=>$this->_getOrderWay($orderby)
        );
        $product_list = $model->find($options)->getResultArray();
		
		$this->putContext('total',$total);
        $this->putContext('page', $page);
        $this->putContext('prev_page',$prev_page);
        $this->putContext('next_page',$next_page);
        $this->putContext('records', $records);
		$this->putContext('product_list', $product_list);
		$this->putContext('orderby', $orderby);
		
		//获取频道推荐分类
        $category = new Common_Model_Category();
		//获取一级分类（频道）
        $category_channel = $category->findFirstCategory();
		$this->putContext('category_channel', $category_channel);
		
		$this->putSharedParam();
    	return $this->smartyResult('eshop.newest-list');
    }
    
    public function send(){
        //成功提交订单后，发送提醒邮件
        $order_ref = '20110225';
        $datetime = Common_Util_Date::getNow();
        #'fanjun67@gmail.com','2008xiaobai@gmail.com',
        $to = array('purpen.w@gmail.com');
        $subject = 'whshop订单提醒';
        $body = "客户订单[$order_ref]于 $datetime 已成功下单，请及时查看处理～"; 
        
        $model = new Common_Model_Postoffice();
        
        for($i=0;$i<count($to);$i++){
            $model->setIsNew(true);
            $model->setMailto($to[$i]);
            $model->setSubject($subject);
            $model->setBody($body);
            $model->setMailfrom('whshop@gmail.com');
            $model->setFromName('whshop');
            $model->setCreatedOn($datetime);
            $model->setState(Common_Model_Postoffice::DEFAULT_STATE);
            $model->save();
        }
        
        return $this->rawResult('ok');
    }
    
    /**
     * 显示产品大图
     * 
     * @return string
     */
    public function picture(){
    	
    }
	/**
	 * 显示正在建设中
	 */
	public function build(){
		$this->putSharedParam();
    	return $this->smartyResult('eshop.build');
	}
    
    /*****************************设置参数******************************/
    public function setSlug($v){
    	$this->_slug = $v;
    	return $this;
    }
    public function getSlug(){
    	return $this->_slug;
    }
    
    public function setName($v){
        $this->_name = $v;
        return $this;
    }
    public function getName(){
        return $this->_name;
    }
    
    public function setSize($v){
    	$this->_size = $v;
    	return $this;
    }
    public function getSize(){
    	return $this->_size;
    }
    /**
     * 显示方式
     * 
     * @param $v
     * @return Eshop_Action_Index
     */
    public function setStyle($v){
    	$this->_style = $v;
    	return $this;
    }
    public function getStyle(){
    	return $this->_style;
    }
    /**
     * 排序方式
     * 
     * @param $v
     * @return Eshop_Action_Index
     */
    public function setOrderby($v){
    	$this->_orderby = $v;
    	return $this;
    }
    public function getOrderBy(){
    	return $this->_orderby;
    }
}
/**vim:sw=4 et ts=4 **/
?>