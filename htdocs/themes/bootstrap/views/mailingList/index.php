<?php
/* @var $this MailingListController */

$this->breadcrumbs=array(
	'Mailing List',
	);
	?>

<?php 
$this->widget('bootstrap.widgets.TbGridView', array(
	'type'=>'striped bordered condensed',
	'dataProvider'=>$gridDataProvider,
	'template'=>"{items}",
	'columns'=>array(
		array('name'=>'listName', 'header'=>'Mailing Lists'),
		array('name'=>'Owner', 'header'=>'Owner'),
		array('name'=>'Subscribers', 'header'=>'Subscribers (Mode)'),
		array('name'=>'subscribe', 'header'=>''),
		array('name'=>'unsubscribe', 'header'=>''),
		array(
			'template' => '{update} {delete}',
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'htmlOptions'=>array('style'=>'width: 50px'),
			'updateButtonUrl'=>'Yii::app()->createUrl(
				\'MailingList/update\',
				array(
					\'mailingList\' => $data[\'listName\']
					))',
		'deleteButtonUrl'=>'Yii::app()->createUrl(
			\'MailingList/delete\', array(
				\'mailingList\' => $data[\'listName\']
				))',
		),

		),
	'afterAjaxUpdate'=>'function(id, data){
		$(\'a[data-target="#subscribeModal"]\').click(function() {
			$(\'#SubscribeForm_listName\').val(this.id);
		});
		$(\'a[data-target="#unsubscribeModal"]\').click(function() {
		$(\'#unsubscribeListName\').val($(this).attr("data-listname"));
		});
	}'
));
$this->widget('bootstrap.widgets.TbButton',array(
	'label' => 'Create Mailing List',
	'type' => 'null',
	'size' => 'normal',
	'url' => 'index.php?r=mailingList/create',
	'htmlOptions'=>array('class'=>"pull-left"),
	
));
?>

<?php $this->beginWidget('bootstrap.widgets.TbModal', array('id'=>'subscribeModal')); ?>
<?php echo $this->renderPartial('_subscribe', array('subscribtionForm'=>$subscribtionForm)) ?>
<?php $this->endWidget(); ?>

<?php $this->beginWidget('bootstrap.widgets.TbModal', array('id'=>'unsubscribeModal')); ?>
<?php echo $this->renderPartial('_unsubscribe', array('subscribtionForm'=>$subscribtionForm)) ?>
<?php $this->endWidget(); ?>