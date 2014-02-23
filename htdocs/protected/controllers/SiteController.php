<?php

class SiteController extends Controller
{

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 * This action displays the table with all the accounts.
	 * If there are no accounts it displays another view.
	 * And if there is no domain with this name it creates it
	 */
	public function actionIndex()
	{
		// renders the view file 'themes/bootstrap/views/site/index.php'
		// using the layout 'themes/bootstrap/layouts/main.php

		// include the javascript that preselects
		// the option for the dropdown
		$baseUrl = Yii::app()->baseUrl; 
		$cs = Yii::app()->getClientScript();
		$cs->registerScriptFile($baseUrl.'/js/preselect.js');

		$domain = Yii::app()->params['domain'];
		$cli = $this->ConnectToCG();
		$domains = $cli->ListDomains();

		if (!in_array($domain, $domains)) {
			$cli->CreateDomain($domain);
		}

		$model = new Accounts($domain);
		$forwarders = new Forwarders($domain);
		$forwadersData  = $forwarders->getForwarders($domain);
		$defaultAddressesForm = new DefaultAddressesForm();
		$defaultAddressesSettings = $this->getDefaultAddressSettings();
		$autoResponders = new AutoResponders($domain);
		$autoRespondersData = $autoResponders->autoRespondersDataProvider();

		if (isset($_POST['DefaultAddressesForm'])) {
			$defaultAddressesForm->attributes = $_POST['DefaultAddressesForm'];
			if ($defaultAddressesForm->validate()) {
				$defaultAddressesForm->setDefaultAddresses();
				$this->redirect(array('site/index'));
			}
		}

		$this->render('index',array(
			'data'=>$model->data(),
			'defaultAddressesForm' => $defaultAddressesForm,
			'defaultAddressesSettings' => $defaultAddressesSettings,
			'forwarders' => $forwadersData,
			'autoRespondersData' => $autoRespondersData,

		));
	}

	/**
	 * This is action for creating accounts
	 * it uses a model form located in
	 * models/AccountForm.php  The view is located
	 * in  themes/bootstrap/views/site/createAccount.php
	 */
	public function actionCreateAccount()
	{
		$accountTypes = $this->getAccountTypes($domain = Yii::app()->params['domain']);

		$model = new AccountForm();

		if (isset($_POST['AccountForm'])) {
			$model->attributes = $_POST['AccountForm'];

			if ($model->validate()) {
				$model->createAccount();
				$this->redirect(array('site/index'));
			}
		}

		$this->render('createAccount', array(
			'model'=>$model,
			'accountTypes' => $accountTypes));
	}

    /**
	 * This is action for updating an account
	 * it uses a model located in mdoels/UpdateForm
	 * the view is in themes/bootstrap/views/site/updateAccount.php
	 */
    public function actionUpdateAccount($account)
    {

    	$accountTypes = $this->getAccountTypes($domain = Yii::app()->params['domain']);

    	$domain = Yii::app()->params['domain'];
    	$cli = $this->ConnectToCG();
    	$settings = $cli->GetAccountSettings("$account@$domain"); 

    	$model = new UpdateForm;

		// collect user input data
    	if(isset($_POST['UpdateForm']))
    	{
    		$model->attributes=$_POST['UpdateForm'];
    		if ($model->validate()) {
    			$model->updateAccount();
    			$this->redirect(array('site/index'));
    		}
    	}
		
		// include the javascript that preselects
		// the option for the dropdown
		$baseUrl = Yii::app()->baseUrl; 
		$cs = Yii::app()->getClientScript();
		$cs->registerScriptFile($baseUrl.'/js/preselect.js');

    	$this->render('updateAccount',array(
    		'model' => $model,
    		'settings' => $settings,
    		'account' =>$account,
    		'accountTypes' => $accountTypes
    		));
    }

