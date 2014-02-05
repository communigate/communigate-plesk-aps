<?php
/* @var $this ForwardersController */
/* @var $model ForwarderForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Add Forwarder';
$this->breadcrumbs=array(
	'Add Forwarder',
);
?>

<h1>Add a New Forwarder</h1>

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


	<?php echo $form->textFieldRow($model,'addressToForward'); ?>
	<?php echo $form->textFieldRow($model,'destination'); ?>


	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
            'buttonType'=>'submit',
            'type'=>'primary',
            'label'=>'Add Forwarder',
        )); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->