<?php
$this->widget('bootstrap.widgets.TbNav', array(
    'type' => TbHtml::NAV_TYPE_LIST,
    'submenuHtmlOptions' => array('class' => 'submenu'),
    'encodeLabel' => false,
    'items' => array(
        array('label' => '<span class="menu-text">' . sysMenuHome() . '</span>',
            'icon' => 'menu-icon '  . 'menu-icon ' . sysMenuHomeIcon(),
            'url' => url('site/home'),
            'active' => $this->id . '/' . $this->action->id == 'site/home' ? true : false,
            'visible' => ckacc('report.dashboard')
        ),
        array('label' => '<span class="menu-text">' . strtoupper(sysMenuDashboard()) . '</span>',
            'icon' => 'menu-icon '  . sysMenuDashboardIcon(),
            'url' => url('dashboard/view'),
            'active' => $this->id . '/' . $this->action->id == 'dashboard/view' ? true : false,
            'visible' => ckacc('report.dashboard')
        ),
        array('label' => '<span class="menu-text">' . strtoupper(sysMenuItem()) . '</span>',
            'icon' => 'menu-icon '  . sysMenuItemIcon(),
            'url' => url('item/admin'),
            'active' => $this->id == 'item' || $this->id == 'priceBook' || $this->id == 'category',
            'visible' => ckacc('item.read') || ckacc('category.read') || ckacc('pricebook.read'),
            'items' => array(
                array('label' => sysMenuItemAdd(),
                    'icon' => 'menu-icon '  . 'menu-icon fa fa-plus pink',
                    'url' => url('item/create'),
                    'active' => $this->id . '/' . $this->action->id == 'item/create',
                    'visible' => ckacc('item.create')),
                array('label' => sysMenuItemView(), 'icon' => 'menu-icon '  . 'menu-icon fa fa-eye pink',
                    'url' => url('item/admin'),
                    'active' => $this->id . '/' . $this->action->id == 'item/admin',
                    'visible' => ckacc('item.create') || ckacc('item.read') || ckacc('item.update') || ckacc('item.delete'),
                ),
                array('label' => sysMenuCategoryView(),
                    'icon' => 'menu-icon '  . 'menu-icon fa fa-plus pink',
                    'url' => url('category/admin'),
                    'active' => $this->id . '/' . $this->action->id == 'category/admin',
                    'visible' => ckacc('category.create') || ckacc('category.read') || ckacc('category.update') || ckacc('category.delete'),
                ),
                array('label' => sysMenuPriceBookView(),
                    'icon' => 'menu-icon '  . 'menu-icon fa fa-plus pink',
                    'url' => url('priceBook/index'),
                    'active' => $this->id . '/' . $this->action->id == 'priceBook/index',
                    'visible' => ckacc('pricebook.create') || ckacc('pricebook.read') || ckacc('pricebook.update') || ckacc('pricebook.delete'),
                ),
                array('label' => sysMenuItemFinder(),
                    'icon' => 'menu-icon '  . 'menu-icon fa fa-search pink',
                    'url' => url('Item/ItemFinder'),
                    'active' => $this->id . '/' . $this->action->id== 'item/ItemFinder',
                    'visible' => ckacc('item.create') || ckacc('item.read') || ckacc('item.update') || ckacc('item.delete'),
                ),
            ),
        ),
        array('label' => '<span class="menu-text">' . strtoupper(sysMenuInventory()) . '</span>',
            'icon' => 'menu-icon '  . sysMenuInventoryIcon(),
            //'url' => url('receivingItem/index'),
            'active' => $this->id . '/' . $this->action->id == 'receivingItem/index' || $this->id . '/' . $this->action->id == 'receivingItem/inventoryCountCreate',
            'visible' => ckacc('stockcount.read') || ckacc('stockcount.create') || ckacc('stockcount.update') || ckacc('stockcount.delete'),
            'items' => array(
                array('label' => sysMenuInventoryCount(),
                    'icon' => 'menu-icon '  . sysMenuInventoryCountIcon(),
                    'url' => url('receivingItem/index', array('trans_mode' => 'physical_count')),
                    'active' => $this->id . '/' . $this->action->id . '/' . Yii::app()->request->getQuery('trans_mode') == 'receivingItem/index/physical_count' || $this->id . '/' . $this->action->id == 'receivingItem/inventoryCountCreate',
                    'visible' => ckacc('stockcount.read') || ckacc('stockcount.create') || ckacc('stockcount.update') || ckacc('stockcount.delete')
                ),
            )),
        array('label' => '<span class="menu-text">' . strtoupper(sysMenuPurchase()) . '</span>',
            'icon' => 'menu-icon '  . sysMenuPurchaseIcon(),
            'url' => url('receivingItem/index'),
            'active' => $this->id . '/' . $this->action->id == 'receivingItem/index',
            'visible' => ckacc('purchasereceive.read') || ckacc('purchasereturn.read') || ckacc('purchase.update') || ckacc('purchase.delete') || ckacc('purchase.receive') || ckacc('purchase.return'),
            'items' => array(
                array('label' => sysMenuPurchaseReceive(),
                    'icon' => 'menu-icon '  . sysMenuPurchaseReceiveIcon(),
                    'url' => url('receivingItem/index', array('trans_mode' => 'receive')),
                    'active' => $this->id . '/' . $this->action->id . '/' . Yii::app()->request->getQuery('trans_mode') == 'receivingItem/index/receive',
                    'visible' => ckacc('purchasereceive.read')),
                array('label' => sysMenuPurchaseReturn(),
                    'icon' => 'menu-icon '  . sysMenuPurchaseReturnIcon(),
                    'url' => url('receivingItem/index', array('trans_mode' => 'return')), 'active' => $this->id . '/' . $this->action->id . '/' . Yii::app()->request->getQuery('trans_mode') == 'receivingItem/index/return',
                    'visible' => ckacc('purchasereturn.read')),
            )),
        array('label' => '<span class="menu-text">' . strtoupper(sysMenuSale()) . '</span>',
            'icon' => 'menu-icon '  . 'menu-icon ' . sysMenuSaleOrderIcon(),
            'url' => url('saleItem/list', array('status' => param('sale_submit_status'), 'user_id' => getEmployeeId())),
            'active' => $this->id == 'saleItem',
            'visible' => ckacc('sale.create') || ckacc('sale.read') || ckacc('sale.read.all') || ckacc('sale.update') || ckacc('sale.delete'),
                //ckacc('sale.edit') || ckacc('sale.discount') || ckacc('sale.editprice'),
            'items' => array(
                array('label' => sysMenuSaleOrderAdd(),
                    'icon' => 'menu-icon '  . sysMenuSaleAddIcon(),
                    'url' => url('saleItem/create'),
                    'active' => $this->id . '/' . $this->action->id == 'saleItem/create',
                    'visible' => ckacc('sale.create')
                ),
                array('label' => sysMenuSaleOrderToValidate(),
                    'icon' => 'menu-icon '  . sysMenuSaleOrderToValidateIcon(),
                    'url' => url('saleItem/list',array(
                            'status' => param('sale_submit_status'),
                            'user_id' => getEmployeeId(),
                            'title' => sysMenuSaleOrderToValidate(),
                    )),
                    'active' => $this->id . '/' . $this->action->id . '/' . Yii::app()->request->getQuery('status') == 'saleItem/list/' .  param('sale_submit_status'),
                    'visible' => ckacc('sale.validate')
                ),
                array('label' => sysMenuSaleOrderToInvoice(),
                    'icon' => 'menu-icon '  . sysMenuSaleOrderInvoiceIcon(),
                    'url' => url('saleItem/list',array(
                        'status' => param('sale_validate_status'),
                        'user_id' => getEmployeeId(),
                        'title' => sysMenuSaleOrderToInvoice(),
                    )),
                    //'active' => $this->id . '/' . $this->action->id == 'saleItem/approve',
                    'active' => $this->id . '/' . $this->action->id . '/' . Yii::app()->request->getQuery('status') == 'saleItem/list/' .  param('sale_validate_status'),
                    'visible' => ckacc('sale.approve')
                ),
                array('label' => sysMenuSaleOrderToDeliver(),
                    'icon' => 'menu-icon '  . sysMenuSaleOrderToDeliverIcon(),
                    'url' => url('saleItem/list',array(
                        'status' => param('sale_complete_status'),
                        'user_id' => getEmployeeId(),
                        'title' => sysMenuSaleOrderToDeliver(),
                    )),
                    'active' => $this->id . '/' . $this->action->id . '/' . Yii::app()->request->getQuery('status') == 'saleItem/list/' .  param('sale_complete_status'),
                    //'active' => $this->id . '/' . $this->action->id == 'saleItem/approve',
                    'visible' => ckacc('shipmentorder.read') || ckacc('shipmentorder.create') || ckacc('shipmentorder.update') || ckacc('shipmentorder.delete')
                ),
            ),
        ),
        array('label' => '<span class="menu-text">' . strtoupper(sysMenuSalePayment()) . '</span>',
            'icon' => 'menu-icon '  . sysMenuSalePaymentIcon(),
            'url' => url('salePayment/index'),
            'active' => $this->id . '/' . $this->action->id == 'salePayment/index',
            'visible' => ckacc('customerpayment.read') || ckacc('customerpayment.create') || ckacc('customerpayment.update')
        ),
        array('label' => '<span class="menu-text">' . strtoupper(sysMenuPurchasePayment()) . '</span>',
            'icon' => 'menu-icon '  . sysMenuPurchasePaymentIcon(),
            'url' => url('receivingPayment/index'),
            'active' => $this->id . '/' . $this->action->id == 'receivingPayment/index',
            'visible' => ckacc('purchase.payment')),
        array('label' => '<span class="menu-text">' . sysMenuReport() . '</span>',
            'icon' => 'menu-icon '  . sysMenuReportIcon(),
            //'url' => url('report/reporttab'),
            'active' => $this->id == 'report',
            'visible' => ckacc('report.sale') || ckacc('report.sale.analytic') || ckacc('report.stock') || ckacc('report.customer') || ckacc('report.marketing') || ckacc('report.accounting'),
            'items' => array(
                array('label' => Yii::t('app', 'Sale Invoice'),
                    'icon' => 'menu-icon '  . sysMenuReportSaleIcon(),
                    'url' => url('report/SaleInvoice'),
                    'active' => $this->id . '/' . $this->action->id == 'report/SaleInvoice',
                    //'visible' => ckacc('invoice.index') || ckacc('invoice.print') || ckacc('invoice.delete') || ckacc('invoice.update')
                    'visible' => ckacc('report.sale')
                ),
                array('label' => Yii::t('app', 'Sale Daily'),
                    'icon' => 'menu-icon '  . sysMenuReportSaleIcon(),
                    'url' => url('report/SaleDaily'),
                    'active' => $this->id . '/' . $this->action->id == 'report/SaleDaily',
                    'visible' => ckacc('report.sale')
                ),
                array('label' => Yii::t('app', 'Sale Hourly'),
                    'icon' => 'menu-icon '  . sysMenuReportSaleIcon(),
                    'url' => url('report/SaleHourly'),
                    'active' => $this->id . '/' . $this->action->id == 'report/SaleHourly',
                    'visible' => ckacc('report.sale')
                ),
                array('label' => Yii::t('app', 'Sale Summary'),
                    'icon' => 'menu-icon '  . sysMenuReportSaleIcon(),
                    'url' => url('report/SaleSummary'),
                    'active' => $this->id . '/' . $this->action->id == 'report/SaleSummary',
                    'visible' => ckacc('report.sale')
                ),
                array('label' => Yii::t('app', 'Sale By Sale Rep'),
                    'icon' => 'menu-icon '  . sysMenuReportSaleIcon(),
                    'url' => url('report/SaleSumBySaleRep'),
                    'active' => $this->id . '/' . $this->action->id == 'report/SaleSumBySaleRep',
                    'visible' => ckacc('report.sale')
                ),
                array('label' => Yii::t('app', 'Sale Weekly By Customer'),
                    'icon' => 'menu-icon '  . sysMenuReportSaleIcon(),
                    'url' => url('report/SaleWeeklyByCustomer'),
                    'active' => $this->id . '/' . $this->action->id == 'report/SaleWeeklyByCustomer',
                    'visible' => ckacc('report.sale.analytic')
                ),
                array('label' => Yii::t('app', 'Sale Item Summary'),
                    'icon' => 'menu-icon '  . sysMenuReportSaleIcon(),
                    'url' => url('report/SaleItemSummary'),
                    'active' => $this->id . '/' . $this->action->id == 'report/SaleItemSummary',
                    'visible' => ckacc('report.sale')
                ),
                array('label' => Yii::t('app', 'Outstanding Balance'),
                    'icon' => 'menu-icon '  . sysMenuReportSaleIcon(),
                    'url' => url('report/outstandingInvoice'),
                    'active' => $this->id . '/' . $this->action->id == 'report/outstandingInvoice',
                    'visible' => ckacc('report.customer')
                ),
                array('label' => Yii::t('app', 'Profit Daily Sum'),
                    'icon' => 'menu-icon '  . sysMenuReportAccountIcon(),
                    'url' => url('report/ProfitDailySum'),
                    'active' => $this->id . '/' . $this->action->id == 'report/ProfitDailySum',
                    'visible' => ckacc('report.accounting')
                ),
                array('label' => Yii::t('app', 'Payment Receive'),
                    'icon' => 'menu-icon '  . sysMenuReportAccountIcon(),
                    'url' => url('report/PaymentReceiveByEmployee'),
                    'active' => $this->id . '/' . $this->action->id == 'report/PaymentReceiveByEmployee',
                    'visible' => ckacc('report.accounting')
                ),
                array('label' => Yii::t('app', 'Best Selling Item'),
                    'icon' => 'menu-icon '  . 'menu-icon fa fa-trophy',
                    'url' => url('report/TopItem'),
                    'active' => $this->id . '/' . $this->action->id == 'report/TopItem',
                    'visible' => ckacc('report.sale')
                ),
                array('label' => Yii::t('app', 'Item Expiry'),
                    'icon' => 'menu-icon '  .  'menu-icon fa fa-calendar-times-o',
                    'url' => url('report/itemExpiry'),
                    'active' => $this->id . '/' . $this->action->id == 'report/itemExpiry',
                    'visible' => ckacc('report.stock')
                ),
                array('label' => Yii::t('app', 'Inventory'),
                    'icon' => 'menu-icon '  . sysMenuReportStockIcon(),
                    'url' => url('report/Inventory'),
                    'active' => $this->id . '/' . $this->action->id == 'report/Inventory',
                    'visible' => ckacc('report.stock')
                ),
                array('label' => Yii::t('app', 'Transaction'),
                    'icon' => 'menu-icon '  . 'menu-icon fa fa-caret-right',
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
                array('label' => Yii::t('app', 'User Log Summary'), 'icon' => 'menu-icon '  . 'menu-icon fa fa-caret-right', 'url' => url('report/UserLogSummary'),
                    'active' => $this->id . '/' . $this->action->id == 'report/UserLogSummary',
                    'visible' => Yii::app()->user->isAdmin,
                ),
            )),
        array('label' => '<span class="menu-text">' . strtoupper(Yii::t('app', 'PIM')) . '</span>',
            'icon' => 'menu-icon '  . 'menu-icon fa fa-group',
            'url' => url('client/admin'),
            'active' => $this->id == 'employee' || $this->id == 'supplier' || $this->id == 'client' || $this->id == 'publisher',
            'visible' => ckacc('customer.read') || ckacc('supplier.read') || ckacc('employee.read'),
            'items' => array(
                array('label' => sysMenuCustomer(),
                    'icon' => 'menu-icon '  . sysMenuCustomerIcon(),
                    'url' => url('client/admin'),
                    'active' => $this->id == 'client',
                    'visible' => ckacc('customer.read') || ckacc('customer.create') || ckacc('customer.update') || ckacc('client.delete')
                ),
                array('label' => sysMenuEmployee(),
                    'icon' => 'menu-icon '  . sysMenuEmployeeIcon(),
                    'url' => url('employee/admin'),
                    'active' => $this->id == 'employee',
                    'visible' => ckacc('employee.read') || ckacc('employee.create') || ckacc('employee.update') || ckacc('employee.delete')
                ),
                array('label' => sysMenuSupplier(),
                    'icon' => 'menu-icon '  . sysMenuSupplierIcon(),
                    'url' => url('supplier/admin'),
                    'active' => $this->id == 'supplier',
                    'visible' => ckacc('supplier.read') || ckacc('supplier.create') || ckacc('supplier.update') || ckacc('supplier.delete')
                ),
            )),
        array('label' => '<span class="menu-text">' . sysMenuSetting() . '</span>',
            'icon' => 'menu-icon '  . sysMenuSettingIcon(),
            'url' => url('settings/index'),
            'active' => strtolower($this->id) == 'default' || $this->id == 'store' || $this->id == 'settings' || $this->id == 'outlet' || $this->id == 'user' || $this->id == 'tax' || $this->id == 'role' || $this->id == 'employee' ,
            'visible' => ckacc('setting.outlet') || ckacc('setting.tax') || ckacc('setting.user'),
            'items' => array(
                array('label' => sysMenuPriceTier(),
                    'icon' => 'menu-icon '  . sysMenuPriceTierIcon(),
                    'url' => url('priceTier/admin'),
                    'active' => $this->id . '/' . $this->action->id == 'priceTier/admin',
                    'visible' => ckacc('store.update')),
                //array('label'=>Yii::t('app','Location'),'icon'=> TbHtml::ICON_MAP_MARKER, 'url'=>url('location/admin'), 'active'=>$this->id .'/'. $this->action->id=='location/admin','visible'=>ckacc('store.update')),
                array('label' => Yii::t('app', 'Outlet'),
                    'icon' => 'menu-icon '  . 'fa fa-building',
                    'url' => url('outlet/admin'),
                    'active' => $this->id == 'outlet',
                ),
                array('label' => Yii::t('app', 'Tax'),
                    'icon' => 'menu-icon '  . 'fa fa-taxi',
                    'url' => url('tax/admin'),
                    'active' => $this->id == 'tax',
                ),
                /*
                array('label' => Yii::t('app', 'User'),
                    'icon' => 'menu-icon '  . TbHtml::ICON_USER,
                    'url' => url('user/admin'),
                    'active' => $this->id == 'user',
                ),
                array('label' => Yii::t('app', 'Role'),
                    'icon' => 'menu-icon '  . 'fa fa-user-circle-o',
                    'url' => url('role/admin'),
                    'active' => $this->id == 'role',
                ),
                */
                array('label' => Yii::t('app', 'Shop Setting'), 'icon' => 'menu-icon '  . TbHtml::ICON_COG, 'url' => url('settings/index'),
                    'active' => $this->id == 'settings',
                    //'visible'=> Yii::app()->user->isAdmin
                ),
                //'visible'=>ckacc('store.update')),
                //array('label'=>Yii::t('app','Branch'),'icon'=> TbHtml::ICON_HOME, 'url'=>url('store/admin'), 'active'=>$this->id .'/'. $this->action->id=='store/admin','visible'=>ckacc('store.update')),
                //array('label'=>Yii::t('app','Database Backup'),'icon'=> TbHtml::ICON_HDD, 'url'=>url('backup/default/index'),'active'=> $this->id =='default'),
            )),
        array('label' =>  '<span class="menu-text">'  . sysMenuAuthorization() . '</span>',
            'icon' => 'menu-icon '  . sysMenuAuthorizationIcon(),
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
            'icon' => 'menu-icon '  . 'menu-icon fa fa-info-circle',
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