<?php

/**
 * GroupMembersForm class.
 */
class GroupMembersForm extends CFormModel
{
	public $groupMember;

	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			// array('newGroupName', 'required'),
			array('groupMember', 'safe')
			);
	}



	/**
	 * Method adding a memeber to the group
	 * @param string $group name of the group with domain added
	 */
	public function addMember($group)
	{
		$cli = $this->ConnectToCG();
		$cli->setDebug(1);
		$members = $cli->GetGroup($group);
		$members = $members['Members'];
		if ($members == 'NO') {
			$members = array();
		}
		array_push($members, $this->groupMember);
		$settings = $cli->GetGroup($group);
		$settings['Members'] = $members;
		$cli->SetGroup($group, $settings);

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