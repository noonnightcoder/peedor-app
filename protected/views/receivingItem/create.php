<?php
$this->breadcrumbs=array(
    sysMenuItem() =>array('Inventory count'),
    'Create',
);
?>

<?php $box = $this->beginWidget('yiiwheels.widgets.box.WhBox', array(
    'title' => Yii::t('app','New Item'),
    'headerIcon' => sysMenuItemIcon(),
    'htmlHeaderOptions'=>array('class'=>'widget-header-flat widget-header-small'),
    'content' => $this->renderPartial('_form', array(
            'model'=>$model,
            'receiveItem'=>$receiveItem,
            'data_provider'=>$data_provider,
            'grid_id' => $grid_id,
            'page_size' => $page_size,
            'grid_columns' => $grid_columns,
    ), true),
)); ?>

<?php $this->endWidget(); ?>

