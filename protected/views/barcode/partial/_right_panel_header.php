<div class="row">
    <div id="cancel_cart">
        <?php if(!empty($items)):?>
            <?php
                $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
                    'id' => 'suspend_sale_form',
                    'action' => Yii::app()->createUrl('item/resetItemBarcode/'),
                    'enableAjaxValidation' => false,
                    'layout' => TbHtml::FORM_LAYOUT_INLINE,
                ));
            ?>
                <?php
                    echo TbHtml::linkButton(Yii::t('app', 'Empty Cart'), array(
                        'color' => TbHtml::BUTTON_COLOR_DANGER,
                        'size' => TbHtml::BUTTON_SIZE_SMALL,
                        'icon' => ' glyphicon-remove white',
                        'url' => Yii::app()->createUrl('item/resetItemBarcode/'),
                        'class' => 'reset-item-barcode pull-right',
                        'id' => 'reset_item_barcode_button',
                        //'title' => Yii::t('app', 'Cancel Sale'),
                    ));
                ?>
            <?php $this->endWidget();?>
        <?php endif;?>
    </div>
</div>
<div class="row">
    <div class="sidebar-nav" id="client_cart">
        <?php
            $this->widget('yiiwheels.widgets.box.WhBox', array(
                'title' => Yii::t('app', 'Select Paper'),
                'headerIcon' => 'ace-icon fa fa-info-circle ',
                'htmlHeaderOptions' => array('class' => 'widget-header-flat widget-header-small'),
                'content' => $this->renderPartial('//barcode/partial/_paper_select', array(
                    'paper_type' => array('0'=>'Basic Paper')
                ), true),
            ));
        ?>
    </div>
</div>