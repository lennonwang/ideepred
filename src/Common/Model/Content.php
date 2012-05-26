<?php
/**
 * 文章、静态页
 * 
 * @author purpen
 * @version $Id$
 */
class Common_Model_Content extends Common_Model_Table_Content {
    
    //关系映射表
    protected $_relation_map = array(
        //所属栏目
        'sorts'=>array(
            'type'=>self::HAS_AND_BELONGS_TO_MANY,
            'class'=>'Common_Model_Sort',
            'this_foreign_key'=>'article_id',
            'other_foreign_key'=>'sort_id',
            'join_table'=>'article_sort'
        ),
        //附件
        'assets'=>array(
            'type'=>self::HAS_MANY,
            'class'=>'Common_Model_Asset',
            'foreign_key'=>'parent_id',
            'options'=>array(
                 'condition'=>'parent_type=?',
                 'vars'=>array(Common_Model_Constant::ARTICLE_SOURCE)
            )
        ),
        'metas'=>array(
            'type'=>self::HAS_MANY,
            'class'=>'Common_Model_Meta',
            'foreign_key'=>'owner_id',
            'options'=>array(
                'condition'=>'domain=?',
                'vars'=>array(Common_Model_Constant::ARTICLE_DOMAIN)
            )
        )
    );
    /**
     * 默认的magic field
     */
    protected $_magic_field = array(
        'sort_ids'=>'_getBelongSort'
    );
    /**
     * @return Common_Model_Content
     */
    public static function getModel($data=array(),$class=__CLASS__){
        return parent::getModel($data,$class);
    }
    
    /**
     * 稿件库状态
     * 
     * @var int
     */
    const CHECKED_STATUS = 1;
    /**
     * 草稿箱状态
     * 
     * @var int
     */
    const DRAFT_STATUS = 0;
    /**
     * 垃圾箱状态
     * 
     * @var int
     */
    const DUSTBIN_STATUS = -1;
    /**
     * 资讯标识
     * 
     * @var int
     */
    const ARTICLE_TYPE = 1;
    /**
     * 专题标识
     * 
     * @var int
     */
    const TOPIC_TYPE = 2;
    /**
     * 页面类型
     * 
     * @var string
     */
    const PAGE_TYPE = 'page';
    /**
     * 英文版类型
     * 
     * @var string
     */
    const EN_VERSION = 2;
    
    
    private $_belongs_sorts = array();
    
    
    public function beforeValidation(){
        if($this->isNew()){
            $this->setCreatedOn(date('Y-m-d H:i:s'));
        }
        return true;
    }
    /**
     * validate验证
     * @see src/Anole/ActiveRecord/Anole_ActiveRecord_Base#validate()
     */
    public function validate(){
        if($this->isNew()){
            $fields = array('title','excerpt');   
        }else{
            $fields = array('id');
        }
        if(!$this->validateRequird($fields)){
            return False;
        }
        return true;
    }
    /**
     * afterValidation事件
     * @see src/Anole/ActiveRecord/Anole_ActiveRecord_Base#afterValidation()
     */
    public function afterValidation(){
        $status = $this->getStatus();
        if($status == self::CHECKED_STATUS){
            $admin_id = Anole_Util_Cookie::getAdminID();
            $this->setPublishedOn(Common_Util_Date::getNow());
            $this->setPublishedBy($admin_id);
        }
    }
    
    public function beforeSave(){
        //检查所属栏目
        $this->_validateBelongSort();   
    }
    
    /**
     * afterDestroy事件
     * @see src/Anole/ActiveRecord/Anole_ActiveRecord_Base#afterDestroy()
     */
    public function afterDestroy(){
        $id = $this->getId();
        
        if(!empty($id)){
            self::debug("re article[$id] assets..", __METHOD__);
            
            $asset = new Common_Model_Asset();
            if(is_array($id)){
                foreach($id as $pid){
                    $condition = 'parent_id=? AND parent_type=?';
                    $vars = array($pid,Common_Model_Constant::ARTICLE_SOURCE);
                    
                    //删除文章的附件
                    $asset->destroyAll($condition,$vars);
                }
            }else{
                $condition = 'parent_id=? AND parent_type=?';
                $vars = array($id,Common_Model_Constant::ARTICLE_SOURCE);
                
                //删除文章的附件
                $asset->destroyAll($condition,$vars);
            }
            
            unset($asset);
            
            
            //清除关联表数据
           $dsql = 'DELETE FROM `content_sort` WHERE content_id=?';
           $this->getDba()->execute($dsql,array($id));
           
           //清除相关的meta
           $meta = new Common_Model_Meta();
           $meta->destroyAll('owner_id=? AND domain=?', array($id,Common_Model_Constant::ARTICLE_DOMAIN));
           
           unset($meta);
        }
       
        return true;
    }
    
