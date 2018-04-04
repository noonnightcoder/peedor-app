<?php $this->renderPartial('_header', array('model' => $model)) ?>

<?php $this->renderPartial('//layouts/partial/_flash_message'); ?>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
    'id'=>'item-form',
    'enableAjaxValidation'=>true,
    'action'=>$this->createUrl('Item/SaveItem'),
    'enableClientValidation'=>true,
    'clientOptions' => array(
        'validateOnSubmit'=>true,
        'validateOnChange'=>true,
        'validateOnType'=>false,
    ),
    'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
    'htmlOptions'=>array('enctype' => 'multipart/form-data'),
)); ?>
<?php echo TbHtml::submitButton($model->isNewRecord ? Yii::t('app','Create') : Yii::t('app','Save'),array(
    'color'=>TbHtml::BUTTON_COLOR_PRIMARY,
    //'size'=>TbHtml::BUTTON_SIZE_SMALL,
)); ?>
<?php //echo CHtml::ajaxSubmitButton('Save',CHtml::normalizeUrl(array('Item/SaveItem','render'=>true)),
// array(
//        'dataType'=>'json',
//        'type'=>'post',
//     'success'=>'function(data) {
//         $("#AjaxLoader").hide();
//        if(data.status=="success"){
//         $("#formResult").html("form submitted successfully.");
//         $("#item-form")[0].reset();
//        }
//         else{
//        $.each(data, function(key, val) {
//        $("#item-form #"+key+"_em_").html(val);
//        $("#item-form #"+key+"_em_").show();
//        });
//        }
//    }',
//     'beforeSend'=>'function(){
//           $("#AjaxLoader").show();
//      }'
//     ),array('id'=>'mybtn','class'=>'btn btn-primary'));
//?>
    <div id="report_grid" class="tabbable">
        <?php $this->widget('bootstrap.widgets.TbTabs', array(
            'type' => 'tabs',
            'placement' => 'above',
            'id' => 'tabs',
            'tabs' => array(
                array('label' =>  t('Basic','app'),
                    'id' => 'tab_1',
                    'icon' => sysMenuItemIcon(),
                    'content' => $this->renderPartial('_form_basic' ,array(
                        'model' => $model,
                        'price_tiers' => $price_tiers,
                        'price_quantity_range' => $price_quantity_range,
                        'form' => $form,
                        'title' => 'Basic'),true),
                    'active' => true,
                ),
                array('label' => sysMenuSale(),
                    'id' => 'tab_2',
                    'icon' => sysMenuSaleIcon(),
                    'content' => $this->renderPartial('partialList/_saleTab' ,array(
                        'model' => $model,
                        'price_tiers' => $price_tiers,
                        'price_quantity_range' => $price_quantity_range,
                        'form' => $form,
                        'title' => sysMenuSale()),true),
                    'visible' => ckacc('sale.review')
                ),
                array('label' => t('Purchase ','app'),
                    'id' => 'tab_2',
                    'icon' => sysMenuPurchaseIcon(),
                    'content' => $this->renderPartial('_form_inventory' ,array(
                        'model' => $model,
                        'price_tiers' => $price_tiers,
                        'price_quantity_range' => $price_quantity_range,
                        'form' => $form,
                        'title' => 'Purchase'),true),
                    'visible' => ckacc('sale.review')
                ),
                array('label' => t('Transaction ','app'),
                    'id' => 'tab_2',
                    'icon' => sysMenuInventoryIcon(),
                    'content' => $this->renderPartial('_form_inventory' ,array(
                        'model' => $model,
                        'price_tiers' => $price_tiers,
                        'price_quantity_range' => $price_quantity_range,
                        'form' => $form,
                        'title' => 'Transaction'),true),
                    'visible' => ckacc('sale.review')
                ),
            ),
        ));
        ?>

    </div>

    <!--<div class="col-sm-6">
        <h4 class="header blue"><i
                class="ace-icon fa fa-info-circle blue"></i><?/*= t('Basic Information','app') */?>
        </h4>

        <?php /*$this->renderPartial('_form_basic', array('model' => $model, 'price_tiers' => $price_tiers, 'form' => $form)); */?>
    </div>

    <div class="col-sm-6">

    </div>

    <div class="col-sm-12">

    </div>-->
<?php $this->endWidget(); ?>