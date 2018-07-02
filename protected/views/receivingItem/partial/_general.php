<div>
    <div class="row">
        <!-- <p class="help-block"><?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span>
    <?= Yii::t('app', 'are required'); ?></p> -->
        <div class="col-sm-11 col-md-11">
            <div class="form-group">
                
                <?php $this->renderPartial('partial/_outlet',
                    array('model' => $model,'label'=>true
                    ))?>
            </div>
        </div>
        <div class="col-sm-11 col-md-11">
            <div class="col-sm-12 form-group">
                <?php echo CHtml::label('Start Date *', 1, array('class' => 'control-label')); ?>
                <?php $this->widget('yiiwheels.widgets.datepicker.WhDatePicker', array(
                        'attribute' => 'created_date',
                        'model' => $model,
                        'pluginOptions' => array(
                            'format' => 'yyyy-mm-dd',
                        ),
                        'htmlOptions'=>array('value'=>date('Y-m-d'))
                    ));
                ?>
            </div>
        </div>
        <div class="col-sm-11 col-md-11">
            <div class="col-sm-12 form-group">
                <?php echo CHtml::label('Time *', 1, array('class' => 'control-label')); ?>
                <?php echo CHtml::TextField('InventoryCount',date('H:i:s'),array('class'=>'form-control span10 input-mask-date','id'=>'InventoryCount_count_time','value'=>date('H:i:s'))); ?>
            </div>
        </div>
        <div class="col-sm-11 col-md-11">
            <div class="col-sm-12 form-group">
                <?php echo CHtml::label('Count Name *', 1, array('class' => 'control-label')); ?>
                <?php echo CHtml::TextField('InventoryCount','InventoryCount'.date('Y-m-d'),array('class'=>'form-control','id'=>'InventoryCount_count_name')); ?>
            </div>
        </div>
        
    </div>
</div>