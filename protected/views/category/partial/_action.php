<?php $baseUrl = Yii::app()->baseUrl;?>
<script type="text/javascript">
	var i=0
	function showDialog(val){
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
						            <select class="form-control" id="db-category'+i+'" class="parents" onchange="showDialog(event.target.value)">\
						            	<option value="0" selected>--Choose Parent--</option>\
						            	<?php foreach($parent as $key=>$value):?>\
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
		var url=''
		if(cateid>0){
			url="<?php echo Yii::app()->createUrl('Category/Update2/')?>"+cateid
		}else{
			url="<?php echo Yii::app()->createUrl('Category/SaveCategory')?>"
		}
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
					reloadCategory(i);
					if(i==100000){
						if(cateid>0){
							$('.errorMsg'+i).html('<span style="color:#00f;">Update successfully</span>');
						}else{
							window.location.href="<?php echo $baseUrl.'/index.php/Category/Admin'?>"	
						}
					}
				}
			}
		})
	}
	function reloadCategory(i){
		//alert(i)
		// var pid=$('#pid'+i).val();
		var pid=1;
		$.ajax({
			type:'post',
			data:{id:i},
			url:"<?php echo Yii::app()->createUrl('Category/ReloadCategory')?>/"+pid,
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