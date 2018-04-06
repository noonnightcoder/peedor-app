<?php

// this contains the application parameters that can be maintained via GUI
return array(
    // this is used in contact page
    'adminEmail' => 'support@peedor.com',
    'sale_cancel_status' => '0', // Sale Reject
    'sale_complete_status' => '1', // Sale Order Complete - When all details are entered and no further changes are required.
    'sale_submit_status' => '2', // Sale Order Submit For Approval - stock mark as allocated for this order
    'sale_approve_status' => '3', // Sale Order Approved
    'sale_reject_status' => '-3', // Sale Order Rejected
    'sale_confirm_status' => '4', // Sale Order Confirmed by Account / Finance team - Ready to delivery
    'sale_do_status' => '5', // Print Delivery Note
    'sale_print_status' => '6', // Print / Reprint Invoice
    'active_status' => '1',
    'inactive_status' => '0',
    'defaultArchived' => 'false',
    'biz_name' => 'peedor',
    'biz_title' => 'smart inventory system',
    // this is displayed in the header section
	'title' => 'Simply The Best',
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
    'company_slogan' => 'simply the best',
    'menu_dashboard' => 'dashboard',
    'menu_item' => 'item',
    'menu_item_add' => 'add item',
    'menu_item_add2' => 'add item 2',
    'menu_item_view' => 'view items',
    'menu_item_imp_exp' => 'Import/Export',
    'menu_item_markup_price' => 'Markup Price Update',
    'menu_inventory' => 'inventory',
    'menu_inventory_count' => 'physical count',
    'menu_inventory_add' => 'in stock',
    'menu_inventory_minus' => 'out stock',
    'menu_inventory_transfer' => 'transfer stock',
    'menu_purchase' => 'purchase',
    'menu_purchase_receive' => 'receive from supplier',
    'menu_purchase_return' => 'return to supplier',
    'menu_purchase_payment' => 'supplier payment',
    'menu_sale' => 'sale',
    'menu_sale_add' => 'add sale order',
    'menu_sale_view' => 'review sale order',
    'menu_sale_approve' => 'approve sale order',
    'menu_sale_payment' => 'payment',
    'menu_invoice' => 'invoice',
    'menu_report' => 'report',
    'menu_report_sale_invoice' => 'sale invoice',
    'menu_report_sale_daily' => 'sale daily',
    'menu_report_sale_hourly' => 'sale hourly',
    'menu_report_sale_summary' => 'sale summary',
    'menu_customer' => 'customer',
    'menu_employee' => 'employee',
    'menu_supplier' => 'supplier',
    'menu_setting' => 'setting',
    'menu_category' => 'category',
    'menu_price_tier' => 'price tier',
    'menu_authorization' => 'authorization',
    'menu_about_us' => 'about us',
);
