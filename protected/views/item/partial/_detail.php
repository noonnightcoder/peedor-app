<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
    'id'=>'item-form',
    'enableAjaxValidation'=>false,
    'layout'=>TbHtml::FORM_LAYOUT_HORIZONTAL,
    'htmlOptions'=>array('enctype' => 'multipart/form-data'),
)); ?>
	 <?php echo $form->textFieldControlGroup($model,'product_name',array('class'=>'span3','maxlength'=>255)); ?>
<?php $this->endWidget(); ?>