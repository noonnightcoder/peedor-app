<div class="container">
    <div id="price-range">
            <div class="col-sm-2">
                <div class="form-group col-sm-12">
                    <?php //echo $form->labelEx($item_price_quantity, 'from_quantity'); ?>
                    <?php echo $form->numberField($item_price_quantity,'from_quantity',array('name'=>'price_quantity[price_qty][from_quantity]','class'=>'form-control txt-from-qty0','placeholder'=>'From','onkeyUp'=>'getValue(0)')); ?>
                    <?php echo $form->error($item_price_quantity,'from_quantity'); ?>
                </div>
            </div>
            <div class="col-sm-2">
                <div class="form-group col-sm-12">
                    <?php //echo $form->labelEx($item_price_quantity, 'to_quantity'); ?>
                    <?php echo $form->numberField($item_price_quantity,'to_quantity',array('name'=>'price_quantity[price_qty][to_quantity]','class'=>'form-control txt-to-qty0','placeholder'=>'To','onkeyUp'=>'getValue(0)')); ?>
                    <?php echo $form->error($item_price_quantity,'to_quantity'); ?>
                </div>
            </div>
            <div class="col-sm-2">
                <div class="form-group col-sm-12">
                    <?php //echo $form->labelEx($item_price_quantity, 'unit_price'); ?>
                    <?php echo $form->numberField($item_price_quantity,'unit_price',array('name'=>'price_quantity[price_qty][unit_price]','class'=>'form-control txt-price0','placeholder'=>'Price','onkeyUp'=>'getValue(0)','step'=>'0.01')); ?>
                </div>
            </div>

            <div class="col-sm-2">
                <div class="form-group col-sm-12">
                    <?php //echo $form->labelEx($item_price_quantity, 'start_date'); ?>
                    <?php echo $form->textField($item_price_quantity,'start_date',array('name'=>'price_quantity[price_qty][start_date]','class'=>'form-control dt-start-date0','placeholder'=>'dd/mm/yyyy','title'=>'Start Date','onChange'=>'getValue(0)')); ?>
                </div>
            </div>
            <div class="col-sm-2">
                <div class="form-group col-sm-12">
                    <?php //echo $form->labelEx($item_price_quantity, 'end_date'); ?>
                    <?php echo $form->textField($item_price_quantity,'end_date',array('name'=>'price_quantity[price_qty][end_date]','class'=>'form-control dt-end-date0','placeholder'=>'dd/mm/yyyy','title'=>'End Date','onChange'=>'getValue(0)')); ?>
                </div>
            </div>
    </div>
    <div class="form-group col-sm-10">
        <?php echo CHtml::Button('Add Range',array('class'=>'btn btn-primary pull-right','onClick'=>'addPriceRange()'))?>
    </div>

</div>
<?php $this->renderPartial('partialList/_js'); ?>
<style>
    .ui-corner-all, .ui-corner-bottom, .ui-corner-right, .ui-corner-br{
        height: 30px;
    }
</style>
 

