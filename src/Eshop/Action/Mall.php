<?php
/**
 * 商家、品牌商品展示
 * 
 * @author purpen
 * @version $Id$
 */
class Eshop_Action_Mall extends Eshop_Action_Common {
	
	protected $_model_class='Common_Model_Product';
	/**
     * url slug
     * 
     * @var string
     */
    private $_slug=null;
	//分类代码
	private $_catcode=null;
	//分类ID
	private $_catid=null;
	//每页显示个数
	private $_size=20;
	//排序方式; 1 desc ;2 asc
    private $_orderby=1;
    //排序顺序
    private $_orderSeq=1;
    //显示方式
    private $_style=1;
    //查询关键词
	private $_query=null;
	 //国家
	private $_country=null;
	 //葡萄酒品种
	private $_grape_breed=null;
	
	private $low_price=null;
    
    private $high_price=null;
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
        return $this->categoryList();
    }
	
    /**
     * 分类列表页
     * 
     * @return string
     */
    public function categories(){
        
    }
    /**
     * 品牌列表
     * 
     * @return string
     */
    public function brandList(){
        $page = $this->getPage();
    	$size = 100;
    	
    	$model = new Common_Model_Store();
    	$condition = 'state=?';
    	$vars = array(1);
    	//获取记录数
		$records = $model->countIf($condition,$vars);
		
    	$total = ceil($records/$size);
    	$page  = min($total, $page);
    	$prev_page = ($page-1 > 0) ? $page-1 : 1;
        $next_page = ($page+1 < $total) ? $page+1 : $total;
    	
    	$options = array(
    	    'condition'=>$condition,
    	    'vars'=>$vars,
    	    'page'=>$page,
    	    'size'=>$size
    	);
    	$brand_list = $model->find($options)->getResultArray();
    	if(!empty($brand_list)){
    	    for($i=0;$i<count($brand_list);$i++){
    	        $store_id = $brand_list[$i]['id'];
    	        $brand_list[$i]['thumb'] = Common_Util_Asset::fetchAssetUrl($store_id, Common_Model_Constant::STORE_THUMB);
    	    }
    	}
    	
    	$this->putContext('total', $total);
        $this->putContext('page', $page);
        $this->putContext('prev_page', $prev_page);
        $this->putContext('next_page', $next_page);
        $this->putContext('records', $records);
        
        $this->putContext('brand_list', $brand_list);
        
    	$this->putSharedParam();
    	
    	return $this->smartyResult('eshop.brandlist');
    }
	/**
	 * 品牌店铺
	 */
	public function brand(){
		$page = $this->getPage();
    	$size = $this->getSize();
		$store_id = $this->getId();
		
		$store = new Common_Model_Store();
		$store_row = $store->findById($store_id)->getResultArray();
		unset($store);
		
		$model = new Common_Model_Product();
		$condition = 'state=? AND store_id=?';
		$vars = array(1,$store_id);
		//获取记录数
		$records = $model->countIf($condition,$vars);
		
    	$total = ceil($records/$size);
    	$page  = min($total, $page);
    	$prev_page = ($page-1 > 0) ? $page-1 : 1;
        $next_page = ($page+1 < $total) ? $page+1 : $total;

		//排序方式
		$orderby = 1;
        $options = array(
            'condition'=>$condition,
            'vars'=>$vars,
            'page'=>$page,
            'size'=>$size,
            'order'=>$this->_getOrderWay($orderby,$orderSeq)
        );
        $product_list = $model->find($options)->getResultArray();
		
		//获取一级分类（频道）
		$category = new Common_Model_Category();
        $category_channel = $category->findFirstCategory();
		unset($category);
		
		$this->putContext('total',$total);
        $this->putContext('page', $page);
        $this->putContext('prev_page',$prev_page);
        $this->putContext('next_page',$next_page);
        $this->putContext('records', $records);
		
		$this->putContext('store', $store_row);
		$this->putContext('product_list', $product_list);
		$this->putContext('category_channel', $category_channel);
		
		$this->putSharedParam();
    	
    	return $this->smartyResult('eshop.brand-product');
	}

	/**
     * 产品搜索列表页
     * 参数：category_id,page,style,orderby,low_price,high_price,keyword
     * 
     * @return string
     */
    public function search(){
    	$page = $this->getPage();
    	$size = $this->getSize();
    	$orderby = $this->getOrderBy();
    	$orderSeq = $this->getOrderSeq();
        $style = $this->getStyle();
        
    	$low_price = $this->getLowPrice();
    	$high_price = $this->getHighPrice();
    	$query = $this->getQuery();
		$country = $this->getCountry();
		$grape_breed = $this->getGrapeBreed();
		$catcode = $this->getCatcode();
    	
    	$conditions = array();
    	$vars = array();
    	
    	//筛选已发布的产品
        $conditions[] = 'state=1';
        
    	//价格筛选，low_price,high_price都不空
    	if(!empty($low_price) && !empty($high_price)){
    	    $conditions[] = 'sale_price>=? AND sale_price<=?';
    	    $vars[] = $low_price;
    	    $vars[] = $high_price;
    	}
    	//价格筛选，low_price=0,high_price=100,300的条件
    	if(empty($low_price) && !empty($high_price)){
    	    if($high_price == 100){
    	    	$conditions[] = 'sale_price<=?';
    	    }
    	    if($high_price == 300){
    	    	$conditions[] = 'sale_price>=?';
    	    }
    		$vars[] = $high_price;
    	}
		
    	//从产品标题中查询匹配项
    	if(!empty($query)){
			//匹配sku
			if(preg_match('/[0-9]{10}/',$query)){
				$conditions[] = 'id=?';
				$vars[] = $query;
			}else{
				//从品牌名搜索
				$store = new Common_Model_Store();
				$b_options = array(
					'condition'=>'title LIKE ?',
					'vars' => "%$query%"
				);
				$brand_list = $store->find($b_options)->getResultArray();
				if(!empty($brand_list)){
					foreach($brand_list as $brand){
						$brand_ids[] = $brand['id'];
					}
				}
				if(isset($brand_ids) && !empty($brand_ids)){
					$conditions[] = '(category_id IN ( '.implode(',', $brand_ids).') OR title LIKE ? OR tags LIKE ?)';
				}else{
					$conditions[] = '(title LIKE ? OR tags LIKE ?)';
				}
				$vars[] = "%$query%";
				$vars[] = "%$query%";

				unset($store);
			}
    	}
    	//从某国家中筛选 
		if(!empty($country)){
			$conditions[] = 'wine_country = ?';
			$vars[] = $country;
		}
		//从葡萄酒品牌筛选
   		if(!empty($grape_breed)){
			$conditions[] = 'grape_breed LIKE ?';
			$vars[] = "%,$grape_breed,%";
		}
		self::debug("query======".$query."grape_breed===".$grape_breed);
		//从某类别中筛选
		if(!empty($catcode)){
			$conditions[] = 'LEFT(catcode,'.strlen($catcode).')=?';
			$vars[] = $catcode;
			
			//获取父分类路径
			$category = new Common_Model_Category();
	        $category_path = $category->findRootNodePath($catcode);
			$this->putContext('category_path', $category_path);
		}
    	
    	if(!empty($conditions)){
    		$condition = implode(' AND ', $conditions);
    	}else{
    		$condition = null;
    	}
		
    	$model = $this->wiredModel();
    	
    	//获取记录数
		$records = $model->countIf($condition,$vars);
		
    	$total = ceil($records/$size);
    	$page  = min($total, $page);
    	$prev_page = ($page-1 > 0) ? $page-1 : 1;
        $next_page = ($page+1 < $total) ? $page+1 : $total;
        
        //排序方式
        $options = array(
            'condition'=>$condition,
            'vars'=>$vars,
            'page'=>$page,
            'size'=>$size,
            'order'=>$this->_getOrderWay($orderby,$orderSeq)
        );
        $product_list = $model->find($options)->getResultArray();
      
        
        $this->putContext('total',$total);
        $this->putContext('page', $page);
        $this->putContext('prev_page',$prev_page);
        $this->putContext('next_page',$next_page);
        $this->putContext('records', $records);
		$this->putContext('catcode', $catcode);
        $this->putContext('style', $style);
        $this->putContext('orderby', $orderby);
        $this->putContext('orderSeq', $orderSeq); 
        if($orderSeq!=2){
        	$this->putContext('nextOrderSeq', 1);
        }
		$this->putContext('low_price',$low_price);
        $this->putContext('high_price',$high_price);
		$this->putContext('query', $query);
		$this->putContext('country', $country);
		$this->putContext('grape_breed', $grape_breed);

        $this->putContext('product_list', $product_list);

				$category = new Common_Model_Category();
				//获取一级分类（频道）
        $category_channel = $category->findFirstCategory();
				$this->putContext('category_channel', $category_channel);
		
		$this->putSharedParam();
		$this->_setExtraParams();
    	return $this->smartyResult('eshop.search-list');
    }
    
    /**
     * 设置订单的扩展参数
     *
     * @return void
     */
    protected function _setExtraParams( ){
    	$category = new Common_Model_Category();
    	$all_category = $category->findAllCategory();
    	$this->putContext('all_category',$all_category);
    	$this->putContext('wine_country_array',Common_Util_ProductProUtil::getWineGrapeCountryArray());
    	$this->putContext('grape_breed_array',Common_Util_ProductProUtil::getWineGrapeBreedArray());
    	$this->putContext('order_by_array',$this->getSearchOrderByInfo());
    }
    /**
     * 频道类别页
     * 
     * @return string
     */
    public function channel(){
        $slug = $this->getSlug();
        
        if(empty($slug)){
            $message = '缺少频道参数，请不要恶意尝试！';
            return $this->_hintResult($message,true);
        }
        
        //获取频道推荐分类
        $category = new Common_Model_Category();
        $options = array(
            'condition'=>'slug=? AND state=? ',
            'vars'=>array($slug,1)
        );
        $channel = $category->findFirst($options)->getResultArray();
        if(!count($channel)){
            $message = "您请求的分类[$slug]信息不存在或已被删除！";
            return $this->_hintResult($message,true);
        }
        $channel_id = $channel['id'];
        $channel_code = $channel['code'];
        //添加类别缩略图
        $channel['image'] = Common_Util_Asset::fetchAssetUrl($channel_id, Common_Model_Constant::CATEGORY_THUMB);
        
        $options = array(
            'condition'=>'LEFT(`code`,1)=? AND code <> ? AND state=? AND total <> ?',
            'vars'=>array($channel_code,$channel_code,1,0),
            'order'=>'total DESC,stick DESC, id ASC'
        );
			  self::debug("channel_code======".$channel_code);
        $stick_category = $category->find($options)->getResultArray();
        if(!empty($stick_category)){
            for($i=0;$i<count($stick_category);$i++){
                $cid = $stick_category[$i]['id'];
                //添加类别缩略图
                $stick_category[$i]['image'] = Common_Util_Asset::fetchAssetUrl($cid, Common_Model_Constant::CATEGORY_THUMB);
            }
        }
        self::debug("[1111111]channel_code".$channel_code); 
        $this->setCatcode($channel_code);
        $this->categoryList(); 
        $this->_setExtraParams();
        return $this->smartyResult('eshop.search-list');
       // return $this->smartyResult('eshop.channel');
    }
    
    /**
     * 产品类别页
     * 参数：category_id,page,style,orderby
     * 
     * @return string
     */
    public function categoryList(){
        $catcode = $this->getCatcode();
        
        if(empty($catcode)){
            $message = '缺少分类参数，请不要恶意尝试！';
            return $this->_hintResult($message,true);
        }
        $page  = $this->getPage();
        $size  = $this->getSize();
        $style = $this->getStyle();
        $orderby = $this->getOrderBy();
        $orderSeq = $this->getOrderSeq();
        self::debug("[param]:categoryList:catcode:".$catcode
        		."\t page:".$page."\t size:".$size."\t style:".$style."\t order".$orderby);
        //获取当前分类
        $category = new Common_Model_Category();
        $options = array(
            'condition'=>'code=? AND state=?',
            'vars'=>array($catcode,1)
        );
        $current_category = $category->findFirst($options)->getResultArray();
        if(!count($current_category)){
            $message = '您请求的分类信息不存在或已被删除！';
            return $this->_hintResult($message,true);
        }
        
        //获取父分类路径
        $category_path = $category->findRootNodePath($catcode);
        //获取一级分类（频道）
        $category_channel = $category->findFirstCategory();
        self::debug("111111111".$category_path."3333333333". $category_channel);
        //获取所属频道
        $channel = $category_path[0];
        self::debug("ddddddddddddddd".$catcode."ppppppppp". $channel['id']);
        $channel_id = $channel['id'];
        //添加类别缩略图
        $channel['image'] = Common_Util_Asset::fetchAssetUrl($channel_id, Common_Model_Constant::CATEGORY_THUMB);
        
        //获取频道下二三级分类
        $children_category = $category->findChildrenCategory($channel['code']);
        
        //获取当前分类下的商品数
        $product = $this->wiredModel();
        
        $condition = "LEFT(`catcode`,".strlen($catcode).")=? AND state=?";
        $vars = array($catcode,1);
        
        $records = $product->countIf($condition,$vars);
        $total   = ceil($records/$size);
        $page    = min($total,$page);
        
        $prev_page = ($page-1 > 0) ? $page-1 : 1;
        $next_page = ($page+1 < $total) ? $page+1 : $total;
        
        $options = array(
            'condition'=>$condition,
            'vars'=>$vars,
            'page'=>$page,
            'size'=>$size,
            'order'=>$this->_getOrderWay($orderby,$orderSeq)
        );
         self::debug("[param]:categoryList:condition:".$condition.' vars:'.$vars.' orderby:'.$this->_getOrderWay($orderby));
        $product_list = $product->find($options)->getResultArray();
		
        $this->putContext('catcode', $catcode);
        
        $this->putContext('total',$total);
        $this->putContext('page', $page);
        $this->putContext('prev_page',$prev_page);
        $this->putContext('next_page',$next_page);
        $this->putContext('records', $records);
        
        $this->putContext('style', $style);
        $this->putContext('orderby', $orderby);
        $this->putContext('orderSeq', $orderSeq);
        
        $this->putContext('channel', $channel);
        $this->putContext('current_category', $current_category);
        $this->putContext('category_channel', $category_channel);
        $this->putContext('children_category', $children_category);
        $this->putContext('category_path', $category_path);
        
        $this->putContext('product_list', $product_list);
        $this->putContext('current_menu', 'tab_'.$catcode);
		  	$this->putSharedParam();
		 
		  $this->_setExtraParams();
    //    return $this->smartyResult('eshop.category-list');
        return $this->smartyResult('eshop.search-list');
    }
    
    /**
     * 产品详情页
     * 
     * @return string
     */
    public function product(){
        $id = $this->getId();
        if(empty($id)){
            $message = '缺少参数，请不要恶意尝试！';
            return $this->_hintResult($message,true);
        }
        $model = $this->wiredModel();
        $options = array(
            'condition'=>'state=? AND id=?',
            'vars'=>array(1,$id)
        );
        $product = $model->findFirst($options)->getResultArray();
        
        if(!$model->count()){
            $message = '抱歉，此商品已下架或被删除，请尝试其他！';
            return $this->_hintResult($message,true);
        }

        //获取产品照片 附件中获取 需要detail_image
        $asset_list = $model->findRelationModel('assets',array('size'=>-1),$id)->getResultArray(); 
				$content_image = array();
				$detail_image = array();
        if(!empty($asset_list)){
            for($i=0;$i<count($asset_list);$i++){
                $parent_type = $asset_list[$i]['parent_type'];
                $path = $asset_list[$i]['path'];
                $domain = $asset_list[$i]['domain'];
				
							//细节照片
							$asset_list[$i]['asset_url'] = Common_Util_Storage::getAssetUrl($domain,$path);
							if($parent_type == Common_Model_Constant::PRODUCT_WHOLE){
								$detail_image[] = $asset_list[$i];
							}
							//内容图片
              if($parent_type == Common_Model_Constant::PRODUCT_SOURCE){
								$content_image[] =  $asset_list[$i];
							}
				
                if($parent_type == Common_Model_Constant::PRODUCT_THUMB){
                    $product['asset_thumb'] = $asset_list[$i];
									//$detail_image[] = $asset_list[$i];
                  //过滤掉缩略图
                  //unset($asset_list[$i]);
                }
            }
        }
        $product['asset_list'] = $detail_image;
		$product['content_image'] = $content_image;
        
        //获取产品所属分类
        $catcode = $product['catcode'];
		$category = new Common_Model_Category();
		//获取一级分类（频道）
        $category_channel = $category->findFirstCategory();
		if(!empty($catcode)){
	        $categories = $category->findRootNodePath($catcode);
	        $product['categories'] = $categories; 
		}    
        for($i=0;$i<count($category_channel);$i++){
        	$code = $category_channel[$i]['code'];
        	$category_channel[$i]['children'] = $category->findChildrenCategory($code,true,8);
        	self::debug('[dat]!!!!1length:::::'.count($category_channel[$i]['children']).' code:'.$code);
        } 
        $this->putContext('category_channel', $category_channel);
        
		
		//获取产品所属品牌
		$store_id = $product['store_id'];
		if(!empty($store_id)){
			$store = new Common_Model_Store();
			$store_brand = $store->findById($store_id)->getResultArray();
			$this->putContext('store_brand', $store_brand);
			unset($store);
		}
		
		//获取产品所属类别
		$category_id = $product['category_id'];
		if(!empty($category_id)){
			$category = new Common_Model_Category();
			$wine_category = $category->findById($category_id)->getResultArray();
			$this->putContext('wine_category', $wine_category);
			unset($category);
		} 
		//获取红酒国家、产地和分级等信息  
		$productInfo = Common_Model_ProductInfo::getProductInfo($product);
		$this->putContext('product_info', $productInfo);
		 
		 
		unset($productInfo);
		
        //获取浏览记录
        $visited_products = Common_Util_Product::fetchVisitedProducts();
        //写入浏览记录
        Common_Util_Product::pushVisitedProducts($id);
			//记录查看次数
			Common_Event_Update::updateProductCount($id,'view_count');
		
			$like_products = Common_Util_Product::findLikeProducts($id);
        
        $this->putContext('product', $product);
        $this->putContext('visited_products', $visited_products);
		$this->putContext('like_products', $like_products);
		
		# 配送说明
		$helper = new Common_Model_Content();
		$pagebody = $helper->findFirst(array('condition'=>'name=?','vars'=>array('sendsmary')))->getResultArray();
		$this->putContext('hpage_body', $pagebody);

		$this->putSharedParam();
        
        return $this->smartyResult('eshop.product-detail');
    }
    /**
     * 添加到收藏
     */
	public function favorite(){
		$id = $this->getId();
		$user_id = Anole_Util_Cookie::getUserID();
		if(empty($id) || empty($user_id)){
			$message = '缺少参数，请不要恶意尝试！';
            return $this->_hintResult($message,true);
		}
		try{
			$favorite = new Common_Model_Favorite();
			if(!$favorite->countIf('user_id=? AND product_id=?', array($user_id,$id))){
				$favorite->setId(null);
				$favorite->setIsNew(true);
				$favorite->setProductId($id);
				$favorite->setUserId($user_id);
				$favorite->save();
				
				$msg = '该产品已经成功地加入了您的收藏夹。';
			}else{
				$msg = '该产品已经存在于您的收藏夹中。';
			}
		}catch(Common_Model_Exception $e){
			self::warn('favorite product error: '.$e->getMessage(), __METHOD__);
			$msg = '系统繁忙，请稍后再试！';
		}
		$this->putContext('msg', $msg);
		
		return $this->jqueryResult('eshop.favorite_ok');
	}
	
	/**
	 * 获取排序名称
	 */
	public static function getSearchOrderByInfo(){ 
		$order_by_array=array(array("id"=>"1","name"=>"上架"),array("id"=>"2","name"=>"价格")
				,array("id"=>"3","name"=>"人气"),array("id"=>"4","name"=>"折扣") 
		);
		self::debug("getSearchOrderByInfo.".$order_by_array);
		return $order_by_array;
	}
	
    /**
     * 获取排序方式
     * 
     * @return string
     */
    protected function _getOrderWay($orderby=1,$orderSeq=1){
    	$orderSeqValue = "DESC";
    	if($orderSeq == 2){
    		$orderSeqValue = " asc ";
    	}
    	switch($orderby){
    		case 1:
    			$order_str = 'published_on '.$orderSeqValue;
    			break;
    		case 2:
    			$order_str = 'sale_price '.$orderSeqValue;
    			break;
    		case 3:
    			$order_str = 'view_count '.$orderSeqValue;
    			break;
    		case 4:
    			$order_str = 'sale_count '.$orderSeqValue;
    			break;
    		default:
    			$order_str = 'published_on '.$orderSeqValue;
                break;
    	}
    	return $order_str;
    }
	/**
	 * 工具方法
	 */
	public function remath(){
		$category = new Common_Model_Category();
		$options = array(
			'condition'=>'state=?',
			'vars'=>array(1)
		);
		$category_list = $category->find($options)->getResultArray();
		if(!empty($category_list)){
			$product = new Common_Model_Product();
			foreach($category_list as $cat){
				$product->remathCategoryProductTotal($cat['code']);
			}
			unset($product);
		}
		unset($category);
		return $this->rawResult('remath ok!');
	}
    
    /*****************参数辅助方法******************/
    public function setSlug($v){
        $this->_slug = $v;
        return $this;
    }
    public function getSlug(){
        return $this->_slug;
    }
    
	public function setCatid($v){
    	$this->_catid = $v;
    	return $this;
    }
    public function getCatid(){
    	return $this->_catid;
    }
    
	public function setCatcode($v){
    	$this->_catcode = $v;
    	return $this;
    }
    public function getCatcode(){
    	return $this->_catcode;
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
     * @return Eshop_Action_Mall
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
     * @return Eshop_Action_Mall
     */
    public function setOrderby($v){
        $this->_orderby = $v;
        return $this;
    }
    public function getOrderBy(){
        return $this->_orderby;
    }
    
    public function setOrderSeq($v){
    	$this->_orderSeq = $v;
    	return $this;
    }
    public function getOrderSeq(){
    	return $this->_orderSeq;
    }
	public function setLowPrice($v){
    	$this->low_price = $v;
    	return $this;
    }
    public function getLowPrice(){
    	return $this->low_price;
    }
    
    public function setHighPrice($v){
    	$this->high_price = $v;
    	return $this;
    }
    public function getHighPrice(){
    	return $this->high_price;
    }
	/**
     * 搜索关键词
     * 
     * @param $v
     * @return Eshop_Action_Mall
     */
    public function setQuery($v){
    	$this->_query = $v;
    	return $this;
    }
    public function getQuery(){
    	return $this->_query;
    }
    
	public function setCountry($v){
    	$this->_country = $v;
    	return $this;
    }
    public function getCountry(){
    	return $this->_country;
    }
    
	public function setGrapeBreed($v){
    	$this->_grape_breed = $v;
    	return $this;
    }
    public function getGrapeBreed(){
    	return $this->_grape_breed;
    }
}
/**vim:sw=4 et ts=4 **/
?>