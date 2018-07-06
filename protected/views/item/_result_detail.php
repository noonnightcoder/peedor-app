<?php
$this->breadcrumbs=array(
    sysMenuItem() =>array('admin'),
    'Detail',
);
?>

<?php $box = $this->beginWidget('yiiwheels.widgets.box.WhBox', array(
    'title' => Yii::t('app','Item Detail'),
    'headerIcon' => sysMenuItemIcon(),
    'htmlHeaderOptions'=>array('class'=>'widget-header-flat widget-header-small'),
    'content' => $this->renderPartial('partial/_detail', array(
            'model' => $model,
            'item' => $item,
            'data_provider' => $data_provider,
            'item_image' => $item_image,
            'grid_columns' => $grid_columns
    ), true),
    'headerButtons' => array(
        TbHtml::buttonGroup(
            array(
                array('label' => Yii::t('app','Edit Item'),'url' => Yii::app()->createUrl('item/updateImage',array('id'=>$model[0]['id'])),'icon'=>'fa fa-edit  white','id'=>'btn-review'),
            ),array('color'=>TbHtml::BUTTON_COLOR_PRIMARY,'size'=>TbHtml::BUTTON_SIZE_SMALL)
        ),
    ),
)); ?>

<?php $this->endWidget(); ?>
	