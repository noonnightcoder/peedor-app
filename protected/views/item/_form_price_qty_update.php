<div class="container">
    <div id="price-range">
		<?php foreach($item_price_quantity as $k=>$item_price):?>
			<div class="range-<?php echo $item_price['id'] ?>">
			<div class="row">
				<hr style="width:90%; margin-left:0px;">
			    <div class="col-sm-2">
	                <div class="form-group col-sm-12">
	                    <?php echo CHtml::TextField('price_quantity[price_qty'.$item_price["id"].'][from_quantity]', $item_price["from_quantity"] !== null ? round($item_price["from_quantity"], Yii::app()->shoppingCart->getDecimalPlace()) : $item_price["from_quantity"], array('class'=>'form-control txt-from-qty0','placeholder'=>'From','title'=>'From Quantity','onkeyUp'=>'getValue(0)')); ?>
	                </div>
	            </div>
	            <div class="col-sm-2">
	                <div class="form-group col-sm-12">
	                    <?php echo CHtml::TextField('price_quantity[price_qty'.$item_price["id"].'][to_quantity]', $item_price["to_quantity"] !== null ? round($item_price["to_quantity"], Yii::app()->shoppingCart->getDecimalPlace()) : $item_price["to_quantity"], array('class'=>'form-control txt-from-qty0','placeholder'=>'To','title'=>'To Quantity','onkeyUp'=>'getValue(0)')); ?>
	                </div>
	            </div>
	            <div class="col-sm-2">
	                <div class="form-group col-sm-12">
	                    <?php echo CHtml::TextField('price_quantity[price_qty'.$item_price["id"].'][unit_price]', $item_price["unit_price"] !== null ? round($item_price["unit_price"], Yii::app()->shoppingCart->getDecimalPlace()) : $item_price["price"], array('class'=>'form-control txt-from-qty0','placeholder'=>'Unit Price','title'=>'Unit Price','onkeyUp'=>'getValue(0)')); ?>
	                </div>
	            </div>
	            <div class="col-sm-2">
	                <div class="form-group col-sm-12">
	                    <?php echo CHtml::TextField('price_quantity[price_qty'.$item_price["id"].'][start_date]', $item_price["start_date"] !== null ? $item_price["start_date"] : $item_price["start_date"], array('class'=>'form-control dt-start-date'.$item_price["id"],'placeholder'=>'yyyy/mm/dd','title'=>'Start Date','onkeyUp'=>'getValue(0)')); ?>
	                </div>
	            </div>
	            <div class="col-sm-2">
	                <div class="form-group col-sm-12">
	                    <?php echo CHtml::TextField('price_quantity[price_qty'.$item_price["id"].'][end_date]', $item_price["end_date"] !== null ? $item_price["end_date"] : $item_price["end_date"], array('class'=>'form-control dt-end-date'.$item_price["id"],'placeholder'=>'yyyy/mm/dd','title'=>'End Date','onkeyUp'=>'getValue(0)')); ?>
	                </div>
	            </div>
	            <div class="col-sm-2"><input type="button" value="X" class="btn btn-danger" onClick="removePriceRange(<?php echo $item_price['id'] ?>)"></div>
	        </div>
	        </div>
		<?php endforeach;?>
	</div>
	<div class="form-group col-sm-10">
        <?php echo CHtml::Button('Add Range',array('class'=>'btn btn-primary pull-right','onClick'=>'addPriceRange('.$item_price["id"].')'))?>
    </div>
</div>
<?php $this->renderPartial('partialList/_js'); ?>