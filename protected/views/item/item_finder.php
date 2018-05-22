<?php
$this->breadcrumbs=array(
    sysMenuItem() =>array('admin'),
    'Create',
);
?>

<?php $box = $this->beginWidget('yiiwheels.widgets.box.WhBox', array(
    'title' => Yii::t('app','New Item'),
    'headerIcon' => sysMenuItemIcon(),
    'htmlHeaderOptions'=>array('class'=>'widget-header-flat widget-header-small'),
    'content' => $this->renderPartial('_tree_view', array(
            'model'=>$model,
            // 'priceQty'=>$priceQty
    ), true),
)); ?>

<?php $this->endWidget(); ?>

