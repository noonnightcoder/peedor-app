<?php
$this->breadcrumbs = array(
    Yii::t('app', 'Item') => array('admin'),
    Yii::t('app', 'Create'),
);
?>

<?php $this->renderPartial('//layouts/partial/_flash_message'); ?>

<?php /*$box = $this->beginWidget('yiiwheels.widgets.box.WhBox', array(
    'title' => Yii::t('app', 'Create Item'),
    'headerIcon' => 'ace-icon fa fa-coffee',
    'htmlHeaderOptions' => array('class' => 'widget-header-flat widget-header-small'),
    'content' => $this->renderPartial('_form_image', array('model' => $model, 'price_tiers' => $price_tiers), true),
    'headerButtons' => array(
        TbHtml::buttonGroup(
            array(
                array(
                    'label' => Yii::t('app', ''),
                    'url' => Yii::app()->createUrl('Item/Admin'),
                    'icon' => 'ace-icon fa fa-undo white'
                ),
            ), array('color' => TbHtml::BUTTON_COLOR_INVERSE, 'size' => TbHtml::BUTTON_SIZE_SMALL)
        ),
    )
)); */?>

<?php //$this->endWidget(); ?>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
    'id'=>'item-form',
    'enableAjaxValidation'=>false,
    'layout'=>TbHtml::FORM_LAYOUT_HORIZONTAL,
    'htmlOptions'=>array('enctype' => 'multipart/form-data'),
)); ?>

<div class="widget-container-col ui-sortable">
    <div class="widget-box">
        <?php $this->renderPartial('//layouts/partial/_form_header',array('icon_class' => 'ace-icon fa fa-info-circle','header' => 'Detail')); ?>

        <div class="widget-body">
            <div class="widget-main">
                <?php $this->renderPartial('_form_detail', array('model' => $model, 'price_tiers' => $price_tiers, 'form' => $form)); ?>
            </div>
        </div>

    </div>
 </div>

<div class="widget-container-col ui-sortable">
    <div class="widget-box">
        <?php $this->renderPartial('//layouts/partial/_form_header',array('icon_class' => 'ace-icon fa fa-money','header' => 'Pricing')); ?>

        <div class="widget-body">
            <div class="widget-main">
                <?php $this->renderPartial('_form_pricing', array('model' => $model, 'price_tiers' => $price_tiers, 'form' => $form)); ?>
            </div>
        </div>
    </div>
</div>

<div class="widget-container-col ui-sortable">
    <div class="widget-box">
        <?php $this->renderPartial('//layouts/partial/_form_header',array('icon_class' => 'ace-icon fa fa-money','header' => 'Inventory')); ?>

        <div class="widget-body">
            <div class="widget-main">
                <?php $this->renderPartial('_form_inventory', array('model' => $model, 'price_tiers' => $price_tiers, 'form' => $form)); ?>
            </div>
        </div>
    </div>
</div>


<div class="form-actions">
    <?php echo TbHtml::submitButton($model->isNewRecord ? Yii::t('app','Create') : Yii::t('app','Save'),array(
        'color'=>TbHtml::BUTTON_COLOR_PRIMARY,
        //'size'=>TbHtml::BUTTON_SIZE_SMALL,
    )); ?>
</div>

<?php $this->endWidget(); ?>


<?php //$this->renderPartial('//layouts/partial/_form_js'); ?>
