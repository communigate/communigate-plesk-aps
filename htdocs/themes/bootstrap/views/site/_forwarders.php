<p>
  <?php
  $this->widget('bootstrap.widgets.TbGridView', array(
// 'filter' => $data, Add filter here
    'type'=>'striped bordered condensed',
    'dataProvider'=>$forwarders,
    'template'=>"{items}\n{pager}",
    'columns'=>array(
      array('name'=>'forwarders', 'header'=>'Forwardres'),
      array('name'=>'forwardTo', 'header'=>'Forward To'),
      // array('name'=>'type', 'header'=>'Type'),
      array(
        'template' => '{delete}',
        'class'=>'bootstrap.widgets.TbButtonColumn',
        'htmlOptions'=>array('style'=>'text-align: center;'),
        'deleteButtonUrl'=> 'Yii::app()->createUrl(\'forwarders/delete\', array(\'forwarders\' => $data[\'forwarders\']))',
        ),

      ),
    ));
  $this->widget('bootstrap.widgets.TbButton',array(
      'label' => 'Add Forwarder',
      'type' => 'null',
      'size' => 'normal',
      'url' => Yii::app()->createUrl('forwarders/addForwarder'),
      'htmlOptions'=>array('class'=>"pull-left"),
      ));?>
  </p>