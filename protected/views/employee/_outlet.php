<div class="form-group">
    <?php echo $form->labelEx($model,'outlet',array('class'=>'control-label col-sm-3')); ?>
    <?php echo $form->dropDownList($model,'outlet', CHtml::listData(Outlet::model()->findAll(), 'id', 'outlet_name'),array(
        'id'=>'from_outlet','class'=>'form-control col-sm-9','options' => array(1=>array('selected'=>'selected')))); ?>
    <?php echo $form->error($model,'outlet'); ?>
</div>