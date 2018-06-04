<?php $this->renderPartial('//layouts/partial/_flash_message'); ?>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
    'id'=>'item-form',
    'enableAjaxValidation'=>true,
    //'action'=>$this->createUrl('Item/Create'),
    'enableClientValidation'=>true,
    'clientOptions' => array(
        'validateOnSubmit'=>true,
        'validateOnChange'=>true,
        'validateOnType'=>true,
        'beforeValidate'=>"js:beforeValidate()",
    ),
    'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
    'htmlOptions'=>array('enctype' => 'multipart/form-data')
)); ?>

<div>
    <h4>General</h4>  
    <hr> 
    <div class="container">
        <div class="row">
            <p class="help-block"><?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span>
        <?= Yii::t('app', 'are required'); ?></p>
            <div class="col-sm-11 col-md-3">
                <div class="form-group">
                    <?php echo CHtml::label('Start Date *', 1, array('class' => 'control-label')); ?>
                    <?php $this->widget('yiiwheels.widgets.datepicker.WhDatePicker', array(
                            'attribute' => 'created_date',
                            'model' => $model,
                            'pluginOptions' => array(
                                'format' => 'yyyy-mm-dd',
                            ),
                            'htmlOptions'=>array('value'=>date('Y-m-d'))
                        ));
                    ?>
                </div>
            </div>
            <div class="col-sm-11 col-md-3">
                <div class="form-group">
                    <?php echo CHtml::label('Time *', 1, array('class' => 'control-label')); ?>
                    <?php echo CHtml::TextField('InventoryCount',date('H:i:s'),array('class'=>'form-control input-mask-date','id'=>'InventoryCount_count_time','value'=>date('H:i:s'))); ?>
                </div>
            </div>
            <div class="col-sm-11 col-md-6 margin-3">
                <div class="form-group">
                    <?php echo CHtml::label('Count Name *', 1, array('class' => 'control-label')); ?>
                    <?php echo CHtml::TextField('InventoryCount','InventoryCount'.date('Y-m-d'),array('class'=>'form-control','id'=>'InventoryCount_count_name')); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div>
    <div class="row">
        <div class="col-sm-12">
            <h4>Item Count</h4>  
            <hr> 
                <div class="row">
                    <div class="col-sm-4">
                        <div class="col-sm-5 margin-3">
                            <div class="form-group">
                                <input type="hidden" class="txt-pro-id">
                                <label>Search Product</label>
                                <?php 
                                    $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                                            'model'=>$model,
                                            'attribute'=>'item_id',
                                            'source'=>$this->createUrl('request/suggestItemRecv'),
                                            'htmlOptions'=>array(
                                                'size'=>'10',
                                                'class'=>'txt-pro-name form-control',
                                                'onfocus'=>'this.select();'
                                            ),
                                            'options'=>array(
                                                'showAnim'=>'fold',
                                                'minLength'=>'1',
                                                'delay' => 10,
                                                'autoFocus'=> false,
                                                'select'=>'js:function(event, ui) {
                                                    event.preventDefault();
                                                    $(".btn-count").prop("disabled",false);
                                                    $(".txt-pro-name").val(ui.item.value);
                                                    $(".txt-pro-id").val(ui.item.id);
                                                    $(".txt-count").val(1);
                                                    $(".txt-count").focus();
                                                    // alert(ui.item.quantity)
                                                }',
                                            ),
                                        ));
                                    ?>
                            </div>
                        </div>
                        <div class="col-sm-2 margin-3">
                            <div class="form-group">
                                <label>Count</label>
                                <?php echo CHtml::NumberField('InventoryCount','',array('class'=>'form-control txt-count','placeholder'=>'Count',)); ?>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <?php echo CHtml::Button('Count',array('class'=>'btn btn-primary btn-count','onClick'=>'inventoryCount(1,"")','style'=>'margin-top:20px;'))?>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <div class="col-sm-12" id="lasted-count">
                            <?php if(isset($_SESSION['latestCount'])):?>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Counted</th>
                                            <th style="text-align: right;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($_SESSION['latestCount'] as $key=>$value):?>
                                            <tr>
                                                <td width="30"><?=$value['itemId']?></td>
                                                <td><?=$value['name']?></td>
                                                <td width="100">
                                                    <div class="col-sm-12">
                                                        <input type="number" onkeypress="updateCount(<?=$value['itemId']?>)" class="txt-counted<?=$value['itemId']?> form-control" value="<?=$value['countNum']?>">
                                                    </div>
                                                </td>
                                                <td width="80" align="center">
                                                    <a class="delete-item btn btn-danger btn-xs" onClick="inventoryCount(2,<?=$key?>)">
                                                        <span class="glyphicon glyphicon glyphicon-trash "></span>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach;?>
                                    </tbody>
                                </table>
                            <?php endif;?>
                        </div>
                    </div>

                </div>
        </div>
    </div>
</div>

<?php $this->endWidget(); ?>


<style type="text/css">
    .margin-3{
        margin:0px 3px 0px 3px;
    }
    .border-bottom-1{
        border-bottom: solid 1px #f5f5f5;
    }
</style>

<script type="text/javascript">
    
    $(document).ready(function()
    {
        $('.input-mask-date').mask('99:99:99');
        $('.btn-count').prop('disabled',true);
        $('.txt-pro-name').keyup(function(e){
            $('.btn-count').prop('disabled',true);
        });

        // $('#btn-review').attr('disabled',true); 
        $('#InventoryCount_count_name').keypress(function(){
            var countDate=$('#InventoryCount_count_date').val();
            var countTime=$('#InventoryCount_count_time').val();
            var countName=$('#InventoryCount_count_name').val();
            if(countDate=='' || countTime=='' || countName==''){
                $('#btn-review').attr('disabled',true);    
                  
            }else{
                $('#btn-review').removeAttr('disabled');    
            }
        })
        
        
        var itemId=$('.txt-pro-id').val();
        $('.txt-count'+itemId).keypress(function(e){
            if(e.which == 13) {
                inventoryCount(1,"");
                $('.txt-pro-name').focus();
            }
        })
    });

    function inventoryCount(opt,idx){
        var url='addCount';
        var countDate=$('#InventoryCount_created_date').val();
        var countTime=$('#InventoryCount_count_time').val();
        var countName=$('#InventoryCount_count_name').val();
        var itemId=$('.txt-pro-id').val();
        var proName=$('.txt-pro-name').val();
        var countNum=$('.txt-count').val();
        if(opt==1 && (proName =='' || countNum=='')){
            return false;
        }else{
            $.ajax({url:url,
                type : 'post',
                data:{opt:opt,countDate:countDate,countTime:countTime,countName:countName,idx,itemId:itemId,name:proName,countNum:countNum},
                beforeSend: function() { $('.waiting').slideDown(); },
                complete: function() { $('.waiting').slideUp(); },
                success : function(data) {
                    $('#lasted-count').html(data);
                    $('.txt-pro-name').focus();
                    if(countDate!=='' && countTime!=='' && countName!==''){
                        $('#btn-review').removeAttr('disabled');   
                    }
                }
            });    
        }
        
    }
    function updateCount(itemId){
        var opt=3;
        var url='addCount';
        var newCount=$('.txt-counted'+itemId).val();
        var x = event.which || event.keyCode
        if(x == 13){
            $.ajax({url:url,
                type : 'post',
                data:{opt:opt,itemId:itemId,newCount:newCount},
                beforeSend: function() { $('.waiting').slideDown(); },
                complete: function() { $('.waiting').slideUp(); },
                success : function(data) {
                    $('#lasted-count').html(data);
                }
            });    
        }
        
    }
</script>