
<?= $form->textFieldControlGroup($item_price_quantity,'from_quantity',array('size'=>60,'maxlength'=>10,'class'=>'span3',)); ?>

<?= $form->textFieldControlGroup($item_price_quantity,'to_quantity',array('size'=>60,'maxlength'=>10,'class'=>'span3',)); ?>

<?= $form->textFieldControlGroup($item_price_quantity,'unit_price',array('size'=>60,'maxlength'=>10,'class'=>'span3',)); ?>

<?= $form->textFieldControlGroup($item_price_quantity, "start_date", array('class' => 'input-grid input-mask-date', 'placeholder' => '31/12/' . date('Y'),)); ?>

<?= $form->textFieldControlGroup($item_price_quantity, "end_date", array('class' => 'input-grid input-mask-date', 'placeholder' => '31/12/' . date('Y'),)); ?>


<div class="form-actions">
    <?php echo TbHtml::submitButton($model->isNewRecord ? Yii::t('app', 'Add') : Yii::t('app', 'Edit'), array(
        'color' => TbHtml::BUTTON_COLOR_PRIMARY,
        'size'=>TbHtml::BUTTON_SIZE_SMALL,
    )); ?>
</div>

<script>
    $(document).ready(function()
    {
        $('.input-mask-date').mask('99/99/9999');
    });
</script>

 

