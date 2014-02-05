<?php
$file = dirname(__FILE__).'/params.inc';
$content = file_get_contents($file);
$arr = unserialize(base64_decode($content));
return CMap::mergeArray(
        $arr,
        array(
		'adminEmail'=>'webmaster@example.com',
	// // 	'webmail' => 'http://77.77.150.135:8100/',
	// 	'host' => '77.77.150.135',
	// 	// 'port' => 11106,
	// 	'login' => 'postmaster',
	// 	'password' => 'jR6]FKhi',
		'domain' => $_SERVER['HTTP_HOST']
        )
    )
;
?>