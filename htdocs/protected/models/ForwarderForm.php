<?php

/**
 * ForwarderForm class.
 */
class ForwarderForm extends CFormModel
{
	public $addressToForward;
	public $destination;

	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			array('addressToForward, destination', 'required'),
			array('addressToForward', 'forwarderValidation'),
			array('addressToForward', 'adressBelongToDomain'),
			array('destination', 'email'),
			);
	}

	/**
	 * Function validating the forwarder name
	 */
	public function forwarderValidation($attribute,$params)
	{
		$cli = $this->ConnectToCG();
		$domain = Yii::app()->params['domain'];

		$forwarders = $cli->ListForwarders($domain);
		
		if (in_array($this->addressToForward, $forwarders)) {
			$this->addError('addressToForward', 'Forwarder with that name already exists');
		}
	
		$cli->Logout();
	}

	/**
	 * Function validating if the account with domain is in this domain
	 */
	public function adressBelongToDomain($attribute,$params)
	{
		$cli = $this->ConnectToCG();
		// $cli->setDebug(1);
		$domain = Yii::app()->params['domain'];

        $whatIWant = substr($this->addressToForward, strpos($this->addressToForward, "@"));

        // var_dump($this->addressToForward);

        if (strpos($this->addressToForward, "@")) {
            if ($whatIWant === "@$domain"){
                return true;
            } else {
                $this->addError('addressToForward', 'The email doesn\'t belong to this domain');
                return false;
            }
        } else {
            return true;
        }

        $cli->Logout();



		
		if (in_array($this->addressToForward, $forwarders)) {
			$this->addError('addressToForward', 'Forwarder with that name already exists');
		}

		
		$cli->Logout();
	}

	/**
	 * Method for adding a Forwarder
	 */
	public function addForwarder()
	{
		$cli = $this->ConnectToCG();
		// $cli->setDebug(1);
        $domain = Yii::app()->params['domain'];

        // Проверка дали потребителя не е въвел и домейна към акаунта
        // ако е въвел то въведеното си остава, ако не е то домейна се добавя
        if (strpos($this->addressToForward, "@$domain")) {
            $addressToForward = $this->addressToForward;
        } else {
            $addressToForward = $this->addressToForward . "@$domain";
        }     
        $destination = $this->destination;
        Forwarders::addForwarder($addressToForward, $destination, $domain);

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
