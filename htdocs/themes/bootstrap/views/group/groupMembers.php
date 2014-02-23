<?php
/* @var $this GroupController */
/* @var $model GroupMembersForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Group Members';
$this->breadcrumbs=array(
	'Group Members',
);
?>

<h1>Group Members</h1>

<p>Please fill out the following form to add members to <?php echo $_GET['group'] ?></p>

<div class="form">

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'RenameGroup-form',
    'type'=>'horizontal',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<div class="row" style="overflow:hidden">
		<div class="span4">
			<?php 
			echo $form->dropDownListRow($model, 'groupMember', $accounts); ?>
		</div>
		<div class="span1">
			<?php echo  CHtml::ajaxSubmitButton(
				'Add',
				Yii::app()->createUrl('group/groupMembers', array('group' => $_GET['group'])),
				array(
					'beforeSend'=>'function(){

					}',
					'success'=>'function(data){
						jQuery(\'#yw0\').yiiGridView(\'update\');
					}',
					),
				array('class' => 'pull-right btn')
				); ?>			
		</div>
	</div>

	<?php 
	$this->widget('bootstrap.widgets.TbGridView', array(
      // 'filter' => $data, Add filter here
		'type'=>'striped bordered condensed',
		'dataProvider'=>$dataProvider,
		'template'=>"{items}\n{pager}",
		'columns'=>array(
			array('name'=>'member', 'header'=>'Members'),
			array(
				'template' => '{delete}',
				'class'=>'bootstrap.widgets.TbButtonColumn',
				'deleteButtonIcon' => false,
				'htmlOptions'=>array('style'=>'width: 500px; text-align:center;'),
				'buttons' => array(
					'delete' => array(
						'label'=>'Delete',
						'imageUrl'=> false,
						'options'=>array('rel'=> 'tooltip', 'data-original-title'=>"Delete Group" ),
						'url'=>'Yii::app()->createUrl(\'group/removeGroupMembers\', array(\'member\' => $data[\'id\'], \'group\' =>  $_GET[\'group\']))',
						),
					)
				),
	))); ?>

<?php $this->endWidget(); ?>

</div><!-- form -->