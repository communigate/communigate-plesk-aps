<?php

class MailingListController extends Controller
{
	
	/**
	 * Action displaying a grid view
	 * with all the mailing lists
	 * and links to do operations with them
	 */
	public function actionIndex()
	{
		$baseUrl = Yii::app()->baseUrl; 
		$cs = Yii::app()->getClientScript();
		$cs->registerScriptFile($baseUrl.'/js/script.js', CClientScript::POS_END);

		$domain = Yii::app()->params['domain'];
		
		$mailingLists = MailingLists::getMailingLists($domain);

		$subscribtionForm = new SubscribeForm();
		
		$this->render('index', array(
			'gridDataProvider' => $mailingLists,
			'subscribtionForm' => $subscribtionForm,
			));
	}

	/**
	 * Action for creating a mailing list
	 */
	public function actionCreate()
	{
		$domain = Yii::app()->params['domain'];
		$cli = $this->ConnectToCG();
		$model = new MailingListCreationForm();

		$accounts = array_keys($cli->ListAccounts($domain));
		$accounts = array_combine($accounts, $accounts);

		if (isset($_POST['MailingListCreationForm'])) {
			$model->attributes = $_POST['MailingListCreationForm'];
			if ($model->validate()) {
				$model->createMailingList();
				$this->redirect(array('MailingList/index'));
			}
		}
		$this->render('create', array(
			'model' => $model,
			'accounts' => $accounts
			));
	}

	/**
	 * Action for updating a mailing list
	 */
	public function actionUpdate($mailingList)
	{
		$model = new MailingListUpdateForm();
		$cli = self::ConnectToCG();
		$domain = Yii::app()->params['domain'];
		$data =  $cli->GetList("$mailingList@$domain");

		if(isset($_POST['MailingListUpdateForm']))
		{
			$model->attributes=$_POST['MailingListUpdateForm'];
			if ($model->validate()) {
				$model->updateMailingList();
				$this->redirect(array('MailingList/index'));
			}
		}
		$this->render('update', array(
			'model' => $model,
			'data' => $data
			));
	}

	/**
	 * Action for deleting a mailing list
	 */
	public function actionDelete($mailingList)
	{
		$cli = $this->ConnectToCG();
		$domain = Yii::app()->params['domain'];
		$cli->DeleteList("$mailingList@$domain");
		$cli->Logout();
	}

	/**
	 * Action to subscribe user from mailing list
	 */
	public function actionSubscribe()
	{
		$model = new SubscribeForm();
		if (isset($_POST)) {
			$model->attributes=$_POST['SubscribeForm'];
			$model->subscribe();
		}
	}

	/**
	 * Action to unsubscribe user from mailing list
	 */
	public function actionUnsubscribe()
	{
		$model = new SubscribeForm();
		if (isset($_POST)) {
			$model->attributes=$_POST['SubscribeForm'];
			$model->unsubscribe();
		}

	}

	/**
	 * A helper method to connect to the CG
	 */
	private function ConnectToCG($value='')
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