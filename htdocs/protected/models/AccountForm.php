<?php

include("CLI.php");

/**
 * The form model for creating accounts
 */
class AccountForm extends CFormModel
{
	public $accountName;
	public $accountPassword;
	public $accountType;
	public $realName;

	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			array('accountName, accountPassword, realName,', 'required'),
			array('accountName', 'uniqueAccount'),
			array('accountType', 'safe')
			);
	}	

	/**
	 * Function validating the uniqueness of the account
	 */
	public function uniqueAccount($attribute,$params)
	{
		$cli = $this->ConnectToCG();
		// $cli->setDebug(1);
		$domain = Yii::app()->params['domain'];

		$accounts = $cli->ListAccounts($domain);

		$accounts = array_keys($accounts);

		// Generating array with all aliaes
		foreach ($accounts as $account) {
			$aliases1[] = $cli->GetAccountAliases("$account@$domain");
		}

		if (isset($aliases1)) {
			foreach ($aliases1 as $alias) {
				foreach ($alias as $a) {
					$aliases[] = $a;
				}
			}
		}

		$forwarders = $cli->ListForwarders($domain);
		

		if (isset($aliases)) {
			if (in_array($this->accountName, $accounts) || in_array($this->accountName, $aliases) || in_array($this->accountName, $forwarders)) {
				$this->addError('accountName', 'Account, Alias or Forwarder with that name already exists');
			}
		}

		$cli->Logout();
	}


	/**
	 * Function to create an account
	 */
	public function createAccount()
	{

		if ($this->accountType === null) {
			$accountType = "";
		} else {
			$accountType = $this->accountType;
		}

		$cli = $this->ConnectToCG();
		// $cli->setDebug(1);
		$domain = Yii::app()->params['domain'];

		$UserData = array(
			"accountName" => "$this->accountName@$domain",
			"settings" => array(
				"ServiceClass" => $accountType,
				"RealName" => $this->realName,
				"MaxAccountSize" => "100k"
				)
			);

		$cli->CreateAccount($UserData);
		$cli->SetAccountPassword("$this->accountName@$domain",$this->accountPassword);
		$cli->Logout();
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
