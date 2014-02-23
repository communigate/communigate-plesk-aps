<?php
/**
* 
*/
include 'CLI.php';

class Accounts extends CComponent
{
	
	public $accounts;
	public $accountNames;
	public $emails;
	public $usage;
	public $accountAliases;
	private $domain;

	/**
	 * This is constructor for the Accounts helper class
	 */
	function __construct($domain) {
		$this->domain = $domain;
		$cli = $this->ConnectToCG();
		$this->setAccounts($cli);
		$this->setMails();
		$this->setUsage($cli);
		$this->setAliases($cli);
	}

	/**
	 * A setter for the accounts
	 */
	public function setAccounts($cli)
	{
		$accounts = $cli->ListAccounts($this->domain);
		$accounts = array_keys($accounts);
		$this->accountNames = $accounts;
		foreach ($accounts as $account) {
			$this->accounts[] = "$account" . "@". "$this->domain"; 
		}
	}

	/**
	 * A setter for the mails
	 */
	public function setMails()
	{
		if ($this->accounts != null) {
			foreach ($this->accounts as $account) {
				$this->emails[] = "$account";
			}
		} else {
			return false;
		}
	}

	/**
	 * A setter for the usage
	 */
	public function setUsage($cli)
	{
		if ($this->accounts != null) {
			$fileInfo = array();
			foreach ($this->accounts as $account) {
				$info = $cli->GetStrorageFileInfo($account) ;
				$used = ltrim ($info[1],'#');
				$size = ltrim ($info[3],'#');
				$fileInfo[] = array('size' => $size,
					'used' => $used );
			}
			foreach ($fileInfo as $FI) {
				$this->usage[] = $this->percent($FI['used'], $FI['size']);
			}
		}
		else {
			return false;
		}
	}

	/**
	 * A setter for the aliases
	 */
	public function setAliases($cli)
	{
		if ($this->accounts != null) {
			foreach ($this->accounts as $account) {
				$this->accountAliases[] = implode(", ",$cli->GetAccountAliases($account));
			}
		} else {
			return false;
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

	/**
	 * This is a helper function to calculate the ammount of space 
	 * used by the user in percentage
	 */
	private function percent($num_amount, $num_total) {
		$count1 = $num_amount / $num_total;
		$count2 = $count1 * 100;
		$count = number_format($count2, 0);
		return $count;
	}

	/**
	 * This is a helper function for the service classes of the accounts
	 */
	public function getAccountTypes($domain)
	{
		$cli = self::ConnectToCG($domain);

		$defaults = $cli->GetAccountDefaults("$domain");

		if (isset($defaults["ServiceClasses"])) {
			$sc = array_keys($defaults["ServiceClasses"]);
		} else {
			$sc = array_keys($serverDefaults["ServiceClasses"]);
		}

		return $sc;
	}

	/**
	 * This is a method that returns a data provider for the 
	 * grid view with the accouns in the index page
	 */
	public function data($accountName = '')
	{

        $cli = self::ConnectToCG();
        $domain = $this->domain;

		if ($this->accounts != null) {

			for ($i=0; $i < count($this->accounts); $i++) { 
				
				$account = $this->accounts[$i];
	            $settings = $cli->GetAccountSettings($account);
				$aliasLink = CHtml::link('Create Alias',array('site/createAlias',
                   'accountName'=>"$account"), array('role'=>'button', 'class' => 'btn'));
				if ($this->accountAliases[$i] !== '') {
					$account = $this->accountNames[$i] . ' (' . $this->accountAliases[$i]. ')';
				}else {
					$account = $this->accountNames[$i];
				}

				$data[$i] = (
					array('id'=> $i,
						'pagination'=>array(
							'pageSize'=>5,),
						'account'=> $account,
						'E-mail'=> $this->emails[$i],
						'type'=> $settings['ServiceClass'],
						'usage' => "<div class=\"progress\"><div class=\"bar\" style=\"width:".
						$this->usage[$i]. "%;\"></div></div>",
						'accountAliases' => $this->accountAliases[$i],
						'aliasButton' => $aliasLink,
						));

				if ($account === $accountName && $accountName !== '') {
					$data = (
						array(
							'id'=> $i,
							'pagination'=>array(
								'pageSize'=>5,),
							'account'=> $this->accounts[$i],
							'E-mail'=> $this->emails[$i],
							'type'=> $settings['ServiceClass'],
							'usage' => "<div class=\"progress\"><div class=\"bar\" style=\"width:".
							$this->usage[$i]. "%;\"></div></div>",
							'accountAliases' => $this->accountAliases[$i],
							'aliasButton' => $aliasLink,
							));
					break;
				}
			}	
			$dataProvider = new CArrayDataProvider($data);
			return $dataProvider;
		} else {
			return new CArrayDataProvider(array());
		}
	}

}