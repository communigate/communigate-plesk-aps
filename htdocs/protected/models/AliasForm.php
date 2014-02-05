<?php

include("CLI.php");

/**
 * AliasForm class.
 */
class AliasForm extends CFormModel
{
	public $aliasName;
	public $accountName;

	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			array('aliasName', 'required'),
			array('accountName', 'safe'),
			array('aliasName', 'uniqueAlias')
			);
	}

	/**
	 * Function validating the uniqueness of the alias
	 */
	public function uniqueAlias($attribute,$params)
	{
		$cli = $this->ConnectToCG();
		// $cli->setDebug(1);

		$domain = Yii::app()->params['domain'];

		$accounts = $cli->ListAccounts($domain);

		$accounts = array_keys($accounts);
		
		// Generating array with all aliaes
		foreach ($accounts as $account) {
			$aliases1[] = $cli->GetAccountAliases("$account@$domain");
		}
		foreach ($aliases1 as $alias) {
			foreach ($alias as $a) {
				$aliases[] = $a;
			}
		}

		if (isset($aliases)) {
			if (in_array($this->aliasName, $accounts) || in_array($this->aliasName, $aliases)) {
				$this->addError('aliasName', 'Account or Alias with that name already exists');
			}
		}
		
		$cli->Logout();
	}

	/**
	 * Method for creating an alias
	 */
	public function createAlias()
	{
		$cli = $this->ConnectToCG();
		// $cli->setDebug(1);

		foreach ($cli->GetAccountAliases($this->accountName) as $alias) {
			$aliases[] = $alias; 
		}



		if (empty($aliases)) {
			$aliases = array_fill(0,1, $this->aliasName);
				// }
		} else {
			array_push($aliases, $this->aliasName);
		}

		$cli->SetAccountAliases($this->accountName, $aliases);

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
