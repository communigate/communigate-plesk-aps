<?php
/* @var $this GroupController */
/* @var $model GroupMembersForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Remote POP';
$this->breadcrumbs=array(
	'Remote POP',
);
?>

<h1>Remote POP</h1>

<div class="form">
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'RenameGroup-form',
    'type'=>'horizontal',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
	)); ?>		
		<div id="accountElement">
			<?php echo CHtml::label('Accounts','accountsDropdown', array('class' => 'control-label' , 'id' => 'accountLbl')); ?>
		<?php echo CHtml::dropDownList('accountsDropdown','', $accounts); ?>

		</div>
<?php $this->endWidget(); ?>
</div>

<div id="table"></div>

</div><!-- form -->

<script type="text/javascript">
	$( "#accountsDropdown" ).change(function() {
		
		var url = "<? echo Yii::app()->createUrl('remotePop/index', array('account' => 'replace')); ?>";
		url = url.replace("replace", $('#accountsDropdown').val());
		
		var	urlCreate = "<? echo Yii::app()->createUrl('remotePop/add', array('account' => 'replace')); ?>";
		urlCreate = urlCreate.replace("replace", $('#accountsDropdown').val());

		var createBtn =  '<a class="btn" href="' +  urlCreate  + '">Add Remote Pop</a>'
		
		if ($('#accountsDropdown').val() !== 'Please Choose') {
			$.ajax({
				url: url,
				dataType: 'html',
				complete: function(data){
					$('#table').empty();
					$('#table').append(data.responseText);
					$('#table').prepend(createBtn);
				},
			});
		} else{
			$('#table').empty();
		};
	}).change();
</script>