<?php
$this->breadcrumbs=array(
    sysMenuItem() =>array('admin'),
    'Create',
);
?>

<?php /*$box = $this->beginWidget('yiiwheels.widgets.box.WhBox', array(
    'title' => Yii::t('app','New Item'),
    'headerIcon' => sysMenuItemIcon(),
    'htmlHeaderOptions'=>array('class'=>'widget-header-flat widget-header-small'),
    'content' => $this->renderPartial('_form', array('model'=>$model,'price_tiers' => $price_tiers), true),
)); */?><!--

--><?php /*$this->endWidget(); */?>


<?php $this->renderPartial('_form', array('model'=>$model,'price_tiers' => $price_tiers,'price_quantity_range'=>$price_quantity_range)); ?>

<?php //$this->renderPartial('//layouts/partial/_form_js'); ?>
