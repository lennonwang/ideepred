<?php
define('ANOLE_PROJECT', 'Anole');
define('ANOLE_LIB_ROOT','/home/lennon/project/Anole/src');
define('ANOLE_DATA_ROOT','/opt/project/deepred/data');
require ANOLE_LIB_ROOT.'/Anole.php';
Anole::boot();
Anole_Dispatcher_Server::run();
?>
