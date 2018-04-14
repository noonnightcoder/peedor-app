<?php
$this->breadcrumbs=array(
    sysMenuAssembliesView() =>array('assemblies'),
    'Create',
);
?>
<div class="container">
	<div class="col-sm-12">
		<?php $this->renderPartial('//layouts/partial/_flash_message'); ?>
		<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
			'id'=>'assembly-form',
			'enableAjaxValidation'=>false,
		)); ?>
			<?php $this->renderPartial('//layouts/partial/_flash_message'); ?>
		<div class="col-xs-12 col-sm-10 widget-container-col">
			<?php $box = $this->beginWidget('yiiwheels.widgets.box.WhBox',array(
			        'title'         =>  Yii::t('app','Search Product'),
			        'headerIcon'    => 'ace-icon fa fa-chain',
			        'htmlHeaderOptions'=>array('class'=>'widget-header-flat widget-header-small')
			));?>	
			
	        <div class="col-sm-12">
	        	<div class="form-group">
		            <?php
			            $this->widget('yiiwheels.widgets.select2.WhSelect2', array(
			                'asDropDownList' => false,
			                'model'=> $model,
			                'attribute'=>'item_id',
			                'pluginOptions' => array(
			                    'placeholder' => Yii::t('app','Select Product You want to add its assembly'),
			                    'multiple'=>false,
			                    'onchange'=>'enableBtn()',
			                    'width' => '100%',
			                    //'tokenSeparators' => array(',', ' '),
			                    'allowClear'=>true,
			                    //'minimumInputLength'=>1,
			                    'ajax' => array(
			                        'url' => Yii::app()->createUrl('item/getProduct2/'),
			                        'dataType' => 'json',
			                        'cache'=>true,
			                        'data' => 'js:function(term,page) {
			                                                return {
			                                                    term: term,
			                                                    page_limit: 10,
			                                                    quietMillis: 100,
			                                                    apikey: "e5mnmyr86jzb9dhae3ksgd73"
			                                                };
			                                            }',
			                        'results' => 'js:function(data,page){
			                                        return { results: data.results };

			                                     }',
			                    ),
			                    'formatResult' => 'js:function(term) {
			                                    if (term.isNew) {
			                                        return "<span class=\"label label-important\">New</span> " + term.text;
			                                    }
			                                    else {
			                                        return term.text;

			                                    }
			                                }',
			                )));
			            ?>
	        	</div>
	        </div>
			<?php $this->endWidget()?>
		</div>
		<div class="col-xs-12 col-sm-12">
		    <div id="assembly-item">
				<?php $id=0; foreach($assembly_item as $k=>$item):?>
					<div class="item-<?php echo $item['id'] ?>">
					<div class="row">
						<hr style="width:90%; margin-left:0px;">
					    <div class="col-sm-5">
			                <div class="form-group">
			                	<?php echo CHtml::label('Assembly Name', $k, array('class' => 'control-label')); ?>
			                    <?php echo CHtml::TextField('assembly_item[item'.$item["id"].'][assembly_name]', $item["to_quantity"] !== null ? round($item["to_quantity"], Yii::app()->shoppingCart->getDecimalPlace()) : $item["price"], array('class'=>'form-control txt-from-qty0','onkeyUp'=>'getValue(0)')); ?>
			                </div>
			            </div>
			            <div class="col-sm-2">
			                <div class="form-group">
			                	<?php echo CHtml::label('Quantity', $k, array('class' => 'control-label')); ?>
			                    <?php echo CHtml::NumberField('price_quantity[price_qty'.$item["id"].'][to_quantity]', $item["to_quantity"] !== null ? round($item["to_quantity"], Yii::app()->shoppingCart->getDecimalPlace()) : $item["to_quantity"], array('class'=>'form-control txt-from-qty0','onkeyUp'=>'getValue(0)')); ?>
			                </div>
			            </div>
			            <div class="col-sm-2">
			                <div class="form-group">
			                	<?php echo CHtml::label('Unit Price', $k, array('class' => 'control-label')); ?>
			                    <?php echo CHtml::NumberField('price_quantity[price_qty'.$item["id"].'][unit_price]', $item["unit_price"] !== null ? round($item["unit_price"], Yii::app()->shoppingCart->getDecimalPlace()) : $item["price"], array('step'=>'0.01','class'=>'form-control txt-from-qty0','onkeyUp'=>'getValue(0)')); ?>
			                </div>
			            </div>
			            <div class="col-sm-2"><input type="button" value="X" class="btn btn-danger" onClick="removeAssembly('<?php echo $item["id"]?>')" style="margin-top: 23px;"></div>
			        </div>
			        </div>
				<?php $id=$item["id"]; endforeach;?>
			</div>
			<div class="form-group col-sm-10">
				<?php echo CHtml::Button('Add Assembly',array('class'=>'btn btn-primary pull-right','onClick'=>'addAssembly('.$id.')'))?>
				<?= TbHtml::submitButton($model->isNewRecord ? Yii::t('app','Create') : Yii::t('app','Save'),array(
				    'color'=>TbHtml::BUTTON_COLOR_PRIMARY,'class'=>'btn btn-primary pull-right'
				    //'size'=>TbHtml::BUTTON_SIZE_SMALL,
				));?>
		        
		    </div>
		</div>
    <?php $this->endWidget()?>
	</div>
</div>
<?php $this->renderPartial('partialList/_js'); ?>
