<?php
/**
 * AddRpopForm class.
 */
class AddRpopForm extends CFormModel
{
	public $displayName;
	public $account;
	public $host;
	public $password;
	public $mailbox;
	public $leaveMessageOnServer;
	public $apop;
	public $tls;
	public $pullEvery;

	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			array('displayName, account, host, password', 'required'),
			array('mailBox, pullEvery', 'safe'),
			array('leaveMessageOnServer, apop, tls', 'boolean')
			);
	}

	/**
	 * Method adding a new remote pop to account
	 * @param string $account the name of the account with domain added
	 */
	public function addRemotePop($account)
	{
		$remotePop = new RemotePop();
		
		$this->mailbox = (!isset($this->mailbox) ? '' : $this->mailbox);

		$details = array(
			$this->displayName => array(
				'TLS' => $this->tls,
				'authName' => $this->account,
				'domain' => $this->host,
				'leave' => $this->leaveMessageOnServer,
				'password' => $this->password,
				'period' => $this->pullEvery,
				'APOP' => $this->apop,
				'mailbox' => $this->mailbox
				)
		);
		$remotePop->addRemotePop($account, $details);
	}

	/**
	 * Method changing the labels go the attributes
	 * @return [type] [description]
	 */
	public function attributeLabels()
	{
		return array(

			'apop' => 'APOP',
			'tls' => 'TLS'

			);
	}


}
