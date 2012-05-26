<?php
/**
 * 生成静态页类
 * 
 * @author purpen
 * @version $Id$
 */
class Common_Util_PageBuilder extends Anole_Object {
	protected static $_builder=null;
    /**
     * 返回singleton实例
     *
     * @return Cms_Core_Util_PageBuilder
     */
    public static function getBuilder(){
        if(is_null(self::$_builder)){
            self::$_builder = new Common_Util_PageBuilder();
        }
        return self::$_builder;
    }
    
    /**
     * 返回smarty实例
     *
     * @return Doggy_Util_Smarty_Base
     */
    public function initSmarty(){
        $smarty = Anole_Util_Smarty::factory(true);
        $smarty->resetAnolePlugin();
        $smarty->initRuntimeDirectory();
        
        return $smarty;
    }
    /**
     * 创建文章静态页
     * 
     * @param int $id
     * @return string
     */
    public function buildContentPage($id){
    	$smarty = $this->initSmarty();
    	try{
    		$article = new Common_Model_Article();
    		$options = array(
    		    'select'=>'id,title,name,type,excerpt,content,author,tags,created_on,created_by'
    		);
    		$article_data = $article->findById($id,$options)->getResultArray();
    		if(empty($article_data)){
    			self::debug("Not Found Article[$id].", __METHOD__);
    			unset($article);
    			return;
    		}
    		
    		$article_body = stripslashes($article_data['content']);
    		$created_on = $article['created_on'];
    		$created_by = $article['created_by'];
    		
    		$pages_content = self::splitArtilcePage($article_body);
    		$total = count($pages_content);
    		
    		$root = Anole_Config::get('runtime.article.root');
    		$tpl = Anole_Config::get('smarty.static_page');
            
	        
    		for($i=0;$i<$total;$i++){
    			$page = $i+1;
    			if($page == 1){
    				$file = 'index.shtml';
    			}else{
    			    $file = "p$page.shtml";	
    			}
    			$static = $root.'/'.Common_Util_Url::buildPathIdByTime($id,$created_on,$created_by,$file);
    			
    			$page_content = $pages_content[$i];
    			
    			$smarty->assign('content', $page_content);
    			$smarty->assign('news',$article_data);
    			$smarty->assign('total',$total);
    			$smarty->assign('page',$page);
    			
    			
    			$content = $smarty->fetch($tpl);
    			
	    		//start to storage
		        if(!Anole_Util_File::writeFile($static, $content)){
		            throw new Common_Model_Exception('rebuild article page failed!');
		        }
    		}
    	}catch(Anole_ActiveRecord_Exception $e){
    		self::warn('db faild '.$e->getMessage(),__METHOD__);
    	}catch(Anole_Exception $e){
    		self::warn('exception faild '.$e->getMessage(),__METHOD__);
    	}
    	unset($article);
    	unset($smarty);
    	
    	return true;
    }
    
    /**
     * 按分页符分隔文章内容
     *
     * @param string $content
     * @return array
     */
    public static function splitArtilcePage($content){
        //分页符表达式
        $reg  = '/\<img([^>]*)class="mcePageBreak mceItemNoResize"(.*)\/?\>?/';//非贪婪模式
        $reg2 = '/\<!-- pagebreak --\>?/';
        
        //分隔成内容数组
        if(preg_match($reg2,$content)){
        	$pages_content = preg_split($reg2, $content);
        }else{
        	$pages_content = preg_split($reg, $content);
        }
        
        return $pages_content;
    }
    
}
/**vim:sw=4 et ts=4 **/
?>