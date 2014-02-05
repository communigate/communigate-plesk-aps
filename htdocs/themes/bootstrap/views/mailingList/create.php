<?php

$this->pageTitle=Yii::app()->name . ' - Create Mailing List';
$this->breadcrumbs=array(
	'Mailing List'=>array('/mailingList'),
	'Create',
);
?>

<h1>Create Mailing List</h1>

	<p>Fill the following form to create account</p>

	<?php /** @var BootActiveForm $form */
	$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	    'id'=>'horizontalForm',
	    'type'=>'horizontal',
	));
	?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>
	
	<fieldset>

	<?php echo $form->dropDownListRow($model,'accountName', $accounts); ?>
	 <!-- echo $form->passwordFieldRow($model,'accountPassword');  -->
	<?php echo $form->textFieldRow($model,'mailingListName'); ?>

 
	</fieldset>
 
<div class="form-actions">
	<?php $this->widget('bootstrap.widgets.TbButton',
						array('buttonType'=>'submit',
							 'type'=>'primary',
							 'label'=>'Submit')); 
	?>
</div>
 
<?php $this->endWidget(); ?>


