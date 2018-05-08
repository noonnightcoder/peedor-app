<?php
$this->breadcrumbs=array(
	'Categories'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Category','url'=>array('index')),
	array('label'=>'Manage Category','url'=>array('admin')),
);
?>

<h1>Create Category</h1>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'category-form',
	'enableAjaxValidation'=>false,
        'layout'=>TbHtml::FORM_LAYOUT_HORIZONTAL,
)); ?>

        <p class="help-block"><?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?></p>

	<?php echo $form->errorSummary($model); ?>
	<div class="container">
		<div class="col-sm-11 col-md-11">
	        <div class="form-group">
	            <?php echo CHtml::label('Category Name', 1, array('class' => 'control-label')); ?>
	            <?php echo CHtml::TextField('Category','',array('class'=>'form-control','id'=>'Category_Name')); ?>
	        </div>
	    </div>
	    <div class="col-sm-11 col-md-11">
	        <div class="form-group">
	            <?php echo CHtml::label('Parent', 1, array('class' => 'control-label')); ?>
	            <select class="form-control" id="db-category" onchange="showDialog(event.target.value)">
	            	<option value="0">--Choose Parent--</option>
	            	<?php foreach($parent as $key=>$value):?>
	            		<option value="<?=$value['id']?>"><?=$value['name']?></option>
	            	<?php endforeach;?>
	            	<optgroup >
	            		<option value="addnew">
	            			Create New
	            		</option>
	            	</optgroup >
	            </select>
	        </div>
	    </div>
	</div>

	<?php //echo $form->textFieldRow($model,'created_date',array('class'=>'span5')); ?>

	<?php //echo $form->textFieldRow($model,'modified_date',array('class'=>'span5')); ?>

	<div class="form-actions">
            <?php echo CHtml::Button($model->isNewRecord ? Yii::t('app','Create') : Yii::t('app','Save'),array(
                'color'=>TbHtml::BUTTON_COLOR_PRIMARY,
                'onclick'=>'saveCategory("")',
                'class'=>'btn btn-primary'
                //'size'=>TbHtml::BUTTON_SIZE_SMALL,
            )); ?>
	</div>
<!-- Modal -->
<div id="modal-container"></div>
<?php $this->endWidget(); ?>
<script type="text/javascript">
	$(document).ready(function(e){
		
	})
	var i=0
	var t='addnew'
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
				        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>\
				        <button type="button" class="btn btn-primary" onclick="saveCategory('+i+')">Save changes</button>\
				      </div>\
				    </div>\
				  </div>\
				</div>'
			);

			$('#myModal'+i).modal('show')
			$('#myModal'+i).on('hidden.bs.modal', function () {
			  	$("#db-category"+i).val(0);
			  	reloadCategory(i);
			})
			$('#myModal0').on('hidden.bs.modal', function () {
			  	i=0;
			  	$("#db-category").val(0);
			  	reloadCategory(i);
			})
			$('#myModal'+i).on('shown.bs.modal', function () {
			  	$("#db-category"+i).val(0);
			  	reloadCategory(i);
			})
			$('#myModal0').on('shown.bs.modal', function () {
			  	$("#db-category0").val(0);
			})
			
			i=i+1;
		}
	}

	function saveCategory(i){
		var category_name=$('#myModal'+i+' .modal-body #Category_Name').val() || $('#Category_Name'+i).val();
		var parent_id=$('#db-category'+i).val();
		//alert(category_name+'-'+parent_id);
		if(i==''){
			i=100000
		}
		$.ajax({
			type:'post',
			data:{id:i,category_name:category_name,parent_id:parent_id},
			url:'SaveCategory',
			beforeSend:function(){
				$('#myModal'+i+' .modal-body').html('saving...')
			},
			success:function(data){
				$('#myModal'+i+' .modal-body').html(data)
				if(i==100000){
					window.location.href='/peedor-app/index.php/category/list'
				}
			}
		})
	}
	function reloadCategory(i){

		$.ajax({
			type:'post',
			data:{id:i},
			url:'ReloadCategory',
			beforeSend:function(){
				$('.parents').html('loading...')
			},
			success:function(data){
				$('#myModal'+(i-1)+' .modal-body #db-category'+(i-1)).html(data)
				$("#db-category").html(data)
				$("#db-category"+(i-2)).html(data)
			}
		})
	}
</script>