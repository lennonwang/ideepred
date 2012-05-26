<?php
/**
 * 产品相关工具类
 * 
 * @author purpen
 * @version $Id$
 */
class Common_Util_Product extends Anole_Object {
	
	const VISITED_KEY = '_XEIS_VPL_';
	
    /**
     * 将某产品放入浏览历史中
     * 
     * @param string $id <产品的ID>
     * @return void
     */
    public static function pushVisitedProducts($id){
        $key = self::VISITED_KEY;
        $data = Anole_Util_Cookie::getCookie($key);
        if(!empty($data)){
            $_datas = explode('_',$data);
            if(!in_array($id,$_datas)){
                array_unshift($_datas,$id);
                $data = implode('_',$_datas);
            }
        }else{
            $data = $id;
        }
        Anole_Util_Cookie::setCookie($key,$data);
    }
	
    /**
     * 获取某用户浏览过的产品
     * 
     * @return array
     */
    public static function fetchVisitedProducts($limit=8){
        $data = Anole_Util_Cookie::getCookie(self::VISITED_KEY);
        $product_ids = explode('_',$data);
		
        $visited_products = array();
        if(!empty($product_ids)){
            $max = count($product_ids);
            if($limit != -1){
                $max = min($limit, $max);
            }
            $product_ids = array_slice($product_ids,0,$max);

            $product = new Common_Model_Product();
			$visited_products = $product->findById($product_ids)->getResultArray();
           	unset($product);
        }
        return $visited_products;
    }
    
    /**
     * 将某产品从浏览历史中删除
     * 
     * @param array $datas
     * @return void
     */
    public static function removeVisitedProducts($datas){
        $key = self::VISITED_KEY;
        if(!empty($datas)){
            $data = implode('_',$datas);
            self::debug("Products[$data] set to cookie.", __METHOD__);
            
            Anole_Util_Cookie::setCookie($key,$data);
        }
    }
    
    /**
     * 通过产品编后查找产品
     * 
     * @return array
     */
    public static function findProductByNumber($sku){
    	
    	$product = new Common_Model_Product();
    	$options = array(
            'select'=>'id,title,number,sale_price,retail_price,member_price',
            'condition'=>'id=?',
            'vars'=>array($sku)
        );
        $data = $product->findFirst($options)->getResultArray();
    	
        return $data;
    }
	/**
	 * 获取相似产品
	 */
	public static function findLikeProducts($sku,$limit=6){
		$detail = new Common_Model_Detail();
		$options = array(
			'select'=>'user_id',
			'condition'=>'product_id=?',
			'vars'=>array($sku)	
		);
		$rows = $detail->find($options)->getResultArray();
		$user_ids = array();
		$like_products = array();
		if(!empty($rows)){
			foreach($rows as $row){
				$user_ids[] = $row['user_id'];
			}
		}
		if(!empty($user_ids)){
			$strSQL = 'select A.*,COUNT(*) AS sale_num,B.id,B.title,B.sale_price,B.catcode,B.category_id,B.thumb from `detail` AS A INNER JOIN `product` AS B on A.product_id=B.id WHERE B.state=? AND A.user_id IN ('.implode(',', $user_ids).') AND A.product_id <> ? GROUP BY A.product_id ORDER BY A.created_on DESC ';
			$options1 = array(
				'page'=>1,
				'size'=>$limit,
				'vars'=>array(1,$sku)
			);
			$like_products = $detail->findBySql($strSQL,$options1)->getResultArray();
		}
		return $like_products;
	}
	/**
	 * 获取品牌店铺
	 */
	public static function findBrandInfo($brand_id){
		$store = new Common_Model_Store();
		$row = array();
		if(!empty($brand_id)){
			$row = $store->findById($brand_id)->getResultArray();
		}
		unset($store);
		return $row;
	}
}
/**vim:sw=4 et ts=4 **/
?>