

<?php foreach($outlet_model as $outlet):?>

	<?php 

		$item_id = isset($_GET['id']) ? $_GET['id'] : '';

		$item_outlet_info = ItemOutlet::model()->findByAttributes(array('item_id'=>$item_id,'outlet_id'=>$outlet['id']));

		$quantity = isset($item_outlet_info) ? $item_outlet_info->quantity : 0;
		$reorder_point = isset($item_outlet_info) ? $item_outlet_info->reorder_point : 0;
		$reorder_amount = isset($item_outlet_info) ? $item_outlet_info->reorder_amount : 0;

	?>
	<h4 class="header blue">
	    <i class="fa fa-university  blue"></i><?= Yii::t('app', ' '.$outlet['outlet_name']) ?>
	</h4>
	<div class="row">
		
		<div class="col-sm-4">
            <div class="form-group">
            	<label class="col-sm-3 control-label">
            		Quantity
            	</label>
            	<div class="col-sm-9">
            		<input class="span3 form-control" name="Item[Outlet][<?=$outlet['id']?>][quantity]" value="<?=$quantity?>"  type="text">
            	</div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
            	<label class="col-sm-3 control-label">
            		Reorder Point
            	</label>
            	<div class="col-sm-9">
            		<input class="span3 form-control" name="Item[Outlet][<?=$outlet['id']?>][reorder_point]" value="<?=$reorder_point?>"  type="text">
            	</div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
            	<label class="col-sm-3 control-label">
            		Reorder Amount
            	</label>
            	<div class="col-sm-9">
            		<input class="span3 form-control" name="Item[Outlet][<?=$outlet['id']?>][reorder_amount]" value="<?=$reorder_amount?>" type="text">
            	</div>
            </div>
        </div>
	</div>
<?php endforeach;?>