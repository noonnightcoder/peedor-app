<?php
$this->widget('bootstrap.widgets.TbNav', array(
    'type' => TbHtml::NAV_TYPE_LIST,
    'submenuHtmlOptions' => array('class' => 'submenu'),
    'encodeLabel' => false,
    'items' => array(
        array('label' => '<span class="menu-text">' . sysMenuDashboard() . '</span>',
            'icon' => sysMenuDashboardIcon(),
            'url' => url('dashboard/view'),
            'active' => $this->id . '/' . $this->action->id == 'dashboard/view' ? true : false,
            'visible' => ckacc('dashboard.read')
        ),
        array('label' => '<span class="menu-text">' . sysMenuItem() . '</span>',
            'icon' => sysMenuItemIcon(),
            'url' => url('item/admin'),
            'active' => $this->id == 'item',
            'visible' => ckacc('item.create') || ckacc('item.read') || ckacc('item.update') || ckacc('item.delete'),
            'items' => array(
                array('label' => sysMenuItemAdd(),
                    'icon' => 'menu-icon fa fa-plus pink',
                    'url' => url('item/create'),
                    'active' => $this->id . '/' . $this->action->id == 'item/create',
                    'visible' => ckacc('item.create')),
                array('label' => sysMenuItemView(), 'icon' => 'menu-icon fa fa-eye pink',
                    'url' => url('item/admin'),
                    'active' => $this->id . '/' . $this->action->id == 'item/admin',
                    'visible' => ckacc('item.read')
                ),
                array('label' => sysMenuAssembliesAdd(),
                    'icon' => 'menu-icon fa fa-chain pink',
                    'url' => url('item/assembliescreate'),
                    'active' => $this->id . '/' . $this->action->id == 'item/assembliescreate',
                    'visible' => ckacc('item.create')
                ),
            ),
            /*
            'items' => array(
                array('label' => sysMenuItemAdd(), 'icon' => 'menu-icon fa fa-plus pink',
                    'url' => url('item/create'),
                    'active' => $this->id . '/' . $this->action->id == 'item/create',
                    'visible' => ckacc('item.create')),
                array('label' => sysMenuItemView(), 'icon' => 'menu-icon fa fa-eye pink',
                    'url' => url('item/admin'),
                    'active' => $this->id . '/' . $this->action->id == 'item/admin',
                    'visible' => ckacc('item.read')
                ),
                array('label' => sysMenuItemImpExp(), 'icon' => 'menu-icon fa fa-cog pink',
                    'url' => url('item/testExcel'),
                    'active' => $this->id . '/' . $this->action->id == 'item/utilities',
                    'visible' => ckacc('item.index')
                ),
                 array('label' => sysMenuItemAdd2(), 'icon' => 'menu-icon fa fa-cog pink',
                    'url' => url('item/create2'),
                    'active' => $this->id . '/' . $this->action->id == 'item/create2',
                    'visible' => ckacc('item.create2')
                ),
                array('label' => sysMenuItemMarkupPrice(), 'icon' => 'menu-icon fa fa-euro pink',
                    'url' => url('item/admin'),
                    'active' => $this->id . '/' . $this->action->id == 'item/markup',
                    'visible' => ckacc('item.index')
                ),
            ),
           */
        ),
        array('label' => '<span class="menu-text">' . sysMenuInventory() . '</span>',
            'icon' => sysMenuInventoryIcon(),
            //'url' => url('receivingItem/index'),
            'active' => $this->id . '/' . $this->action->id == 'receivingItem/index',
            'visible' => ckacc('stock.in') || ckacc('stock.out') || ckacc('stock.count') || ckacc('stock.count'),
            'items' => array(
                array('label' => sysMenuInventoryAdd(),
                    'icon' => sysMenuInventoryAddIcon(),
                    'url' => url('receivingItem/index', array('trans_mode' => 'adjustment_in')),
                    'active' => $this->id . '/' . $this->action->id . '/' . Yii::app()->request->getQuery('trans_mode') == 'receivingItem/index/adjustment_in',
                    'visible' => ckacc('stock.in')),
                array('label' => sysMenuInventoryMinus(),
                    'icon' => sysMenuInventoryMinusIcon(),
                    'url' => url('receivingItem/index', array('trans_mode' => 'adjustment_out')),
                    'active' => $this->id . '/' . $this->action->id . '/' . Yii::app()->request->getQuery('trans_mode') == 'receivingItem/index/adjustment_out',
                    'visible' => ckacc('stock.out')),
                array('label' => sysMenuInventoryCount(),
                    'icon' => sysMenuInventoryCountIcon(),
                    'url' => url('receivingItem/index', array('trans_mode' => 'physical_count')),
                    'active' => $this->id . '/' . $this->action->id . '/' . Yii::app()->request->getQuery('trans_mode') == 'receivingItem/index/physical_count',
                    'visible' => ckacc('stock.count')),
                /*array('label' => sysMenuInventoryTransfer(),
                    'icon' => sysMenuInventoryTransferIcon(),
                    'url' => url('receivingItem/index', array('trans_mode' => 'transfer')),
                    'active' => $this->id . '/' . $this->action->id . '/' . Yii::app()->request->getQuery('trans_mode') == 'receivingItem/index/transfer',
                    'visible' => ckacc('stock.transfer')),*/
            )),
        array('label' => '<span class="menu-text">' . sysMenuPurchase() . '</span>',
            'icon' => sysMenuPurchaseIcon(),
            'url' => url('receivingItem/index'),
            'active' => $this->id . '/' . $this->action->id == 'receivingItem/index',
            'visible' => ckacc('purchase.create') || ckacc('purchase.read') || ckacc('purchase.update') || ckacc('purchase.delete') || ckacc('purchase.receive') || ckacc('purchase.return'),
            'items' => array(
                array('label' => sysMenuPurchaseReceive(),
                    'icon' => sysMenuPurchaseReceiveIcon(),
                    'url' => url('receivingItem/index', array('trans_mode' => 'receive')),
                    'active' => $this->id . '/' . $this->action->id . '/' . Yii::app()->request->getQuery('trans_mode') == 'receivingItem/index/receive',
                    'visible' => ckacc('purchase.receive')),
                array('label' => sysMenuPurchaseReturn(),
                    'icon' => sysMenuPurchaseReturnIcon(),
                    'url' => url('receivingItem/index', array('trans_mode' => 'return')), 'active' => $this->id . '/' . $this->action->id . '/' . Yii::app()->request->getQuery('trans_mode') == 'receivingItem/index/return',
                    'visible' => ckacc('purchase.return')),
            )),
        array('label' => '<span class="menu-text">' . sysMenuOrders() . '</span>',
            'icon' => sysMenuSaleIcon(),
            'url' => url('saleItem/list', array('status' => param('sale_submit_status'), 'user_id' => getEmployeeId())),
            'active' => $this->id == 'saleItem',
            'visible' => ckacc('sale.create') || ckacc('sale.read') || ckacc('sale.read.all') || ckacc('sale.update') || ckacc('sale.delete'),
                //ckacc('sale.edit') || ckacc('sale.discount') || ckacc('sale.editprice'),
            /*
            'items' => array(
                array('label' => sysMenuSaleAdd(),
                    'icon' => sysMenuSaleAddIcon(),
                    'url' => url('saleItem/update'),
                    'active' => $this->id . '/' . $this->action->id == 'saleItem/update',
                    'visible' => ckacc('sale.create')
                ),
                array('label' => sysMenuSaleView(),
                    'icon' => sysMenuSaleViewIcon(),
                    'url' => url('saleItem/review'),
                    'active' => $this->id . '/' . $this->action->id == 'saleItem/review',
                    'visible' => ckacc('sale.read.all') || ckacc('sale.read')
                ),
                array('label' => sysMenuSaleApprove(),
                    'icon' => sysMenuSaleViewIcon(),
                    'url' => url('saleItem/approve'),
                    'active' => $this->id . '/' . $this->action->id == 'saleItem/approve',
                    'visible' => ckacc('sale.approve')
                ),
            ),
            */
        ),
        array('label' => '<span class="menu-text">' . sysMenuInvoicing() . '</span>',
            'icon' => sysMenuSaleIcon(),
            'url' => url('saleItem'),
            'active' => $this->id == 'saleItem',
            'visible' => ckacc('sale.create') || ckacc('sale.read') || ckacc('sale.read.all') || ckacc('sale.update') || ckacc('sale.delete'),
            //ckacc('sale.edit') || ckacc('sale.discount') || ckacc('sale.editprice'),
            'items' => array(
                array('label' => sysMenuOrderToInvoice(),
                    'icon' => sysMenuSaleViewIcon(),
                    'url' => url('saleItem/approve'),
                    'active' => $this->id . '/' . $this->action->id == 'saleItem/approve',
                    'visible' => ckacc('sale.approve')
                ),
                array('label' => sysMenuOrderToDeliver(),
                    'icon' => sysMenuOrderToDeliverIcon(),
                    'url' => url('saleItem/approve'),
                    'active' => $this->id . '/' . $this->action->id == 'saleItem/approve',
                    'visible' => ckacc('sale.approve')
                ),
            ),
        ),
        array('label' => '<span class="menu-text">' . sysMenuSalePayment() . '</span>',
            'icon' => sysMenuSalePaymentIcon(),
            'url' => url('salePayment/index'),
            'active' => $this->id . '/' . $this->action->id == 'salePayment/index',
            'visible' => ckacc('sale.payment')),
        array('label' => '<span class="menu-text">' . sysMenuPurchasePayment() . '</span>',
            'icon' => sysMenuPurchasePaymentIcon(),
            'url' => url('receivingPayment/index'),
            'active' => $this->id . '/' . $this->action->id == 'receivingPayment/index',
            'visible' => ckacc('purchase.payment')),
        array('label' => '<span class="menu-text">' . sysMenuReport() . '</span>',
            'icon' => sysMenuReportIcon(),
            //'url' => url('report/reporttab'),
            'active' => $this->id == 'report',
            'visible' => ckacc('report.sale') || ckacc('report.sale.analytic') || ckacc('report.stock') || ckacc('report.customer') || ckacc('report.marketing') || ckacc('report.accounting'),
            'items' => array(
                array('label' => Yii::t('app', 'Sale Invoice'),
                    'icon' => sysMenuReportSaleIcon(),
                    'url' => url('report/SaleInvoice'),
                    'active' => $this->id . '/' . $this->action->id == 'report/SaleInvoice',
                    //'visible' => ckacc('invoice.index') || ckacc('invoice.print') || ckacc('invoice.delete') || ckacc('invoice.update')
                    'visible' => ckacc('report.sale')
                ),
                array('label' => Yii::t('app', 'Sale Daily'),
                    'icon' => sysMenuReportSaleIcon(),
                    'url' => url('report/SaleDaily'),
                    'active' => $this->id . '/' . $this->action->id == 'report/SaleDaily',
                    'visible' => ckacc('report.sale')
                ),
                array('label' => Yii::t('app', 'Sale Hourly'),
                    'icon' => sysMenuReportSaleIcon(),
                    'url' => url('report/SaleHourly'),
                    'active' => $this->id . '/' . $this->action->id == 'report/SaleHourly',
                    'visible' => ckacc('report.sale')
                ),
                array('label' => Yii::t('app', 'Sale Summary'),
                    'icon' => sysMenuReportSaleIcon(),
                    'url' => url('report/SaleSummary'),
                    'active' => $this->id . '/' . $this->action->id == 'report/SaleSummary',
                    'visible' => ckacc('report.sale')
                ),
                array('label' => Yii::t('app', 'Sale By Sale Rep'),
                    'icon' => sysMenuReportSaleIcon(),
                    'url' => url('report/SaleSumBySaleRep'),
                    'active' => $this->id . '/' . $this->action->id == 'report/SaleSumBySaleRep',
                    'visible' => ckacc('report.sale')
                ),
                array('label' => Yii::t('app', 'Sale Weekly By Customer'),
                    'icon' => sysMenuReportSaleIcon(),
                    'url' => url('report/SaleWeeklyByCustomer'),
                    'active' => $this->id . '/' . $this->action->id == 'report/SaleWeeklyByCustomer',
                    'visible' => ckacc('report.sale.analytic')
                ),
                array('label' => Yii::t('app', 'Sale Item Summary'),
                    'icon' => sysMenuReportSaleIcon(),
                    'url' => url('report/SaleItemSummary'),
                    'active' => $this->id . '/' . $this->action->id == 'report/SaleItemSummary',
                    'visible' => ckacc('report.sale')
                ),
                array('label' => Yii::t('app', 'Outstanding Balance'),
                    'icon' => sysMenuReportSaleIcon(),
                    'url' => url('report/outstandingInvoice'),
                    'active' => $this->id . '/' . $this->action->id == 'report/outstandingInvoice',
                    'visible' => ckacc('report.customer')
                ),
                array('label' => Yii::t('app', 'Profit Daily Sum'),
                    'icon' => sysMenuReportAccountIcon(),
                    'url' => url('report/ProfitDailySum'),
                    'active' => $this->id . '/' . $this->action->id == 'report/ProfitDailySum',
                    'visible' => ckacc('report.accounting')
                ),
                array('label' => Yii::t('app', 'Payment Receive'),
                    'icon' => sysMenuReportAccountIcon(),
                    'url' => url('report/PaymentReceiveByEmployee'),
                    'active' => $this->id . '/' . $this->action->id == 'report/PaymentReceiveByEmployee',
                    'visible' => ckacc('report.accounting')
                ),
                array('label' => Yii::t('app', 'Best Selling Item'),
                    'icon' => 'menu-icon fa fa-trophy',
                    'url' => url('report/TopItem'),
                    'active' => $this->id . '/' . $this->action->id == 'report/TopItem',
                    'visible' => ckacc('report.sale')
                ),
                array('label' => Yii::t('app', 'Item Expiry'),
                    'icon' =>  'menu-icon fa fa-calendar-times-o',
                    'url' => url('report/itemExpiry'),
                    'active' => $this->id . '/' . $this->action->id == 'report/itemExpiry',
                    'visible' => ckacc('report.stock')
                ),
                array('label' => Yii::t('app', 'Inventory'),
                    'icon' => sysMenuReportStockIcon(),
                    'url' => url('report/Inventory'),
                    'active' => $this->id . '/' . $this->action->id == 'report/Inventory',
                    'visible' => ckacc('report.stock')
                ),
                array('label' => Yii::t('app', 'Transaction'),
                    'icon' => 'menu-icon fa fa-caret-right',
                    'url' => url('report/Transaction'),
                    'active' => $this->id . '/' . $this->action->id == 'report/Transaction',
                    'visible' => ckacc('report.stock')
                ),
                array('label'=>Yii::t('app','Total Asset'),
                    'icon'=> 'menu-icon fa fa-building',
                    'url'=>url('report/ItemAsset'),
                    'active'=>$this->id .'/'. $this->action->id =='report/ItemAsset',
                    'visible'=> ckacc('report.index'),
                ),
                array('label' => Yii::t('app', 'User Log Summary'), 'icon' => 'menu-icon fa fa-caret-right', 'url' => url('report/UserLogSummary'),
                    'active' => $this->id . '/' . $this->action->id == 'report/UserLogSummary',
                    'visible' => Yii::app()->user->isAdmin,
                ),
            )),
        array('label' => '<span class="menu-text">' . strtoupper(Yii::t('app', 'PIM')) . '</span>',
            'icon' => 'menu-icon fa fa-group',
            'url' => url('client/admin'),
            'active' => $this->id == 'employee' || $this->id == 'supplier' || $this->id == 'client' || $this->id == 'publisher',
            'visible' => ckacc('customer.read') || ckacc('supplier.read') || ckacc('employee.read'),
            'items' => array(
                array('label' => sysMenuCustomer(),
                    'icon' => sysMenuCustomerIcon(),
                    'url' => url('client/admin'),
                    'active' => $this->id == 'client',
                    'visible' => ckacc('customer.read') || ckacc('customer.create') || ckacc('customer.update') || ckacc('client.delete')
                ),
                array('label' => sysMenuEmployee(),
                    'icon' => sysMenuEmployeeIcon(),
                    'url' => url('employee/admin'),
                    'active' => $this->id == 'employee',
                    'visible' => ckacc('employee.read') || ckacc('employee.create') || ckacc('employee.update') || ckacc('employee.delete')
                ),
                array('label' => sysMenuSupplier(),
                    'icon' => sysMenuSupplierIcon(),
                    'url' => url('supplier/admin'),
                    'active' => $this->id == 'supplier',
                    'visible' => ckacc('supplier.read') || ckacc('supplier.create') || ckacc('supplier.update') || ckacc('supplier.delete')
                ),
            )),
        array('label' => '<span class="menu-text">' . sysMenuSetting() . '</span>',
            'icon' => sysMenuSettingIcon(),
            'url' => url('settings/index'),
            'active' => $this->id == 'priceTier' || strtolower($this->id) == 'default' || $this->id == 'store' || $this->id == 'settings' || $this->id == 'location' || $this->id == 'category',
            'visible' => ckacc('store.update'),
            'items' => array(
                array('label' => sysMenuCategory(),
                    'icon' => sysMenuCategoryIcon(),
                    'url' => url('category/admin'),
                    'active' => $this->id == 'category',
                    'visible' => ckacc('item.index') || ckacc('item.create') || ckacc('item.update') || ckacc('item.delete')),
                array('label' => sysMenuPriceTier(),
                    'icon' => sysMenuPriceTierIcon(),
                    'url' => url('priceTier/admin'),
                    'active' => $this->id . '/' . $this->action->id == 'priceTier/admin',
                    'visible' => ckacc('store.update')),
                //array('label'=>Yii::t('app','Location'),'icon'=> TbHtml::ICON_MAP_MARKER, 'url'=>url('location/admin'), 'active'=>$this->id .'/'. $this->action->id=='location/admin','visible'=>ckacc('store.update')),
                array('label' => Yii::t('app', 'Shop Setting'), 'icon' => TbHtml::ICON_COG, 'url' => url('settings/index'),
                    'active' => $this->id == 'settings',
                    //'visible'=> Yii::app()->user->isAdmin
                ),
                //'visible'=>ckacc('store.update')),
                //array('label'=>Yii::t('app','Branch'),'icon'=> TbHtml::ICON_HOME, 'url'=>url('store/admin'), 'active'=>$this->id .'/'. $this->action->id=='store/admin','visible'=>ckacc('store.update')),
                //array('label'=>Yii::t('app','Database Backup'),'icon'=> TbHtml::ICON_HDD, 'url'=>url('backup/default/index'),'active'=> $this->id =='default'),
            )),
        array('label' =>  '<span class="menu-text">'  . sysMenuAuthorization() . '</span>',
            'icon' => sysMenuAuthorizationIcon(),
            'active' => $this->id == 'assignment' || $this->id == 'role' || $this->id == 'operation' || $this->id == 'task',
            'visible' => Yii::app()->user->isAdmin,
            'items' => array(
                array(
                    'label' => Yii::t('app', 'Assignments'),
                    'url' => array('/auth/assignment/index'),
                    'active' => $this->id . '/' . $this->action->id== 'assignment/index',
                ),
                array(
                    'label' => 'Role',
                    'url' => array('/auth/role/index'),
                    'active' => $this->id . '/' . $this->action->id== 'role/index',
                ),
                array(
                    'label' => 'Task',
                    'url' => array('/auth/task/index'),
                    'active' => $this->id . '/' . $this->action->id== 'task/index',
                ),
                array(
                    'label' => 'Operation',
                    'url' => array('/auth/operation/index'),
                    'active' => $this->id . '/' . $this->action->id== 'operation/index',
                ),
            )
        ),
        array('label' => '<span class="menu-text">' . sysMenuAboutUS() . '</span>',
            'icon' => 'menu-icon fa fa-info-circle',
            'url' => url('site/about'),
            'active' => $this->id . '/' . $this->action->id == 'site/about',
        ),
    ),
));
?>

<!-- #section:basics/sidebar.layout.minimize -->
<div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
    <i class="ace-icon fa fa-angle-double-left" data-icon1="ace-icon fa fa-angle-double-left"
       data-icon2="ace-icon fa fa-angle-double-right"></i>
</div>

<!-- /section:basics/sidebar.layout.minimize -->
<script type="text/javascript">
    try {
        ace.settings.check('sidebar', 'collapsed')
    } catch (e) {
    }
</script>