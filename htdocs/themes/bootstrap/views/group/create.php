<?php
/* @var $this GroupController */
/* @var $model CreateGroupForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Create Group';
$this->breadcrumbs=array(
	'Create Group',
);
?>

<h1>Create Group</h1>

<p>Please fill out the following form to create a group </p>

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


	<?php echo $form->textFieldRow($model,'groupName'); ?>
	<?php echo $form->textFieldRow($model,'groupEmailAdress', array('append'=> "@" . Yii::app()->params['domain'])); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
            'buttonType'=>'submit',
            'type'=>'primary',
            'label'=>'Create',
        )); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->