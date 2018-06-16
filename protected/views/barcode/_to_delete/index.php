<?php $this->renderPartial('//barcode/partial/_header_view_barcode')?>


<?php
    $baseUrl = Yii::app()->theme->baseUrl;
    $cs = Yii::app()->getClientScript();
?>
<?php Yii::app()->bootstrap->register(); ?>
<?php if(isset($_GET['preview'])):?>
	<?php $this->renderPartial('//barcode/partial/_header_view_barcode')?>
<?php endif;?>
<div id="register_container">
	<?php $this->renderPartial('//barcode/'.$view,$data)?>
</div>
<!--<link rel="icon" type="image/ico" href="<?php /*echo $baseUrl */?>/css/img/bakouicon.ico" />-->
    <link rel="apple-touch-icon" sizes="57x57" href="<?= $baseUrl ?>/favicon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="<?= $baseUrl ?>/favicon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="<?= $baseUrl ?>/favicon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="<?= $baseUrl ?>/favicon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="<?= $baseUrl ?>/favicon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="<?= $baseUrl ?>/favicon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="<?= $baseUrl ?>/favicon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="<?= $baseUrl ?>/favicon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="<?= $baseUrl ?>/favicon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="<?= $baseUrl ?>/favicon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= $baseUrl ?>/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="<?= $baseUrl ?>/favicon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= $baseUrl ?>/favicon/favicon-16x16.png">
    <link rel="manifest" href="<?= $baseUrl ?>/favicon/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="<?= $baseUrl ?>/favicon/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    
    <!-- bootstrap & fontawesome -->
    <!--<link rel="stylesheet" type="text/css" href="<?php //echo $baseUrl ?>/css/bootstrap.min.css" /> -->
    <link rel="stylesheet" type="text/css" href="<?php echo $baseUrl ?>/css/font-awesome.min.css" />
    
    <!-- page specific plugin styles -->
    <!-- <link rel="stylesheet" type="text/css" href="<?php //echo $baseUrl ?>/css/jquery-ui.custom.min.css" /> -->
    
    <!-- text fonts -->
    <link rel="stylesheet" type="text/css" href="<?php echo $baseUrl ?>/css/ace-fonts.css" />
    
    <!-- ace styles -->
    <link rel="stylesheet" type="text/css" href="<?php echo $baseUrl ?>/css/ace.min.css" />
    
    <!--[if lte IE 9]>
        <link rel="stylesheet" type="text/css" href="<?php echo $baseUrl ?>/css/ace-part2.min.css" />
    <![endif]-->
    <link rel="stylesheet" type="text/css" href="<?php echo $baseUrl ?>/css/ace-skins.min.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo $baseUrl ?>/css/ace-rtl.min.css" />
    
    <!--[if lte IE 9]>
        <link rel="stylesheet" type="text/css" href="<?php echo $baseUrl ?>/css/ace-ie.min.css" />
    <![endif]-->
    
    <link rel="stylesheet" type="text/css" href="<?php echo $baseUrl ?>/css/loading_animation.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo $baseUrl ?>/css/jquery-ui-1.10.4.custom.min.css" />
<?php
        $cs->registerScriptFile($baseUrl.'/js/ace-extra.min.js',CClientScript::POS_END);
        //$cs->registerScriptFile($baseUrl.'/js/jquery-ui.custom.min.js',CClientScript::POS_END);
        //$cs->registerScriptFile($baseUrl.'/js/jquery.ui.touch-punch.min.js',CClientScript::POS_END);
        //$cs->registerScriptFile($baseUrl.'/js/jquery.gritter.min.js',CClientScript::POS_END);
        //$cs->registerScriptFile($baseUrl.'/js/jquery.slimscroll.min.js',CClientScript::POS_END); 
        //$cs->registerScriptFile($baseUrl.'/js/jquery.bxslider.min.js',CClientScript::POS_END); 
        //$cs->registerScriptFile($baseUrl.'/js/jquery.colorbox-min.js',CClientScript::POS_END);
        $cs->registerScriptFile($baseUrl.'/js/jquery.maskedinput.min.js',CClientScript::POS_END);
        $cs->registerScriptFile($baseUrl.'/js/ace-elements.min.js',CClientScript::POS_END);
        $cs->registerScriptFile($baseUrl.'/js/ace.min.js',CClientScript::POS_END);
        //$cs->registerScriptFile($baseUrl.'/js/jquery.jkey.min.js',CClientScript::POS_END);
        //$cs->registerScriptFile($baseUrl.'/js/common.js',CClientScript::POS_END);
        $cs->registerScriptFile($baseUrl.'/js/jquery.form.min.js',CClientScript::POS_END);
    ?>
    
    <?php
        if (Yii::app()->components['user']->loginRequiredAjaxResponse){
            Yii::app()->clientScript->registerScript('ajaxLoginRequired', '
                jQuery("body").ajaxComplete(
                    function(event, request, options) {
                        if (request.responseText == "'.Yii::app()->components['user']->loginRequiredAjaxResponse.'") {
                            window.location.href = options.url;
                        }
                    }
                );
            ');
        }
    ?>