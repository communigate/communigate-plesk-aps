<?php 

$this->pageTitle=Yii::app()->name ;
?>

<h1>Edit Filters</h1>
<p>In this area you can manage filters for  <?php echo $_GET['account'] ?>.</p>

<?

$this->widget('bootstrap.widgets.TbGridView', array(
      // 'filter' => $data, Add filter here
	'type'=>'striped bordered condensed',
	'dataProvider'=>$gridDataProvider,
		'template'=>"{items}\n{pager}",
	'columns'=>array(
		array('name'=>'filter', 'header'=>'Current Filters'),
		array(
			'template' => '{edit} &nbsp&nbsp&nbsp&nbsp {delete}',
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'deleteButtonIcon' => false,
			'htmlOptions'=>array('style'=>'width: 500px; text-align:center;'),
			'buttons' => array(
				'delete' => array(
					'label'=>'Delete',
					'imageUrl'=> false,
					'options'=>array('rel'=> 'tooltip', 'data-original-title'=>"Delete Group" ),
					'url'=>'Yii::app()->createUrl(\'filter/delete\', array(\'filter\' => $data[\'filter\'], \'account\' => $_GET[\'account\']))',
					),
				'edit' => array(
					'label'=>'Edit',
					'imageUrl'=>false,
					'options'=>array('rel'=> 'tooltip', 'data-original-title'=>"Rename filter" ),
					'url'=>'Yii::app()->createUrl(\'filter/update\', array(\'filter\' => $data[\'filter\'], \'account\' => $_GET[\'account\']))',
					),
				),
			),	
)));

$this->widget('bootstrap.widgets.TbButton',array(
  'label' => 'Create New Filter',
  'type' => 'null',
  'size' => 'normal',
  'url' => Yii::app()->createUrl("filter/create", array('account' => $_GET['account'])),
  'htmlOptions'=>array('class'=>"pull-left"),
  ));
?>