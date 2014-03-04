<?php
/*
*************** 
* This is a helper class for getting the necessary info for filters
* and also providing the basing CRUD functionality
***************
*/
class Filter extends CComponent
{
	/**
	 * Method to get all accounts that belog to a domain
	 * @param  string $domain the name of the domain
	 * @return CArrayDataProvider      data provider with account
	 */
	public function getAllAccounts($domain)
	{
		$cli = $this->ConnectToCG();
		$accounts = $cli->ListAccounts($domain);
		$accounts = array_keys($accounts);
		foreach ($accounts as $account) {
			$accountNames[] = "$account" . "@". "$domain"; 
		}
		if (!empty($accountNames)) {
			for ($i=0; $i < count($accountNames); $i++) { 
				$data[$i] = (
					array('id'=> $i,
						'pagination'=>array(
							'pageSize'=>5,),
						'account'=> $accountNames[$i],
						));
			}
			$dataProvider = new CArrayDataProvider($data);
			return $dataProvider;
		} else {
			return new CArrayDataProvider(array());
		}
	}

	/**
	 * Method to get all the filters that belong to a account
	 * @param  string $account account name with domain added
	 * @return CArrayDataProvider      data provider with filter names
	 */
	public function getFilters($account)
	{
		$cli = $this->ConnectToCG();
		$filterNames = array();
		$filters = $cli->GetAccountRules($account);

		for ($i=0; $i < count($filters); $i++) { 
			$filterNames[] = $filters[$i][1];
		}

		if (!empty($filterNames)) {
			for ($i=0; $i < count($filterNames); $i++) { 
				$data[$i] = (
					array('id'=> $i,
						'pagination'=>array(
							'pageSize'=>5,),
						'filter'=> $filterNames[$i],
						));
			}
			$dataProvider = new CArrayDataProvider($data);
			return $dataProvider;
		} else {
			return new CArrayDataProvider(array());
		}
	}

	/**
	 * Method to create a new filter fo account
	 * @param  AA $post    the post variable returnt from the create form
	 * @param  string $account account name with domain added
	 */
	public function createFilter($post, $account)
	{
		$data = array();
		$operations = array();
		$params = array();
		$actions = array();
		$actionParam = array();

		foreach ($post as $info) {
			if (is_array($info)) {
				foreach ($info as $key => $value) {
					if ($key == 'data') {
						$data[] = $value;
					} elseif ($key == 'operation') {
						$operations[] = $value;
					} elseif ($key == 'dataParam') {
						$params[] = $value;
					} elseif ($key == 'action') {
						$actions[] = $value;
					} elseif ($key == 'actionParam') {
						$actionParam[] = $value;
					}
				}
			}
		}
		array_push($data, $post['data']);
		array_push($operations, $post['operation']);
		array_push($params, $post['dataParam']);
		array_push($actions, $post['action']);
		array_push($actionParam, $post['actionParam']);

		for ($i=0; $i < count($data); $i++) { 
			$ruleSettings[] = array($data[$i], $operations[$i], $params[$i]);
		}

		for ($i=0; $i < count($actions); $i++) { 
			$actionsForRules[] = array($actions[$i], $actionParam[$i]);
		}

		$answer = array($post['priority'], $post['name'], $ruleSettings, $actionsForRules);
		$cli = $this->ConnectToCG();

		$rules = $cli->GetAccountRules($account);
		array_push($rules, $answer);
		$cli->SetAccountRules($account, $rules);
	}

	/**
	 * Method for deleting a filter of account
	 * @param  string $filterName the name of the filter
	 * @param  string $account    the name of the account with domain added
	 * @return [type]             [description]
	 */
	public function deleteFilter($filterName, $account)
	{
		$cli = $this->ConnectToCG();
		$filters = $cli->GetAccountRules($account);
	
		foreach ($filters as $filter) {
			if ($filter[1] == $filterName) {
				$filterInfo = $filter;
			}
		}
		if(($key = array_search($filterInfo, $filters)) !== false) {
			unset($filters[$key]);
		}
		$cli->SetAccountRules($account, array_values($filters));
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