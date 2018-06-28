<div class="row">
    
</div>
<div class="row">
    <div class="sidebar-nav" id="client_cart">
        <?php $employee_outlet=Yii::app()->session['employee_outlet'] ?>
        <?php $box = $this->beginWidget('yiiwheels.widgets.box.WhBox', array(
            'title' => Yii::t('app', 'Information'),
            'headerIcon' => 'ace-icon fa fa-info-circle ',
            'htmlHeaderOptions' => array('class' => 'widget-header-flat widget-header-small'),
        )); ?>
            <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
                'action'=>Yii::app()->createUrl('receiving/setReferenceName'),
                'method'=>'post',
                'htmlOptions'=>array('class'=>'line_item_form','id'=>'reference_name_form'),
                'layout'=>TbHtml::FORM_LAYOUT_HORIZONTAL,
            )); ?>
            <?php $referenceName = Yii::app()->receivingCart->getTransferHeader('reference_name');?>
             <div class="col-sm-12">
                <div class="col-sm-12 form-group">
                    <?= $form->labelEx($model,'name') ?>
                    <?= $form->textField($model,'reference_name',array(
                        'size'=>60,
                        'maxlength'=>500,
                        'class'=>'span10',
                        'value'=>$referenceName,
                        'disabled'=>$from_outlet!==$employee_outlet ? 'disabled' : ''
                        )); ?>
                    <?php echo $form->error($model,'name'); ?>
                </div>
            <?php $this->endWidget()?>
            <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
                'action'=>Yii::app()->createUrl('receiving/setOutlet'),
                'id' => 'set-outlet-form',
                'method'=>'post',
                'layout'=>TbHtml::FORM_LAYOUT_HORIZONTAL,
            )); ?>
                
                <div class="col-sm-12 form-group">
                    <?php echo $form->labelEx($model,'from_outlet'); ?>
                    <?php if(!empty($items)):?>
                        <h5 class="form-control" style="background-color: #ddd; color: #333;" title="<?php echo $from_outlet==$employee_outlet ? 'To change this Outlet, please remove all item first' : '' ?>" id="from_outlet_text"></h5>
                    <?php endif;?>
                    <?php echo $form->dropDownList($model,'from_outlet', CHtml::listData(Outlet::model()->findAll(), 'id', 'outlet_name'),array(
                        'empty'=>'Select Source',
                        'id'=>'from_outlet',
                        'style'=>!empty($items) ? 'display:none;' : '',
                        'options' => array($from_outlet=>array('selected'=>'selected')))); ?>
                    <?php echo $form->error($model,'from_outlet'); ?>
                    
                </div>
                <div class="col-sm-12 form-group">
                    <?php echo $form->labelEx($model,'to_outlet'); ?>
                    <?php echo $form->dropDownList($model,'to_outlet', 
                        CHtml::listData(Outlet::model()->findAll(), 'id', 'outlet_name'),
                        array(
                            'empty'=>'Select Destination',
                            'id'=>'to_outlet',
                            'disabled'=>$from_outlet!==$employee_outlet ? 'disabled' : '',
                            'options' => array($to_outlet=>array('selected'=>'selected'))
                        )
                    ); ?>
                    <?php echo $form->error($model,'to_outlet'); ?>
                </div>
            </div>

            <?php $this->endWidget()?>
        <?php $this->endWidget()?>
    
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        $('#from_outlet_text').text($('#from_outlet option:selected').text());
    })
</script>