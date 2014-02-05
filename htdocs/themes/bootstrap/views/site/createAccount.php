<?php
/* @var $this SiteController */
/* @var $model AccountForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Create Account';
$this->breadcrumbs=array(
	'Create Account',
);
?>

<h1>Create Account</h1>

	<p>Fill the following form to create account</p>

	<?php /** @var BootActiveForm $form */
	$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	    'id'=>'horizontalForm',
	    'type'=>'horizontal',
	));
	?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>
	
	<fieldset>

    <?php echo $form->textFieldRow($model,'realName'); ?>
	<?php echo $form->textFieldRow($model,'accountName'); ?>
	<?php echo $form->passwordFieldRow($model,'accountPassword'); ?>
	<?php echo $form->dropDownListRow($model, 'accountType', $accountTypes); ?>

 
	</fieldset>
 
<div class="form-actions">
	<?php $this->widget('bootstrap.widgets.TbButton',
						array('buttonType'=>'submit',
							 'type'=>'primary',
							 'label'=>'Submit')); 
	?>
</div>
 
<?php $this->endWidget(); ?>

