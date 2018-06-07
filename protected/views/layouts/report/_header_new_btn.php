<!------ To do next to pass permission from variable same as Admin page template ---->
<?php if (ckacc('saleorder.create')) { ?>

    <?php echo TbHtml::linkButton(Yii::t('app', 'New'), array(
        'color' => TbHtml::BUTTON_COLOR_PRIMARY,
        'size' => TbHtml::BUTTON_SIZE_SMALL,
        'icon' => 'ace-icon fa fa-plus white',
        'url' => $this->createUrl('saleItem/list', array(
                'status' => param('sale_order_status'),
                'user_id' => getEmployeeId(),
                'title' => 'Order To Validate',
        )),
    )); ?>

<?php } ?>