<?php 

$this->pageTitle=Yii::app()->name ;
?>

<h1>Groups</h1>
<p>Groups allow a group of people to exchange emails by using a single email address
 (for example support@mycompany.com), . Groups can be private (only members
 of the group can submit emails to the group) or public (anybody can send an email to the group).</p>

<?
$this->widget('bootstrap.widgets.TbGridView', array(
      // 'filter' => $data, Add filter here
	'type'=>'striped bordered condensed',
	'dataProvider'=>$gridDataProvider,
		'template'=>"{items}\n{pager}",
	'columns'=>array(
		array('name'=>'group', 'header'=>'Groups'),
		array(
			'template' => '{delete}  &nbsp&nbsp&nbsp  {rename}  &nbsp&nbsp&nbsp  {settings}  &nbsp&nbsp&nbsp  {groupMembers}',
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'deleteButtonIcon' => false,
			'htmlOptions'=>array('style'=>'width: 500px; text-align:center;'),
			// 'updateButtonUrl'=> 'Yii::app()->createUrl(\'site/updateAccount\', array(\'account\' =>   substr($data[\'account\'], 0, strpos($data[\'account\'], \' \')) == \'\' ? $data[\'account\'] : substr($data[\'account\'], 0, strpos($data[\'account\'], \' \')) ))',
			// 'deleteButtonUrl'=>'Yii::app()->createUrl(\'site/delete\', array(\'account\' => substr($data[\'account\'], 0, strpos($data[\'account\'], \' \')) == \'\' ? $data[\'account\'] : substr($data[\'account\'], 0, strpos($data[\'account\'], \' \')) ))',
			'buttons' => array(
				'delete' => array(
					'label'=>'Delete',
					'imageUrl'=> false,
					'options'=>array('rel'=> 'tooltip', 'data-original-title'=>"Delete Group" ),
					'url'=>'Yii::app()->createUrl(\'group/delete\', array(\'group\' => $data[\'group\']))',
				),
				'rename' => array(
					'label'=>'Rename',
					'imageUrl'=>false,
					'options'=>array('rel'=> 'tooltip', 'data-original-title'=>"Rename Group" ),
					'url'=>'Yii::app()->createUrl(\'group/rename\', array(\'group\' => $data[\'group\']))',
				),
				'settings' => array(
					'label'=>'Settings',
					'imageUrl'=>false,
					'options'=>array('rel'=> 'tooltip', 'data-original-title'=>"Setting For Group" ),
					'url'=>'Yii::app()->createUrl(\'group/settings\', array(\'group\' => $data[\'group\']))',
				),
				'groupMembers' => array(
					'label'=>'Group Members',
					'imageUrl'=>false,
					'options'=>array('rel'=> 'tooltip', 'data-original-title'=>"Group Members" ),
					'url'=>'Yii::app()->createUrl(\'group/groupMembers\', array(\'group\' => $data[\'group\']))',
				),
				),
			),
		
	)));
$this->widget('bootstrap.widgets.TbButton',array(
  'label' => 'Create Group',
  'type' => 'null',
  'size' => 'normal',
  'url' => Yii::app()->createUrl("group/create"),
  'htmlOptions'=>array('class'=>"pull-left"),
  ));



?>