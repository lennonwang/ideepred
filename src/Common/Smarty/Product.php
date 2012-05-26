<?php
/**
 * 产品列表
 * 
 * @author purpen
 * @version $Id$
 */
class Common_Smarty_Product extends Anole_Object {
    
    /**
     * 获取产品的详细信息
     * 
     * @param array $params
     * @param $smarty
     * @return mixed
     */
    public function smarty_function_info($params,&$smarty){
        $id = null;
        $var = 'product';
        
        extract($params,EXTR_IF_EXISTS);
        
        if(empty($id)){
            return;
        }
        $product = new Common_Model_Product();
        $product->findById($id);
        
        if(empty($var)){
            return $product;
        }else{
            $smarty->assign($var,$product);
        }
    }
    /**
     * 获取产品缩略图
     * @return unknown_type
     */
    public static function smarty_function_photoThumb($params,&$smarty){
    	$thumb_path = null;
		$is_resize = false;
		$domain = 'product';
		$w = 107;
		$h = 107;
    	
    	extract($params,EXTR_IF_EXISTS);
    	
		self::debug("get product photo thumb [$thumb_path]!\n", __METHOD__);
    	if(!empty($thumb_path)){
    	    $domain = Common_Model_Constant::PRODUCT_DOMAIN;
			if(!$is_resize){
				return Common_Util_Storage::getAssetUrl($domain,$thumb_path);
			}else{
				$data = Common_Util_Asset::makeThumb($thumb_path,$w,$h,$domain,2);
				return !empty($data) ? $data['url'] : null;
			}
    	}
    }
	/**
     * 获取产品品牌
     * @return unknown_type
     */
    public static function smarty_function_brand($params,&$smarty){
    	$brand_id = null;
		$var = '';
    	
    	extract($params,EXTR_IF_EXISTS);
    	
		self::debug("get product brand [$brand_id]!\n", __METHOD__);
    	if(!empty($brand_id)){
    	    $brand = Common_Util_Product::findBrandInfo($brand_id);	
    	}
		if(!empty($var)){
			$smarty->assign($var, $brand);
		}else{
			return isset($brand['title']) ? $brand['title'] : null;
		}
    }
    
    /**
     * 获取多条产品列表
     * 
     * @param array $params
     * @param string $content
     * @param Anole_Util_Smarty_Base $smarty
     * @param bool $repeat
     * @return string
     */
    public static function smarty_block_findManyProduct($params,$content,$smarty,&$repeat){
        $var='products';
        $item='product';
        $category_id=null;
        $order='published_on DESC'; //stick,view_count
        $size=5;
        $page=1;
        
        extract($params,EXTR_IF_EXISTS);
        
        static $_index;
        if(is_null($content)){
            $product = new Common_Model_Product();
            $options = array(
                'condition'=>'state=1',
                'order'=>$order,
                'size'=>$size,
                'page'=>$page
            );
            //$product_list = $product->findProductsByCategoryId($category_id,$options);
            $product_list = $product->find($options)->getResultArray();
            
            $max = count($product_list);
            for($i=0;$i<$max;$i++){
                $product_id = $product_list[$i]['id'];
                $product_list[$i]['thumb'] = Common_Util_Storage::getAssetUrl(Common_Model_Constant::PRODUCT_DOMAIN,$product_list[$i]['thumb']);
            }
            
            unset($product);
            
            $smarty->assign($var, $product_list);
            
            $_index = 0;
        }
        $product_list = $smarty->get_template_vars($var);
        if(!empty($product_list[$_index])){
            $smarty->assign($item,$product_list[$_index]);
            $_index++;
            $repeat=true;
            if($_index == 1){
                $first = true;
            }else{
                $first = false;
            }
            $smarty->assign('first', $first);
        }else{
            $repeat=false;
            $smarty->assign($item,null);
        }
        
        return $content;
    }
    
    /**
     * 排序方式
     * 
     * @param $order_by
     * @return string
     */
    public static function _fetchOrderBy($order_by=1){
        switch($order_by){
            case 1:
                $orderby = ' stick DESC,updated_on DESC ';
                break;
            case 2:
                $orderby = ' title ASC';
                break;
            case 3:
                $orderby = ' has_new DESC';
                break;
            case 4:
                $orderby = ' id DESC';
                break;
            default:
                $orderby = ' stick DESC,id DESC ';
                break;
        }
        return $orderby;
    }
    
