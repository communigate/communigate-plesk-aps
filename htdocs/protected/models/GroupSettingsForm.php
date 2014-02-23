<?php

/**
 * GroupSettingsForm class.
 */
class GroupSettingsForm extends CFormModel
{
	public $realName;
	public $settings;


	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			array('realName', 'safe'),
			array('settings', 'boolean')
			);
	}

	/**
	 * Method for seting email archiving
	 */
	public function changeSettingsForGroup($group)
	{
		$cli = $this->ConnectToCG();
		// $cli->setDebug(1);
		$domain = Yii::app()->params['domain'];
		$settings = $cli->GetGroup($group);
		
		foreach ($settings as $setting => $enabled) {
			if (is_array($this->settings) && in_array($setting, $this->settings)) {
				$settings[$setting] = 'YES';
			} else {
				$settings[$setting] = 'NO';
			}
		}

		$settings['RealName'] = $this->realName;

		$cli->SetGroup($group, $settings);

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