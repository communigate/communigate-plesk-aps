<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>


<?php $this->widget('bootstrap.widgets.TbAlert', array(
        'block'=>true, // display a larger alert block?
        // 'fade'=>true, // use transitions?
        'closeText'=>'&times;', // close link text - if set to false, no close link is displayed
        // 'alerts'=>array( // configurations per alert type
        //     'success'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'), // success, info, warning, error or danger
        // ),
        'htmlOptions' => array('class' => 'test'),
    )); ?>



<?php $this->widget('bootstrap.widgets.TbTabs', array(
  'tabs'=>array(
    array(
      'id'=>'accounts',
      'active'=>true,
      'label'=>'Accounts',
      'content'=>$this->renderPartial('_accounts', array('accountsData'=>$data), true ),            
      ),
    array(
      'id'=>'aliases',
      'active'=>false,
      'label'=>'Aliases',
      'content'=>$this->renderPartial('_aliases', array('data'=>$data), true),
      ),
    
    array(
      'id'=>'defaultAddresses',
      'active'=>false,
      'label'=>'Default Adresses',
      'content'=>$this->renderPartial('_defaultAddresses', array('defaultAddressesForm'=> $defaultAddressesForm,'defaultAddressesSettings' => $defaultAddressesSettings), true),
      ),
    array(
      'id'=>'forwarders',
      'active'=>false,
      'label'=>'Forwarders',
      'content'=>$this->renderPartial('_forwarders', array('forwarders'=> $forwarders), true),
      ),
    array(
      'id'=>'autoResponders',
      'active'=>false,
      'label'=>'Auto Responders',
      'content'=>$this->renderPartial('_autoResponders', array('autoRespondersData' => $autoRespondersData), true),
      ),
    ),
    ));  ?>
