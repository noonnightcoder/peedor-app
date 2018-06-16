<!-- #right.panel -->
<div class="col-xs-12 col-sm-3 widget-container-col">

	<!-- #section:right.panel.header -->
    <?php $this->renderPartial('//barcode/partial/_right_panel_header',
    	array(
    		'items'=>$items
    	)); ?>
    <!-- #/section:right.panel.header -->
    <?php $this->renderPartial('//barcode/partial/_right_panel_footer',
    	array(
    		'items'=>$items
    	)); ?>
</div>