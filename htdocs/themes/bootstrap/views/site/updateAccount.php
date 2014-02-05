<?php
/* @var $this SiteController */
/* @var $model UpdateForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Update Account';
$this->breadcrumbs=array(
	'Update Account',
	);
	?>

	<h1>Update Account</h1>

	<div class="form">

		<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
			'id'=>'account-form',
			'type'=>'horizontal',
			'enableClientValidation'=>true,
			'clientOptions'=>array(
				'validateOnSubmit'=>true,
				),
			)); 
			?>

			<p class="note">Fields with <span class="required">*</span> are required.</p>

			<!-- Form fields -->
			<?php echo CHtml::hiddenField('UpdateForm[accountName]', $_GET['account']); ?>
			<?php echo $form->textFieldRow($model,'realName', array('value'=>$settings['RealName'])); ?>
			<?php echo $form->textFieldRow($model,'newAccountName', array('value'=>$account)); ?>
			<?php echo $form->passwordFieldRow($model,'newAccountPassword'); ?>
			<?php echo $form->dropDownListRow($model,'accountType', $accountTypes,
			array('id' => $settings['ServiceClass'])); ?>

			<div class="form-actions">
				<?php $this->widget('bootstrap.widgets.TbButton', array(
					'buttonType'=>'submit',
					'type'=>'primary',
					'label'=>'Update',
					)); ?>
			</div>

		<?php $this->endWidget(); ?>

			</div><!-- form -->
