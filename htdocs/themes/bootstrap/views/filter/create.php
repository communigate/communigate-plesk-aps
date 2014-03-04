<?php
/* @var $this FilterController */
/* @var $model CreateFilterForm */
/* @var $form CActiveForm  */
$this->pageTitle=Yii::app()->name . ' - Create Filter';
$this->breadcrumbs=array(
	'Create Filter',
);
?>

<h1>Create Filter</h1>

<p>Please create a filter for  <?php echo $_GET['account'] ?>. You can add multiple rules to match subjects, addresses, or other parts of the message. You can then add multiple actions to take on a message such as to deliver the message to a different address and then discard it.</p>

<div class="form">

<?php 
// Options for the dropdowns
$optionsForPriority = array('0' => 'Inactive', '1' => '1', '2' => '2', '3' => '3',
'4' => '4', '5' => '5', '6' => '6', '7' => '7', '8' => '8', '9', '10' => 'Higheset');

$optionsForDataFilter = array('---','From', 'Sender', 'Return-Path',
    'To', 'Cc', 'Any To or Cc', 'Each To or Cc', 'Reply-To', "'From' Name",
    'Subject', 'Message-ID', 'Message Size', 'Time Of Day', 'Current Date',
    'Current Day', 'Preference', 'FreeBusy', 'Human Generated', 'Header Field',
    'Any Recipient', 'Each Recipient', 'Existing Mailbox', 'Security',
    'Source', 'Submit Address'
    );
$optionsForOperations = array('is', 'is not', 'in', 'greater than', 'less than');

$optionsForActions = array('---', 'Store in', 'Mark', 'Add Header', 'Tag Subject',
    'Reject with', 'Discard', 'Stop Processing', "Remember 'From' in",
    'Access Request', 'Accept Reply', 'Store Encrypted in', 'Copy Attachments into',
    'Redirect To', 'Forward to', 'Mirror to', 'Reply with', 'Reply with All with',
    'React with', ' Send IM', 'Execute URL', 'Execute', 'FingerNotify');
?>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'RenameGroup-form',
    'type'=>'horizontal',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>


	<?php echo $form->textFieldRow($model,'name', array('hint'=>'The filter name must be unique. If you give the filter the same name as another filter, the previous filter will be overwritten.')); ?>
	
	<?php echo $form->dropDownListRow($model,'priority',array_combine( $optionsForPriority,  $optionsForPriority)); ?>
	
	<div id="rules" class="test">
		<div class="dataClass">
		<?php echo $form->dropDownListRow($model,'data',array_combine($optionsForDataFilter, $optionsForDataFilter)); ?>
		</div>
		<div class="operClass">
		<?php echo $form->dropDownListRow($model,'operation',array_combine($optionsForOperations, $optionsForOperations)); ?>
		</div>
		<div class="paramClass">
		<?php echo $form->textFieldRow($model, 'dataParam', array('class' => 'dataParamClass')) ?>
		</div>
		<div class="operationButtons">
		<a href="" class="btn duplicate" id="btnDuplicate">+</a>
		<a href="" class="btn remove" id="btnRemove">-</a>
		</div>
	</div>

	<div id="actions" class="actionsClass">
	<?php echo $form->dropDownListRow($model,'action',array_combine($optionsForActions, $optionsForActions)); ?>
	<?php echo $form->textFieldRow($model,'actionParam', array('class' => 'operClass')); ?>
	<div class="operationButtonsAction">
	<a href="" class="btn duplicateAction" id="btnDuplicateAction">+</a>
	<a href="" class="btn removeAction" id="btnActionRemove">-</a>
	</div>
	</div>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
            'buttonType'=>'submit',
            'type'=>'primary',
            'label'=>'Create',
        )); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->