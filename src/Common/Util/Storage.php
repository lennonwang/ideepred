<?php
/**
 * File Storage System Class
 *
 * @version $Id$
 * @author purpen
 */
class Common_Util_Storage extends Anole_Object {
    /**
     * 将文件存储到附件区域
     *
     * @param string $domain
     * @param string $path
     * @param string $file
     */
    public static function storeAsset($domain,$path,$file){
        $storage = Anole_Storage_Manager::getDomainByKey($domain);
        try{
            $storage->storeFile($path,$file);
        }catch(Anole_Storage_Exception $e){
            self::warn("failed store asset:[domain:$domain][path:$path][file:$file]", __CLASS__);
            throw new Common_Util_Exception('failed store asset into '.$path);
        }
    }
    /**
     * 将字符串存储为文件
     *
     * @param string $domain
     * @param string $path
     * @param string $content
     */
    public static function storeData($domain,$path,$content){
        $storage = Anole_Storage_Manager::getDomainByKey($domain);
        try{
            $storage->store($path,$content);
        }catch(Anole_Storage_Exception $e){
            self::warn("failed store asset:[domain:$domain][path:$path]",__CLASS__);
            throw new Common_Util_Exception('failed store asset into '.$path);
        }
    }
    /**
     * 删除指定域的附件
     *
     * @param string $domain
     * @param string $path
     * @return boolean
     */
    public static function deleteAsset($domain,$path){
        $storage = Anole_Storage_Manager::getDomainByKey($domain);
        try{
            $storage->delete($path);
            return true;
        }catch(Anole_Storage_Exception $e){
            self::warn("failed delete asset:[domain:$domain][path:$path]",__METHOD__);
            //skip,exception
        }
        return false;
    }
    
    /**
     * 获得附件绝对路径
     *
     * @param string $domain
     * @param string $path
     * @return string
     */
    public static function getAssetPath($domain,$path){
        $storage = Anole_Storage_Manager::getDomainByKey($domain);
        return $storage->getPath($path);
    }
    /**
     * 获得附件的url
     *
     * @param string $domain
     * @param string $path
     * @return string
     */
    public static function getAssetUrl($domain,$path){
        $storage = Anole_Storage_Manager::getDomainByKey($domain);
        return $storage->getUri($path);
    }
    /**
     * 获取专题的上传路径
     * 
     * @param string $name
     * @return string
     */
    public static function getTopicPath($name){
    	$topic_root = Anole_Config::get('runtime.topic.root');
        return $topic_root.'/'.$name;
    }
}
/**vim:sw=4 et ts=4 **/
?>