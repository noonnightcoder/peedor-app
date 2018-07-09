<div class="row">
	<div class="col-xs-12">
		<span class="text-info">- Brand: </span>
		<strong><?=$model[0]['brand'] ? $model[0]['brand'] : 'N/A' ?></strong><br>
		<span class="text-info">- Category: </span>
		<strong><?=$model[0]['category'] ? $model[0]['category'] : 'N/A'?></strong>
		<hr>
	</div>
</div>
<div class="row">
	<div class="col-sm-12 col-sm-12">
		<strong>Item Description</strong>
		<?=$model[0]['description']?>
		<hr/>
	</div>
</div>
<div class="row">
	<div class="col-sm-4">
		
		<div class="thumbnail search-thumbnail" id="big-image">
			<img class="media-object" src="<?=$model[0]['image'] ? Yii::app()->baseUrl .'/ximages/'.strtolower(get_class($item)).'/'.$model[0]['id'].'/'.$model[0]['image'] : Yii::app()->baseUrl.'/images/noimage.gif'?>" />
		</div>

		<div class="row">
			<?php if(!empty($item_image)):?>
				<?php foreach($item_image as $image):?>
					<div class="col-sm-4">
						<div class="thumbnail search-thumbnail">
							<img class="media-object" style="" onclick="changeImage(event.target.src)" src="<?= Yii::app()->baseUrl .'/ximages/'.strtolower(get_class($item)).'/'.$model[0]['id'].'/'.$image['filename']?>" />
						</div>
					</div>
				<?php endforeach;?>
			<?php endif;?>
		</div>
	</div>
	<div class="col-sm-8">
		<h4>
			<strong class="text-primary">
				<a href="<?= Yii::app()->createUrl('item/updateImage')?>/<?=$model[0]['id']?> ">
					<?=ucfirst($model[0]['name'])?>
				</a>
			</strong>
		</h4>
		<h3 style="color:red">
			$ <?=round($model[0]['unit_price'],2)?>
		</h3>
		<hr>
		<?php foreach($model as $item):?>
			<div class="col-sm-3">
				<div class="panel <?=$item['quantity'] < 0 ? 'panel-danger' : ($item['quantity'] < 20 ? 'panel-warning' : 'panel-info')?>">
					<div class="panel-heading">
						<b><?=ucfirst($item['outlet_name'])?></b>
					</div>
					<div class="panel-body">
						<span>
							<b class="text-primary"><?=round($item['quantity'])?></b> <?php echo $item['quantity'] < 0 ? '<span style="color:red;">Minus Quantity</span>' : ($item['quantity'] > 1 ? 'Items Available' : 'Item Available');?> 
						</span>
					</div>
				</div>
			</div>
		<?php endforeach;?>
	</div>
</div>

<div class="row">
	<div class="col-sm-12">

		<div class="panel panel-default">
			<div class="panel-heading">
				<b>Inventory History</b>
			</div>
			<div class="panel-body">
				<?php $this->widget('yiiwheels.widgets.grid.WhGridView', array(
				    'id' => 'inventory_history',
				    'fixedHeader' => true,
				    'type' => TbHtml::GRID_TYPE_BORDERED,
				    'dataProvider' => $data_provider,
				    'columns' => $grid_columns,
				    'enablePagination' => true
				));?>
			</div>
		</div>
	</div>
</div>

<style type="text/css">
	.search-btn-action{
		left: 14px !important;
		width: 85% !important;
	}
</style>
<script type="text/javascript">
	function changeImage(image){
		//var image=$('#image'+id).val();
		$('#big-image').html('<img class="media-object" src="'+image+'">')
	}
</script>