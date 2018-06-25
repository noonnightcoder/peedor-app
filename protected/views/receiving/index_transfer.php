<?php
	$this->breadcrumbs=array(
	    'Stock' => Yii::app()->createUrl('receiving/itemTransferSubmited',array('tran_type'=>param('sale_submit_status'))),
	    'Transfter',
	);
?>
<?php $this->renderPartial('//layouts/alert/_flash'); ?>

<div id="register_container">
    
    <?php $this->renderPartial('partial/_left_panel',
        array(
            'model' => $model,
            'items_model' => $items_model,
            'items' => $items,
            'from_outlet' => $from_outlet,
            'to_outlet' => $to_outlet
        )); ?>

    <?php $this->renderPartial('partial/_right_panel', 
    	array(
        	'model' => $model,
        	'items_model' => $items_model,
            'items' => $items,
            'from_outlet' => $from_outlet,
            'to_outlet' => $to_outlet
    	)); ?>

</div>