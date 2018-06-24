<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
    'action'=>Yii::app()->createUrl('stockTransfer/itemTransfer'),
    'id' => 'stockTransfer-form',
    'method'=>'post',
    'enableAjaxValidation'=>true,
    'enableClientValidation'=>true,
    'clientOptions' => array(
        'validateOnChange'=>true,
        'validateOnType'=>true,
    ),
    'layout'=>TbHtml::FORM_LAYOUT_HORIZONTAL,
)); ?>
 <div class="col-sm-12">
    <div class="col-sm-12 form-group">
    	<?= $form->labelEx($model,'name') ?>
        <?= $form->textField($model,'name',array('size'=>60,'maxlength'=>500,'class'=>'span10')); ?>
        <?php echo $form->error($model,'name'); ?>
    </div>

    <div class="col-sm-12 form-group">
        <?= $form->labelEx($model,'delivery_due_date')?>
        <?php $this->widget('yiiwheels.widgets.datepicker.WhDatePicker', array(
            'attribute' => 'delivery_due_date',
            'model' => $model,
            'pluginOptions' => array(
                'format' => 'yyyy-mm-dd'
            ),
            'htmlOptions' => array(
                // 'placeholder'=>'Delivery Due Date',
                'class' => 'form-control',
                'value'=>date('Y-m-d')
            )
        ));
        ?>
        <?php echo $form->error($model,'delivery_due_date'); ?>
    </div>

	<div class="col-sm-12 form-group">
	    <?php echo $form->labelEx($model,'from_outlet'); ?>
	    <?php echo $form->dropDownList($model,'from_outlet', CHtml::listData(Outlet::model()->findAll(), 'id', 'outlet_name')); ?>
	    <?php echo $form->error($model,'from_outlet'); ?>
	</div>
	<div class="col-sm-12 form-group">
	    <?php echo $form->labelEx($model,'to_outlet'); ?>
	    <?php echo $form->dropDownList($model,'to_outlet', CHtml::listData(Outlet::model()->findAll(), 'id', 'outlet_name'),array('empty'=>'Select Destination')); ?>
	    <?php echo $form->error($model,'to_outlet'); ?>
	</div>
</div>
<div class="row">
    <div class="sidebar-nav" id="payment_cart">

    <?php
        if(!empty($items)){
            echo TbHtml::submitButton($model->isNewRecord ? Yii::t('app','Create') : Yii::t('app','Save'),array(
                'color'=>TbHtml::BUTTON_COLOR_PRIMARY,
            //'size'=>TbHtml::BUTTON_SIZE_SMALL,
            )); 
        }
    ?>

    </div>
</div>
<?php $this->endWidget()?>