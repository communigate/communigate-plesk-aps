<?php
/*
*************** 
* This is a helper class for getting the necessary info for Auto Responders
***************
*/
class AutoResponders extends CComponent
{
	
	public $vacationMessages;
    public $subjectsFromVacationMessages;
    public $domain;

    function __construct($domain) 
    {
        $this->domain = $domain;
        $cli = self::ConnectToCG();
        $this->setVactionMessages($cli);
        $this->setSubjectsFromVacationMessages($cli);
    }

    /*
    *************** 
    * Method for setiing the vacationMessages variable
    ***************
    */
    public function setVactionMessages($cli)
    {

        $domain = $this->domain;
        $accounts = array_keys($cli->ListAccounts($domain));
        foreach ($accounts as $account) {
            $rules =$cli->GetAccountRules("$account@$domain");
            if (isset($rules[$this->recursive_array_search('#Vacation', $rules)]) && 
                $this->recursive_array_search('#Vacation', $rules)!==false) {

                $this->vacationMessages["$account@$this->domain"] = 
            $rules[$this->recursive_array_search('#Vacation', $rules)][3][0][1] . '\eEndDate: ' . 
            $rules[$this->recursive_array_search('#Vacation', $rules)][2][0][2];
            }
        }
    }

    /*
    *************** 
    * Method for setiing the subjectFromVacationMessages variable
    ***************
    */
    public function setSubjectsFromVacationMessages($cli)
    {
        $vacationMessages = $this->vacationMessages;

        if (isset($vacationMessages)) {
            foreach ($vacationMessages as $account => $message) {
                $components = explode("\\e", $message);
                if (substr($components[0], 0, 8 ) !== '+Subject') {
                    $this->subjectsFromVacationMessages[$account] = '';
                } else {
                   $this->subjectsFromVacationMessages[] = array(
                    $account => substr($components[0], strpos($components[0], " ") + 1)
                    ); 
               }
           }        
       }
    }

    /*
    *************** 
    * Healper method for recursive searching in array, used for searching
    * vacation messages searching
    ***************
    */
    private function recursive_array_search($needle,$haystack) 
    {
        foreach($haystack as $key=>$value) {
            $current_key=$key;
            if($needle===$value OR (is_array($value) && $this->recursive_array_search($needle,$value) !== false)) {
                return $current_key;
            }
        }
        return false;
    }

    /*
    *************** 
    * Method for getting the subjectFromVacationMessages variable
    ***************
    */
    public function getSubjectsFromVacationMessages()
    {
        return $this->subjectsFromVacationMessages;
    }

    /*
    *************** 
    * Method for deleating an auto responder
    ***************
    */
    public function deleteAutoResponder($account)
    {
        $cli = self::ConnectToCG();
        $cli->SendCommand("UPDATEACCOUNTMAILRULE $account DELETE \"#Vacation\"");
    }

    /*
    *************** 
    * method for adding a new auto responder
    ***************
    */
    public function addAutoResponder($account, $endDate, $subject, $from, $body)
    {
        $cli = self::ConnectToCG();
        $cli->setDebug(1);
        $updateVacationMessage = sprintf("UPDATEACCOUNTMAILRULE %s".
            '( 2, "#Vacation", (("Current Date","less than","%s"), ("Human Generated", "---"), (From, "not in", "#RepliedAddresses")), ( ("Reply with",'.
                ' "+Subject: %s\eFrom: %s\e\e%s" ' 
                . '), ("Remember \'From\' in", RepliedAddresses) ) )',
        $account, $endDate, $subject, $from, $body);

        $cli->SendCommand($updateVacationMessage);
        return $cli->parseWords($cli->getWords());
    }

    /*
    *************** 
    * method for getting the information about autro responders
    * in array data provider for the grid view
    ***************
    */
    public function autoRespondersDataProvider()
    {

        $subjects = $this->subjectsFromVacationMessages;
        
        $data = array();

        for ($i=0; $i <count($subjects) ; $i++) { 
            $email = array_keys($subjects[$i]);
            $subject = array_values($subjects[$i]);
            $data[$i] = (
                array('id'=> $i,
                    'pagination'=>array(
                        'pageSize'=>5,),
                    'email' => $email[0],
                    'subject' => $subject[0],
                    ));
        }

        if (isset($data)) {
            return new CArrayDataProvider($data);
        } else {
            return new CArrayDataProvider(array());
        }
    }

    /*
    *************** 
    * method for getting the auto responder data for the population
    * of the update form
    ***************
    */
    public function getAutoResponderData($account)
    {
        $components = explode("\\e\\e", $this->vacationMessages[$account]);
        $data['body'] = '';
        foreach ($components as $component) {

            // var_dump($component);
            if (substr($component, 1, 7) == 'Subject') {
                $subjectFrom = explode("\\e", $component);
                foreach ($subjectFrom as $key) {
                    if (substr($key, 1, 7) == 'Subject') {
                        $data['subject'] = str_replace("+Subject: ","", $key);
                        // var_dump('Subject found');
                    }
                    if (substr($key, 0, 4) == 'From') {
                        $data['from'] = str_replace("From: ","", $key);
                        // var_dump('From found');
                    }
                }
            } else {
                $bodyDate= explode("\\e", $component);
                foreach ($bodyDate as $key) {
                    if (substr($key, 0, 7) == 'EndDate') {
                        $data['endDate'] = str_replace("EndDate: ","", $key);
                    }else {
                        // var_dump($key);
                        // $data['body'] = '';
                        $data['body'] .= "\r\n".$key;
                    }
                }

            }
        }

        // var_dump($data);

        // $components = explode("\\e", $this->vacationMessages[$account]);


        // foreach ($components as $component) {
        // // var_dump(substr($component, 0, 4));
        //     if (substr($component, 1, 7) == 'Subject') {
        //         $data['subject'] = str_replace("+Subject: ","", $component);
        //         // var_dump('Subject found');
        //     }
        //     if (substr($component, 0, 4) == 'From') {
        //         $data['from'] = str_replace("From: ","", $component);
        //         // var_dump('From found');
        //     }
        //     if (substr($component, 0, 7) == 'EndDate') {
        //         $data['endDate'] = str_replace("EndDate: ","", $component);
        //     }
        //     if ($component !== '' && substr($component, 0, 4) !== 'From' && substr($component, 1, 7) !== 'Subject' && substr($component, 0, 7) !== 'EndDate') {
        //         $data['body'] = $component;
        //     }
        // }
        $data['email'] = substr($account, 0, strpos($account, "@"));
        return $data;
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