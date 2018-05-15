<?php $this->renderPartial('//layouts/partial/_flash_message'); ?>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
    'id'=>'item-form',
    'enableAjaxValidation'=>true,
    'action'=>$this->createUrl('PriceBook/SavePriceBook/'.@$_GET['id']),
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
            <div class="col-sm-11 col-md-6">
                <div class="form-group">
                    <?php echo CHtml::label('Name *', 1, array('class' => 'control-label')); ?>
                    <?php echo CHtml::TextField('PriceBook[price_book_name]',isset($_POST['PiceBook']['price_book_name']) ? $_POST['PiceBook']['price_book_name'] : (isset($_SESSION['pricebookHeader']) ? $_SESSION['pricebookHeader']['name'] : ''),array('class'=>'form-control','id'=>'PriceBook_name','value'=>date('H:i:s'))); ?>
                    <span style="color:#f00;"><?=@$_GET['status']=='error' ? $_GET['name']=='' ? 'Field name is rquired' : 'Price book name '.@$_GET['name'].' already taken!' : ''?></span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-11 col-md-3">
                <div class="form-group">
                    <?php echo CHtml::label('Customer Group', 1, array('class' => 'control-label')); ?>
                    <select name='PriceBook[group_id]' class="form-control" id="db-group">
                        <?php foreach($customer_group as $key=>$value):?>
                            <?php if($value['id']==isset($_POST['PiceBook']['group_id']) ? $_POST['PiceBook']['group_id'] : (isset($_SESSION['pricebookHeader']) ? $_SESSION['pricebookHeader']['customer_group'] : '')):?>
                                <option value="<?=$value['id']?>" selected><?=$value['group_name']?></option>
                            <?php else:?>
                                <option value="<?=$value['id']?>"><?=$value['group_name']?></option>
                            <?php endif;?>
                        <?php endforeach;?>
                    </select>
                </div>
            </div>
            <div class="col-sm-11 col-md-3 margin-left-10">
                <div class="form-group">
                    <?php echo CHtml::label('Outlet', 1, array('class' => 'control-label')); ?>
                    <select name='PriceBook[outlet_id]' class="form-control" id="db-outlet">
                        <?php foreach($outlet as $key=>$value):?>
                            <?php if($value['id']==isset($_POST['PiceBook']['outlet_id']) ? $_POST['PiceBook']['outlet_id'] : (isset($_SESSION['pricebookHeader']) ? $_SESSION['pricebookHeader']['outlet'] : '')):?>
                                <option value="<?=$value['id']?>" selected><?=$value['outlet_name']?></option>
                            <?php else:?>
                                <option value="<?=$value['id']?>"><?=$value['outlet_name']?></option>
                            <?php endif;?>
                        <?php endforeach;?>
                    </select>
                </div>
            </div>
        </div>   
        <div class="row"> 
            <div class="col-sm-11 col-md-3">
                <div class="form-group">
                    <?php echo CHtml::label('Valid From', 1, array('class' => 'control-label')); ?>
                    <?php $this->widget('yiiwheels.widgets.datepicker.WhDatePicker', array(
                            'attribute' => 'start_date',
                            'model' => $model,
                            'pluginOptions' => array(
                                'format' => 'yyyy-mm-dd',
                            ),
                            'htmlOptions'=>array('value'=>isset($_POST['PiceBook']['start_date']) ? $_POST['PiceBook']['start_date'] : isset($_SESSION['pricebookHeader']['start_date']) ? $_SESSION['pricebookHeader']['start_date'] : date('Y-m-d H:i:s'))
                        ));
                    ?>
                </div>
            </div>
            <div class="col-sm-11 col-md-3 margin-left-10">
                <div class="form-group">
                    <?php echo CHtml::label('Valid To', 1, array('class' => 'control-label')); ?>
                    <?php $this->widget('yiiwheels.widgets.datepicker.WhDatePicker', array(
                            'attribute' => 'end_date',
                            'model' => $model,
                            'pluginOptions' => array(
                                'format' => 'yyyy-mm-dd',
                            ),
                            'htmlOptions'=>array('value'=>isset($_POST['PiceBook']['end_date']) ? $_POST['PiceBook']['end_date'] : isset($_SESSION['pricebookHeader']['end_date']) ? $_SESSION['pricebookHeader']['end_date'] : date('Y-m-d H:i:s'))
                        ));
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div>
    <div class="row">
        <div class="col-sm-11">
            <h4>Items</h4>  
            <hr> 
            <div class="container">
                <div class="row">
                    <div class="col-sm-5">
                        <div class="col-sm-5 margin-3">
                            <div class="form-group">
                                <input type="hidden" class="txt-pro-id">
                                <label>Search Product</label>
                                <?php 
                                    $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                                            'model'=>$model,
                                            'attribute'=>'id',
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
                                                    priceBook(1,"")
                                                }',
                                            ),
                                        ));
                                    ?>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <?php echo CHtml::Button('Add',array('class'=>'btn btn-primary btn-count','onClick'=>'priceBook(1,"")','style'=>'margin-top:20px;'))?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-11 table-responsive" id="lasted-count">
                    <?php if(isset($_SESSION['itemsApplied'])):?>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Cost</th>
                                    <th>Markup<small>(%)</small></th>
                                    <th>Discount<small>(%)</small></th>
                                    <th>Retail Price<br><small>Exclude Tax</small></th>
                                    <th>Min Quantity</th>
                                    <th>Max Quantity</th>
                                    <th style="text-align: right;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($_SESSION['itemsApplied'] as $key=>$value):?>
                                    <tr>
                                        <td width="30"><?=$value['itemId']?></td>
                                        <td><?=$value['name']?></td>
                                        <td><?=$value['cost']?></td>
                                        <td width="100">
                                            <div class="col-sm-12">
                                                <input type="number" onkeyup="updateItem(<?=$value['itemId']?>,'markup',<?=$key?>)" class="txt-markup<?=$key?> form-control" value="<?=$value['markup']?>">
                                            </div>
                                        </td>
                                        <td width="100">
                                            <div class="col-sm-12">
                                                <input type="number" onkeyup="updateItem(<?=$value['itemId']?>,'discount',<?=$key?>)" class="txt-discount<?=$key?> form-control" value="<?=$value['discount']?>">
                                            </div>
                                        </td>
                                        <td width="100">
                                            <div class="col-sm-12">
                                                <input type="number" onkeyup="updateItem(<?=$value['itemId']?>,'retail_price',<?=$key?>)" class="txt-retail-price<?=$key?> form-control" value="<?=$value['retail_price'] > 0 ? $value['retail_price'] : $value['cost'] ?>">
                                            </div>
                                        </td>
                                        <td width="100">
                                            <div class="col-sm-12">
                                                <input type="number" onkeyup="updateItem(<?=$value['itemId']?>,'min_qty',<?=$key?>)" class="txt-min-qty<?=$key?> form-control" value="<?=$value['min_qty']?>">
                                            </div>
                                        </td>
                                        <td width="100">
                                            <div class="col-sm-12">
                                                <input type="number" onkeyup="updateItem(<?=$value['itemId']?>,'max_qty',<?=$key?>)" class="txt-max-qty<?=$key?> form-control" value="<?=$value['max_qty']?>">
                                            </div>
                                        </td>
                                        <td width="80" align="center">
                                            <a class="delete-item btn btn-danger btn-xs" onClick="priceBook(2,<?=$key?>)">
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
            <div class="row">
                <div class='col-sm-11'>
                    <!-- <a href="<?=Yii::app()->createUrl('PriceBook/SavePriceBook')?>" class="btn btn-primary pull-right">Save Price Book</a> -->
                    <input type="button" class="btn btn-primary pull-right" onclick="form.submit()" value="Save">
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
        })
        // $('#btn-review').attr('disabled',true);
        var pricebookname=$('#PriceBook_name').val(); 
        if(pricebookname.length<=0){
             $('#PriceBook_id').attr('disabled',true);  
             $('#PriceBook_id').attr('title','Please input price book name to continue');    
        }
        $('#PriceBook_name').keyup(function(){
            if($(this).val()==''){
                $('#PriceBook_id').attr('disabled',true);   
                $('#PriceBook_id').attr('title','Please input price book name to continue');   
            }else{
                $('#PriceBook_id').prop('disabled',false);    
                $('#PriceBook_id').removeAttr('title','Please input price book name to continue');   
            }
        })
        
        
        var itemId=$('.txt-pro-id').val();
        $('.txt-count'+itemId).keypress(function(e){
            if(e.which == 13) {
                priceBook(1,"");
                $('.txt-pro-name').focus();
            }
        })
    });
    function priceBook(opt,idx){
        var url='<?=Yii::app()->createUrl('/PriceBook/AddItem')?>';
        var start_date=$('#PriceBook_start_date').val();
        var end_date=$('#PriceBook_end_date').val();
        var price_book_name=$('#PriceBook_name').val();
        var itemId=$('.txt-pro-id').val();
        var proName=$('.txt-pro-name').val();
        var outlet=$('#db-outlet').val();
        var group_id=$('#db-group').val();
        if(opt==1 && (proName =='')){
            return false;
        }else{
            $.ajax({url:url,
                type : 'post',
                data:{opt,start_date,end_date,price_book_name,outlet,group_id,idx,itemId,proName},
                beforeSend: function() { $('.waiting').slideDown(); },
                complete: function() { $('.waiting').slideUp(); },
                success : function(data) {
                    $('#lasted-count').html(data);
                    $('.txt-pro-name').focus();
                }
            });    
        }
        
    }
    var timer=null;
    function updateItem(itemId,val,idx){
        var opt=3;
        var url='<?=Yii::app()->createUrl('/PriceBook/AddItem')?>';
        var markup=$('.txt-markup'+idx).val();
        var discount=$('.txt-discount'+idx).val();
        var retail_price=$('.txt-retail-price'+idx).val();
        var min_qty=$('.txt-min-qty'+idx).val();
        var max_qty=$('.txt-max-qty'+idx).val();
        var x = event.which || event.keyCode
        if(x == 13){
            //clearTimeout(timer)
            //timer=setTimeout(function(){
            $.ajax({url:url,
                type : 'post',
                data:{opt,itemId,markup,discount,retail_price,min_qty,max_qty,val,idx},
                beforeSend: function() { $('.waiting').slideDown(); },
                complete: function() { $('.waiting').slideUp(); },
                success : function(data) {
                    $('#lasted-count').html(data);
                    switch(val){
                        case 'markup':
                        $('#discount'+idx).focus();
                        $('#discount'+idx).select();
                        break;
                        case 'discount':
                        $('#retail_price'+idx).focus();
                        $('#retail_price'+idx).select();
                        break;
                        case 'retail_price':
                        $('#min_qty'+idx).focus();
                        $('#min_qty'+idx).select();
                        break;
                        case 'min_qty':
                        $('#max_qty'+idx).focus();
                        $('#max_qty'+idx).select();
                        break;
                        case 'max_qty':
                        $('.txt-pro-name').focus();
                        //$('#markup'+idx).select();
                        break;
                    }
                }
            });
                //},700   
            //)
        }
        
    }
    function validateBeforeSubmit(){
        var price_book_name=$('#PriceBook_name').val();
        var url = '<?=Yii::app()->createUrl('/PriceBook/SavePriceBook')?>';
        $.ajax({url:url,
            type : 'post',
            data:{price_book_name},
            beforeSend: function() { $('.waiting').slideDown(); },
            complete: function() { $('.waiting').slideUp(); },
            success : function(data) {
                if(data=='exist'){
                    alert('existed')
                }
            }
        });
    }
</script>

<style type="text/css">
    .margin-left-10{
        margin-left: 10px !important; 
    }
</style>