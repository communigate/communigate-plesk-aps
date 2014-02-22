<?php

/**
 * EmailArchivingForm class.
 */
class EmailArchivingForm extends CFormModel
{
	public $archiveMessageAfter;
	public $deleteMessageAfter;

	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			array('archiveMessageAfter, deleteMessageAfter', 'safe'),
			);
	}

	/**
	 * Method for seting email archiving
	 */
	public function setEmailArchiving()
	{
		$cli = $this->ConnectToCG();
		// $cli->setDebug(1);
		$domain = Yii::app()->params['domain'];

		$cli->SetAccountDefaults(array('domainName'=>$domain, 'settings' => array(
			'ArchiveMessagesAfter' => $this->archiveMessageAfter,
			'DeleteMessagesAfter' => $this->deleteMessageAfter
			)));

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
