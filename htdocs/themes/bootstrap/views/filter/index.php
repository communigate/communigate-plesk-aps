<?php 
$this->pageTitle=Yii::app()->name ;
?>

<h1>Manage Filters</h1>
<p>In this area, you can manage filters for each user. Each user filter is processed after the main account filters.</p>

<?
$this->widget('bootstrap.widgets.TbGridView', array(
      // 'filter' => $data, Add filter here
	'type'=>'striped bordered condensed',
	'dataProvider'=>$gridDataProvider,
		'template'=>"{items}\n{pager}",
	'columns'=>array(
		array('name'=>'account', 'header'=>'Accounts'),
		array(
			'template' => '{manage}',
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'deleteButtonIcon' => false,
			'htmlOptions'=>array('style'=>'width: 500px; text-align:center;'),
			'buttons' => array(
				'manage' => array(
					'label'=>'Manage Filters',
					'imageUrl'=> false,
					'options'=>array('rel'=> 'tooltip', 'data-original-title'=>"Manage Filters" ),
					'url'=>'Yii::app()->createUrl(\'filter/manageFilters\', array(\'account\' => $data[\'account\']))',
					),
				),
			),
		
	)));
?>