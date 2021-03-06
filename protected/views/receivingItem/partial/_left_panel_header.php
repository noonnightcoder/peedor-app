<?php $box = $this->beginWidget('yiiwheels.widgets.box.WhBox',array(
        'title'         =>  Yii::t('app',$trans_header),
        'headerIcon'    => 'ace-icon fa fa-cloud-download',
        'htmlHeaderOptions'=>array('class'=>'widget-header-flat widget-header-small'),
        'headerButtons' => array(
            TbHtml::buttonGroup(
                array(
                    array('label' => Yii::t('app','New Item'),'url' => Yii::app()->createUrl('Item/create',array('grid_cart'=>'R')),'icon'=>'fa fa-plus white'),
                ),array('color'=>TbHtml::BUTTON_COLOR_SUCCESS,'size'=>TbHtml::BUTTON_SIZE_SMALL)
            ),
        )
));
?>

    <div id="itemlookup" class="col-xs-12 col-sm-10">
        <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
                'action'=>Yii::app()->createUrl('receivingItem/add'),
                'method'=>'post',
                'layout'=>TbHtml::FORM_LAYOUT_HORIZONTAL,
                'id'=>'add_item_form',
        )); ?>

            <?php
            $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                    'model'=>$model,
                    'attribute'=>'item_id',
                    'source'=>$this->createUrl('request/suggestItemRecv'),
                    'htmlOptions'=>array(
                        'size'=>'40'
                    ),
                    'options'=>array(
                        'showAnim'=>'fold',
                        'minLength'=>'1',
                        'delay' => 10,
                        'autoFocus'=> false,
                        'select'=>'js:function(event, ui) {
                            event.preventDefault();
                            $("#ReceivingItem_item_id").val(ui.item.id);
                            $("#add_item_form").ajaxSubmit({target: "#register_container", beforeSubmit: receivingsBeforeSubmit, success: itemScannedSuccess(ui.item.id)});
                        }',
                    ),
                ));
            ?>

        <?php $this->endWidget(); ?>
    </div>

    <div id="cancel_cart" class="col-xs-12 col-sm-2">
        <?php if ($count_item <> 0) { ?>
            <?php
            $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
                'id' => 'cancel_recv_form',
                'action' => Yii::app()->createUrl('receivingItem/cancelRecv/'),
                'layout' => TbHtml::FORM_LAYOUT_INLINE,
            ));
            ?>
            <div>
                <?php
                echo TbHtml::linkButton(Yii::t('app', ''), array(
                    'color' => TbHtml::BUTTON_COLOR_DANGER,
                    'size' => TbHtml::BUTTON_SIZE_SMALL,
                    'icon' => 'bigger-140 fa fa-trash',
                    'url' => Yii::app()->createUrl('receivingItem/cancelRecv/'),
                    'class' => 'cancel-receiving',
                    'id' => 'cancel_receiving_button',
                    'title' => Yii::t('app', 'Empty Cart'),
                ));
                ?>
            </div>
            <?php $this->endWidget(); ?>
        <?php } ?>
    </div>

<?php $this->endWidget(); ?>
