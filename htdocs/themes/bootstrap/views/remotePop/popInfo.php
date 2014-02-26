<?php 
$this->widget('bootstrap.widgets.TbGridView', array(
	'id' => 'rpopGrid',
	'type'=>'striped bordered condensed',
	'dataProvider'=>$dataProvider,
	'template'=>"{items}\n{pager}",
	'columns'=>array(
		array('name'=>'popName', 'header'=>'Remote POP'),
		array(
			'template' => '{view} {delete}',
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'deleteButtonIcon' => false,
			'viewButtonIcon' => false,
			'header' => 'Functions',
			'htmlOptions'=>array('style'=>'width: 500px; text-align:center;'),
			'buttons' => array(
				'delete' => array(
					'label'=>'Delete',
					'imageUrl'=> false,
					'options'=>array('rel'=> 'tooltip', 'data-original-title'=>'Delete Remote Pop', 'class' => 'remove' ),
					'url'=>'Yii::app()->createUrl(\'remotePop/delete\', array(\'name\' => $data[\'popName\'], 
						\'account\' => $data[\'account\']))',
				),
				'view' => array(
					'label'=>'View/Edit',
					'imageUrl'=> false,
					'options'=>array('rel'=> 'tooltip', 'data-original-title'=>"View and edit Remote Pop" ),
					'url'=>'Yii::app()->createUrl(\'remotePop/viewEdit\', array(\'name\' => $data[\'popName\'], 
						\'account\' => $data[\'account\']))',
				),
				)
			),
		)
	)); 
?>
