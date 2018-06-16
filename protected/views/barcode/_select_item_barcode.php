<?php
	$this->breadcrumbs=array(
	    'Item' => array('item/admin'),
	    'Barcode',
	);
?>

<div id="register_container">

    <?php $this->renderPartial('//barcode/partial/_left_panel',
        array(
            'model' => $model,
            'items' => $items
        )); ?>

    <?php $this->renderPartial('//barcode/partial/_right_panel', 
    	array(
        	'model' => $model,
        	'items' => $items
    	)); ?>

</div>