    /**
     * 验证是否有需要更新的栏目
     * 
     * @return Common_Model_Article
     */
    protected function _validateBelongSort(){
        if(empty($this->_belongs_sorts)){
            return;
        }
        foreach($this->_belongs_sorts as $item){
            $this->addRelationModelData('sorts', $item);
        }
        //reset empty
        $this->_belongs_sorts = array();
        return $this;
    }
    /**
     * 添加所属栏目
     * 
     * @param int $sort_id
     * @return Common_Model_Article
     */
    public function addBelongSorts($sort_id){
        $this->_belongs_sorts[] = array('sort_id'=>$sort_id);
        return $this;
    }
    /**
     * 获取所属的栏目Id列表
     * 
     * @return array
     */
    protected function _getBelongSort(){
        $belong_ids = array();
        $id = $this->getId();
        if(empty($id)){
            return $belong_ids;
        }
        $sorts = $this->findRelationModel('sorts',array(),$id);
        $max = $sorts->count();
        if($max > 0){
            for($i=0;$i<$max;$i++){
                $belong_ids[] = $sorts[$i]['sort_id'];
            }
        }
        return $belong_ids;
    }
    
    /**
     * 删除旧key
     * 
     * @param $name
     * @return string
     */
    public function delMeta($name,$id=null){
        if(is_null($id)){
            $id = $this->getId();
        }
        if(empty($id)){
            return;
        }
        $sql = 'DELETE FROM meta WHERE owner_id=? AND name=? AND domain=?';
        $vars = array($id,$name,Common_Model_Constant::ARTICLE_DOMAIN);
        
        $this->getDba()->execute($sql,$vars);
    }
    /**
     * 设置一个meta值
     * 
     *
     * @param string $domain
     * @param string $name
     * @param mixed $value
     * @return Passport_Model_Product
     */
    public function addMeta($name,$value){
        self::debug("name: ".$name." value: ".$value, __CLASS__);
        $this->addRelationModelData('metas',array('name'=>$name,'value'=>$value,'domain'=>Common_Model_Constant::ARTICLE_DOMAIN));
        
        $this->delMeta($name);
        
        return $this;
    }
    /**
     * 获得指定key的meta的值
     *
     * @param string $name
     * @return string
     */
    public function getMeta($name){
        return $this->findRelationModel('metas',
            array('condition'=>'name=? AND domain=?',
                'vars'=>array($name,Common_Model_Constant::ARTICLE_DOMAIN),
                '_first'=>true
            ));
    }
    /**
     * 获取资讯的所有附件
     * 
     * @param int $id
     * @return array
     */
    public function fetchArticleAssets($id=null){
        $asset = new Common_Model_Asset();
        
        $options = array(
           'condition'=>'parent_id=? AND parent_type=?',
           'order'=>'created_on DESC',
           'vars'=>array($id, Common_Model_Constant::ARTICLE_SOURCE)
        );
        
        $assets = $asset->find($options)->getResultArray();
        if(!empty($assets)){
            for($i=0;$i<count($assets);$i++){
                $assets[$i]['url'] = Common_Util_Storage::getAssetUrl(Common_Model_Constant::ARTICLE_DOMAIN,$assets[$i]['path']);
            }
        }
        
        return $assets;
    }
    
    /**
     * 查找匹配指定条件的记录的数量，如果没有匹配则返回0
     *
     * @param string $condition
     * @param array $vars
     * @param string $table
     * @param string $joins
     * 
     * @return int
     */
    public function countIfRelated($condition=null,$vars=array(),$joins=null,$table=null){
        if(is_null($table)){
            $table = $this->tablelize();
        }else{
            $table = $this->tablelize($table);
        }
        $sql = 'SELECT COUNT(*) AS cnt FROM `'.$table.'`';
        
        if($joins){
            $sql .= " $joins "; 
        }
        if(!empty($condition)){
            $sql .= " WHERE $condition";
        }
        try{
            $rows = self::getDba()->query($sql,1,1,$vars);
        }catch(Anole_Dba_Exception $e){
            self::warn("count data error:".$e->getMessage(), __METHOD__);
        }
        return $rows[0]['cnt'];
    }
    
}
/**vim:sw=4 et ts=4 **/
?>