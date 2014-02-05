<p>
	<?php 
	$this->widget('bootstrap.widgets.TbGridView', array(
      // 'filter' => $data, Add filter here
		'type'=>'striped bordered condensed',
		'dataProvider'=>$data,
		'template'=>"{items}\n{pager}",
		'columns'=>array(
			array('name'=>'account', 'header'=>'Accounts'),
			array('name'=>'accountAliases', 'header'=>'Account Aliases'),
			array('name'=>'aliasButton', 'header'=>'', 'id' => 'asdasd',  'htmlOptions'=>array('style'=>'width: 120px; text-align:center;')),
			)));
			?>
</p>