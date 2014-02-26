<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/styles.css" />

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>

	<?php Yii::app()->bootstrap->register(); ?>
</head>

<body>

<?php 
$this->widget('bootstrap.widgets.TbNavbar', array(
    'type'=>'', // null or 'inverse'
    'brand'=>'CommuniGate',
    'brandUrl'=>'#',
    'collapse'=>true, // requires bootstrap-responsive.css
    'items'=>array(
        array(
            'class'=>'bootstrap.widgets.TbMenu',
            'items'=>array(
                array('label'=>'Accounts', 'url'=>array('/site/index')),
                array('label'=>'Mailing Lists', 'url'=>array('/mailingList/index')),
                array('label'=>'Mobile Devices', 'url'=>array('/site/MobileDevices')),
                array('label'=>'VoIP', 'url'=>array('/site/VoIP')),
                array('label'=>'Email Archiving', 'url'=>array('/site/emailArchiving')),
                array('label'=>'Group', 'url'=>array('/group/index')),
                array('label'=>'Remote POP', 'url'=>array('/remotePop/index')),
            ),
        ),
        // '<a href="'.    Yii::app()->createUrl("site/configureServer")  . '"'.
        // 'rel="tooltip" title="Configure CommuniGate Server" class="btn btn-normal pull-right" data-placement="bottom"'.
        // '><i class="icon-cog"></i></a>',
    ),
));
















// $this->widget('bootstrap.widgets.TbNavbar',array(
//     'items'=>array(
//         array(
//             'class'=>'bootstrap.widgets.TbMenu',
//             'items'=>array(
//                 array('label'=>'Accounts', 'url'=>array('/site/index')),
//                 array('label'=>'Mailing Lists', 'url'=>array('/mailingList/index')),
//                 array('label'=>'Mobile Devices', 'url'=>array('/site/MobileDevices')),
//                 array('label'=>'VoIP', 'url'=>array('/site/VoIP')),
// 				// array('label'=>'Login', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
//     //             array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest)
//             ),
//         ),
//     ),
// )); 
?>

<div class="container" id="page">

	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
	<?php endif?>

	<?php echo $content; ?>

	<div class="clear"></div>

<!-- 	<div id="footer">
		Copyright &copy; <?php //echo date('Y'); ?> by My Company.<br/>
		All Rights Reserved.<br/>
		<?php //echo Yii::powered(); ?>
	</div><!-- footer -->

	

<?php if(CHttpRequest::getParam("tab") != null): ?>
 
    <script>
        $(document).ready(function() {
            $('.tab-content').children().removeClass('active in');
            $('#yw7').children().removeClass('active');
            $('a[href="#<?php echo CHttpRequest::getParam("tab"); ?>"]').parent().addClass('active');
            $('#<?php echo CHttpRequest::getParam("tab"); ?>').addClass('active in');
        });
 
    </script>
 
<?php endif; ?>
</div><!-- page -->

</body>
</html>
