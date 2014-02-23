<?php
/* @var $this GroupController */
/* @var $model GroupSettingsForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Group Settings';
$this->breadcrumbs=array(
	'Group Settings',
);
?>

<h1>Group Settings</h1>

<p>Please fill out the following form to change the group settings for <?php echo $_GET['group'] ?></p>

<div class="form">

<?php
$options = array('EmailDisabled' => 'Disable E-mails',
		'Expand' => 'Expand Member Groups',
		'FinalDelivery' => 'Report Delivery to Group',
		'RejectAutomatic' => 'Reject Automatic Messages',
		'RemoveAuthor' => 'Remove Author from Distribution',
		'RemoveToAndCc' => 'Remove To and Cc from Distribution',
		'SetReplyTo' => 'Set Reply-To to Group',
		'SignalDisabled' => 'Disable Signals');


?>


<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'GroupSettings-form',
    'type'=>'horizontal',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>


	<?php echo $form->textFieldRow($model,'realName'); ?>

	<?php $model->settings = $preselect?>
	<?php echo $form->checkBoxListRow($model, 'settings' ,$options
		 

	); ?>



	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
            'buttonType'=>'submit',
            'type'=>'primary',
            'label'=>'Save',
        )); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->