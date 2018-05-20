<?php $baseUrl = Yii::app()->baseUrl;?>
<script type="text/javascript">
	var i=0
	var tags=[]
	var tagsItem=$('#item-tags').val();
	tags=tagsItem.split(',');
	$(document).ready(function(e){

		var unitprice=$('#Item_unit_price').val();
		var costprice=$('#Item_cost_price').val();
		var markup=$('#Item_markup').val();
		markup=((unitprice*100)/costprice)-100 || 0;
		$('#Item_markup').val(markup);

		$('#Item_markup').on('keyup',function(){
			var unitprice=$('#Item_unit_price').val();
			var costprice=$('#Item_cost_price').val();
			var markup=$('#Item_markup').val();
			unitprice=parseInt(costprice)+(parseInt(costprice)*(parseInt(markup)/100));
			$('#Item_unit_price').val(unitprice);
		})
		$('#Item_unit_price').on('keyup',function(){
			var unitprice=$('#Item_unit_price').val();
			var costprice=$('#Item_cost_price').val();
			var markup=$('#Item_markup').val();
			markup=((unitprice*100)/costprice)-100;
			$('#Item_markup').val(markup);
		})
		$('#Item_cost_price').on('keyup',function(){
			var unitprice=$('#Item_unit_price').val();
			var costprice=$('#Item_cost_price').val();
			var markup=$('#Item_markup').val();
			unitprice=parseInt(costprice)+(parseInt(costprice)*(parseInt(markup)/100));
			$('#Item_unit_price').val(unitprice);
		})
		$('.tag-box').on('keydown',function(e){
			var char = event.which || event.keyCode;
			
			if(char==188 || char==13 || char==9){
				var tagslen=$(this).val();
				if(tagslen.length>0){
					tags.push($(this).val());
					$(this).val('');
					console.log(tags);
					$('#item-tags').val(tags);
					$('.tag-item-box').html('');
					addTagsItem()
				}
				return false;
			}
			
		})
	})
	addTagsItem()
	function addTagsItem(){
		if(tags.length>0){
			tags.forEach(function(v,i){
				if(v!==''){
					$('.tag-item-box').append('<span class="tag-item '+i+'">'+v+' <b style="cursor:pointer" onclick="removeTagsItem('+i+')">&times;<b></span>');	
				}
				
			})	
		}
	}
	function removeTagsItem(i){
		tags.splice(i,1);
		$('.'+i).html('');
		$('.'+i).css('display','none');
	}
	function showBrandDialog(val){
		if(val=='addnew'){
			$('#brandModal').modal('show');
			$('#brandModal').on('hidden.bs.modal',function(){
				$('#db-supplier').val(0);

			})
		}
	}

	function saveBrand(){
		var name=$('#Brand_Name').val();
		var url="<?php echo Yii::app()->createUrl('Brand/SaveBrand')?>"
		ajaxSaveData(url,{name},name,$('#brandModal'),$('#db-brand'))
		
	}
	function showSupplierDialog(val){
		if(val=='addnew'){
			$('#supplierModal').modal('show');
			$('#supplierModal').on('hidden.bs.modal',function(){
				$('#db-supplier').val(0);

			})
		}
	}

	function saveSupplier(){
		var company_name=$('#Supplier_Name').val();
		var first_name=$('#Supplier_First_Name').val();
		var last_name=$('#Supplier_Last_Name').val();
		var url="<?php echo Yii::app()->createUrl('Supplier/SaveSupplier')?>"
		ajaxSaveData(url,{company_name,first_name,last_name},company_name,$('#supplierModal'),$('#db-supplier'))
		
	}
	function showMeasurableDialog(val){
		if(val=='addnew'){
			$('#measurableModal').modal('show');
			$('#measurableModal').on('hidden.bs.modal',function(){
				$('#db-measurable').val(0);

			})
		}
	}
	function saveMeasurable(){
		var measurable_name=$('#Measurable_Name').val();
		var url="<?php echo Yii::app()->createUrl('unitMeasurable/SaveMeasurable')?>"
		ajaxSaveData(url,{measurable_name},measurable_name,$('#measurableModal'),$('#db-measurable'))
		
	}


	function ajaxSaveData(url,data,field,modal,dblist){
		if(i===''){
			i=100000
		}
		$.ajax({
			type:'post',
			data:data,
			url:url,
			beforeSend:function(){
				$('.errorMsg').html('Processing...')
			},
			success:function(data){
				if(data=='error'){
					$('.errorMsg').html('Unit Measurable name is required');
					$('#success').html('');
				}else if(data=='existed'){
					$('.errorMsg').html('Name "'+field+'" has already been taken.');
					$('#success').html('');
				}else if(data.indexOf('success')>=0){
					$('.errorMsg').html('');
					modal.hide();
					$('body').removeClass('modal-open');
					dblist.html(data);
				}
			}
		})
	}

	function showCategoryDialog(val){
		if(val=='addnew'){
			$('#modal-container').append('\
				<div class="modal fade" id="myModal'+i+'" tabindex="-1" data-backdrop="false" role="dialog" aria-labelledby="myModalLabel">\
				  <div class="modal-dialog" role="document">\
				    <div class="modal-content">\
				      <div class="modal-header">\
				        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>\
				        <h4 class="modal-title" id="myModalLabel">Create Category</h4>\
				      </div>\
				      <div class="modal-body">\
							<div class="col-sm-11 col-md-11">\
								<hr>\
						        <div class="form-group">\
						            <?php echo CHtml::label('Category Name', 1, array('class' => 'control-label')); ?>\
						            <?php echo CHtml::TextField('Category','',array('class'=>'form-control','id'=>'Category_Name')); ?>\
						            <span id="error" class="errorMsg'+i+'"></span>\
						        </div>\
						    </div>\
						    <div class="col-sm-11 col-md-11">\
						        <div class="form-group">\
						            <?php echo CHtml::label('Parent', 1, array('class' => 'control-label')); ?>\
						            <select class="form-control" id="db-category'+i+'" class="parents" onchange="showCategoryDialog(event.target.value)">\
						            	<option value="0" selected>--Choose Parent--</option>\
						            	<?php foreach($categories as $key=>$value):?>\
						            		<option value="<?=$value['id']?>"><?=$value['name']?></option>\
						            	<?php endforeach;?>\
						            	<optgroup >\
						            		<option value="addnew">\
						            			Create New\
						            		</option>\
						            	</optgroup>\
						            </select>\
						        </div>\
						    </div>\
				      </div>\
				      <div class="modal-footer">\
				      <input type="hidden" values="" id="pid">\
				        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>\
				        <button type="button" class="btn btn-primary" onclick="saveCategory('+i+')">Save changes</button>\
				      </div>\
				    </div>\
				  </div>\
				</div>'
			);
			$('#myModal'+i).modal('show')
			$('#myModal0').on('hidden.bs.modal',function(){
				$("#db-category").val(0);
				$('body').removeClass('modal-open');
			})
			
			$('#myModal'+i).on('shown.bs.modal', function () {
			  	$("#db-category"+i).val(0);
			})
			$('#myModal0').on('shown.bs.modal', function () {
			  	$("#db-category0").val(0);
			})
			i=i+1;
		}
	}
	function saveCategory(i,cateid){
		//alert(i);
		var category_name=$('#myModal'+i+' .modal-body #Category_Name').val() || $('#Category_Name'+i).val();
		var parent_id=$('#db-category'+i).val();
		var url="<?php echo Yii::app()->createUrl('Item/SaveCategory')?>"
		if(i===''){
			i=100000
		}
		$.ajax({
			type:'post',
			data:{id:i,category_name:category_name,parent_id:parent_id},
			url:url,
			beforeSend:function(){
				$('.errorMsg'+i).html('Processing...')
			},
			success:function(data){
				if(data=='error'){
					$('.errorMsg'+i).html('Category name is required');
					$('#success').html('');
				}else if(data=='existed'){
					$('.errorMsg'+i).html('Name "'+category_name+'" has already been taken.');
					$('#success').html('');
				}else if(data.indexOf('success')>=0){
					$('#myModal'+i+' .modal-body').html(data)
					$('#myModal'+i).hide()//hide modal
					$('body').removeClass('modal-open');
					reloadCategory(i);
				}
			}
		})
	}
	function reloadCategory(i){
		//alert(i)
		var pid=$('#pid'+i).val();
		$.ajax({
			type:'post',
			data:{id:i},
			url:"<?php echo Yii::app()->createUrl('Item/ReloadCategory')?>/"+pid,
			beforeSend:function(){
				$('.parents').html('loading...')
			},
			success:function(data){
				$('#myModal'+(i-1)+' .modal-body #db-category'+(i-1)).html(data)
				//if(i==0){
					$("#db-category").html(data)	
				//}else{
					$("#db-category"+(i-2)).html(data)	
				//}
			}
		})
	}

</script>
<style type="text/css">
	#error{
		color:#f00;
	}
	#success{
		color:#00f;
	}

</style>