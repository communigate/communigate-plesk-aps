<?php

/**
 * CreateGroupForm class.
 */
class CreateGroupForm extends CFormModel
{
	public $groupName;
	public $groupEmailAdress;


	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			array('groupEmailAdress', 'required'),
			array('groupName', 'safe')
			);
	}

	public function createGroup()
	{
		$cli = $this->ConnectToCG();
		$settings = array(
			"Expand"=>"YES",
			"Members"=>array(),
			"RejectAutomatic"=>"YES",
			"RemoveAuthor"=>"YES",
			"RemoveToAndCc"=>"YES",
			"SetReplyTo"=>"YES",
			"EmailDisabled"=> "NO",
			"FinalDelivery"=> "NO",
			"SignalDisabled"=>"NO",
			"RealName"=>""
			);
		$domain = Yii::app()->params['domain'];
		if ($this->groupName !== '') {
			$settings['RealName'] = $this->groupName;
		}
		$cli->CreateGroup("$this->groupEmailAdress@$domain", $settings);
		if ($cli->getWords() !== 'OK') {
			$this->addError('groupEmailAdress', $cli->getWords());
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