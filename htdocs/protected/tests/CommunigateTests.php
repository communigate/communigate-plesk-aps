<?php 

/**
 * This is helper function for connecting to the communigate server
 */
function ConnectToCG()
{
	$host = Yii::app()->params['host'];
	$port = Yii::app()->params['port'];
	$login = Yii::app()->params['login'];
	$password = Yii::app()->params['password'];
	$cli = new CLI;
    // $cli->setDebug(1);
	$cli->Login($host,$port,$login,$password);
	return $cli;
}



$cli = ConnectToCG();

$cli->GetAccountRPOP('svetlio@communigate-aps.com');