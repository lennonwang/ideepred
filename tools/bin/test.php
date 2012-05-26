<?php

require_once '../init_config.php';
$post = array(
    'mailto'=>'tianxiaoyi@chinavisual.com',
    'subject'=>'sju',
    'body'=>'conetent',
    'from'=>'',
    'from_name'=>'xx',
);
print_r($post);
$ok = Anole_Util_Mail::send($post['mailto'],$post['subject'],stripslashes($post['body']),$post['from'],$post['from_name']);

print $ok."\r\n";
?>
