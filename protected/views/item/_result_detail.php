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
            'model'=>$model
    ), true),
)); ?>

<?php $this->endWidget(); ?>
	