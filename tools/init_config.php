<?php
/**
 * 所有PHP脚本运行的初始环境装配
 * @see app
 * 
 * @version $Id$
 * @author purpen
 */
define('ANOLE_PROJECT', 'Anole');
define('ANOLE_LIB_ROOT','/Users/lennon/project/Anole/src');
define('ANOLE_DATA_ROOT','/Users/lennon/project/ideepred/data');
require ANOLE_LIB_ROOT.'/Anole.php';
Anole::boot();
?>