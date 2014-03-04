<?php

class FilterController extends Controller
{

	/**
	 * Action for displaying a grid view with all
	 * the accounts of the domain with a button 
	 * to manage their filters
	 */
	public function actionIndex()
	{
		$domain = Yii::app()->params['domain'];
		$filter = new Filter();
		$dataProvider = $filter->getAllAccounts($domain);

		$this->render('index',array(
			'gridDataProvider' => $dataProvider
			));
	}

	/**
	 * Method for displaying a grid view with all 
	 * the filters(rules) for an account and a button
	 * to add new filters delete and update existing ones
	 * @param  string $account the name of the account with domain added
	 */
	public function actionManageFilters($account)
	{
		$filter = new Filter();
		$dataProvider = $filter->getFilters($account);

		$this->render('manage',array(
			'gridDataProvider' => $dataProvider
			));
	}

	/**
	 * Action for adding a new filter
	 * @param  string $account the name of the account with domain added
	 */
	public function actionCreate($account)
	{

		// include the javascript for dynamicly generated form
		$baseUrl = Yii::app()->baseUrl; 
		$cs = Yii::app()->getClientScript();
		$cs->registerScriptFile($baseUrl.'/js/dynamicForm.js', CClientScript::POS_END);

		$model = new CreateFilterForm();

		if (isset($_POST['CreateFilterForm'])) {
			$form = $_POST['CreateFilterForm'];
			$filter = new Filter();
			$filter->createFilter($form, $account);
	
			$this->redirect(array(
				'filter/manageFilters', 'account' => $account));
		}

		$this->render('create', array(
			'model' => $model
			));
	}

	/**
	 * Action for deleting an rule for account
	 * @param  string $filter the name of the filter to be deleted
	 * @param  string $account the name of the account with domain added
	 */
	public function actionDelete($filter, $account)
	{
		$filterOBJ = new Filter();
		var_dump($filter);
		$filterOBJ->deleteFilter($filter, $account);
	}

	/**
	 * Action for updating a rule for account
  	 * @param  string $filter the name of the filter to updated
	 */
	public function actionUpdate($filter)
	{
		// include the javascript for dynamicly generated form
		$baseUrl = Yii::app()->baseUrl; 
		$cs = Yii::app()->getClientScript();
		$cs->registerScriptFile($baseUrl.'/js/dynamicForm.js', CClientScript::POS_END);

		$model = new CreateFilterForm();
		$account = $_GET['account'];
		$cli = $this->ConnectToCG();
		$filters = $cli->GetAccountRules($account);

		foreach ($filters as $filterName) {
			if ($filterName[1] == $filter) {
				$filterInfo = $filterName;
			}
		}

		if (isset($_POST['CreateFilterForm'])) {
			$form = $_POST['CreateFilterForm'];
			$filterObj = new Filter();
			$filterObj->deleteFilter($filter, $account);
			$filterObj->createFilter($form, $account);
			
			$this->redirect(array(
				'filter/manageFilters', 'account' => $account));
		}

		$this->render('update', array(
			'model' => $model,
			'filter' => $filterInfo
			));
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