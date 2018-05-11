<?php
$this->breadcrumbs=array(
    'Price Book' =>array('/pricebook'),
    'Create',
);
?>

<?php $box = $this->beginWidget('yiiwheels.widgets.box.WhBox', array(
    'title' => Yii::t('app','Count Inventory'),
    'headerIcon' => sysMenuItemIcon(),
    'htmlHeaderOptions'=>array('class'=>'widget-header-flat widget-header-small'),
    'headerButtons' => array(
        // TbHtml::buttonGroup(
        //     array(
        //         array('label' => Yii::t('app','Review'),'url' => Yii::app()->createUrl('receivingItem/CountReview'),'icon'=>'fa fa-check-square  white','id'=>'btn-review'),
        //     ),array('color'=>TbHtml::BUTTON_COLOR_SUCCESS,'size'=>TbHtml::BUTTON_SIZE_SMALL)
        // ),
    ),
    'content' => $this->renderPartial('_form', array(
            'model'=>$model,
            'outlet'=>$outlet,
            'data_provider'=>$data_provider,
            'grid_id' => $grid_id,
            'page_size' => $page_size,
            'grid_columns' => $grid_columns,
    ), true),
)); ?>

<?php $this->endWidget(); ?>

