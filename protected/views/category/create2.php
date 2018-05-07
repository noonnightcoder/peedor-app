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
	            <?php echo CHtml::TextField('Category','',array('class'=>'form-control','id'=>'Category')); ?>
	        </div>
	    </div>
	    <div class="col-sm-11 col-md-11">
	        <div class="form-group">
	            <?php echo CHtml::label('Parent', 1, array('class' => 'control-label')); ?>
	            <select class="form-control" id="db-category" onchange="showDialog(event.target.value)">
	            	<option value="0">--Choose Parent--</option>
	            	<?php foreach($parent as $key=>$value):?>
	            		<option value="<?=$value['name']?>"><?=$value['name']?></option>
	            	<?php endforeach;?>
	            	<optgroup >
	            		<option value="addnew0">
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
            <?php echo TbHtml::submitButton($model->isNewRecord ? Yii::t('app','Create') : Yii::t('app','Save'),array(
                'color'=>TbHtml::BUTTON_COLOR_PRIMARY,
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
		

		alert(val);
		if(val==t+i){
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
						            <?php echo CHtml::TextField('Category','',array('class'=>'form-control','id'=>'Category')); ?>\
						        </div>\
						    </div>\
						    <div class="col-sm-11 col-md-11">\
						        <div class="form-group">\
						            <?php echo CHtml::label('Parent', 1, array('class' => 'control-label')); ?>\
						            <select class="form-control" id="db-category" onchange="showDialog(event.target.value)">\
						            	<option value="0">--Choose Parent--</option>\
						            	<?php foreach($parent as $key=>$value):?>\
						            		<option value="<?=$value['name']?>"><?=$value['name']?></option>\
						            	<?php endforeach;?>\
						            	<optgroup >\
						            		<option value="addnew'+(i+1)+'">\
						            			Create New\
						            		</option>\
						            	</optgroup>\
						            </select>\
						        </div>\
						    </div>\
				      </div>\
				      <div class="modal-footer">\
				        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>\
				        <button type="button" class="btn btn-primary">Save changes</button>\
				      </div>\
				    </div>\
				  </div>\
				</div>'
			);

			$('#myModal'+i).modal('show')
			$('#myModal'+i).on('hidden.bs.modal', function () {
			  	$("#db-category").val(0);
			})
			i=i+1;
		}
	}
</script>