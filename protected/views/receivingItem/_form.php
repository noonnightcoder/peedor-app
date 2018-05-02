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
            <div class="col-sm-3 margin-3">
                <div class="form-group">
                    <?php echo CHtml::label('Start Date', 1, array('class' => 'control-label')); ?>
                    <?php $this->widget('yiiwheels.widgets.datepicker.WhDatePicker', array(
                            'attribute' => 'count_date',
                            'model' => $model,
                            'pluginOptions' => array(
                                'format' => 'dd-mm-yyyy'
                            )
                        ));
                    ?>
                </div>
            </div>
            <div class="col-sm-3 margin-3">
                <div class="form-group">
                    <?php echo CHtml::label('Time', 1, array('class' => 'control-label input-mask-date')); ?>
                    <?php echo CHtml::TextField('InventoryCount','',array('class'=>'form-control')); ?>
                </div>
            </div>
            <div class="col-sm-5 margin-3">
                <div class="form-group">
                    <?php echo CHtml::label('Count Name', 1, array('class' => 'control-label')); ?>
                    <?php echo CHtml::TextField('InventoryCount','',array('class'=>'form-control')); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div>
    <div class="row">
        <div class="col-sm-11">
            <h4>Item Count</h4>  
            <hr> 
            <div class="container">
                <div class="row">
                    <div class="col-sm-3 margin-3">
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
                                            'class'=>'txt-pro-search form-control',
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
                                                // alert(ui.item.quantity)
                                            }',
                                        ),
                                    ));
                                ?>
                        </div>
                    </div>
                    <div class="col-sm-3 margin-3">
                        <div class="form-group">
                            <label>Product Name</label>
                            <?php echo CHtml::TextField('InventoryCount','',array('class'=>'form-control txt-pro-name','placeholder'=>'Name','disabled'=>'disabled')); ?>
                        </div>
                    </div>
                    <div class="col-sm-1 margin-3">
                        <div class="form-group">
                            <label>Count</label>
                            <?php echo CHtml::NumberField('InventoryCount','',array('class'=>'form-control txt-count','placeholder'=>'Count',)); ?>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <?php echo CHtml::Button('Count',array('class'=>'btn btn-primary pull-right btn-count','onClick'=>'inventoryCount(1,"")','style'=>'margin-top:20px;'))?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-11">
                    <h4>Counted Item</h4>  
                    <hr> 
                    <div class="col-sm-12" id="lasted-count">
                        <?php if(isset($_SESSION['latestCount'])):?>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Item ID</th>
                                        <th>Name</th>
                                        <th>Counted</th>
                                        <th style="text-align: right;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($_SESSION['latestCount'] as $key=>$value):?>
                                        <tr>
                                            <td><?=$value['itemId']?></td>
                                            <td><?=$value['proName']?></td>
                                            <td>
                                                <input type="number" onblur="updateCount(<?=$value['itemId']?>)" class="txt-counted<?=$value['itemId']?>" value="<?=$value['countNum']?>">
                                            </td>
                                            <td>
                                                <input type="button" value="Remove" class="btn btn-danger pull-right" onClick="inventoryCount(2,<?=$key?>)">
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
        $('.input-mask-date').mask('99/99/9999');
        $('.btn-count').prop('disabled',true);
        $('.txt-pro-name').keyup(function(e){
            $('.btn-count').prop('disabled',true);
        })
    });
    function inventoryCount(opt,idx){
        var url='addCount';
        var itemId=$('.txt-pro-id').val();
        var proName=$('.txt-pro-name').val();
        var countNum=$('.txt-count').val();
        if(opt==1 && (proName =='' || countNum=='')){
            return false;
        }else{
            $.ajax({url:url,
                type : 'post',
                data:{opt:opt,idx,itemId:itemId,name:proName,countNum:countNum},
                beforeSend: function() { $('.waiting').slideDown(); },
                complete: function() { $('.waiting').slideUp(); },
                success : function(data) {
                    $('#lasted-count').html(data);
                    //console.log(data)
                }
            });    
        }
        
    }
    function updateCount(itemId){
        var opt=3;
        var url='addCount';
        var newCount=$('.txt-counted'+itemId).val();
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
</script>