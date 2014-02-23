<?php

/**
 * Controller for Groups actions 
 * impelenting CRUD functionality for groups 
 * and adding and removing members to a group
 */
class GroupController extends Controller
{
	
	/**
	 * Action rendering the grid view with groups
	 * and operations to them
	 */
	public function actionIndex()
	{
		$domain = Yii::app()->params['domain'];
		$group = new Group($domain);
		$dataProvider = $group->getDataForGridView();

		$this->render('index',array(
			'gridDataProvider' => $dataProvider

			));
	}


	public function actionGroupMembers($group)
	{
		
		$model = new GroupMembersForm;

		if (Yii::app()->request->isAjaxRequest) {
			if (!empty($_POST) || isset($_POST['GroupMembersForm'])) {
				$model->attributes = $_POST['GroupMembersForm'];
				$model->addMember($group);
				Yii::app()->end();
			}
		}
		
		$domain = Yii::app()->params['domain'];
		$groupObj = new Group($domain);
		$dataProvider = $groupObj->getDataForGroupMembers($group);
		$cli = $this->ConnectToCG();
		$accounts = array_keys($cli->ListAccounts($domain));
		foreach ($accounts as $index => $account) {
			$accounts[$index] = $account . "@$domain";
		}

		$this->render('groupMembers', array(
			'model' => $model,
			'dataProvider' => $dataProvider,
			'accounts' => array_combine($accounts, $accounts),
			));
	}

	public function actionremoveGroupMembers($member, $group)
	{
		$domain = Yii::app()->params['domain'];
		$groupObj = new Group($domain);
		$groupObj->removeMember($member, $group);
	}

	public function actionCreate()
	{
		$model = new CreateGroupForm;

		if (isset($_POST['CreateGroupForm'])) {
			$model->attributes = $_POST['CreateGroupForm'];
			$model->createGroup();
			$this->redirect(array('group/index'));

		}


		$this->render('create', array(
			'model' => $model
			));
	}




	/**
	 * Action for changing settings of groups
	 * @param  string $group name of the group with domain added
	 */
	public function actionSettings($group)
	{
		$model = new GroupSettingsForm;

		$settings = $this->getSelectedSettings($group);

		$preselect = $settings[0];
		$model->realName = $settings[1];


		if (isset($_POST['GroupSettingsForm'])) {
			$model->attributes = $_POST['GroupSettingsForm'];
			$model->changeSettingsForGroup($group);
			$this->redirect(array('group/index'));
		}

		$this->render('settings', array(
			'model' => $model,
			'preselect' => $preselect, 
			));
	}


	/**
	 * Action for renameing groups
	 * @param  string $group group name with domain added
	 */
	public function actionRename($group)
	{
		$model = new RenameGroupForm;

		if (isset($_POST['RenameGroupForm'])) {
			$model->attributes = $_POST['RenameGroupForm'];
			if ($model->renameGroup()) {
				$this->redirect(array('group/index'));
			}
		}
		$this->render('rename', array('model' => $model));
	}


	/**
	 * Action for deleting groups
	 * @param  string $group name of the group with domain added
	 */
	public function actionDelete($group)
	{
		$cli = $this->ConnectToCG();
	    // $cli->setDebug(1);
		$cli->DeleteGroup("$group");
		$cli->Logout();
	}


	/**
	 * Method to getting the group setting to be checked
	 * @param  string $group name og group with added domain
	 * @return array        elements to be selected
	 */
	private function getSelectedSettings($group){

		$cli = $this->ConnectToCG();
		$settings = $cli->GetGroup($group);
		$preselect= array();
		foreach ($settings as $setting => $checked) {
			if ($checked === 'YES') {
				$preselect[] = $setting;
			}
		}
		if (isset($settings['RealName'])) {
			$name = $settings['RealName'];
		} else {
			$name = '';
		}
		

		return array($preselect, $name);

	}

	/**
	 * Helper method to connect with communigate
	 * @return CLI        object providing methods to control the server
	 */
	private function ConnectToCG()
	{
		$host = Yii::app()->params['host'];
		$port = Yii::app()->params['port'];
		$login = Yii::app()->params['login'];
		$password = Yii::app()->params['password'];
		$domain = Yii::app()->params['domain'];
		$cli = new CLI;
		$cli->Login($host,$port,$login,$password);

		return $cli;
	}

}