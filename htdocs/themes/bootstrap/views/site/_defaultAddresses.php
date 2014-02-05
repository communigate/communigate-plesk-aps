<h1>Set Default Addresses</h1>

<p>
	The default email address will "catch" any mail that is sent to an invalid email address for your domain.
	You can also choose to Discard,Reject, or Accept and bounce
	any mails sent to an invalid email address for your domain.
</p>

<?php /** @var BootActiveForm $form */
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'horizontalForm',
	'type'=>'horizontal',
	));
	?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<fieldset>
		<?php
		$defaultBehaviors = array(
			'' => '--',
			'Discarded' => 'Discard Email',
			'Rejected' => 'Reject Email',
			'Rerouted to' => 'Forward to this address:',
			'Accepted and Bounced' => 'Accept and Bounce'
			); 
			echo $form->textFieldRow($defaultAddressesForm,'domainName', array( 
			'readonly' => true, 'value' => Yii::app()->params['domain'])); 
		 	echo $form->dropDownListRow($defaultAddressesForm, 'setDefaultBehavior', $defaultBehaviors,
		 		array('id' => $defaultBehaviors[$defaultAddressesSettings["MailToUnknown"]]));
			echo $form->textFieldRow($defaultAddressesForm,'addressToForwardTo', array('value' => $defaultAddressesSettings["MailRerouteAddress"])); ?>

		</fieldset>

		<div class="form-actions">
			<?php $this->widget('bootstrap.widgets.TbButton',
				array('buttonType'=>'submit',
					'type'=>'primary',
					'label'=>'Submit')); 
					?>
		</div>
<?php $this->endWidget(); ?>