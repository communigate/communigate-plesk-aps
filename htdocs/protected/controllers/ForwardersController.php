<?php

class ForwardersController extends Controller
{

	public function actionIndex()
	{
	}

	/**
	 * Action for adding a forwarder
	 */
	public function actionAddForwarder()
	{

		$model = new ForwarderForm();

		if (isset($_POST['ForwarderForm'])) {
			$model->attributes = $_POST['ForwarderForm'];
			if ($model->validate()) {
				$model->addForwarder();
				$this->redirect(array(
					'site/index',
                    'tab'=>'forwarders'));
			}
		}
		$this->render('addForwarder', array('model' => $model));
	}

	/**
	 * Action for deleting a forwarder
	 */
	public function actionDelete($forwarders)
	{
		$cli = $this->ConnectToCG();
		$domain = Yii::app()->params['domain'];

		Forwarders::deleteForwarder($forwarders);
		$cli->Logout();
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

    /*
    *************** 
    * A recursive array search to find the redirect rules of accounts
    ***************
    */
    public function recursive_array_search($needle,$haystack) 
    {
        foreach($haystack as $key=>$value) {
            $current_key=$key;
            if($needle===$value OR (is_array($value) && $this->recursive_array_search($needle,$value) !== false)) {
                return $current_key;
            }
        }
        return false;
    }

	
}