	/**
	 * 获取销售排行
	 *
     * @param array $params
     * @param string $content
     * @param Anole_Util_Smarty_Base $smarty
     * @param bool $repeat
     * @return string
	 */
	public static function smarty_block_findSaleProduct($params,$content,$smarty,&$repeat){
		$var='product_list';
        $item='product';
		$catcode=null;//所属分类
		$store_id=null;//品牌店铺
		$date_type=null;//时间段
		$size=10;
        $page=1;

		extract($params,EXTR_IF_EXISTS);
        
        static $_index;
		
		if(is_null($content)){
            $model_product = new Common_Model_Product();
            
			$strSQL = 'select A.*,COUNT( * ) AS sale_num,B.id,B.title,B.sale_price,B.catcode,B.category_id,B.thumb from `detail` AS A INNER JOIN `product` AS B on A.product_id=B.id ';
            //已审核的产品
            $conditions[] = 'B.state=?';
            $vars[] =  Common_Model_Product::CHECK_STATE;
            
            //某店铺内的
            if(!empty($store_id)){
                $conditions[] = 'B.category_id=?';
                $vars[] = $store_id;
            }
            //某分类下的
            if(!empty($catcode)){
            	$conditions[] = 'LEFT(B.catcode,'.strlen($catcode).')=?';
            	$vars[] = $catcode;
            }
            
            if(!empty($conditions)){
            	$condition = implode(' AND ', $conditions);
            }else{
            	$condition = null;
            }
            
			if(!empty($condition)){
				$strSQL .= ' WHERE '.$condition;
			}
			
			$strSQL .= ' GROUP BY B.id ORDER BY A.created_on DESC';
			
			$options = array(
				'vars'=>$vars,
				'page'=>$page,
				'size'=>$size
			);
            
            $product_list = $model_product->findBySql($strSQL,$options);
            
            unset($model_product);
            
            $smarty->assign($var, $product_list);
            
            $_index = 0;
        }

		$product_list = $smarty->get_template_vars($var);
        if(!empty($product_list[$_index])){
            $smarty->assign($item,$product_list[$_index]);
            $_index++;
            $repeat=true;
            if($_index == 1){
                $first = true;
            }else{
                $first = false;
            }
            $smarty->assign('first', $first);
            $smarty->assign('loop', $_index);
			$smarty->assign('index', $_index);
        }else{
            $repeat=false;
            $smarty->assign($item,null);
        }
        
        return $content;
	}

    /**
     * 获取推荐产品列表
     * 条件：1.某店铺的
     *     2.某分类的
     * 
     * @param array $params
     * @param string $content
     * @param Anole_Util_Smarty_Base $smarty
     * @param bool $repeat
     * @return string
     */
    public static function smarty_block_findProductList($params,$content,$smarty,&$repeat){
        $var='product_list';
        $item='product';
        $parent_id=null;
        $catcode=null;
        $category_slug=null;
        $stick=null;
        $show_meta=false;
        $size=10;
        $page=1;
        
        extract($params,EXTR_IF_EXISTS);
        
        static $_index;
        
        if(is_null($content)){
            $model_product = new Common_Model_Product();
            
            if(empty($catcode) && !empty($category_slug)){
            	$category = new Common_Model_Category();
            	$options1 = array(
            	    'condition'=>'slug=? AND state=?',
            	    'vars'=>array($category_slug, 1)
            	);
            	$row = $category->findFirst($options1)->getResultArray();
            	if(!empty($row)){
            		$catcode = $row['code'];
            	}
            	unset($category);
            }
            
			$orderby = 'published_on DESC';
            //已审核的产品
            $conditions[] = 'state=?';
            $vars[] =  Common_Model_Product::CHECK_STATE;
            
            //店长推荐产品
            if(!empty($stick)){
                $conditions[] = 'stick=?';
                $vars[] = $stick;
				$orderby = 'sticked_on DESC';
            }
            //某店铺内的
            if(!empty($parent_id)){
                $conditions[] = 'parent_id=?';
                $vars[] = $parent_id;
            }
            //某分类下的
            if(!empty($catcode)){
            	$conditions[] = 'LEFT(`catcode`,'.strlen($catcode).')=?';
            	$vars[] = $catcode;
            }
            
            if(!empty($conditions)){
            	$condition = implode(' AND ', $conditions);
            }else{
            	$condition = null;
            }
            
            $options = array(
                'condition'=>$condition,
                'vars'=>$vars,
                'page'=>$page,
                'size'=>$size,
                'order'=>$orderby
            );
            
            $product_list = $model_product->find($options)->getResultArray();
            
            if(!empty($product_list)){
                $max = count($product_list);
                
                if($show_meta){
                    //获取产品的属性
                    $meta = new Common_Model_Meta();
                    $options_2 = array(
                        'condition'=>'owner_id=? AND domain=?'
                    );
                    $meta_ary = array();
                }
                
                for($i=0;$i<$max;$i++){
                    $product_id = $product_list[$i]['id'];
					$product_list[$i]['thumb_path'] = $product_list[$i]['thumb'];
                    $product_list[$i]['thumb'] = Common_Util_Storage::getAssetUrl(Common_Model_Constant::PRODUCT_DOMAIN,$product_list[$i]['thumb']);
                    
                    if($show_meta){
                        $options_2['vars'] = array($product_id, Common_Model_Constant::PRODUCT_DOMAIN);
                        $meta_list = $meta->find($options_2)->getResultArray();
                        if(!empty($meta_list)){
                            for($k=0;$k<count($meta_list);$k++){
                                $meta_ary[$meta_list[$k]['name']] = $meta_list[$k]['value'];
                            }
                        }
                        $product_list[$i]['meta'] = $meta_ary;
                    }
                    
                }
                if($show_meta){
                    unset($meta);
                }
            }
            
            unset($model_product);
            
            $smarty->assign($var, $product_list);
            
            $_index = 0;
        }
        
        $product_list = $smarty->get_template_vars($var);
        if(!empty($product_list[$_index])){
            $smarty->assign($item,$product_list[$_index]);
            $_index++;
            $repeat=true;
            if($_index == 1){
                $first = true;
            }else{
                $first = false;
            }
            $smarty->assign('first', $first);
            $smarty->assign('loop', $_index);
			$smarty->assign('index', $_index);
        }else{
            $repeat=false;
            $smarty->assign($item,null);
        }
        
        return $content;
    }
    
    
}
/**vim:sw=4 et ts=4 **/
?>