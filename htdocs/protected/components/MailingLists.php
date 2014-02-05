<?php
/**
* 
*/
class MailingLists extends CComponent
{

	/**
	 * This is a method that returns a data provider for the 
	 * grid view with the mailing lists
	 */
	public function getMailingLists($domain)
	{

		$cli = self::ConnectToCG();
		$lists = $cli->ListLists($domain);

		for ($i=0; $i < count($lists) ; $i++) { 
			$info = $cli->GetList("$lists[$i]@$domain");
			$subscribers = implode(", ", self::getSubscriptionMode("$lists[$i]","$domain"));

			$subscribeBtn = CHtml::link('Subscribe',
				Yii::app()->createUrl('#'),
				array(
					'data-toggle'=>'modal',
					'data-target'=>'#subscribeModal',
					'id' => $lists[$i]
					));

			$unsubscribeBtn = CHtml::link('Unsubscribe',
				Yii::app()->createUrl('#'),
				array(
					'data-toggle'=>'modal',
					'data-target'=>'#unsubscribeModal',
					'data-listName' => $lists[$i]
					));


			$data[$i] = (
				array('id'=> $i,
					'pagination'=>array(
						'pageSize'=>5,),
					'listName' => $lists[$i],
					'Owner'=> $info['Owner'],
					'Subscribers' =>$subscribers,
					'subscribe' => $subscribeBtn,
					'unsubscribe' => $unsubscribeBtn,
					));
		};
		$cli->Logout();
		if (isset($data)) {
			return new CArrayDataProvider($data);
		} else {
			return new CArrayDataProvider(array());
		}
	}

	public function getListData($list, $domain)
	{
		$cli = self::ConnectToCG();
		return $cli->GetList("$list@$domain");
	}

	/**
	 * This is a helepr method to get the subscription mode
	 * of the users
	 */
	private function getSubscriptionMode($list, $domain)
	{
		$cli = self::ConnectToCG();
		$subscribers = $cli->ListSubscribers("$list@$domain");
		foreach ($subscribers as $subscriber) {
			$cli->SendCommand("GETSUBSCRIBERINFO $list@$domain NAME $subscriber");
			$mode = $cli->parseWords($cli->getWords());
			$result[] = "$subscriber ($mode)";
		}
		$cli->Logout();

		if (isset($result)) {
			return $result;
		}

		return array();
	}

	/**
	 * This is a helper method to connect to the 
	 * communigate server
	 */
	private function ConnectToCG()
	{
		$host = Yii::app()->params['host'];
		$port = Yii::app()->params['port'];
		$login = Yii::app()->params['login'];
		$password = Yii::app()->params['password'];
		$cli = new CLI;
		$cli->Login($host,$port,$login,$password);

		return $cli;
	}
}