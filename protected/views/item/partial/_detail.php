	<?php $baseUrl = Yii::app()->theme->baseUrl?>
<div class="row">
	<div class="col-xs-12">
		<span class="text-info">- Brand: </span>
		<strong><?=$model[0]['brand'] ? $model[0]['brand'] : 'N/A' ?></strong><br>
		<span class="text-info">- Category: </span>
		<strong><?=$model[0]['category'] ? $model[0]['category'] : 'N/A'?></strong>
		<hr>
	</div>
	<div class="col-sm-12">
		<h4>
			<a href="<?=Yii::app()->createUrl('item/updateImage')?>/<?=$model[0]['id']?>">
				<?=$model[0]['name']?>
			</a>
		</h4>
	</div>
	<div class="col-sm-3">
		
		<div class="thumbnail search-thumbnail" style="height: 190px;">
			<span class="search-promotion label label-success arrowed-in arrowed-in-right"></span>

			<img class="media-object" src="<?=$baseUrl.'/images/noimage.gif'?>" />
			
		</div>
	</div>
	<div class="col-sm-7">
		<?=$model[0]['description']?>
	</div>
	<div class="col-sm-2">
		
		<div class="thumbnail search-thumbnail" style="height: 190px;">
			<span class="search-promotion label label-success arrowed-in arrowed-in-right"><?='$'.$model[0]['unit_price']?></span>
			<hr>
			<strong class="blue">- Qantity In Stock: <?=$model[0]['quantity']?></strong>
			<p></p>
			<strong class="blue">- Supplier: <?=$model[0]['company_name'] ? $model[0]['company_name'] : 'N/A'?></strong>
			<hr>
			<a href="<?=Yii::app()->createUrl('item/updateImage')?>/<?=$model[0]['id']?>" class="search-btn-action btn btn-sm btn-block btn-info">Edit</a>
			
		</div>
	</div>
</div>
<style type="text/css">
	.search-btn-action{
		left: 14px !important;
		width: 85% !important;
	}
</style>