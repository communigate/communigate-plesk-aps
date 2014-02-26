<?php 
/**
* 			
*/
class RemotePop extends CComponent
{
	
	/**
	 * Method for getting the data for the grid view
	 * @return CArrayDataProvider data for the grid view
	 */
	public function getDataForGridWithPops($account)
	{		
		$cli = $this->ConnectToCG();
		$pops = $cli->GetAccountRPOP($account);
		if (!empty($pops)) {
			$i = 0;
			foreach ($pops as $popName => $settings) {
				
				$data[$i] = (
					array('id'=> $i,
						'popName'=> $popName,
						'account' => $account,
						));
				$i ++;
			}
			$dataProvider = new CArrayDataProvider($data);
			return $dataProvider;
		} else {
			return new CArrayDataProvider(array());
		}
	}

	/**
	 * Method for adding the a new remote pop to account
	 * @param  string $account account to add the rpop with domain
	 */
	public function addRemotePop($account, $details)
	{
		$cli = $this->ConnectToCG();
		$pops = $cli->GetAccountRPOP($account);
		$details = array_merge($pops, $details);
		$cli->SetAccountRPOP($account, $details);
	}

	/**
	 * Method for removing a pop from account
	 * @param  string $name    the name of the rpop
	 * @param  string $account name of account with domain added
	 */
	public function deleteRemotePop($name, $account)
	{
		$cli = $this->ConnectToCG();
		// $cli->setDebug(1);
		$pops = $cli->GetAccountRPOP($account);
		unset($pops[$name]);
		if (empty($pops)) {
			$cli->SendCommand("SETACCOUNTRPOPS $account {}");
		} else {
			$cli->SetAccountRPOP($account, $pops);
		}
	}

	/**
	 * Method for getting info for a pop
	 * @param  string $name    the name of the rpop
	 * @param  string $account name of account with domain added
	 */
	public function getPopInfo($name, $account)
	{
		$cli = $this->ConnectToCG();
		$pops = $cli->GetAccountRPOP($account);
		return $pops[$name];
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