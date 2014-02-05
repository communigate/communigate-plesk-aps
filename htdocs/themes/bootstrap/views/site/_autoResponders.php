<p>
  <?php
  $this->widget('bootstrap.widgets.TbGridView', array(
// 'filter' => $data, Add filter here
    'type'=>'striped bordered condensed',
    'dataProvider'=>$autoRespondersData,
    'template'=>"{items}\n{pager}",
    'columns'=>array(
      array('name'=>'email', 'header'=>'E-mail'),
      array('name'=>'subject', 'header'=>'subject'),
      array(
        'template' => '{update} {delete}',
        'class'=>'bootstrap.widgets.TbButtonColumn',
        'htmlOptions'=>array('style'=>'width: 50px'),
        'updateButtonUrl'=> 'Yii::app()->createUrl(\'autoResponders/update\', array(\'account\' => $data[\'email\']))',
        'deleteButtonUrl'=>'Yii::app()->createUrl(\'autoResponders/delete\', array(\'account\' => $data[\'email\']))',
        ),

      ),
    ));
  
  $this->widget('bootstrap.widgets.TbButton',array(
      'label' => 'Add Auto Responder',
      'type' => 'null',
      'size' => 'normal',
      'url' => Yii::app()->createUrl("autoResponders/create"),
      'htmlOptions'=>array('class'=>"pull-left"),
      ));?>
  </p>