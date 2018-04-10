<?php
$this->breadcrumbs=array(
    sysMenuItem() =>array('admin'),
    'Create',
);
?>
<div class="container">
	<?php $this->renderPartial('//layouts/partial/_flash_message'); ?>
	<div class="col-xs-12 col-sm-10 widget-container-col">
		<?php $box = $this->beginWidget('yiiwheels.widgets.box.WhBox',array(
		        'title'         =>  Yii::t('app','Search Product'),
		        'headerIcon'    => 'ace-icon fa fa-chain',
		        'htmlHeaderOptions'=>array('class'=>'widget-header-flat widget-header-small'),
		        'headerButtons' => array(
		            TbHtml::buttonGroup(
		                array(
		                    array('label' => Yii::t('app','Search'),'url' => Yii::app()->createUrl('Item/search',array('grid_cart'=>'R')),'icon'=>'fa fa-search white'),
		                ),array('color'=>TbHtml::BUTTON_COLOR_SUCCESS,'size'=>TbHtml::BUTTON_SIZE_SMALL)
		            ),
		        )
		));?>	
		<div class="col-sm-12">
			<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
				'id'=>'sale-form',
				'enableAjaxValidation'=>false,
			        'layout'=>TbHtml::FORM_LAYOUT_HORIZONTAL,
			)); ?>
			<div class="row">
		        <div class="col-sm-12">
		        	<div class="form-group">
			            <?php echo CHtml::TextField('Price[tier_id]', 'Product', array('class' => 'form-control')); ?>
		        	</div>
		        </div>
			</div>
			<?php $this->endWidget()?>
		</div>
		<?php $this->endWidget()?>
	</div>
    <div id="price-range">
		<?php $id=0; foreach($item_price_quantity as $k=>$item_price):?>
			<div class="range-<?php echo $item_price['id'] ?>">
			<div class="row">
				<hr style="width:90%; margin-left:0px;">
			    <div class="col-sm-6">
	                <div class="form-group">
	                	<?php echo CHtml::label('Assembly Name', $k, array('class' => 'control-label')); ?>
	                    <?php echo CHtml::TextField('price_quantity[price_qty'.$item_price["id"].'][from_quantity]', 'Assembly Name', array('class'=>'form-control txt-from-qty0','onkeyUp'=>'getValue(0)')); ?>
	                </div>
	            </div>
	            <div class="col-sm-2">
	                <div class="form-group">
	                	<?php echo CHtml::label('Quantity', $k, array('class' => 'control-label')); ?>
	                    <?php echo CHtml::TextField('price_quantity[price_qty'.$item_price["id"].'][to_quantity]', $item_price["to_quantity"] !== null ? round($item_price["to_quantity"], Yii::app()->shoppingCart->getDecimalPlace()) : $item_price["to_quantity"], array('class'=>'form-control txt-from-qty0','onkeyUp'=>'getValue(0)')); ?>
	                </div>
	            </div>
	            <div class="col-sm-2">
	                <div class="form-group">
	                	<?php echo CHtml::label('Unit Price', $k, array('class' => 'control-label')); ?>
	                    <?php echo CHtml::TextField('price_quantity[price_qty'.$item_price["id"].'][unit_price]', $item_price["unit_price"] !== null ? round($item_price["unit_price"], Yii::app()->shoppingCart->getDecimalPlace()) : $item_price["price"], array('class'=>'form-control txt-from-qty0','onkeyUp'=>'getValue(0)')); ?>
	                </div>
	            </div>
	        </div>
	        </div>
		<?php $id=$item_price["id"]; endforeach;?>
	</div>
	<div class="form-group col-sm-10">
        <?php echo CHtml::Button('Add Range',array('class'=>'btn btn-primary pull-right','onClick'=>'addPriceRange('.$id.')'))?>
    </div>
</div>
<?php $this->renderPartial('partialList/_js'); ?>
