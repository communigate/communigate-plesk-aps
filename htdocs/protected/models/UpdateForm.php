<?php

include("CLI.php");

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class UpdateForm extends CFormModel
{
	public $accountName; // The account name of the user that updates his settings
	public $newAccountName; // The account name to wich the user wants to rename his account
	public $newAccountPassword; 
	public $accountType;
	public $realName;

	

	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			array('newAccountName, realName', 'required'),
			array('newAccountName', 'uniqueAccount'),
			array('accountType, accountName, newAccountPassword', 'safe'),
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
		if (in_array($this->newAccountName, $accounts) && $this->accountName !== $this->newAccountName) {
			$this->addError('newAccountName', 'Account Already Exists');
		}
		$cli->Logout();
	}

	/**
	 * Function for updating an account
	 */
	public function updateAccount()
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
			"ServiceClass" => $accountType,
			"RealName" => $this->realName,
			"MaxAccountSize" => "100k"
			);

		if (isset($this->newAccountName)) {
			$cli->RenameAccount("$this->accountName@$domain", "$this->newAccountName@$domain");
		}

		$cli->UpdateAccountSettings("$this->newAccountName@$domain",$UserData);

		if (isset($this->newAccountPassword) &&  $this->newAccountPassword !== "") {
			$cli->SetAccountPassword("$this->newAccountName@$domain",$this->newAccountPassword);
		}

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
