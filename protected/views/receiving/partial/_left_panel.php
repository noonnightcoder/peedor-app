<!-- #section:left.panel-->
<div class="col-xs-12 col-sm-9 widget-container-col">
    <!-- #section:left.panel.header-->
    <?php $this->renderPartial('partial/_left_panel_header',
        array(
            'model' => $model,
            'items_model' => $items_model,
            'items' => $items,
            'from_outlet' => $from_outlet,
            'to_outlet' => $to_outlet
        ));
    ?>
    <!-- /section:left.panel.header-->

    <!-- #section:left.panel.grid.cart-->
    <?php $this->renderPartial('partial/_left_panel_grid_cart', 
        array(
            'model' => $model,
            'items_model' => $items_model,
            'items' => $items,
            'from_outlet' => $from_outlet,
            'to_outlet' => $to_outlet
        ));
    ?>
    <!-- /section:left.panel.grid.cart -->


</div>
<!-- /section:left.panel -->


<?php $this->renderPartial('partial/_js')?>