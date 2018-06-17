<!-- #section:left.panel-->
<div class="col-xs-12 col-sm-9 widget-container-col">
    <!-- #section:left.panel.header-->
    <?php $this->renderPartial('//barcode/partial/_left_panel_header',
        array(
            'model' => $model,
            'items' => $items
        ));
    ?>
    <!-- /section:left.panel.header-->

    <!-- #section:left.panel.grid.cart-->
    <?php $this->renderPartial('//barcode/partial/_left_panel_grid_cart', 
        array(
            'model' => $model,
            'items' => $items
        ));
    ?>
    <!-- /section:left.panel.grid.cart -->


</div>
<!-- /section:left.panel -->


<?php $this->renderPartial('//barcode/partial/_js')?>