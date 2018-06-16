<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
    'id'=>'barcode-form',
    'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
    'htmlOptions'=>array('enctype' => 'multipart/form-data'),
)); ?>


    <?php echo CHtml::label('Number of barcode', 1, array('class' => 'control-label')); ?>
    <?php echo CHtml::TextField('Barcode','',array('class'=>'form-control','id'=>'barcode'));?>
    <div style="margin-top: 10px; margin-bottom: 50px;">
    <?php echo TbHtml::submitButton(Yii::t('app','Preview'),array(
            'color'=>TbHtml::BUTTON_COLOR_PRIMARY,
            'class'=>'pull-right'
            //'size'=>TbHtml::BUTTON_SIZE_SMALL,
        )); ?>
    </div>

<?php $this->endWidget(); ?>