<?php $box = $this->beginWidget('yiiwheels.widgets.box.WhBox',array(
    'title'         =>  'Barcode Label',
    'headerIcon'    => 'fa fa-barcode',
    'headerButtons' => array(
        // TbHtml::buttonGroup(
        //     array(
        //         array('label' => Yii::t('app','Preview'),
        //             'url' =>Yii::app()->createUrl('Item/PreviewItemBarcode',array('preview'=>'1')),
        //             'icon'=>'ace-icon fa fa-eye white',
        //             'visible' => ckacc('item.create')
        //         ),
        //     ),array('color' => TbHtml::BUTTON_COLOR_SUCCESS,'size'=>TbHtml::BUTTON_SIZE_SMALL)
        // ),
    ),
    'htmlHeaderOptions'=>array('class'=>'widget-header-flat widget-header-small'),
));
?>
    <div class="widget-main">
        <div id="itemlookup">
            <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
                'action'=>Yii::app()->createUrl('item/addItembarcode'),
                'method'=>'post',
                'layout'=>TbHtml::FORM_LAYOUT_INLINE,
                'id'=>'add_item_form',
            )); ?>

            <?php
            $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                'model'=>$model,
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
            <?php $this->endWidget(); ?>
        </div>
    </div>

<?php $this->endWidget(); ?>