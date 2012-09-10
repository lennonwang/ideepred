<?php
/**
 * 产品的三级分类
 * 目前支持三级分类,代码编号：一级代码（1位）,二级代码（3位）,三级代码（4位）;
 * 
 * @version $Id$
 * @author purpen
 */
class Common_Model_Category extends Common_Model_Table_Category {
    
    //关系映射表
    protected $_relation_map = array(
    );
    /**
     * 默认的magic field
     */
    protected $_magic_field = array(
    );
    /**
     * 类别的分级
     * 
     * @var int
     */
    private $_type = null;
    /**
     * 父级分类代码
     * 
     * @var string
     */
    private $_parent_code = null;
    
    /*************辅助参数*************/
    public function setType($v){
    	$this->_type = $v;
    	return $this;
    }
    public function getType(){
    	return $this->_type;
    }
    
    public function setParentCode($v){
    	$this->_parent_code = $v;
    	return $this;
    }
    public function getParentCode(){
    	return $this->_parent_code;
    }
    /**
     * @return Common_Model_Category
     */
    public static function getModel($data=array(),$class=__CLASS__){
        return parent::getModel($data,$class);
    }
    /**
     * 自动生产分类代码
     * 
     * @see src/Anole/ActiveRecord/Anole_ActiveRecord_Base#beforeValidation()
     */
    public function beforeValidation(){
    	if($this->isNew()){
    		$type = $this->getType();
    		$parent_code = $this->getParentCode();
    		if(($type == 2 || $type == 3) && empty($parent_code)){
    			$this->pushValidateError('所属的父分类未选择！');
    			return false;
    		}
    		$code = $this->_GenCateCode($type,$parent_code);
    		
    		$this->setCode($code);
    	}
    }
    /**
     * 验证输入数据
     * 
     * @see src/Anole/ActiveRecord/Anole_ActiveRecord_Base#validate()
     */
    public function validate(){
        if($this->isNew()){
            $fields = array('name','code');
        }else{
            $fields = array('id');
        }
        if(!$this->validateRequird($fields)){
            return false;
        }
        return true;
    }
    
    /**
     * 生产分类代码
     * @return string
     */
    protected function _GenCateCode($type=1,$parent_code=null){
    	
    	switch($type){
    		
    		case 1: //一级分类
    			$options = array(
    			    'condition'=>'LENGTH(`code`)=?',
    			    'vars'=>array(1),
    			    'order'=>'id DESC'
    			);
    			$row = $this->findFirst($options)->getResultArray();
    			if(count($row) > 0){
    		        $code = chr(ord($row['code'])+1);
    			}else{
    				$code = chr(65);
    			}
    			$this->debug("gen category code [$code]", __METHOD__);
    			break;
    			
    		case 2: //二级分类
    			$is_end=false;
    			if(strlen($parent_code) != 1){
    				throw new Common_Model_Exception('类别级别与所属分类不符!');
    			}
                while(!$is_end){
                    $code = $parent_code.$this->_randString(3);
                    //检测是否已存在该分类代码
                    if(!$this->countIf('code=?',array($code))){
                        //不存在，则直接跳出，否则自动产生下一个代码，再进行检测
                        break;
                    }
                }
                break;
    		case 3: //二、三级分类
    			$is_end=false;
    	        if(strlen($parent_code) != 4){
                    throw new Common_Model_Exception('类别级别与所属分类不符!');
                }
                while(!$is_end){
                    $code = $parent_code.$this->_randString(4);
                    //检测是否已存在该分类代码
                    if(!$this->countIf('code=?',array($code))){
                        //不存在，则直接跳出，否则自动产生下一个代码，再进行检测
                        break;
                    }
                }
                break;
    		
    		default:
    			//skip
    			break;
    	}
    	
    	return $code;
    }
    /**
     * 获取一级分类
     * 
     * @return array
     */
    public function findFirstCategory(){
    	$options = array(
            'condition'=>'LENGTH(`code`)=? AND state=?',
            'vars'=>array(1,1),
            'order'=>'position ASC,id ASC'
        );
        return $this->find($options)->getResultArray();
    }
    /**
     * 获取某个一级分类的二、三级分类
     * 
     * @return array
     */
    public function findChildrenCategory($code,$is_stick=false,$size=-1){
    	if(!$is_stick){
    		$order = 'position ASC,id Asc';
    	}else{
    		$order = 'total DESC,id ASC';
    	}
    	
    	//不包含频道分类
    	$options = array(
            'condition'=>'LEFT(`code`,1)=? AND code <> ? AND state=?',
            'vars'=>array($code,$code,1),
            'order'=>$order,
    	    'page'=>1,
    	    'size'=>$size
        );
        $rows = $this->find($options)->getResultArray();
        $blank = 'oneblank';
        $twoblank = 'twoblank';
        for($i=0;$i<count($rows);$i++){
            if(strlen($rows[$i]['code']) == 4){
                $rows[$i]['classname'] = $blank;
            }
            if(strlen($rows[$i]['code']) == 8){
                $rows[$i]['classname'] = $twoblank;
            }
        }
        return $rows;
    }
    
