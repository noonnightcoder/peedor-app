<?php $this->renderPartial('//layouts/partial/_flash_message'); ?>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
    'id'=>'item-form',
    'enableAjaxValidation'=>true,
    //'action'=>$this->createUrl('Item/SaveItem'),
    'enableClientValidation'=>true,
    'clientOptions' => array(
        'validateOnSubmit'=>true,
        'validateOnChange'=>true,
        'validateOnType'=>false,
    ),
    'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
    'htmlOptions'=>array('enctype' => 'multipart/form-data'),
)); ?>

<?php $this->renderPartial('_header', array('model' => $model)) ?>


<br> <br>

    <div id="report_grid" class="tabbable">
        <?php $this->widget('bootstrap.widgets.TbTabs', array(
            'type' => 'tabs',
            'placement' => 'above',
            'id' => 'tabs',
            'tabs' => array(
                array('label' =>  t('Basic','app'),
                    'id' => 'tab_1',
                    'icon' => sysMenuItemIcon(),
                    'content' => $this->renderPartial('_tab_basic' ,array(
                        'model' => $model,
                        'price_tiers' => $price_tiers,
                        //'price_quantity_range' => $price_quantity_range,
                        'form' => $form,
                        'title' => 'Basic'),true),
                    'active' => true,
                ),
                array('label' => sysMenuSale(),
                    'id' => 'tab_2',
                    'icon' => sysMenuSaleIcon(),
                    'content' => $this->renderPartial('_tab_sale' ,array(
                        'model' => $model,
                        'price_tiers' => $price_tiers,
                        'item_price_quantity' => $item_price_quantity,
                        'form' => $form,
                        'title' => sysMenuSale()),true),
                    //'visible' => ckacc('sale.review')
                ),
                /*
                array('label' => t('Purchase ','app'),
                    'id' => 'tab_3',
                    'icon' => sysMenuPurchaseIcon(),
                    'content' => $this->renderPartial('_form_inventory' ,array(
                        'model' => $model,
                        'price_tiers' => $price_tiers,
                        'form' => $form,
                        'title' => 'Purchase'),true),
                    //'visible' => ckacc('sale.review')
                ),
                array('label' => t('Transaction ','app'),
                    'id' => 'tab_4',
                    'icon' => sysMenuInventoryIcon(),
                    'content' => $this->renderPartial('_form_inventory' ,array(
                        'model' => $model,
                        'price_tiers' => $price_tiers,
                        'form' => $form,
                        'title' => 'Transaction'),true),
                    //'visible' => ckacc('sale.review')
                ),
                */
            ),
        ));
        ?>

    </div>

<?php $this->endWidget(); ?>