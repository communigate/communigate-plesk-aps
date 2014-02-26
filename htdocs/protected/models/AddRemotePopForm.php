<?php

/**
 * AddRemotePopForm class.
 */
class AddRemotePopForm extends CFormModel
{
	public $account;

	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			// array('newGroupName', 'required'),
			array('account', 'safe')
			);
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