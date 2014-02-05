<?php

include("CLI.php");

/**
 * SubscribeForm class.
 */
class SubscribeForm extends CFormModel
{
	public $accountName;
	// public $accountPassword;
	public $listName;

	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			array('accountName', 'required'),
			array('accountPassword, listName', 'safe'),
			);
	}

	/**
	 * Method to subscribe user to the current mailing list
	 */
	public function subscribe()
	{
		$cli = self::ConnectToCG();
		$domain = Yii::app()->params['domain'];
		// $cli->setDebug(1);
		// echo 'penco';
		$cli->SendCommand("LIST $this->listName@$domain subscribe $this->accountName");
		if ($cli->getErrMessage() !== 'OK') {
			echo $cli->getErrMessage();
		}
	}

	/**
	 * Method to unsubscribe user from the current mailing list
	 */
	public function unsubscribe()
	{
		$cli = self::ConnectToCG();
		$domain = Yii::app()->params['domain'];
		$cli->SendCommand("LIST $this->listName@$domain unsubscribe $this->accountName@$domain");
		if ($cli->getErrMessage() !== 'OK') {
			echo $cli->getErrMessage();
		}
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
