<div class="modal-header">
	<a class="close" data-dismiss="modal">&times;</a>
	<h4>Subscribe to a mailing list</h4>
</div>

<div class="modal-body">

<?php /** @var BootActiveForm $form */
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'horizontalForm',
	'type'=>'horizontal',
	'enableClientValidation'=>true,
	));
	?>

<p class="note">Fields with <span class="required">*</span> are required.</p>

<fieldset>

	<?php echo $form->textFieldRow($subscribtionForm,'accountName'); ?>
	<?php
	 // echo $form->passwordFieldRow($subscribtionForm,'accountPassword');
	?>
	<?php echo $form->hiddenField($subscribtionForm,'listName'); ?>

</fieldset>

<div class="modal-footer">
<?php
echo CHtml::ajaxSubmitButton( 'Subscribe',
	CHtml::normalizeUrl(array('MailingList/subscribe')),
	array(
		'error'=>'js:function(){
		}',
		'beforeSend'=>'js:function(){
		}',
		'success'=>'js:function(data){
			if (data != \'\') {
				alert(data);
			}
			jQuery(\'#yw0\').yiiGridView(\'update\');
		}',
		'complete'=>'js:function(){
		}',
		'update'=>'',
		),
	array('class' => 'btn','data-dismiss'=>'modal')
	);

$this->widget('bootstrap.widgets.TbButton', array(
	'label'=>'Close',
	'url'=>'#',
	'htmlOptions'=>array('data-dismiss'=>'modal'),
	)); 
    ?>
	<?php $this->endWidget(); ?>
</div>
</div>
