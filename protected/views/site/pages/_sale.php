<div class="col-xs-6">
    <h3 class="header smaller lighter green">🚀BOOST YOUR SALES</h3>

    <?php if (ckacc('sale.create') || ckacc('sale.update') ) { ?>

        <?php echo TbHtml::linkButton(sysMenuSaleOrder(), array(
            'color' => TbHtml::BUTTON_COLOR_PRIMARY,
            'class' => 'btn btn-app btn-sm',
            'icon' => 'ace-icon '. sysMenuSaleOrderIcon() . ' icon-animated-vertical ' . ' bigger-200',
            'url' => $this->createUrl('saleItem/create'),
            'title' => sysMenuSaleOrder() . ' Add',
        )); ?>

    <?php } ?>

    <?php if (ckacc('sale.review') ) { ?>

        <?php echo TbHtml::linkButton('Order 2 ✅', array(
            'color' => TbHtml::BUTTON_COLOR_PRIMARY,
            'class' => 'btn btn-app btn-sm',
            'icon' => 'ace-icon '. sysMenuSaleOrderToValidateIcon() . ' bigger-200',
            'url' => $this->createUrl('saleItem/create',array (
                'status' => param('sale_submit_status'),
                'user_id' => getEmployeeId(),
                'title' => sysMenuSaleOrderToValidate(),
            )),
            'title' => sysMenuSaleOrderToValidate()
        )); ?>

    <?php } ?>
</div>

<div class="col-xs-6">

    <h3 class="header smaller lighter green">💵MANAGE YOUR FINANCE</h3>

    <?php if (ckacc('sale.create') || ckacc('sale.update') ) { ?>

        <?php echo TbHtml::linkButton(sysMenuInvoice(), array(
            'color' => TbHtml::BUTTON_COLOR_SUCCESS,
            'class' => 'btn btn-app btn-sm',
            'icon' => 'ace-icon '. sysMenuInvoiceIcon() . ' icon-animated-vertical ' . ' bigger-200',
            'url' => $this->createUrl('saleItem/create'),
        )); ?>

    <?php } ?>

    <?php if (ckacc('report.accounting')) { ?>
        <?php echo TbHtml::linkButton('Revenue', array(
            'color' => TbHtml::BUTTON_COLOR_SUCCESS,
            'class' => 'btn btn-app btn-sm',
            'icon' => 'ace-icon '. sysMenuInvoiceIcon() . ' bigger-200',
            'url' => $this->createUrl('report/profitDailySum'),
        )); ?>
    <?php } ?>
</div>