<div class="col-sm-12 form-group">
    <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
        'action'=>Yii::app()->createUrl('receivingItem/setOutlet'),
        'id' => 'set-outlet-form',
        'method'=>'post',
        'layout'=>TbHtml::FORM_LAYOUT_HORIZONTAL,
    )); ?>

        <?php $outlet = isset(Yii::app()->session['outlet']) ? Yii::app()->session['outlet'] : 1;?>
        <?php echo $form->dropDownList($model,'outlet', 
            CHtml::listData(Outlet::model()->findAll(), 'id', 'outlet_name'),
            array(
                'empty'=>'All Outlet',
                'id'=>'outlet',
                'options' => array($outlet=>array('selected'=>'selected'))
            )
        ); ?>
        <?php echo $form->error($model,'to_outlet'); ?>
    <?php $this->endWidget()?>
</div>