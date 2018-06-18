<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
    'id'=>'mail-form',
    'enableAjaxValidation'=>true,
    'action'=>$this->createUrl('saleItem/ViewSaleInvoice',array(
        'sale_id'=>$sale_id,'customer_id'=>$customer_id,'tran_type'=>$tran_type,'pdf'=>$pdf,'email'=>$email
    )),
    'enableClientValidation'=>true,
    'clientOptions' => array(
        'validateOnSubmit'=>true,
        'validateOnChange'=>true,
        'validateOnType'=>true,
    ),
    'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
    'htmlOptions'=>array(
        //'enctype' => 'multipart/form-data'
    ),
)); ?>
        <div class="row">
            <div class="col-sm-11">
                <?= $form->textFieldControlGroup($model,'mail_from',array('size'=>60,'maxlength'=>500,'class'=>'span3',)); ?>
            </div>
            <div class="col-sm-11">
                <?= $form->textFieldControlGroup($model,'mail_to',array('size'=>60,'maxlength'=>500,'class'=>'span3',)); ?>
            </div>
            <div class="col-sm-11">
                <?= $form->textFieldControlGroup($model,'mail_subject',array('size'=>60,'maxlength'=>500,'class'=>'span3',)); ?>
            </div>
            <div class="col-sm-11">
                <?= $form->textFieldControlGroup($model,'mail_cc',array('size'=>60,'maxlength'=>500,'class'=>'span3',)); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <label>Body</label>
                <?php $this->widget('application.extensions.ckeditor.CKEditor', array(
                    'model'=>$model,
                    'attribute'=>'mail_body',
                    'language'=>'en',
                    'editorTemplate'=>'full',
                    'htmlOptions'=>array('placeholder'=>'Body')
                )); ?>
            </div>
        </div>
        <?php echo TbHtml::submitButton(Yii::t('app','Send'),array(
                'color'=>TbHtml::BUTTON_COLOR_PRIMARY,
                'class'=>'pull-right btn-preview'
                //'size'=>TbHtml::BUTTON_SIZE_SMALL,
            )); ?>
        </div>
<?php $this->endWidget(); ?>

<style type="text/css">
    #errmsg{
        color: #ff0000;
    }
</style>