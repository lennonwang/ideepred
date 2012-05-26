<?php
/**
 * 常用数据集
 * 
 * @author purpen
 * @version $Id$
 */ 
class Admin_Util_DataSet extends Anole_Object {	
    /**
     * 获取数组的key
     * 
     * @param $array1
     * @param $target
     * @return string
     */
    public static function fetchKeys($array1, $target){
        $keys = array();
        self::warn("product [$target]!", __METHOD__);
        $_values = preg_split('/\s+/', trim($target));
        foreach($_values as $v1){
            while(list($key, $v2) = each($array1)){
                if($v2 == $v1){
                	self::warn("one key [$key]!", __METHOD__);
                    $keys[] = $key;
                    break;
                }
            }
        }
        
        return implode(' ', $keys);
    }
    /**
     * 获取数组的value
     * 
     * @param $array1
     * @param $target
     * @return string
     */
    public static function fetchValues($array1,$target){
        $values = array();
        $_keys = preg_split('/\s+/', trim($target));
        foreach($_keys as $k1){
            while(list($k2, $value) = each($array1)){
                if($k2 == $k1){
                    $values[] = $value;
                    break;
                }
            }
        }
        
        return implode(' ', $values);
    }
}
/**vim:sw=4 et ts=4 **/
?>