    /**
     * 获取各级分类
     * 
     * @param $type
     * @return 
     */
    public function findAllCategory(){
    	$options = array(
            'condition'=>'state=?',
            'vars'=>array(1),
            'order'=>'position ASC,code ASC'
        );
        $rows = $this->find($options)->getResultArray();
        $blank = 'oneblank';
        $twoblank = 'twoblank';
        for($i=0;$i<count($rows);$i++){
        	if(strlen($rows[$i]['code']) == 4){
        		$rows[$i]['classname'] = $blank;
        	}
        	if(strlen($rows[$i]['code']) == 8){
        		$rows[$i]['classname'] = $twoblank;
        	}
        }
        return $rows;
    }
    
    /**
     * beforeDestroy事件
     * @see src/Anole/ActiveRecord/Anole_ActiveRecord_Base#beforeDestroy()
     */
    public function beforeDestroy(){
    	//检测是否有子分类
    	$id = $this->getId();
    	$row = $this->findById($id)->getResultArray();
    	if(count($row) > 0){
    		$code = $row['code'];
    		$condition = "LEFT(`code`,".strlen($code).")=? AND `code` != ?";
    		if($this->countIf($condition,array($code, $code))){
    			throw new Common_Model_Exception('该分类存在子分类不允许删除！');
    		}
    	}
    }
    /**
     * afterDestroy事件
     * @see src/Anole/ActiveRecord/Anole_ActiveRecord_Base#afterDestroy()
     */
    public function afterDestroy(){
    	
        //清除关联的附件
        $id = $this->getId();
        $asset_type = Common_Model_Constant::CATEGORY_THUMB;
        
        self::debug("Delete catgory belong asset parent_id[$id]、parent_type[$asset_type].", __METHOD__);
        
        $asset = new Common_Model_Asset();
        $condition = 'parent_id=? AND parent_type=?';
        $vars = array($id,$asset_type);
        $asset->destroyAll($condition,$vars);
        unset($asset);
        
        return true;
    }
    /**
     * 产生一个分类代码
     * 
     * @param int $len
     * @param string $chars
     * @return string
     */
    protected function _randString($len, $chars='QWERTYUIOPASDFGHJKLZXCVBNM'){
        $string = '';
        for($i=0;$i<$len;$i++){
            $pos = rand(0, strlen($chars)-1);
            $string .= $chars{$pos};
        }
        return $string;
    }
    /**
     * beforeCreate事件
     * @see src/Anole/ActiveRecord/Anole_ActiveRecord_Base#beforeCreate()
     */
    public function beforeCreate(){
    	
    }
    /**
     * afterCreate事件
     * @see src/Anole/ActiveRecord/Anole_ActiveRecord_Base#afterCreate()
     */
    public function afterCreate(){
    	
    }
    /**
     * beforeUpdate事件
     * @see src/Anole/ActiveRecord/Anole_ActiveRecord_Base#beforeUpdate()
     */
    public function beforeUpdate(){
    	
    }
    /**
     * afterUpdate事件
     * @see src/Anole/ActiveRecord/Anole_ActiveRecord_Base#afterUpdate()
     */
    public function afterUpdate(){
        
    }
    
    /**
     * check hasn't children of current category
     */
    public function hasChildren(){
        
    }
    
    /**
     * 查找当前分类到根分类的id数组
     * 
     * 返回一个数组的顺序就是根分类
     * 
     * 到当前分类的id数组 
     */
    public function findRootIdPath($id=null){
        
    }
    /**
     * 查找从根分类到目标分类途径的所有分类(包括根分类和目标分类)
     *
     * @param string $code
     * @return Common_Model_Category
     */
    public function findRootNodePath($code){
        $length = strlen($code);
        
        switch($length){
        	case 1:
        		//二级分类
        		$parent_code = substr($code,0,1);
        		$options = array(
        		    'condition'=>'code IN (?,?) AND state=?',
        		    'vars'=>array($parent_code,$code,1),
        		    'order'=>'code ASC'
        		);
        		break;
        	case 4:
        			//二级分类
        			$parent_code = substr($code,0,1);
        			$options = array(
        					'condition'=>'code IN (?,?) AND state=?',
        					'vars'=>array($parent_code,$code,1),
        					'order'=>'code ASC'
        			);
        			break;
        	case 8:
        		//三级分类
        		$first_parent_code = substr($code,0,1);
        		$parent_code = substr($code,1,3);
        		$options = array(
                    'condition'=>'code IN (?,?,?) AND state=?',
                    'vars'=>array($first_parent_code,$parent_code,$code,1),
        		    'order'=>'code ASC'
                );
        		break;
        }
        
        if(isset($options) && !empty($options)){
        	return $this->find($options)->getResultArray();
        }
        
    }
    
    /**
     * 查找指定分类的所有子(孙)分类(包括分类本身)
     *
     * @param int $parentId 1 表示根分类
     * @param boolean $recursive 是否递归到子孙分类,若false只返回一级子分类
     * 
     * @return Common_Model_Category
     */
    public function findAllChildrenNodes($parentId=1,$recursive=true){
        
    }
    
    /**
     * 查找当前分类的所有非子孙的分类
     *
     * @param int $id
     * @return Common_Model_Category
     */
    public function findAllNonChildrenNodes($id=null){
        
    }
    /**
     * 递归算法，创建分类树结构，废弃！
     * 
     * @return void
     */
    public function buildCategoryTree($level=2){
        
    }
}
/**vim:sw=4 et ts=4 **/
?>