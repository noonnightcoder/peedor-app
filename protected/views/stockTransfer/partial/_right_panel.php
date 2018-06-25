
    <!-- #right.panel -->
    <div class="col-xs-12 col-sm-3 widget-container-col">

    	<!-- #section:right.panel.header -->
        <?php $this->renderPartial('partial/_right_panel_header',
        	array(
        		'items' => $items,
                'model' => $model,
                'from_outlet' => $from_outlet,
                'to_outlet' => $to_outlet
        	)
        ); ?>
        <!-- #/section:right.panel.header -->
         <?php $this->renderPartial('partial/_right_panel_footer',
            array(
                'items' => $items,
                'model' => $model,
                'from_outlet' => $from_outlet,
                'to_outlet' => $to_outlet
            )
        ); ?>
        
    </div>

