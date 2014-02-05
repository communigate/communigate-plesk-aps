<?php

include("CLI.php");

/**
 * The form model for creating accounts
 */
class MailingListUpdateForm extends CFormModel
{
	public $owner;
	public $subscribe;
	public $confirmationRequestSubject;
	public $confirmationRequestText;
	public $policyMessageSubject;
	public $policyMessageText;
	public $serviceFields;
	public $postingSizeLimit;
	public $feedModeTrailer;
	public $warningMessageSubject;
	public $wrningMessageText;
	public $goodbyeMessageSubject;
	public $goodbyeMessageText;


	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			array('owner,
				subscribe,
				confirmationRequestSubject,
				confirmationRequestText,
				policyMessageSubject,
				policyMessageText,
				serviceFields,
				postingSizeLimit,
				feedModeTrailer,
				warningMessageSubject,
				wrningMessageText,
				goodbyeMessageSubject,
				goodbyeMessageText', 'safe')
			);
	}	

	/**
	 * Method updating the mailing list settings
	 */
	public function updateMailingList()
	{
		$cli = self::ConnectToCG();
		$settings = array(
			'Subscribe'=>(string)$this->subscribe,
			'ConfirmationSubject'=>$this->confirmationRequestSubject,
			'ConfirmationText'=>$this->confirmationRequestText,
			'PolicySubject'=>$this->policyMessageSubject,
			'PolicyText'=>$this->policyMessageText,
			'ListFields'=>$this->serviceFields,
			'SizeLimit'=>$this->postingSizeLimit,
			'TOCTrailer'=>$this->feedModeTrailer,
			'WarningSubject'=>$this->warningMessageSubject,
			'WarningText'=>$this->wrningMessageText,
			'ByeSubject'=>$this->goodbyeMessageSubject,
			'ByeText'=>$this->goodbyeMessageText,
			);

		$domain = Yii::app()->params['domain'];
		$list = Yii::app()->request->getParam('mailingList');
		// $cli->setDebug(1);
		$cli->UpdateList("$list@$domain", $settings);
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
