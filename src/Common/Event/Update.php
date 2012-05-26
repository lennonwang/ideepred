<?php
/**
 * 更新数据事件类
 * 
 * @author purpen
 * @version $Id$
 */
class Common_Event_Update extends Anole_Object {
	
	const offset = 1;
	
	const ttl = 43200; //一个月
    /**
     * 更新产品相关次数的事件
     * 
     * @param int $product_id
     * @param string $field
     * @param string $value
     * @return bool
     */
	public static function updateProductCount($product_id,$field,$value='+1'){
		$fields_scope = array('view_count','sale_count','coment_count','fav_count');
		if(in_array($field,$fields_scope)){
			$model = new Common_Model_Product();
            $model->updateFieldsCount($product_id,$field,"+$value");
			unset($model);
			return true;
		}
		return false;
	}
	/**
	 * 更新某分类下产品总数
	 */
	public static function updateProductTotal($catcode,$total){
		$update_sql = 'UPDATE `category` SET `total`=? WHERE `code`=?';
		Common_Model_Category::getDba()->execute($update_sql,array($total,$catcode));
	}
	
}
/**vim:sw=4 et ts=4 **/
?>