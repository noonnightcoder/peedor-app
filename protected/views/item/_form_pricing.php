<div class="container">
	<div id="price-range">
		<div class="row form-inline">
			<div class="form-group col-sm-2">
				<?php echo $form->labelEx($price_quantity_range, 'from_quantity'); ?>
				<?php echo $form->textField($price_quantity_range,'from_quantity',array('class'=>'form-control','placeholder'=>'Required','id'=>'txt-from-qty0','onkeyUp'=>'getValue(0)')); ?>
			</div>
			<div class="form-group col-sm-2">
				<?php echo $form->labelEx($price_quantity_range, 'to_quantity'); ?>
				<?php echo $form->textField($price_quantity_range,'to_quantity',array('class'=>'form-control','placeholder'=>'Required','id'=>'txt-to-qty0','onkeyUp'=>'getValue(0)')); ?>
			</div>
			<div class="form-group col-sm-2">
				<?php echo $form->labelEx($price_quantity_range, 'price'); ?>
				<?php echo $form->textField($price_quantity_range,'price',array('class'=>'form-control','placeholder'=>'Required','id'=>'txt-price0','onkeyUp'=>'getValue(0)')); ?>
			</div>
			<div class="form-group col-sm-2">
				<?php echo $form->labelEx($price_quantity_range, 'start_date'); ?>
				<?php echo $form->dateField($price_quantity_range,'start_date',array('class'=>'form-control pull-right','placeholder'=>'Optional','id'=>'dt-start-date0','onChange'=>'getValue(0)')); ?>
			</div>
			<div class="form-group col-sm-2" style="margin-left:0px;">
				<?php echo $form->labelEx($price_quantity_range, 'end_date'); ?>
				<?php echo $form->dateField($price_quantity_range,'end_date',array('class'=>'form-control pull-right','placeholder'=>'Optional','id'=>'dt-end-date0','onChange'=>'getValue(0)')); ?>
			</div>
		</div>
	</div>
	<div class="form-group col-sm-10">
		<?php echo CHtml::Button('Add Range',array('class'=>'btn btn-primary pull-right','style'=>'margin-right:95px;margin-top:10px;','onClick'=>'addPriceRange()'))?>
	</div>
	
		<?php foreach($price_tiers as $i=>$price_tier): ?>
		    <div class="form-group">
		        <?php echo CHtml::label($price_tier["tier_name"] . ' Price' , $i, array('class'=>'col-sm-3 control-label no-padding-right')); ?>
		        <div class="col-sm-9">
		            <?php echo CHtml::TextField(get_class($model) . 'Price[' . $price_tier["tier_id"] . ']',$price_tier["price"]!==null ? round($price_tier["price"],Common::getDecimalPlace()) : $price_tier["price"],array('class'=>'span3 form-control')); ?>
		        </div>
		    </div>
		<?php endforeach; ?>
</div>
<script>
	var id=1;
	var price_range=[{arrID:'',from_quantity:'',to_quantity:'',price:0,start_date:'',end_date:''}];
	function addPriceRange(){
		$('#price-range').append('\
			<div class="row form-inline" id="range-'+id+'">\
			<hr style="width:90%; margin-left:0px;">\
			<div class="form-group col-sm-2">\
				<label form="txt-from-qty'+id+'">From Quantity*</label>\
				<input type="text" id="txt-from-qty'+id+'" class="form-control" placeholder="Required" onkeyUp="getValue('+id+')">\
			</div>\
			<div class="form-group col-sm-2">\
				<label form="txt-to-qty'+id+'">To Quantity*</label>\
				<input type="text" id="txt-to-qty'+id+'" class="form-control" placeholder="Required" onkeyUp="getValue('+id+')">\
			</div>\
			<div class="form-group col-sm-2">\
				<label form="txt-price'+id+'">Price*</label>\
				<input type="text" id="txt-price'+id+'" class="form-control" placeholder="Required" onkeyUp="getValue('+id+')">\
			</div>\
			<div class="form-group col-sm-2">\
				<label form="dt-start-date'+id+'">To Quantity*</label>\
				<input type="date" id="dt-start-date'+id+'" class="form-control" placeholder="Required" onChange="getValue('+id+')">\
			</div>\
			<div class="form-group col-sm-2" style="margin-left:0px;">\
				<label form="dt-end-date'+id+'">To Quantity*</label>\
				<input type="date" id="dt-end-date'+id+'" class="form-control" placeholder="Required" onChange="getValue('+id+')">\
			</div>\
			<div class="col-sm-2"><input type="button" value="Remove" class="btn btn-danger pull-right" style="margin-right:85px;margin-top:22px;" onClick="removePriceRange('+id+')"></div>\
		</div>\
			');
		price_range.push({arrID:id,from_quantity:'',to_quantity:'',price:0,start_date:'',end_date:''});
		console.log(price_range);
		id=id+1;
		
	}
	function removePriceRange(id){
		$('#range-'+id).html('');
	}
	function getValue(rid=''){
		price_range.forEach(function(v,i){
			if(price_range[i].arrID==rid){
				price_range[i].from_quantity=$('#txt-from-qty'+rid).val();
				price_range[i].to_quantity=$('#txt-to-qty'+rid).val();
				price_range[i].price=$('#txt-price'+rid).val();
				price_range[i].start_date=$('#dt-start-date'+rid).val();
				price_range[i].end_date=$('#dt-end-date'+rid).val();
			}
		});
		console.log(price_range)
	}
	function saveItem(){
		$.ajax({
			type:'post',
			url:'<?php echo Yii::app()->createUrl('item/saveItem')?>',
			data:{
				item_number:$('#txt-item-number').val(),
				name:$('#txt-item-name').val(),
				recorder_level:$('#txt-recorder-level').val(),
				location:$('#txt-location').val(),
				description:$('#txt-description').val(),
				data:price_range
			},
			beforeSend:function(data){
				console.log(data)
			},
			success:function(data){
				console.log(data)
			}
		})
	}
</script>

 

