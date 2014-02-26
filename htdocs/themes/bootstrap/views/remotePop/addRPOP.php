<?php
/* @var $this RemotePopController */
/* @var $model AddRpopForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Add Remote Pop';
$this->breadcrumbs=array(
	'AddRpopForm',
);
?>
<?php if (Yii::app()->controller->action->id == 'add') {
	$heading = 'Add Remote POP';
	$info = 'Please fill out the following form to add a new remote pop to account ' .  $_GET['account'];
} else {
	$heading = 'Edit Remote POP';
	$info = 'Please fill out the following form to edit the remote pop ' .  $_GET['name'] . ' for account ' .  $_GET['account'];
	} ?>
<h1><?php echo $heading ?></h1>

<p><?php echo $info; ?></p>

<div class="form">

<?php $options = array('2m' => '2 Minutes', '3m' => '3 Minutes',
 '5m' => '5 Minutes', '10m' => '10 Minutes', '15m' => '15 Minutes',
 '20m' => '20 Minutes', '30m' => '30 Minutes', '1h' => '1 Hour',
 '2h' => '2 Hours', '3h' => '3 Hours', '5h' => '5 Hours',
 '6h' => '6 Hours', '8h' => '8 Hours', '1d' => '24 Hours') ?>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'AddRpop-form',
    'type'=>'horizontal',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php if (Yii::app()->controller->action->id == 'add') {
		echo $form->textFieldRow($model,'displayName'); 
		echo $form->textFieldRow($model,'account');
		echo $form->textFieldRow($model,'host');
		echo $form->passwordFieldRow($model,'password');
		echo $form->textFieldRow($model,'mailbox');
		echo $form->checkboxRow($model, 'leaveMessageOnServer'); 
		echo $form->checkboxRow($model, 'apop'); 
		echo $form->checkboxRow($model, 'tls'); 
		echo $form->dropDownListRow($model, 'pullEvery', $options); 
	} else {
		$mailbox = (!isset($popInfo['mailbox']) ? '' : $popInfo['mailbox']);
		$apop = (!isset($popInfo['APOP']) ? 1 : $popInfo['APOP']);
		$tls = (!isset($popInfo['TLS']) ? 1 : $popInfo['TLS']);
		$leave = (!isset($popInfo['leave']) ? 1 : $popInfo['leave']);

		echo $form->textFieldRow($model,'displayName', array('value' => $_GET['name'])); 
		echo $form->textFieldRow($model,'account', array('value' => $popInfo['authName']));
		echo $form->textFieldRow($model,'host', array('value' => $popInfo['domain']));
		echo $form->passwordFieldRow($model,'password', array('value' => $popInfo['password']));
		echo $form->textFieldRow($model,'mailbox', array('value' => $mailbox));
		echo $form->checkboxRow($model, 'leaveMessageOnServer', array('value' => $leave)); 
		echo $form->checkboxRow($model, 'apop' , array('value' => $apop)); 
		echo $form->checkboxRow($model, 'tls', array('value' => $tls)); 
		echo $form->dropDownListRow($model, 'pullEvery', $options, array('data' => $options[$popInfo['period']])); 
	} ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
            'buttonType'=>'submit',
            'type'=>'primary',
            'label'=>'Add',
        )); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->