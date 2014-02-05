<?php

class AutoRespondersController extends Controller
{

	public function actionIndex()
	{
	}

	/**
	 * Action for adding a new auto responder
	 */
	public function actionCreate()
	{

		$model = new CreateAutoResponderForm();
		$baseUrl = Yii::app()->baseUrl; 
		$cs = Yii::app()->getClientScript();
		$cs->registerScriptFile($baseUrl.'/js/bootstrap-datepicker.js');
		$cs->registerCssFile($baseUrl.'/css/datepicker.css');

		if (isset($_POST['CreateAutoResponderForm'])) {
			$model->attributes = $_POST['CreateAutoResponderForm'];
			if ($model->validate()) {
				$model->createAutoResponder();
				$this->redirect(array(
					'site/index',
                    'tab'=>'autoResponders'));
			}
		}
		$this->render('create', array('model' => $model));
	}

	/**
	 * Action for deleting an auto responder
	 */
	public function actionDelete($account)
	{
		AutoResponders::deleteAutoResponder($account);
	}

	/**
	 * Action for updating an auto responder
	 */
	public function actionUpdate($account)
	{

		$model = new CreateAutoResponderForm();
		$domain = Yii::app()->params['domain'];
		$autoResponders = new AutoResponders($domain);
		$values = $autoResponders->getAutoResponderData($account);
		$baseUrl = Yii::app()->baseUrl; 
		$cs = Yii::app()->getClientScript();
		$cs->registerScriptFile($baseUrl.'/js/bootstrap-datepicker.js');
		$cs->registerCssFile($baseUrl.'/css/datepicker.css');
		
		if (isset($_POST['CreateAutoResponderForm'])) {
			$model->attributes = $_POST['CreateAutoResponderForm'];
			if ($model->validate()) {
				$model->createAutoResponder();
				$this->redirect(array(
					'site/index',
                    'tab'=>'autoResponders'));
			}
		}

		$this->render('update',
		 array('model' => $model,
		 	'values' => $values)
		 );
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