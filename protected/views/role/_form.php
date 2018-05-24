

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
    'id'=>'role-form',
    'enableAjaxValidation'=>true,
    'enableClientValidation'=>true,
    'clientOptions' => array(
        'validateOnSubmit'=>true,
        'validateOnChange'=>true,
        'validateOnType'=>true,
    ),
    'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
)); ?>


	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

    <?= $form->textFieldControlGroup($model,'name',array('class'=>'span3','maxlength'=>45)); ?>

    <?= $form->textAreaControlGroup($model, 'description', array('rows' => 2, 'cols' => 10, 'class' => 'span3')); ?>

    <div class="form-actions">
        <?php echo TbHtml::submitButton($model->isNewRecord ? Yii::t('app','Create') : Yii::t('app','Save'),array(
            'color'=>TbHtml::BUTTON_COLOR_PRIMARY,
            //'size'=>TbHtml::BUTTON_SIZE_SMALL,
        )); ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->