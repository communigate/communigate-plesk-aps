<?php

/**
 * SververConfigForm class.
 */
class ServerConfigForm extends CFormModel
{

		// 	'webmail' => 'http://77.77.150.135:8100/',
		// 'host' => '77.77.150.135',
		// 'port' => 11106,
		// 'login' => 'postmaster',
		// 'password' => 'jR6]FKhi'


	public $webmail;
	public $host;
	public $port;
	public $userName;
	public $password;

	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			array('host, port, userName, password, webmail', 'required'),
			// array('addressToForward', 'safe'),
			// array('addressToForward', 'forwarderValidation')
			);
	}

	// /**
	//  * Function validating the forwarder name
	//  */
	// public function forwarderValidation($attribute,$params)
	// {
	// 	$cli = $this->ConnectToCG();
	// 	// $cli->setDebug(1);
	// 	$domain = Yii::app()->params['domain'];

	// 	$accounts = $cli->ListAccounts($domain);

	// 	$accounts = array_keys($accounts);
	// 	$forwarders = $cli->ListForwarders($domain);

	// 	// Generating array with all aliaes
	// 	foreach ($accounts as $account) {
	// 		$aliases1[] = $cli->GetAccountAliases("$account@$domain");
	// 	}
	// 	foreach ($aliases1 as $alias) {
	// 		foreach ($alias as $a) {
	// 			$aliases[] = $a;
	// 		}
	// 	}
	// 	if (isset($aliases)) {
	// 		if (in_array($this->addressToForward, $accounts) ||
	// 		 	in_array($this->addressToForward, $aliases) ||
	// 		 	in_array($this->addressToForward, $forwarders)) {
	// 			$this->addError('addressToForward', 'Forwarder, Account or Alias with that name already exists');
	// 		}
	// 	}

	// 	$cli->Logout();
	// }

	/**
	 * Method for creating an alias
	 */
	public function setConfigurations()
	{
		$file = dirname(__FILE__).'/../config/params.inc';
		$content = file_get_contents($file);
		$arr = unserialize(base64_decode($content));
        // var_dump($this->attributes);

		$config = array(        
			'webmail'=>$this->attributes['webmail'],
			'port'=>$this->attributes['port'],
			'host'=>$this->attributes['host'],
			'login'=> $this->attributes['userName'],
			'password' => $this->attributes['password']
			);
		$str = base64_encode(serialize($config));
        file_put_contents($file, $str);


	}

	/**
	 * This is helper function for connecting to the communigate server
	 */
	public function ConnectToCG()
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
}
