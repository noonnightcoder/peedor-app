<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
    'id'=>'barcode-form',
    'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
    'htmlOptions'=>array('enctype' => 'multipart/form-data'),
)); ?>
    
    <?php if($model[0]['item_number']!='' || $model[0]['item_number']!=null ):?>
        <div class="row">
            <?php $this->renderPartial('//barcode/partial/_barcode',array('item_number'=>$model[0]['item_number']));?><br>
            &nbsp;&nbsp;&nbsp;<?=$model[0]['item_number']?>
        </div>
        
        <?php echo CHtml::label('Number of barcode', 1, array('class' => 'control-label')); ?>
        <?php echo CHtml::TextField('Barcode','',array('class'=>'form-control','id'=>'barcode','autofocus'=>'autofocus','autocomplete'=>'off'));?>
        <small id="errmsg"></small>
        <div style="margin-top: 10px; margin-bottom: 50px;">
        <?php echo TbHtml::submitButton(Yii::t('app','Preview'),array(
                'color'=>TbHtml::BUTTON_COLOR_PRIMARY,
                'class'=>'pull-right btn-preview'
                //'size'=>TbHtml::BUTTON_SIZE_SMALL,
            )); ?>
        </div>
    <?php else:?>
        <div class="alert alert-warning">This item has no barcode to print!!!</div>
    <?php endif;?>

<?php $this->endWidget(); ?>
<script type="text/javascript">
    $(document).ready(function(){
        $('.btn-preview').attr('disabled','disabled');  
        $('#barcode').keyup(function(e){
            if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                //display error message
                $("#errmsg").html("Please input only number");
                $('.btn-preview').attr('disabled','disabled');
                return false;
            }else{
                if( $(this).val() <= 0 || $(this).val()>300 ){
                    $("#errmsg").html("Please input number between 1 and 300");  
                    $('.btn-preview').attr('disabled','disabled');  
                }else{
                    $("#errmsg").html("");    
                    $('.btn-preview').removeAttr('disabled');
                }
            }
        })
    })
</script>

<style type="text/css">
    #errmsg{
        color: #ff0000;
    }
</style>