<?php

include("CLI.php");

/**
 * The form model for creating accounts
 */
class MailingListCreationForm extends CFormModel
{
	public $accountName;
	// public $accountPassword;
	public $mailingListName;

	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			array('accountName, mailingListName', 'required'),
			array('accountName', 'accountExists'),
			array('mailingListName', 'uniqueMailingList'),
			// array('accountPassword', 'validatePassword'),
			// array('accountPassword', 'safe')
			);
	}	

	/**
	 * Function validating if the account exists
	 */
	public function accountExists($attribute,$params)
	{
		$cli = $this->ConnectToCG();
		// $cli->setDebug(1);
		$domain = Yii::app()->params['domain'];

		$accounts = $cli->ListAccounts($domain);

		$accounts = array_keys($accounts);

		if (!in_array($this->accountName, $accounts)) {
			$this->addError('accountName', 'Account does not exist');
		}
		$cli->Logout();
	}

	/**
	 * Function validating if the account exists
	 */
	// public function validatePassword($attribute,$params)
	// {
	// 	$cli = $this->ConnectToCG();
	// 	// $cli->setDebug(1);
	// 	$domain = Yii::app()->params['domain'];

	// 	$cli->VerifyAccountPassword("$this->accountName@$domain", "$this->accountPassword");
	// 	$test = $cli->getWords();
		
	// 	if ( $test !== "OK") {
	// 		$this->addError('accountPassword', 'Incorrect Password');
	// 	}
	// 	$cli->Logout();
	// }

	/**
	 * Function validating if the mailing name already 
	 * exists
	 */
	public function uniqueMailingList($attribute,$params)
	{
		$cli = $this->ConnectToCG();
		// $cli->setDebug(1);
		$domain = Yii::app()->params['domain'];

		$mailingLists = $cli->ListLists($domain);

		if (in_array($this->mailingListName, $mailingLists)) {
			$this->addError('mailingListName', "Mailing List \"$this->mailingListName\" already exist");
		}
		$cli->Logout();
	}

	public function createMailingList()
	{
		$cli = self::ConnectToCG();
		// $cli->setDebug(1);
		$domain = Yii::app()->params['domain'];
		$cli->CreateList("$this->mailingListName@$domain", "$this->accountName");
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
