<p>
<?php

$this->widget('bootstrap.widgets.TbGridView', array(
// 'filter' => $data, Add filter here
  'type'=>'striped bordered condensed',
  'dataProvider'=>$accountsData,
  'template'=>"{items}\n{pager}",
  'columns'=>array(
    array('name'=>'account', 'header'=>'Accounts (Alias)'),
    array('name'=>'E-mail', 'header'=>'E-mail Adresses'),
    array('name'=>'type', 'header'=>'Type'),
    array('name' => 'usage', 'header' => 'Usage'),
    array(
      'template' => '{email} {prontoDrive} {update} {delete}',
      'class'=>'bootstrap.widgets.TbButtonColumn',
      'htmlOptions'=>array('style'=>'width: 70px'),
      'updateButtonUrl'=> 'Yii::app()->createUrl(\'site/updateAccount\', array(\'account\' =>   substr($data[\'account\'], 0, strpos($data[\'account\'], \' \')) == \'\' ? $data[\'account\'] : substr($data[\'account\'], 0, strpos($data[\'account\'], \' \')) ))',
      'deleteButtonUrl'=>'Yii::app()->createUrl(\'site/delete\', array(\'account\' => substr($data[\'account\'], 0, strpos($data[\'account\'], \' \')) == \'\' ? $data[\'account\'] : substr($data[\'account\'], 0, strpos($data[\'account\'], \' \')) ))',
      'buttons' => array(
        'email' => array(
          'label'=>'',
          'imageUrl'=>'',
          'options'=>array("class"=>"icon-envelope", 'rel'=> 'tooltip', 'data-original-title'=>"Webmail" ),
          'url'=>'Yii::app()->createUrl("site/redirectToWebmail", array("account"=>$data[\'account\']))',
        ),
        'prontoDrive' => array(
          'label'=>'',
          'imageUrl'=> Yii::app()->getBaseUrl(true). '/images/cgpro_prontodrive.png',
          'options'=>array('rel'=> 'tooltip', 'data-original-title'=>"Pronto Drive"),
          'url'=>'Yii::app()->createUrl("site/redirectToProntoDrive", array("account"=>$data[\'account\']))',
        ),
      ),
    ),

  ),
));

$this->widget('bootstrap.widgets.TbButton',array(
  'label' => 'Create Account',
  'type' => 'null',
  'size' => 'normal',
  'url' => Yii::app()->createUrl("site/createAccount"),
  'htmlOptions'=>array('class'=>"pull-left"),
  ));?>
</p>