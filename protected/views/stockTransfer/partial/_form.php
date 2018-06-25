<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
    'action'=>Yii::app()->createUrl('stockTransfer/setReferenceName'),
    'method'=>'post',
    'htmlOptions'=>array('class'=>'line_item_form','id'=>'reference_name_form'),
    'layout'=>TbHtml::FORM_LAYOUT_HORIZONTAL,
)); ?>
<?php $referenceName = Yii::app()->shoppingCart->getTransferHeader('reference_name');?>
 <div class="col-sm-12">
    <div class="col-sm-12 form-group">
    	<?= $form->labelEx($model,'name') ?>
        <?= $form->textField($model,'name',array('size'=>60,'maxlength'=>500,'class'=>'span10','value'=>$referenceName)); ?>
        <?php echo $form->error($model,'name'); ?>
    </div>
<?php $this->endWidget()?>
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
    'action'=>Yii::app()->createUrl('stockTransfer/setOutlet'),
    'id' => 'set-outlet-form',
    'method'=>'post',
    'layout'=>TbHtml::FORM_LAYOUT_HORIZONTAL,
)); ?>
    
    
	<div class="col-sm-12 form-group">
	    <?php echo $form->labelEx($model,'from_outlet'); ?>
	    <?php echo $form->dropDownList($model,'from_outlet', CHtml::listData(Outlet::model()->findAll(), 'id', 'outlet_name'),array('empty'=>'Select Source',
            'id'=>'from_outlet','options' => array($from_outlet=>array('selected'=>'selected')))); ?>
	    <?php echo $form->error($model,'from_outlet'); ?>
	</div>
	<div class="col-sm-12 form-group">
	    <?php echo $form->labelEx($model,'to_outlet'); ?>
	    <?php echo $form->dropDownList($model,'to_outlet', 
            CHtml::listData(Outlet::model()->findAll(), 'id', 'outlet_name'),
            array('empty'=>'Select Destination',
                'id'=>'to_outlet','options' => array($to_outlet=>array('selected'=>'selected'))
            )
        ); ?>
	    <?php echo $form->error($model,'to_outlet'); ?>
	</div>
</div>

<?php $this->endWidget()?>