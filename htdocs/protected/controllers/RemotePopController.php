<?php

/**
 * Controller for RPOP
 * CRUD functionality
 */
class RemotePopController extends Controller
{
	/**
	 * Action for the index page of the controller
	 * renders a view with a grid view for the corresponding
	 * account and its rpops using ajax
	 */
	public function actionIndex()
	{
		if (Yii::app()->request->isAjaxRequest) {

			$domain = Yii::app()->params['domain'];
			$remotePop = new RemotePop();
			$dataProvider = $remotePop->getDataForGridWithPops($_GET['account']);

			echo  $this->renderPartial('popInfo', array('dataProvider' => $dataProvider,),true, true);
			Yii::app()->end();
		}

		$model = new AddRemotePopForm;
		$domain = Yii::app()->params['domain'];
		$cli = $this->ConnectToCG();
		$accounts = array_keys($cli->ListAccounts($domain));
		foreach ($accounts as $index => $account) {
			$accounts[$index] = $account . "@$domain";
		}
		array_unshift($accounts , 'Please Choose');

		$this->render('index', array(
			'model' => $model,
			'accounts' => array_combine($accounts, $accounts),
			));
	}

	/**
	 * Action for adding the a new remote pop to account
	 * @param  string $account account to add the rpop with domain
	 */
	public function actionAdd($account)
	{
		$model = new AddRpopForm;

		if (isset($_POST['AddRpopForm'])) {
			$model->attributes = $_POST['AddRpopForm'];
			$model->addRemotePop($account);
			$this->redirect(array('remotePop/index'));
		}

		$this->render('addRPOP', array(
			'model' => $model
			));
	}

	/**
	 * Action for deleting a ramote pop
	 * @param  string $name    the display name of the remote pop
	 * @param  string $account the account to which the pop belongs
	 */
	public function actionDelete($name, $account)
	{
		$remotePop = new RemotePop();
		$remotePop->deleteRemotePop($name, $account);
	}
	
	/**
	 * Action for edditing a pop's settings
	 * @param  string $name    the name of the rpop
	 * @param  string $account name of account with domain added
	 */
	public function actionViewEdit($name, $account)
	{
		$model = new AddRpopForm;
		$remotePop = new RemotePop();
		$popInfo = $remotePop->getPopInfo($name, $account);

		// include the javascript that preselects
		// the option for the dropdown
		$baseUrl = Yii::app()->baseUrl; 
		$cs = Yii::app()->getClientScript();
		$cs->registerScriptFile($baseUrl.'/js/preselect.js');

		if (isset($_POST['AddRpopForm'])) {
			$model->attributes = $_POST['AddRpopForm'];
			$model->addRemotePop($account);
			$this->redirect(array('remotePop/index'));
		}

		$this->render('addRPOP', array(
			'model' => $model,
			'popInfo' => $popInfo,
			));
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
