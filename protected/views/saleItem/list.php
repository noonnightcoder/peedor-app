<?php
$this->breadcrumbs=array(
    'Sales'=>array('index'),
    'Sale Order',
);
?>

<div id="sale_order_id">

    <?php $this->renderPartial('//layouts/alert/_flash'); ?>

    <?php $this->renderPartial('partialList/_grid',array(
        'model' => $model,
        'sale_status' => $sale_status,
        'box_title' => $box_title,
        'grid_columns' => $grid_columns,
        'color_style' => $color_style,
        'sale_header_icon' => $sale_header_icon,
    )); ?>

</div>


<?php $this->renderPartial('partialList/_js'); ?>