	/**
	 * This is action for deleting accounts
	 */
	public function actionDelete($account)
	{
		$domain = Yii::app()->params['domain'];
		$cli = $this->ConnectToCG();
	    // $cli->setDebug(1);
		$cli->DeleteAccount("$account@$domain");
		$cli->Logout();
	}

	/**
	 * This is action for creating aliases for an account
	 * it uses a model located in mdoels/AliasForm
	 * the view is in themes/bootstrap/views/site/createAlias.php
	 */
	public function actionCreateAlias()
	{
		$model=new AliasForm;

		if(isset($_POST['AliasForm']))
		{
			$model->attributes=$_POST['AliasForm'];
			if ($model->validate()) {
				$model->createAlias();
				$this->redirect(array('site/index'));
			}
		}
		$this->render('createAlias',array('model'=>$model));
	}

	/**
	 * Displays the Mobile Devices page
	 */
	public function actionMobileDevices()
	{
		$this->render('MobileDevices');
	}

	/**
	 * This is action for the VoIP page
	 * view is in /bootstrap/views/site/VoIP.php
	 */
	public function actionVoIP()
	{
		$this->render('VoIP');
	}

	
	/**
	 * action for manipulating email archiving
	 * view is in /bootstrap/views/site/emailArchiving.php
	 */
	public function actionEmailArchiving()
	{
	
		// include the javascript that preselects
		// the option for the dropdown
		$baseUrl = Yii::app()->baseUrl; 
		$cs = Yii::app()->getClientScript();
		$cs->registerScriptFile($baseUrl.'/js/preselect.js');

		$cli = $this->ConnectToCG();
		$domain = Yii::app()->params['domain'];

		$model = new EmailArchivingForm;

		if (isset($_POST['EmailArchivingForm'])) {
			$model->attributes = $_POST['EmailArchivingForm'];
			if ($model->validate()) {
				$model->setEmailArchiving();
				Yii::app()->user->setFlash('success', '<strong>Done!</strong> Settings changed.');
				$this->redirect(array('site/index'));
			}
		}

		$this->render('emailArchiving', array(
			'model' => $model,
			'settings' => $cli->GetAccountDefaults($domain)
			));
	}
	
	/**
	 * This is a helper method for getting the
	 * Service classes of an a domain it is used
	 * in the creare account action and the update
	 * account actions
	 */
	public function getAccountTypes($domain)
	{
		$cli = $this->ConnectToCG();

		$serverDefaults = $cli->SendCommand('GETSERVERACCOUNTDEFAULTS');
		$serverDefaults = $cli->parseWords($cli->getWords());

		$defaults = $cli->GetAccountDefaults("$domain");

		if (empty($defaults["ServiceClasses"])) {
			$sc = array_keys($serverDefaults["ServiceClasses"]);
			return array_combine($sc, $sc);
		} else {
			$sc = array_keys($defaults["ServiceClasses"]);
			return array_combine($sc, $sc);
		}
	}
	
	public function actionRedirectToWebmail($account)
	{
		$this->redirect(Yii::app()->params['webmail']);
	}

	// public function actionConfigureServer()
	// {
	// 	$model = new ServerConfigForm;

	// 	if(isset($_POST['ServerConfigForm']))
	// 	{
	// 		$model->attributes=$_POST['ServerConfigForm'];
	// 		if ($model->validate()) {
	// 			$model->setConfigurations();
	// 			$this->redirect(array('site/index'));
	// 		}
	// 	}
	// 	$this->render('configureServer',array('model'=>$model));
	// }	

    private function getDefaultAddressSettings()
    {
		$domain = Yii::app()->params['domain'];
		$cli = $this->ConnectToCG();
        // $cli->setDebug(1);
        $settings = $cli->GetDomainSettings($domain);
        if (isset($settings['MailToUnknown'])) {
        	return array('MailToUnknown' => $settings['MailToUnknown'], 'MailRerouteAddress' => $settings['MailRerouteAddress']);
        }
        
    }

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
?>
