<?php
$this->breadcrumbs=array(
        'Employees'=>array('admin'),
	'Create',
);
?>

<?php $box = $this->beginWidget('yiiwheels.widgets.box.WhBox', array(
              'title' => Yii::t('app','New Employee'),
              'headerIcon' => 'ace-icon fa fa-user',
              'htmlHeaderOptions'=>array('class'=>'widget-header-flat widget-header-small'),
              'content' => $this->renderPartial('_form', array(
                  'model' => $model,
                  'user' => $user,
                  //'role' => $role,
                  'disabled' => $disabled,
                  //'grid_id' => $grid_id,
                  //'data_provider' => $data_provider,
                  //'grid_columns' => $grid_columns,
              ), true),
 )); ?>  

<?php $this->endWidget(); ?>

<?php //echo $this->renderPartial('_form',array('model'=>$model,'user'=>$user)); ?>


