<?php
/**
 * 文章工具类
 * 
 * @author purpen
 * @version $Id$
 */
class Common_Util_Article extends Anole_Object {
	
    /**
     * 通过文章的关键词，获取文章的相关文章
     * 
     * @param string $keyword
     * @return array
     */
	public static function getRelateArticles($keywords,$size=8,$exclude=null){
		$conditions[] = 'status=?';
		$vars[] = Common_Model_Article::CHECKED_STATUS;
		
		//从标签中查询
        for($i=0;$i<count($keywords);$i++){
            $select[] = " tags like ? ";
            $vars[] = "%$keywords[$i]%";
        }
        $conditions[] = " (".implode(' OR ', $select).") ";
        
        //排除的条件
        if(!empty($exclude)){
        	$conditions[] = " id NOT IN (".$exclude.")";
        }
        
	    if(!empty($conditions)){
            $condition = implode(' AND ', $conditions);
        }else{
            $condition = null;
        }
		$options = array(
		   'condition'=>$condition,
		   'vars'=>$vars,
		   'page'=>1,
		   'size'=>$size,
		   'order'=>' rand() '
		);
		
		$article = new Common_Model_Article();
		$posts_list = $article->find($options)->getResultArray();
		
		return $posts_list;
	}
    
}
/**vim:sw=4 et ts=4 **/
?>