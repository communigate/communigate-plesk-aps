<?php
/* @var $this SiteController */
/* @var $model AccountForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Configure Server';
$this->breadcrumbs=array(
	'Configure Server',
);
?>

<h1>Configure Server</h1>

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
		$host = Yii::app()->params['host'];
		$port = Yii::app()->params['port'];
		$login = Yii::app()->params['login'];
		$password = Yii::app()->params['password'];
		$domain = Yii::app()->params['domain'];
		$webmail = Yii::app()->params['webmail'];



	?>

	<?php echo $form->textFieldRow($model,'host', array('value' => $host)); ?>
	<?php echo $form->textFieldRow($model,'port', array('value' => $port)); ?>
	<?php echo $form->textFieldRow($model,'userName', array('value' => $login)); ?>
	<?php echo $form->textFieldRow($model,'password', array('value' => $password)); ?>
	<?php echo $form->textFieldRow($model,'webmail', array('value' => $webmail)); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
            'buttonType'=>'submit',
            'type'=>'primary',
            'label'=>'Update',
        )); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->