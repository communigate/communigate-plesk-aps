<?php

/**
 * CreateFilterForm class.
 */
class CreateFilterForm extends CFormModel
{
	public $name;
	public $priority;
	public $data;
	public $operation;
	public $dataParam;
	public $action;
	public $actionParam;

	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			array('name', 'required'),
			array('priority, data, operation, dataParam, action, actionParam', 'safe'),
			);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'data'=>'Rules',
			'operation' => '',
			'actionParam' => '',
			'dataParam' => '',
		);
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
