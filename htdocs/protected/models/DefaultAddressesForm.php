<?php

/**
 * DefaultAddressesForm class.
 */
class DefaultAddressesForm extends CFormModel
{
	public $domainName;
	public $setDefaultBehavior;
	public $addressToForwardTo;

	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			array('domainName, setDefaultBehavior , addressToForwardTo ', 'safe')
			);
	}

	public function setDefaultAddresses()
	{
		$cli = self::ConnectToCG();
		$domain = $this->domainName;
		// $cli->setDebug(1);
		$domainData = array(
			"domainName" => $domain,
			"settings" => array(
				"MailToUnknown" => $this->setDefaultBehavior,
				'MailRerouteAddress' => $this->addressToForwardTo
				)
			);
		$cli->UpdateDomainSettings($domainData);
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
