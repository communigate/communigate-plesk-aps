<?php

/**
 * RenameGroupForm class.
 */
class RenameGroupForm extends CFormModel
{
	public $newGroupName;
	public $oldGroupName;

	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			array('newGroupName', 'required'),
			array('oldGroupName', 'safe')
			);
	}

	/**
	 * Method for seting email archiving
	 */
	public function renameGroup()
	{
		$cli = $this->ConnectToCG();
		// $cli->setDebug(1);
		$domain = Yii::app()->params['domain'];
		$cli->RenameGroup($this->oldGroupName, "$this->newGroupName@$domain");
		if ($cli->getWords() !== 'OK') {
			$this->addError('newGroupName', $cli->getWords());
		} else {
			$cli->Logout();
			return true;
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