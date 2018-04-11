<?php
$this->breadcrumbs=array(
    'Home' => array('home'),
);
?>

<!-- PAGE CONTENT BEGINS -->
<div class="row">


    <div class="col-xs-6">
            <h3 class="header smaller lighter green">🚀BOOST YOUR SALES</h3>

            <!-- #section:elements.button.app -->
            <p></p>

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

            <!-- #section:elements.button.app -->
            <p></p>

            <?php if (ckacc('sale.create') || ckacc('sale.update') ) { ?>

                <?php echo TbHtml::linkButton(sysMenuInvoice(), array(
                    'color' => TbHtml::BUTTON_COLOR_SUCCESS,
                    'class' => 'btn btn-app btn-sm',
                    'icon' => 'ace-icon '. sysMenuInvoiceIcon() . ' icon-animated-vertical ' . ' bigger-200',
                    'url' => $this->createUrl('saleItem/create'),
                )); ?>

            <?php } ?>

            <?php echo TbHtml::linkButton('Revenue', array(
                'color' => TbHtml::BUTTON_COLOR_SUCCESS,
                'class' => 'btn btn-app btn-sm',
                'icon' => 'ace-icon '. sysMenuInvoiceIcon() . ' bigger-200',
                'url' => $this->createUrl('report/profitDailySum'),
            )); ?>
        </div>

    <div class="col-xs-6">
        <h3 class="header smaller lighter green">🍌MANAGE YOUR PRODUCT</h3>

        <!-- #section:elements.button.app -->
        <p></p>

        <?php if (ckacc('item.create') || ckacc('item.update') ) { ?>

            <?php echo TbHtml::linkButton(sysMenuItemAdd(), array(
                //'color' => 'btn-pink ',
                'class' => 'btn btn-app btn-sm btn-purple',
                'icon' => 'ace-icon '. sysMenuItemIcon() . ' bigger-200',
                'url' => $this->createUrl('item/create'),
                'title' => t('Add New Item','app')
            )); ?>

            <?php echo TbHtml::linkButton(sysMenuItemView(), array(
                //'color' => TbHtml::BUTTON_COLOR_INFO,
                'class' => 'btn btn-app btn-sm btn-purple',
                'icon' => 'ace-icon fa fa-eye' . ' bigger-200',
                'url' => $this->createUrl('item/admin'),
                'title' => sysMenuItemView(),
            )); ?>

        <?php } ?>

        <!-- /section:elements.button.app -->
    </div>

    <div class="col-xs-6">
        <h3 class="header smaller lighter green">🚠MANAGE YOUR INVENTORY</h3>

        <!-- #section:elements.button.app -->
        <p></p>

        <?php if (ckacc('stock.in') || ckacc('stock.out') ) { ?>

            <?php echo TbHtml::linkButton(sysMenuInventoryCount(), array(
                'color' => TbHtml::BUTTON_COLOR_LINK,
                'class' => 'btn btn-app btn-sm',
                'icon' => 'ace-icon '. sysMenuInventoryCountIcon() . ' bigger-200',
                'url' => $this->createUrl('item/create'),
            )); ?>

            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

            <?php echo TbHtml::linkButton(sysMenuInventoryAdd(), array(
                'color' => TbHtml::BUTTON_COLOR_LINK,
                'class' => 'btn btn-app btn-sm',
                'icon' => 'ace-icon '. sysMenuInventoryAddIcon() . ' bigger-200',
                'url' => $this->createUrl('item/admin'),
            )); ?>

            <?php echo TbHtml::linkButton(sysMenuInventoryMinus(), array(
                'color' => TbHtml::BUTTON_COLOR_LINK,
                'class' => 'btn btn-app btn-sm',
                'icon' => 'ace-icon '. sysMenuInventoryMinusIcon() . ' bigger-200',
                'url' => $this->createUrl('item/admin'),
            )); ?>

        <?php } ?>

        <!-- /section:elements.button.app -->
    </div>

    <?php if (ckacc('report.sale.analytic')) { ?>

    <div class="col-xs-12">
        <h3 class="header smaller lighter green">👨‍👩‍👦‍👦TAKING CARE YOU CUSTOMER</h3>
        <?php echo TbHtml::linkButton('CRM', array(
            //'color' => TbHtml::BUTTON_COLOR_LINK,
            'class' => 'btn btn-app btn-pink',
            'icon' => 'ace-icon fa fa-handshake-o' . ' bigger-200',
            'url' => $this->createUrl('report/saleWeeklyByCustomer'),
            'title' => t('Customer Relationship Management','app')
        )); ?>
    </div>

    <?php } ?>

</div>

<script>
    $( ".btn-app" ).tooltip({
        show: {
            effect: "slideDown",
            delay: 250
        }
    });
</script>