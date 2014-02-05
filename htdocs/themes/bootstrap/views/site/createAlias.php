<?php
/* @var $this SiteController */
/* @var $model AccountForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Create Alias';
$this->breadcrumbs=array(
	'Create Alias',
);
?>

<h1>Create Alias</h1>

<p>Please fill out the following form with your account alisas name:</p>

<div class="form">

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'account-form',
    'type'=>'horizontal',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php 
	$model->accountName = $_GET['accountName'];
	
	?>

	<?php echo $form->textFieldRow($model,'aliasName'); ?>
	<?php echo CHtml::hiddenField('AliasForm[accountName]', $_GET['accountName']); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
            'buttonType'=>'submit',
            'type'=>'primary',
            'label'=>'Create',
        )); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->