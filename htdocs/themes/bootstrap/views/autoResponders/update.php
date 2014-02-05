<?php
/* @var $this AutoRespondersController */
/* @var $model CreateAutoRespondersForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Add Auto Responder';
$this->breadcrumbs=array(
	'Add Auto Responder',
);
?>

<h1>Add Auto Responder</h1>
<p>Hint: If you do not create a forwarder or email account with the same address as this auto responder, mail will only be handled by the auto responder before it is discarded.

When configuring an auto responder, you can use the following tags to insert information into the response email:

^S	-	The subject of the message sent to the auto responder.
^F	-	The name of the sender of the message received by the auto responder, if available.
^R	-	The incoming email sender's address.</p>

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

	<?php date_default_timezone_set("UTC"); ?>

	<?php echo $form->textFieldRow($model,'email', array('value'=>$values['email'])); ?>
	<?php echo $form->textFieldRow($model,'from', array('value'=>$values['from'])); ?>
	<?php echo $form->textFieldRow($model,'subject', array('value'=>$values['subject'])); ?>
	<?php echo $form->textAreaRow($model, 'body', array('class'=>'span8', 'rows'=>5, 'value'=>$values['body'])); ?>
	<?php echo $form->textFieldRow($model,'ends', array(
				'class'=> 'span2',
				'value' => date("m/d/Y", strtotime($values['endDate'])),
				'data-date-format'=> 'mm/dd/yyyy',
				'id' => 'datepicker',
				'append'=>'<i class="icon-calendar"></i>'));?>
  <script type="text/javascript"> $('#datepicker').datepicker()</script>



	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
            'buttonType'=>'submit',
            'type'=>'primary',
            'label'=>'Add Forwarder',
        )); ?>
	</div>


<?php $this->endWidget(); ?>


</div><!-- form -->