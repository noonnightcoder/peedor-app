<?php

// this contains the application parameters that can be maintained via GUI
return array(
    // this is used in contact page
    'adminEmail' => 'support@peedor.com',
    'sale_cancel_status' => '0', // Sale Reject
    'sale_complete_status' => '1', // Sale Invoice
    'sale_suspend_status' => '2', // Sale Order
    'active_status' => '1',
    'inactive_status' => '0',
    'defaultArchived' => 'false',
    'biz_name' => 'Peedor',
    // this is displayed in the header section
	'title'=>'Simply The Best',
	// number of posts displayed per page
	'postsPerPage'=>10,
	// maximum number of comments that can be displayed in recent comments portlet
	'recentCommentCount'=>10,
	// maximum number of tags that can be displayed in tag cloud portlet
	'tagCloudCount'=>20,
	// whether post comments need to be approved before published
	'commentNeedApproval'=>true,
	// the copyright information displayed in the footer section
	'copyrightInfo'=>'Copyright &copy; 2009 by My Company.',
    // Company Name
    'company_name' => 'Try Me',
    'company_slogan' => 'camera of your biz',
    'menu_dashboard' => 'dashboard',
    'menu_item' => 'item',
    'menu_item_add' => 'add item',
    'menu_item_view' => 'view items',
    'menu_item_imp_exp' => 'Import/Export',
    'menu_item_markup_price' => 'Markup Price Update',
    'menu_inventory' => 'inventory',
    'menu_inventory_count' => 'physical count',
    'menu_inventory_add' => 'add stock',
    'menu_inventory_minus' => 'minus stock',
    'menu_purchase' => 'purchase',
    'menu_purchase_receive' => 'receive from supplier',
    'menu_purchase_return' => 'return to supplier',
    'menu_sale' => 'sale order',
    'menu_sale_add' => 'add sale order',
    'menu_sale_view' => 'view sale order',
    'menu_invoice' => 'invoice',
    'menu_payment' => 'payment',
    'menu_report' => 'report',
    'menu_report_sale_invoice' => 'sale invoice',
    'menu_report_sale_daily' => 'sale daily',
    'menu_report_sale_hourly' => 'sale hourly',
    'menu_report_sale_summary' => 'sale summary',
);
