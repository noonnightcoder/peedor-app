<div class="col-xs-6">
    <h3 class="header smaller lighter green">🍌គ្រប់គ្រងផលិតផលរបស់អ្នក MANAGE YOUR PRODUCT</h3>
    <?php if (ckacc('item.create') || ckacc('item.update') ) { ?>
        <?php echo TbHtml::linkButton(sysMenuItemAdd(), array(
            'class' => 'btn btn-app btn-sm btn-purple',
            'icon' => 'ace-icon '. sysMenuItemIcon() . ' bigger-200',
            'url' => $this->createUrl('item/create'),
            'title' => t('Add New Item','app')
        )); ?>
        <?php echo TbHtml::linkButton(sysMenuItemView(), array(
            'class' => 'btn btn-app btn-sm btn-purple',
            'icon' => 'ace-icon fa fa-eye' . ' bigger-200',
            'url' => $this->createUrl('item/admin'),
            'title' => sysMenuItemView(),
        )); ?>
    <?php } ?>
</div>


<div class="col-xs-6">
    <h3 class="header smaller lighter green">🚠គ្រប់គ្រងបញ្ជីសារពើភណ្ឌរបស់អ្នក MANAGE YOUR INVENTORY</h3>

    <?php if (ckacc('stock.in') || ckacc('stock.out') ) { ?>

        <?php echo TbHtml::linkButton('Count', array(
            //'color' => TbHtml::BUTTON_COLOR_LINK,
            'class' => 'btn btn-app btn-sm btn-warning',
            'icon' => 'ace-icon '. sysMenuInventoryCountIcon() . ' bigger-200',
            'url' => $this->createUrl('item/create'),
            'title' => sysMenuInventoryCount()
        )); ?>

        <?php echo TbHtml::linkButton(sysMenuInventoryAdd(), array(
            'class' => 'btn btn-app btn-sm btn-warning',
            'icon' => 'ace-icon '. sysMenuInventoryAddIcon() . ' bigger-200',
            'url' => $this->createUrl('item/admin'),
            'title' => sysMenuInventoryAdd(),
        )); ?>

        <?php echo TbHtml::linkButton(sysMenuInventoryMinus(), array(
            //'color' => TbHtml::BUTTON_COLOR_LINK,
            'class' => 'btn btn-app btn-sm btn-warning',
            'icon' => 'ace-icon '. sysMenuInventoryMinusIcon() . ' bigger-200',
            'url' => $this->createUrl('item/admin'),
            'title' => sysMenuInventoryMinus(),
        )); ?>

    <?php } ?>

</div>