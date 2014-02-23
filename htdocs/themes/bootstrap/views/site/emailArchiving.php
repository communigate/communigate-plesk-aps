<?php
/* @var $this SiteController */
/* @var $model EmailArchivingForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Email Archiving';
$this->breadcrumbs=array(
	'Email Archiving',
);
?>

<h1>Email Archiving</h1>

<p>Email Archiving allows you to store a copy of each incoming and outgoing message
 that is sent to or from a domain on your account. The archives are stored in an 
 uncompressed maildir format so they can be browsed via an IMAP connection. 
 Be aware that archiving email can consume disk space quickly, and you should ensure you have enough
 disk space available for the retention period you select.</p>

<div class="form">
	<?php 
	$domainName = Yii::app()->params['domain'];
	$options = array('' => 'default', 0 => 'never', '1d' => '24 hours', '2d' => '2 days',
		'3d' => '3 days', '5d' => '5 days', '7d' => '7 days', '14d' => '2 weeks',
		'30d' => '30 days', '90d' => '90 days', '180d' => '180 days', '365d' => '365 days', '730d' => '730 days',);

	$id_archive = $id_delete = null;
	
	if (isset($settings['ArchiveMessagesAfter'])) {
		$id_archive = $options[$settings['ArchiveMessagesAfter']];
	}
	if (isset($settings['DeleteMessagesAfter'])) {
		$id_delete = $options[$settings['DeleteMessagesAfter']];
	}


	?>

	<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
		'id'=>'emailAchiving-form',
	    'type'=>'horizontal',
		'enableClientValidation'=>true,
		'clientOptions'=>array(
			'validateOnSubmit'=>true,
		),
	)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<h4>Domain: <?php echo $domainName ?></h4>

	<?php echo $form->dropDownListRow($model, 'archiveMessageAfter', $options,
	array('id' => $id_archive)
	); ?>

	<?php echo $form->dropDownListRow($model, 'deleteMessageAfter', $options,
	array('id' => $id_delete)); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
            'buttonType'=>'submit',
            'type'=>'primary',
            'label'=>'Create',
        )); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->