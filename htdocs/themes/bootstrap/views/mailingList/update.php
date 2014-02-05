<?php
/* @var $this MailingListController */

$this->breadcrumbs=array(
	'Mailing List'=>array('/mailingList'),
	'Update',
	);
	?>
	<h1>Update Mailing List</h1>

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
			<?php 
			echo $form->textFieldRow($model, 'owner', array('readonly' => true, 'value'=>$data['Owner']));
			
			echo $form->dropDownListRow($model,'subscribe', array(
				'anybody' => 'anybody',
				'locals only' => 'locals only',
				'this domain only' => 'this domain only',
				'moderated' => 'moderated',
				'nobody' => 'nobody'));
			// array('id' => $settings['subscribe'])); Set the id to the item to be selected and pre select it with js

			echo $form->textFieldRow($model,'confirmationRequestSubject', array('value'=>$data['ConfirmationSubject']));
			
			echo $form->textAreaRow($model, 'confirmationRequestText', array('class'=>'span8', 'rows'=>6 ,
				'value' => $data['ConfirmationText']));
			
			echo $form->textFieldRow($model,'policyMessageSubject', array('value'=>$data['PolicySubject']));
			
			echo $form->textAreaRow($model, 'policyMessageText', array('class'=>'span8', 'rows'=>6 ,
				'value' => $data['PolicyText']));
			echo $form->textAreaRow($model, 'serviceFields', array('class'=>'span8', 'rows'=>6 ,
				'value' => $data['ListFields']));
			echo $form->dropDownListRow($model,'postingSizeLimit', array(
				'unlimited' => 'unlimited',
				'0' => '0',
				'1024' => '1024',
				'3K' => '3K',
				'10K' => '10K',
				'30K' => '30K',
				'100K' => '100K',
				'300K' => '300K',
				'1024K' => '1024K',
				'3M' => '3M',
				'10M' => '10M',
				'300M' => '300M'));
			// array('id' => $settings['subscribe'])); Set the id to the item to be selected and pre select it with js
			echo $form->textAreaRow($model, 'feedModeTrailer', array('class'=>'span8', 'rows'=>6 ,
				'value' => $data['FeedTrailer']));
			echo $form->textFieldRow($model,'warningMessageSubject', array('value'=>$data['WarningSubject']));
			echo $form->textAreaRow($model, 'wrningMessageText', array('class'=>'span8', 'rows'=>6 ,
				'value' => $data['WarningText']));
			echo $form->textFieldRow($model,'goodbyeMessageSubject', array('value'=>$data['ByeSubject']));
			echo $form->textAreaRow($model, 'goodbyeMessageText', array('class'=>'span8', 'rows'=>6 ,
				'value' => $data['ByeText']));

				?>

				<div class="form-actions">
					<?php $this->widget('bootstrap.widgets.TbButton', array(
						'buttonType'=>'submit',
						'type'=>'primary',
						'label'=>'Update',
						)); ?>
					</div>

					<?php $this->endWidget(); ?>

				</div><!-- form -->
