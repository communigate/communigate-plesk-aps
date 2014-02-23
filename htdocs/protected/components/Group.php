<?php 
/**
* 			
*/
class Group extends CComponent
{
	
	private $groups;
	private $domain;


	function __construct($domain)
	{
		$this->domain = $domain;
		$this->setGroups();
	}

	/**
	 * A set method for groups varliable
	 * if there are no groups it is an empty array
	 */
	public function setGroups()
	{
		$cli = self::ConnectToCG();
		$this->groups = $cli->ListGroups($this->domain);
	}

	/**
	 * Method removing a member from certein group
	 * @param  int $member the index of the member in the array
	 * @param  string $group  the name of the group with domain added
	 */
	public function removeMember($member, $group)
	{
		$cli= $this->ConnectToCG();
		$members = $cli->GetGroup($group);
		$members = $members['Members'];
		unset($members[$member]);
		//Restore the indexes of the array after removing
		$members = array_values($members);
		$settings = $cli->GetGroup($group);
		$settings['Members'] = $members;
		$cli->SetGroup($group, $settings);
	}

	public function getDataForGroupMembers($group)
	{
		
		$cli = $this->ConnectToCG();
		$members = $cli->GetGroup($group );
		if (isset($members['Members']) && $members['Members'] !== 'NO') {
			$groupMembers = $members['Members'];
		} else {
		$groupMembers = array();
		}
		if (!empty($groupMembers)) {
			for ($i=0; $i < count($groupMembers); $i++) { 

				$member = $groupMembers[$i];

				$data[$i] = (
					array('id'=> $i,
						'pagination'=>array(
							'pageSize'=>5,),
						'member'=> $member,
						));

			}
			$dataProvider = new CArrayDataProvider($data);
			return $dataProvider;
		} else {
			return new CArrayDataProvider(array());
		}
	}

	/**
	 * Method for getting the data for the grid view
	 * @return CArrayDataProvider data for the grid view
	 */
	public function getDataForGridView()
	{
		if (!empty($this->groups)) {

			for ($i=0; $i < count($this->groups); $i++) { 
				
				$group = $this->groups[$i] . "@$this->domain";

				$data[$i] = (
					array('id'=> $i,
						'pagination'=>array(
							'pageSize'=>5,),
						'group'=> $group,
						));

			}
			$dataProvider = new CArrayDataProvider($data);
			return $dataProvider;
		} else {
			return new CArrayDataProvider(array());
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

?>