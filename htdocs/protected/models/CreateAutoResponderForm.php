<?php

/**
 * CreateAutoResponderForm class.
 */
class CreateAutoResponderForm extends CFormModel
{
	public $email;
	public $from;
	public $subject;
	public $body;
	public $ends;

	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			array('email, from, subject, body, ends', 'required'),
			// array('addressToForward', 'safe'),
			array('email', 'accountExists')
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

        if (strpos($this->email, "@$domain")) {
        	$whatIWant = substr($domain, strpos($domain, "@"));
            $email = str_replace($whatIWant, "", $this->email);
            $email = substr($email, 0, -1);
        } else {
        	$email = $this->email;
        }

		if (!in_array($email, $accounts)) {
			$this->addError('email', 'Account does not exist');
		}
		$cli->Logout();
	}

	/**
	 * Method for creating an auto responder
	 */
	public function createAutoResponder()
	{
		date_default_timezone_set("UTC"); 
		$domain = Yii::app()->params['domain'];

        if (strpos($this->email, "@$domain")) {
            $email = $this->email;
        } else {
            $email = $this->email . "@$domain";
        }

        $bodyWithRemovedNewLines = str_replace("\r\n", '\\e', $this->body);

		AutoResponders::addAutoResponder($email, date("d M Y", strtotime("$this->ends")),
		$this->subject, $this->from, $bodyWithRemovedNewLines);	
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
