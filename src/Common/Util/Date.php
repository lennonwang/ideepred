<?php
/**
 * 时间转换类
 * 
 * @author purpen
 * @version $Id$
 */ 
class Common_Util_Date extends Anole_Object {
    public static $TimeZone='Etc/GMT-8';
    
    public function __construct(){}
    
    public static function  setTimezone(){
        @date_default_timezone_set(self::$TimeZone);
    }    
    /**
     * 获取当前日期
     * 
     * @return string
     */
    public static function getDate(){
        self::setTimezone();
        return self::Dates('Y-m-d',time());
    }
    
    public static function getUnixTimestamp(){
        return time();
    }
    
    /**
     * 返回当前日期和时间
     * 用于保存数据库时,生成相应的datetime字段
     * @return string
     */
    public static function getNow(){
        self::setTimezone();
        return self::Dates('Y-m-d H:i:s',time());
    }
    
    /**
        * 得到两时间差
        * @var: $date1      ->时间一
                $date2      ->时间二
                $interval   ->（时间间隔字符串表达式）可以是以下任意值:  
                    y year年  366天
                    m month月  30天
                    w Weekday一周的天数 7天
                    d Day天 24小时
                    h Hour小时 3600秒
                    n Minute分  
                    s Second秒 
        * @return: 整数
    */
    public static function dateDiff($interval,$date1,$date2)  { 
        $timedifference = strtotime($date2) - strtotime($date1); // 得到两日期之间间隔的秒数 
        switch ($interval){
            case "y": $retval = floor($timedifference/31622400);break;
            case "m": $retval = floor($timedifference/2592000);break;
            case "w": $retval = floor($timedifference/604800); break; 
            case "d": $retval = floor($timedifference/86400); break; 
            case "h": $retval = floor($timedifference/3600); break; 
            case "n": $retval = floor($timedifference/60); break; 
            case "s": $retval = $timedifference; break; 
        } 
        return intval($retval);
    }
    
    /**
     * 当前时间和某个特定时间的时间差
     * 
     * @var:$date1特定时间，$date2当前时间
     * 
     * @return :秒、分钟、天、周、月、年
     */
    public static function dateToString($date1,$date2){
        $stry = self::dateDiff('y',$date1,$date2);
        if($stry >= 1){
            return $stry.'年';
        }
        $strm = self::dateDiff('m',$date1,$date2);
        if($strm >= 1){
            return $strm.'月';
        }
        $strw = self::dateDiff('w',$date1,$date2);  
        if($strw >= 1){
            return $strw.'周';
        }
        $strd = self::dateDiff('d',$date1,$date2);  
        if($strd >= 1){
            return $strd.'天';
        }       
        $strh = self::dateDiff('h',$date1,$date2);  
        if($strh >= 1){
            $timeh = strtotime($date2) - strtotime($date1);
            $h = date('i',$timeh);
            $s = date('s',$timeh);
            return $strh.'小时'.$h.'分';
        }           
        $strn = self::dateDiff('n',$date1,$date2);  
        if($strn >= 1){
            $timeh = strtotime($date2) - strtotime($date1);
            $s = date('s',$timeh);
            return $strn.'分'.$s.'秒';
        }
        $strs = self::dateDiff('s',$date1,$date2);  
        if($strs >= 1){
            return $strs.'秒';
        }
    }
    
    /**
     * 返回指定时间增加或者减少的间隔的日期
     *
     * @param 要增加的类型[年(y),月(m),日(d),周(w),时(h),分(i),秒(s)] $int
     * @param 要增加的数量 负数 减少的数量 为正数 $num
     * @param 指定日期[2007-09-05 12:13:14] $datetime
     * 
     * @return 添加后的正确日期[2007-09-05 12:13:14]
     */
    public static function dateTimeAddMinus($int,$num,$datetime){
        $array = getdate(strtotime($datetime));
        
        $hour = $array["hours"];
        $minute = $array["minutes"];
        $second = $array["seconds"];
        $month = $array["mon"];
        $day = $array["mday"];
        $year = $array["year"];
        
        switch ($int){ 
            case "y": $year -= $num; break;
            case "m": $month -= $num; break;
            case "d": $day -= $num; break;
            case "w": $day -= ($num*7); break;
            case "h": $hour -= $num; break;
            case "i": $minute -= $num; break;
            case "s": $second -= $num; break;
        }
        
        $timestr = mktime($hour,$minute,$second,$month,$day,$year);
        $timestr = date('Y-m-d H:i:s',$timestr);
        
        return $timestr;
    }
    
    /**
     * 从时间串获取时间戳
     * 
     * @param $datetime
     * @return int
     */
    public static function mkTimestamp($strtime){
        $ary = explode('-',$strtime);
        $year = $ary[0];
        $month = $ary[1];

        $ary = explode(':',$ary[2]);
        $minute = $ary[1];
        $second = $ary[2];
        
        $ary = explode(' ', $ary[0]);
        $day = $ary[0];
        $hour = $ary[1];
        
        $timestamp = mktime($hour,$minute,$second,$month,$day,$year);
        
        return $timestamp;
    }
    
    public static function Dates($format,$time){
        return @Date($format,$time);
    }
}
/**vim:sw=4 et ts=4 **/
?>