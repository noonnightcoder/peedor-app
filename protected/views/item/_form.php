<?php $this->renderPartial('_header', array('model' => $model)) ?>

<?php $this->renderPartial('//layouts/partial/_flash_message'); ?>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
    'id'=>'item-form',
    'enableAjaxValidation'=>false,
    'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
    'htmlOptions'=>array('enctype' => 'multipart/form-data'),
)); ?>

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
                        'form' => $form,
                        'title' => 'Basic'),true),
                    'active' => true,
                ),
                array('label' => sysMenuSale(),
                    'id' => 'tab_2',
                    'icon' => sysMenuSaleIcon(),
                    'content' => $this->renderPartial('_form_pricing' ,array(
                        'model' => $model,
                        'price_tiers' => $price_tiers,
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