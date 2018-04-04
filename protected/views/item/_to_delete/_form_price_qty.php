<div class="container">
    <div id="price-range">
            <div class="col-sm-2">
                <div class="form-group col-sm-12">
                    <?php //echo $form->labelEx($price_quantity_range, 'from_quantity'); ?>
                    <?php echo $form->textField($price_quantity_range,'from_quantity',array('class'=>'form-control txt-from-qty0','placeholder'=>'From','onkeyUp'=>'getValue(0)')); ?>
                    <?php echo $form->error($price_quantity_range,'from_quantity'); ?>
                </div>
            </div>
            <div class="col-sm-2">
                <div class="form-group col-sm-12">
                    <?php //echo $form->labelEx($price_quantity_range, 'to_quantity'); ?>
                    <?php echo $form->textField($price_quantity_range,'to_quantity',array('class'=>'form-control txt-to-qty0','placeholder'=>'To','onkeyUp'=>'getValue(0)')); ?>
                    <?php echo $form->error($price_quantity_range,'to_quantity'); ?>
                </div>
            </div>
            <div class="col-sm-2">
                <div class="form-group col-sm-12">
                    <?php //echo $form->labelEx($price_quantity_range, 'price'); ?>
                    <?php echo $form->textField($price_quantity_range,'price',array('class'=>'form-control txt-price0','placeholder'=>'Price','onkeyUp'=>'getValue(0)')); ?>
                </div>
            </div>

            <div class="col-sm-2">
                <div class="form-group col-sm-12">
                    <?php //echo $form->labelEx($price_quantity_range, 'start_date'); ?>
                    <?php echo $form->dateField($price_quantity_range,'start_date',array('class'=>'form-control dt-start-date0','placeholder'=>'Optional','title'=>'Start Date','onChange'=>'getValue(0)')); ?>
                </div>
            </div>
            <div class="col-sm-2">
                <div class="form-group col-sm-12">
                    <?php //echo $form->labelEx($price_quantity_range, 'end_date'); ?>
                    <?php echo $form->dateField($price_quantity_range,'end_date',array('class'=>'form-control dt-end-date0','placeholder'=>'Optional','title'=>'End Date','onChange'=>'getValue(0)')); ?>
                </div>
            </div>
    </div>
    <div class="form-group col-sm-10">
        <?php echo CHtml::Button('Add Range',array('class'=>'btn btn-primary pull-right','onClick'=>'addPriceRange()'))?>
    </div>

</div>

<?php /*$this->renderPartial('partialList/_js'); */?>

 

