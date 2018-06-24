<?php $box = $this->beginWidget('yiiwheels.widgets.box.WhBox',array(
    'title'         =>  'Stock Transfer',
    'headerIcon'    => 'fa fa-exchange',
    'htmlHeaderOptions'=>array('class'=>'widget-header-flat widget-header-small'),
));
?>
    <div class="widget-main">
        <div id="itemlookup"  class="col-xs-12 col-sm-10">
            <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
                'action'=>Yii::app()->createUrl('stockTransfer/addItemToTransfer'),
                'method'=>'post',
                'layout'=>TbHtml::FORM_LAYOUT_HORIZONTAL,
                'id'=>'add_item_form',
            )); ?>
           
            <div class="row">
                <?php
                $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                    'model'=>$items_model,
                    'attribute'=>'id',
                    'source'=>$this->createUrl('request/suggestItem'),
                    //'scriptFile'=>'',
                    //'scriptUrl'=> Yii::app()->theme->baseUrl.'/js/',
                    'htmlOptions'=>array(
                        'size'=>'35'
                    ),
                    'options'=>array(
                        'showAnim'=>'fold',
                        'minLength'=>'1',
                        'delay' => 10,
                        'autoFocus'=> false,
                        'select'=>'js:function(event, ui) {
                                event.preventDefault();
                                $("#Item_id").val(ui.item.id);
                                $("#add_item_form").ajaxSubmit({target: "#register_container", beforeSubmit: salesBeforeSubmit, });                        }',
                        //'search' => 'js:function(){ $(".waiting").show(); }',
                        //'open' => 'js:function(){ $(".waiting").hide(); }',
                    ),
                ));
                ?>
            </div>
            <?php $this->endWidget(); ?>
        </div>
        <div class="col-xs-12 col-sm-2" id="cancel_cart">
        <?php if(!empty($items)):?>
            <?php
                $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
                    'id' => 'suspend_sale_form',
                    'action' => Yii::app()->createUrl('stockTransfer/resetItemToTransfer/'),
                    'enableAjaxValidation' => false,
                    'layout' => TbHtml::FORM_LAYOUT_INLINE,
                ));
            ?>
                <?php
                    echo TbHtml::linkButton(Yii::t('app', ''), array(
                        'color' => TbHtml::BUTTON_COLOR_DANGER,
                        'size' => TbHtml::BUTTON_SIZE_SMALL,
                        'icon' => 'bigger-140 fa fa-trash',
                        'url' => Yii::app()->createUrl('stockTransfer/resetItemToTransfer/'),
                        'class' => 'reset-item-to-transfer pull-right',
                        'id' => 'reset_item_to_transfer_button',
                        //'title' => Yii::t('app', 'Cancel Sale'),
                    ));
                ?>
            <?php $this->endWidget();?>
        <?php endif;?>
    </div>
    </div>

<?php $this->endWidget(); ?>