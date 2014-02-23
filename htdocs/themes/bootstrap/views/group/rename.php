<?php
/* @var $this GroupController */
/* @var $model GroupForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Rename Group';
$this->breadcrumbs=array(
	'Rename Group',
);
?>

<h1>Rename Group</h1>

<p>Please fill out the following form to rename the group <?php echo $_GET['group'] ?></p>

<div class="form">

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'RenameGroup-form',
    'type'=>'horizontal',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>


	<?php echo $form->textFieldRow($model,'newGroupName', array('append'=> "@" . Yii::app()->params['domain'])); ?>
	<?php echo CHtml::hiddenField('RenameGroupForm[oldGroupName]', $_GET['group']); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
            'buttonType'=>'submit',
            'type'=>'primary',
            'label'=>'Rename',
        )); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->