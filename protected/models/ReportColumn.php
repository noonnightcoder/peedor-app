<?php

class ReportColumn extends CModel
{

    public function attributeNames()
    {
        return array(
            'id',
            'sale_id',
            'sale_time',
            'date_report',
            'sub_total',
            'discount_amount',
            'vat_amount',
            'total',
            'cross_profit',
            'profit',
            'margin',
        );
    }

    /**
     * Helper function to get example grid columns
     * @return array
     */
    public static function getSaleInvoiceColumns()
    {
        return array(
            array('name' => 'sale_id',
                'header' => Yii::t('app', 'Invoice ID'),
                'value' => '$data["sale_id"]',
                'class' => 'yiiwheels.widgets.grid.WhRelationalColumn',
                'url' => Yii::app()->createUrl('Report/saleInvoiceDetail'),
            ),
            array('name' => 'new_sale_id',
                'header' => Yii::t('app', 'New Invoice ID'),
                'value' => 'invNumPrefix() . $data["new_sale_id"]',
                //'class' => 'yiiwheels.widgets.grid.WhRelationalColumn',
                //'url' => Yii::app()->createUrl('Report/saleInvoiceDetail'),
            ),
            array('name' => 'sale_time',
                'header' => Yii::t('app', 'Sale Time'),
                'value' => '$data["sale_time"]',
            ),
            array('name' => 'client_name',
                'header' => Yii::t('app', 'Sold To'),
                'value' => '$data["client_name"]',
            ),
            array('name' => 'employee_id',
                'header' => Yii::t('app', 'Sold By'),
                'value' => '$data["employee_name"]',
            ),
            array('name' => 'quantity',
                'header' => Yii::t('app', 'QTY'),
                'value' => 'number_format($data["quantity"],Common::getDecimalPlace(), ".", ",")',
                'htmlOptions' => array('style' => 'text-align: right;'),
                'headerHtmlOptions' => array('style' => 'text-align: right;'),
            ),
            array('name' => 'sub_total',
                'header' => Yii::t('app', 'Sub Total'),
                'value' => 'number_format($data["sub_total"],Common::getDecimalPlace(), ".", ",")',
                'htmlOptions' => array('style' => 'text-align: right;'),
                'headerHtmlOptions' => array('style' => 'text-align: right;'),
            ),
            array('name' => 'discount',
                'header' => Yii::t('app', 'Discount'),
                'value' => 'number_format($data["discount_amount"],Common::getDecimalPlace(), ".", ",")',
                'htmlOptions' => array('style' => 'text-align: right;'),
                'headerHtmlOptions' => array('style' => 'text-align: right;'),
            ),
            array('name' => 'total',
                'header' => Yii::t('app', 'Total'),
                'value' => 'number_format($data["total"],Common::getDecimalPlace(), ".", ",")',
                'htmlOptions' => array('style' => 'text-align: right;'),
                'headerHtmlOptions' => array('style' => 'text-align: right;'),
            ),
            array('name' => 'paid',
                'header' => Yii::t('app', 'Paid'),
                'value' => 'number_format($data["paid"],Common::getDecimalPlace(), ".", ",")',
                'htmlOptions' => array('style' => 'text-align: right;'),
                'headerHtmlOptions' => array('style' => 'text-align: right;'),
            ),
            array('name' => 'balance',
                'header' => Yii::t('app', 'Balance'),
                'value' => 'number_format($data["balance"],Common::getDecimalPlace(), ".", ",")',
                'htmlOptions' => array('style' => 'text-align: right;'),
                'headerHtmlOptions' => array('style' => 'text-align: right;'),
            ),
            array('name' => 'status',
                'header' => Yii::t('app', 'Status'),
                'value' => '$data["status_f"]',
            ),
            array('class' => 'bootstrap.widgets.TbButtonColumn',
                //'header'=>'Invoice Detail',
                'template' => '<div class="btn-group">{view}{print}{cancel}{edit}</div>',
                'buttons' => array(
                    'view' => array(
                        'click' => 'updateDialogOpen',
                        'label' => 'Detail',
                        'url' => 'Yii::app()->createUrl("report/SaleInvoiceItem", array("sale_id"=>$data["sale_id"],"employee_id"=>$data["employee_name"]))',
                        'options' => array(
                            'data-update-dialog-title' => Yii::t('app', 'Invoice Detail'),
                            'title' => Yii::t('app', 'Invoice Detail'),
                            'class' => 'btn btn-xs btn-info',
                            'id' => uniqid(),
                            'on' => false,
                        ),
                    ),
                    'print' => array(
                        'label' => 'print',
                        'icon' => 'glyphicon-print',
                        'url' => 'Yii::app()->createUrl("saleItem/Receipt", array("sale_id"=>$data["sale_id"],"print"=>"true"))',
                        'options' => array(
                            'target' => '_blank',
                            'title' => Yii::t('app', 'Invoice Printing'),
                            'class' => 'btn btn-xs btn-success',
                        ),
                        'visible' => 'Yii::app()->user->checkAccess("invoice.print")',
                    ),
                    'cancel' => array(
                        'label' => 'cancel',
                        'icon' => 'glyphicon-trash',
                        'url' => 'Yii::app()->createUrl("sale/delete", array("sale_id"=>$data["sale_id"], "customer_id"=>$data["client_id"]))',
                        'options' => array(
                            'title' => Yii::t('app', 'Cancel Invoice'),
                            'class' => 'btnCancelInvoice btn btn-xs btn-danger',
                        ),
                        'visible' => '$data["status"]=="1" && Yii::app()->user->checkAccess("invoice.delete")',
                    ),
                    'edit' => array(
                        'label' => 'edit',
                        'icon' => 'glyphicon-edit',
                        'url' => 'Yii::app()->createUrl("SaleItem/EditSale", array(
                            "sale_id"=>$data["sale_id"],
                            "customer_id" => $data["client_name"],
                            "paid_amount"=>$data["paid"]
                        ))',
                        'options' => array(
                            'title' => Yii::t('app', 'Edit Invoice'),
                            'class' => 'btn btn-xs btn-warning',
                        ),
                        'visible' => '$data["status"]=="1" && Yii::app()->user->checkAccess("invoice.update")',
                    ),
                ),
            ),
        );
    }

    public static function getSaleInvoiceDetailColumns()
    {
        return array(
            array('name' => 'name',
                'header' => Yii::t('app', 'Item Name'),
                'value' => '$data["name"]',
            ),
            array('name' => 'quantity',
                'header' => Yii::t('app', 'QTY'),
                'value' => 'number_format($data["quantity"],Common::getDecimalPlace(), ".", ",")',
                'htmlOptions' => array('style' => 'text-align: right;'),
                'headerHtmlOptions' => array('style' => 'text-align: right;'),
            ),
            array('name' => 'price',
                'header' => Yii::t('app', 'Price'),
                'value' => 'number_format($data["price"],Common::getDecimalPlace(), ".", ",")',
                'htmlOptions' => array('style' => 'text-align: right;'),
                'headerHtmlOptions' => array('style' => 'text-align: right;'),
            ),
            array('name' => 'sub_total',
                'header' => Yii::t('app', 'Sub Total'),
                'value' => 'number_format($data["sub_total"],Common::getDecimalPlace(), ".", ",")',
                'htmlOptions' => array('style' => 'text-align: right;'),
                'headerHtmlOptions' => array('style' => 'text-align: right;'),
            ),
        );
    }

    public static function getSaleDailyColumns()
    {
        return array(
            array('name' => 'date',
                'header' => Yii::t('app', 'Date'),
                'value' => '$data["date_report"]',
            ),
            array('name' => 'quantity',
                'header' => Yii::t('app', 'QTY'),
                'htmlOptions' => array('style' => 'text-align: right;'),
                'headerHtmlOptions' => array('style' => 'text-align: right;'),
                'value' => 'number_format($data["quantity"],Common::getDecimalPlace(), ".", ",")',
                //'footer'=>number_format($report->saleDailyTotals()[0],Common::getDecimalPlace(), ".", ","),
                //'footerHtmlOptions'=>array('style' => 'text-align: right;'),
            ),
            array('name' => 'sub_total',
                'header' => Yii::t('app', 'Sub Total'),
                'htmlOptions' => array('style' => 'text-align: right;'),
                'headerHtmlOptions' => array('style' => 'text-align: right;'),
                'value' => 'number_format($data["sub_total"],Common::getDecimalPlace(), ".", ",")',
            ),
            array('name' => 'discount',
                'header' => Yii::t('app', 'Discount'),
                'htmlOptions' => array('style' => 'text-align: right;'),
                'headerHtmlOptions' => array('style' => 'text-align: right;'),
                'value' => 'number_format($data["discount_amount"],Common::getDecimalPlace(), ".", ",")',
            ),
            array('name' => 'vat',
                'header' => Yii::t('app', 'VAT'),
                'htmlOptions' => array('style' => 'text-align: right;'),
                'headerHtmlOptions' => array('style' => 'text-align: right;'),
                'value' => 'number_format($data["vat_amount"],Common::getDecimalPlace(), ".", ",")',
            ),
            array('name' => 'total',
                'header' => Yii::t('app', 'Total'),
                'htmlOptions' => array('style' => 'text-align: right;'),
                'headerHtmlOptions' => array('style' => 'text-align: right;'),
                'value' => 'number_format($data["total"],Common::getDecimalPlace(), ".", ",")',
                //'footer'=>Yii::app()->settings->get('site', 'currencySymbol') . number_format($report->saleDailyTotals()[3],Common::getDecimalPlace(), ".", ","),
                //'footerHtmlOptions'=>array('style' => 'text-align: right;'),
            ),
        );
    }

    public static function getSaleHourlyColumns()
    {
        return array(
            array('name' => 'hours',
                'header' => Yii::t('app', 'Hour'),
                'value' => '$data["hours"]'
            ),
            array('name' => 'qty',
                'header' => Yii::t('app', 'Quantity'),
                'value' => 'number_format($data["qty"],Common::getDecimalPlace(), ".", ",")',
            ),
            array('name' => 'amount',
                'header' => Yii::t('app', 'Amount'),
                'value' => 'number_format($data["amount"],Common::getDecimalPlace(), ".", ",")',
            ),
        );
    }

    public static function getSaleSummaryColumns()
    {
        return array(
            array('name' => 'no_of_invoice',
                'header' => Yii::t('app', 'No. of Invoices'),
                'value' => '$data["no_of_invoice"]',
                'headerHtmlOptions' => array('style' => 'text-align: right;'),
                'htmlOptions' => array('style' => 'text-align: right;'),
            ),
            array('name' => 'quantity',
                'header' => Yii::t('app', 'Quantity Sold'),
                'value' => 'number_format($data["quantity"],Common::getDecimalPlace(), ".", ",")',
                'htmlOptions' => array('style' => 'text-align: right;'),
                'headerHtmlOptions' => array('style' => 'text-align: right;'),
            ),
            array('name' => 'sub_total',
                'header' => Yii::t('app', 'Sub Total'),
                'value' => 'number_format($data["sub_total"],Common::getDecimalPlace(), ".", ",")',
                'htmlOptions' => array('style' => 'text-align: right;'),
                'headerHtmlOptions' => array('style' => 'text-align: right;'),
            ),
            array('name' => 'discount',
                'header' => Yii::t('app', 'Discount'),
                'value' => 'number_format($data["discount_amount"],Common::getDecimalPlace(), ".", ",")',
                'htmlOptions' => array('style' => 'text-align: right;'),
                'headerHtmlOptions' => array('style' => 'text-align: right;'),
            ),
            array('name' => 'total',
                'header' => Yii::t('app', 'Total'),
                'value' => 'number_format($data["total"],Common::getDecimalPlace(), ".", ",")',
                'htmlOptions' => array('style' => 'text-align: right;'),
                'headerHtmlOptions' => array('style' => 'text-align: right;'),
            ),
        );
    }

    public static function getSaleSumBySaleRepColumns()
    {
        return array(
            array(
                'name' => 'sale_rep',
                'header' => Yii::t('app', 'Sale Rep'),
                'value' => '$data["sale_rep"]',
                'headerHtmlOptions' => array('style' => 'text-align: right;'),
                'htmlOptions' => array('style' => 'text-align: right;'),
            ),
            array(
                'name' => 'no_of_invoice',
                'header' => Yii::t('app', 'No. of Invoices'),
                'value' => '$data["no_of_invoice"]',
                'headerHtmlOptions' => array('style' => 'text-align: right;'),
                'htmlOptions' => array('style' => 'text-align: right;'),
            ),
            array(
                'name' => 'quantity',
                'header' => Yii::t('app', 'Quantity Sold'),
                'value' => 'number_format($data["quantity"],Common::getDecimalPlace(), ".", ",")',
                'htmlOptions' => array('style' => 'text-align: right;'),
                'headerHtmlOptions' => array('style' => 'text-align: right;'),
            ),
            array(
                'name' => 'sub_total',
                'header' => Yii::t('app', 'Sub Total'),
                'value' => 'number_format($data["sub_total"],Common::getDecimalPlace(), ".", ",")',
                'htmlOptions' => array('style' => 'text-align: right;'),
                'headerHtmlOptions' => array('style' => 'text-align: right;'),
            ),
            array(
                'name' => 'discount',
                'header' => Yii::t('app', 'Discount'),
                'value' => 'number_format($data["discount_amount"],Common::getDecimalPlace(), ".", ",")',
                'htmlOptions' => array('style' => 'text-align: right;'),
                'headerHtmlOptions' => array('style' => 'text-align: right;'),
            ),
            array(
                'name' => 'total',
                'header' => Yii::t('app', 'Total'),
                'value' => 'number_format($data["total"],Common::getDecimalPlace(), ".", ",")',
                'htmlOptions' => array('style' => 'text-align: right;'),
                'headerHtmlOptions' => array('style' => 'text-align: right;'),
            ),
        );
    }

    public static function getOutStandingInvoiceColumns()
    {
        return array(
            array(
                'name' => 'client_name',
                'header' => Yii::t('app', 'Customer Name'),
                'value' => '$data["client_name"]',
            ),
            array(
                'name' => 'invoices',
                'header' => Yii::t('app', 'Num of Invoices'),
                'value' => '$data["invoices"]',
                'htmlOptions' => array('style' => 'text-align: right;'),
                'headerHtmlOptions' => array('style' => 'text-align: right;'),
            ),
            array(
                'name' => 'balance',
                'header' => Yii::t('app', 'Outstanding Balance'),
                'value' => 'number_format($data["balance"],Common::getDecimalPlace(), ".", ",")',
                'htmlOptions' => array('style' => 'text-align: right;'),
                'headerHtmlOptions' => array('style' => 'text-align: right;'),
            ),
            array(
                'name' => 'last_payment',
                'header' => Yii::t('app', 'Last Payment'),
                'value' => '$data["last_payment"]',
                'htmlOptions' => array('style' => 'text-align: right;'),
                'headerHtmlOptions' => array('style' => 'text-align: right;'),
            ),
            array(
                'name' => 'days',
                'header' => Yii::t('app', 'Last Payment # Days'),
                'value' => '$data["days"]',
                'htmlOptions' => array('style' => 'text-align: right;'),
                'headerHtmlOptions' => array('style' => 'text-align: right;'),
            ),
        );
    }

    public static function getProfitDailyColumns()
    {
        return array(
            array('name' => 'date_report',
                'header' => Yii::t('app', 'Date'),
                'value' => '$data["date_report"]',
                'class' => 'yiiwheels.widgets.grid.WhRelationalColumn',
                'url' => Yii::app()->createUrl('Report/ProfitByInvoice'),
            ),
            array('name' => 'sub_total',
                'header' => Yii::t('app', 'Sub Total'),
                'value' => 'number_format($data["sub_total"],Common::getDecimalPlace(), ".", ",")',
                'htmlOptions' => array('style' => 'text-align: right;'),
                'headerHtmlOptions' => array('style' => 'text-align: right;'),
            ),
            array('name' => 'discount_amount',
                'header' => Yii::t('app', 'Discount Amount'),
                'value' => 'number_format($data["discount_amount"],Common::getDecimalPlace(), ".", ",")',
                'htmlOptions' => array('style' => 'text-align: right;'),
                'headerHtmlOptions' => array('style' => 'text-align: right;'),
            ),
            array('name' => 'vat_amount',
                'header' => Yii::t('app', 'VAT Amount'),
                'value' => 'number_format($data["vat_amount"],Common::getDecimalPlace(), ".", ",")',
                'htmlOptions' => array('style' => 'text-align: right;'),
                'headerHtmlOptions' => array('style' => 'text-align: right;'),
            ),
            array('name' => 'total',
                'header' => Yii::t('app', 'Total'),
                'value' => 'number_format($data["total"],Common::getDecimalPlace(), ".", ",")',
                'htmlOptions' => array('style' => 'text-align: right;'),
                'headerHtmlOptions' => array('style' => 'text-align: right;'),
            ),
            array('name' => 'cross_profit',
                'header' => Yii::t('app', 'Cross Profit'),
                'htmlOptions' => array('style' => 'text-align: right;'),
                'headerHtmlOptions' => array('style' => 'text-align: right;'),
                'value' => 'number_format($data["cross_profit"],Common::getDecimalPlace(), ".", ",")',
            ),
            array('name' => 'profit',
                'header' => Yii::t('app', 'Net Profit'),
                'htmlOptions' => array('style' => 'text-align: right;'),
                'headerHtmlOptions' => array('style' => 'text-align: right;'),
                'value' => 'number_format($data["profit"],Common::getDecimalPlace(), ".", ",")',
            ),
            array('name' => 'margin',
                'header' => Yii::t('app', 'Margin'),
                'htmlOptions' => array('style' => 'text-align: right;'),
                'headerHtmlOptions' => array('style' => 'text-align: right;'),
                'value' => '$data["margin"] . "%"',
            ),
        );
    }

    public static function getProfitByInvoiceColumns()
    {
        return array(
            array('name' => 'sale_id',
                'header' => Yii::t('app', 'Invoice ID'),
                'value' => '$data["sale_id"]',
            ),
            array('name' => 'date_report',
                'header' => Yii::t('app', 'Date'),
                'value' => '$data["date_report"]',
            ),
            array('name' => 'sub_total',
                'header' => Yii::t('app', 'Sub Total'),
                'value' => 'number_format($data["sub_total"],Common::getDecimalPlace(), ".", ",")',
                'htmlOptions' => array('style' => 'text-align: right;'),
                'headerHtmlOptions' => array('style' => 'text-align: right;'),
            ),
            array('name' => 'discount_amount',
                'header' => Yii::t('app', 'Discount Amount'),
                'value' => 'number_format($data["discount_amount"],Common::getDecimalPlace(), ".", ",")',
                'htmlOptions' => array('style' => 'text-align: right;'),
                'headerHtmlOptions' => array('style' => 'text-align: right;'),
            ),
            array('name' => 'vat_amount',
                'header' => Yii::t('app', 'VAT Amount'),
                'value' => 'number_format($data["vat_amount"],Common::getDecimalPlace(), ".", ",")',
                'htmlOptions' => array('style' => 'text-align: right;'),
                'headerHtmlOptions' => array('style' => 'text-align: right;'),
            ),
            array('name' => 'total',
                'header' => Yii::t('app', 'Total'),
                'value' => 'number_format($data["total"],Common::getDecimalPlace(), ".", ",")',
                'htmlOptions' => array('style' => 'text-align: right;'),
                'headerHtmlOptions' => array('style' => 'text-align: right;'),
            ),
            array('name' => 'cross_profit',
                'header' => Yii::t('app', 'Cross Profit'),
                'htmlOptions' => array('style' => 'text-align: right;'),
                'headerHtmlOptions' => array('style' => 'text-align: right;'),
                'value' => 'number_format($data["cross_profit"],Common::getDecimalPlace(), ".", ",")',
            ),
            array('name' => 'profit',
                'header' => Yii::t('app', 'Net Profit'),
                'htmlOptions' => array('style' => 'text-align: right;'),
                'headerHtmlOptions' => array('style' => 'text-align: right;'),
                'value' => 'number_format($data["profit"],Common::getDecimalPlace(), ".", ",")',
            ),
            array('name' => 'margin',
                'header' => Yii::t('app', 'Margin'),
                'htmlOptions' => array('style' => 'text-align: right;'),
                'headerHtmlOptions' => array('style' => 'text-align: right;'),
                'value' => '$data["margin"] . "%"',
            ),
        );
    }

    public static function getTopItemColumns()
    {
        return array(
            array('name' => 'rank',
                'header' => Yii::t('app', 'Rank'),
                'value' => '$data["rank"]',
            ),
            array('name' => 'item_name',
                'header' => Yii::t('app', 'Item Name'),
                'value' => '$data["item_name"]',
            ),
            array('name' => 'qty',
                'header' => Yii::t('app', 'Quantity'),
                'value' => '$data["qty"]',
            ),
            array('name' => 'amount',
                'header' => Yii::t('app', 'Amount'),
                'value' => '$data["amount"]',
            ),
        );
    }

    public static function getSaleItemSummaryColumns()
    {
        return array(
            array('name' => 'item_name',
                'header' => Yii::t('app', 'Item Name'),
                'value' => '$data["item_name"]',
                'headerHtmlOptions' => array('style' => 'text-align: right;'),
                'htmlOptions' => array('style' => 'text-align: right;'),
            ),
            array('name' => 'date_report',
                'header' => Yii::t('app', 'Date'),
                'value' => '$data["date_report"]',
            ),
            array('name' => 'quantity',
                'header' => Yii::t('app', 'QTY'),
                'value' => 'number_format($data["quantity"],Common::getDecimalPlace(), ".", ",")',
                'htmlOptions' => array('style' => 'text-align: right;'),
                'headerHtmlOptions' => array('style' => 'text-align: right;'),
            ),
            array('name' => 'sub_total',
                'header' => Yii::t('app', 'Sub Total'),
                'value' => 'number_format($data["sub_total"],Common::getDecimalPlace(), ".", ",")',
                'htmlOptions' => array('style' => 'text-align: right;'),
                'headerHtmlOptions' => array('style' => 'text-align: right;'),
            ),
        );
    }

    public static function getItemExpiryColumns()
    {
        return array(
            array('name' => 'name',
                'header' => Yii::t('app', 'Item Name'),
                'value' => '$data["name"]'
            ),
            array('name' => 'quantity',
                'header' => Yii::t('app', 'Quantity'),
                'value' => '$data["quantity"]'
            ),
            array('name' => 'total_qty',
                'header' => Yii::t('app', 'Total Quantity'),
                'value' => '$data["total_qty"]'
            ),
            array(//'name'=>'month_expire',
                'header' => Yii::t('app', 'Expire on'),
                'value' => '$data["expire_date"]',
                'htmlOptions' => array('style' => 'text-align: right;'),
                'headerHtmlOptions' => array('style' => 'text-align: right;'),
            ),
            array('name' => 'n_month_expire',
                'header' => Yii::t('app', '# Months Expire'),
                'value' => '$data["n_month_expire"]',
                'htmlOptions' => array('style' => 'text-align: right;'),
                'headerHtmlOptions' => array('style' => 'text-align: right;'),
            ),
        );
    }

    public static function getItemExpiryHeaderTab($filter)
    {
        return array(
            array('label' => '1' . Yii::t('app', 'Month'), 'url' => Yii::app()->urlManager->createUrl('report/itemExpiry', array('filter' => '1')), 'active' => $filter == '1' ? true : false),
            array('label' => '2' . Yii::t('app', 'Months'), 'url' => Yii::app()->urlManager->createUrl('report/itemExpiry', array('filter' => '2')), 'active' => $filter == '2' ? true : false),
            array('label' => '3' . Yii::t('app', 'Months'), 'url' => Yii::app()->urlManager->createUrl('report/itemExpiry', array('filter' => '3')), 'active' => $filter == '3' ? true : false),
            array('label' => '6' . Yii::t('app', 'Months'), 'url' => Yii::app()->urlManager->createUrl('report/itemExpiry', array('filter' => '6')), 'active' => $filter == '6' ? true : false),
            array('label' => '12' . Yii::t('app', 'Months'), 'url' => Yii::app()->urlManager->createUrl('report/itemExpiry', array('filter' => '12')), 'active' => $filter == '13' ? true : false),
        );
    }

    public static function getInventoryColumns()
    {
        return array(
            array('name' => 'name',
                'header' => Yii::t('app', 'Item Name'),
                'value' => '$data["name"]',
            ),
            array('name' => 'category_name',
                'header' => Yii::t('app', 'Category Name'),
                'value' => '$data["category_name"]',
            ),
            array('name' => 'supplier',
                'header' => Yii::t('app', 'Supplier'),
                'value' => '$data["supplier"]',
            ),
            array('name' => 'unit_price',
                'header' => Yii::t('app', 'Retail Price'),
                'value' => '$data["unit_price"]',
                'htmlOptions' => array('style' => 'text-align: right;'),
                'headerHtmlOptions' => array('style' => 'text-align: right;'),
            ),
            array('name' => 'quantity',
                'header' => Yii::t('app', 'On Hand'),
                'htmlOptions' => array('style' => 'text-align: right;'),
                'headerHtmlOptions' => array('style' => 'text-align: right;'),
            ),
            array('name' => 'cost_price',
                'value' => '$data["cost_price"]',
                'header' => Yii::t('app', 'Average Cost'),
                'htmlOptions' => array('style' => 'text-align: right;'),
                'headerHtmlOptions' => array('style' => 'text-align: right;'),
            ),
            array('name' => 'reorder_level',
                'value' => '$data["reorder_level"]',
                'header' => Yii::t('app', 'Reorder Qty'),
                'htmlOptions' => array('style' => 'text-align: right;'),
                'headerHtmlOptions' => array('style' => 'text-align: right;'),
            )
        );
    }

    public static function getInventoryHeaderTab($filter)
    {
        return array(
            array('label' => Yii::t('app', 'All'), 'url' => Yii::app()->urlManager->createUrl('report/Inventory', array('filter' => 'all')), 'active' => true),
            array('label' => Yii::t('app', 'Low Inventory'), 'url' => Yii::app()->urlManager->createUrl('report/Inventory', array('filter' => 'low'))),
            array('label' => Yii::t('app', 'Out of Stock'), 'url' => Yii::app()->urlManager->createUrl('report/Inventory', array('filter' => 'outstock'))),
            array('label' => Yii::t('app', 'On Stock'), 'url' => Yii::app()->urlManager->createUrl('report/Inventory', array('filter' => 'onstock'))),
            array('label' => Yii::t('app', 'Negative Stock'), 'url' => Yii::app()->urlManager->createUrl('report/Inventory', array('filter' => 'negative'))),
        );
    }

    public static function getTransactionColumns()
    {
        return array(
            array('name' => 'no_of_invoice',
                'header' => Yii::t('app', 'No. of Invoices'),
                'value' => '$data["no_of_invoice"]',
                'headerHtmlOptions' => array('style' => 'text-align: right;'),
                'htmlOptions' => array('style' => 'text-align: right;'),
            ),
            array('name' => 'quantity',
                'header' => Yii::t('app', 'Quantity Sold'),
                'value' => 'number_format($data["quantity"],Common::getDecimalPlace(), ".", ",")',
                'htmlOptions' => array('style' => 'text-align: right;'),
                'headerHtmlOptions' => array('style' => 'text-align: right;'),
            ),
            array('name' => 'sub_total',
                'header' => Yii::t('app', 'Sub Total'),
                'value' => 'number_format($data["sub_total"],Common::getDecimalPlace(), ".", ",")',
                'htmlOptions' => array('style' => 'text-align: right;'),
                'headerHtmlOptions' => array('style' => 'text-align: right;'),
            ),
            array('name' => 'discount',
                'header' => Yii::t('app', 'Discount'),
                'value' => 'number_format($data["discount_amount"],Common::getDecimalPlace(), ".", ",")',
                'htmlOptions' => array('style' => 'text-align: right;'),
                'headerHtmlOptions' => array('style' => 'text-align: right;'),
            ),
            array('name' => 'total',
                'header' => Yii::t('app', 'Total'),
                'value' => 'number_format($data["total"],Common::getDecimalPlace(), ".", ",")',
                'htmlOptions' => array('style' => 'text-align: right;'),
                'headerHtmlOptions' => array('style' => 'text-align: right;'),
            ),
        );
    }

    public static function getPaymentReceiveByEmployeeColumns()
    {
        return array(
            array('name' => 'date_report',
                'header' => Yii::t('app', 'Date'),
                'value' => '$data["date_report"]',
            ),
            array('name' => 'employee_name',
                'header' => Yii::t('app', 'Employee'),
                'value' => '$data["employee_name"]',
            ),
            array('name' => 'payment_amount',
                'header' => Yii::t('app', 'Payment Amount'),
                'htmlOptions' => array('style' => 'text-align: right;'),
                'headerHtmlOptions' => array('style' => 'text-align: right;'),
                'value' => 'number_format($data["payment_amount"],Common::getDecimalPlace(), ".", ",")',
            ),
            array('name' => 'give_away',
                'header' => Yii::t('app', 'Give Away'),
                'htmlOptions' => array('style' => 'text-align: right;'),
                'headerHtmlOptions' => array('style' => 'text-align: right;'),
                'value' => 'number_format($data["give_away"],Common::getDecimalPlace(), ".", ",")',
            ),
        );
    }

    public static function getSaleWeeklyByCusotmer()
    {
        return array(
            array(
                'name' => 'client_name',
                'header' => Yii::t('app', 'Client'),
                'value' => '$data["client_name"]',
                'headerHtmlOptions' => array('style' => 'text-align: right;'),
                'htmlOptions' => array('style' => 'text-align: right;'),
            ),
            array(
                'name' => 'item_name',
                'header' => Yii::t('app', 'Item Name'),
                'headerHtmlOptions' => array('style' => 'text-align: right;'),
                'htmlOptions' => array('style' => 'text-align: right;'),
            ),
            array(
                'name' => '1',
                'htmlOptions' => array('style' => 'text-align: right;'),
                'headerHtmlOptions' => array('style' => 'text-align: right;'),
            ),
            array(
                'name' => '2',
                'htmlOptions' => array('style' => 'text-align: right;'),
                'headerHtmlOptions' => array('style' => 'text-align: right;'),
            ),
            array(
                'name' => '3',
                'htmlOptions' => array('style' => 'text-align: right;'),
                'headerHtmlOptions' => array('style' => 'text-align: right;'),
            ),
            array(
                'name' => '4',
                'htmlOptions' => array('style' => 'text-align: right;'),
                'headerHtmlOptions' => array('style' => 'text-align: right;'),
            ),
            array(
                'name' => '5',
                'htmlOptions' => array('style' => 'text-align: right;'),
                'headerHtmlOptions' => array('style' => 'text-align: right;'),
            ),
            array(
                'name' => '6',
                'htmlOptions' => array('style' => 'text-align: right;'),
                'headerHtmlOptions' => array('style' => 'text-align: right;'),
            ),
            array(
                'name' => '7',
                'htmlOptions' => array('style' => 'text-align: right;'),
                'headerHtmlOptions' => array('style' => 'text-align: right;'),
            ),
            array(
                'name' => '8',
                'htmlOptions' => array('style' => 'text-align: right;'),
                'headerHtmlOptions' => array('style' => 'text-align: right;'),
            ),
            array(
                'name' => '9',
                'htmlOptions' => array('style' => 'text-align: right;'),
                'headerHtmlOptions' => array('style' => 'text-align: right;'),
            ),
            array(
                'name' => '10',
                'htmlOptions' => array('style' => 'text-align: right;'),
                'headerHtmlOptions' => array('style' => 'text-align: right;'),
            ),
            array(
                'name' => '11',
                'htmlOptions' => array('style' => 'text-align: right;'),
                'headerHtmlOptions' => array('style' => 'text-align: right;'),
            ),
            array(
                'name' => '12',
                'htmlOptions' => array('style' => 'text-align: right;'),
                'headerHtmlOptions' => array('style' => 'text-align: right;'),
            ),
            array(
                'name' => '13',
                'htmlOptions' => array('style' => 'text-align: right;'),
                'headerHtmlOptions' => array('style' => 'text-align: right;'),
            ),
            array(
                'name' => '14',
                'htmlOptions' => array('style' => 'text-align: right;'),
                'headerHtmlOptions' => array('style' => 'text-align: right;'),
            ),
            array(
                'name' => '15',
                'htmlOptions' => array('style' => 'text-align: right;'),
                'headerHtmlOptions' => array('style' => 'text-align: right;'),
            ),
            array(
                'name' => '16',
                'htmlOptions' => array('style' => 'text-align: right;'),
                'headerHtmlOptions' => array('style' => 'text-align: right;'),
            ),
            array(
                'name' => '17',
                'htmlOptions' => array('style' => 'text-align: right;'),
                'headerHtmlOptions' => array('style' => 'text-align: right;'),
            ),
            array(
                'name' => '18',
                'htmlOptions' => array('style' => 'text-align: right;'),
                'headerHtmlOptions' => array('style' => 'text-align: right;'),
            ),
            array(
                'name' => '19',
                'htmlOptions' => array('style' => 'text-align: right;'),
                'headerHtmlOptions' => array('style' => 'text-align: right;'),
            ),
            array(
                'name' => '20',
                'htmlOptions' => array('style' => 'text-align: right;'),
                'headerHtmlOptions' => array('style' => 'text-align: right;'),
            ),
            array(
                'name' => '21',
                'htmlOptions' => array('style' => 'text-align: right;'),
                'headerHtmlOptions' => array('style' => 'text-align: right;'),
            ),
            array(
                'name' => '22',
                'htmlOptions' => array('style' => 'text-align: right;'),
                'headerHtmlOptions' => array('style' => 'text-align: right;'),
            ),
            array(
                'name' => '23',
                'htmlOptions' => array('style' => 'text-align: right;'),
                'headerHtmlOptions' => array('style' => 'text-align: right;'),
            ),
            array(
                'name' => '24',
                'htmlOptions' => array('style' => 'text-align: right;'),
                'headerHtmlOptions' => array('style' => 'text-align: right;'),
            ),
            array(
                'name' => '25',
                'htmlOptions' => array('style' => 'text-align: right;'),
                'headerHtmlOptions' => array('style' => 'text-align: right;'),
            ),
            array(
                'name' => '26',
                'htmlOptions' => array('style' => 'text-align: right;'),
                'headerHtmlOptions' => array('style' => 'text-align: right;'),
            ),
            array(
                'name' => '27',
                'htmlOptions' => array('style' => 'text-align: right;'),
                'headerHtmlOptions' => array('style' => 'text-align: right;'),
            ),
            array(
                'name' => '28',
                'htmlOptions' => array('style' => 'text-align: right;'),
                'headerHtmlOptions' => array('style' => 'text-align: right;'),
            ),
            array(
                'name' => '29',
                'htmlOptions' => array('style' => 'text-align: right;'),
                'headerHtmlOptions' => array('style' => 'text-align: right;'),
            ),
            array(
                'name' => '30',
                'htmlOptions' => array('style' => 'text-align: right;'),
                'headerHtmlOptions' => array('style' => 'text-align: right;'),
            ),
            array(
                'name' => '31',
                'htmlOptions' => array('style' => 'text-align: right;'),
                'headerHtmlOptions' => array('style' => 'text-align: right;'),
            ),
            array(
                'name' => '32',
                'htmlOptions' => array('style' => 'text-align: right;'),
                'headerHtmlOptions' => array('style' => 'text-align: right;'),
            ),
            array(
                'name' => '33',
                'htmlOptions' => array('style' => 'text-align: right;'),
                'headerHtmlOptions' => array('style' => 'text-align: right;'),
            ),
            array(
                'name' => '34',
                'htmlOptions' => array('style' => 'text-align: right;'),
                'headerHtmlOptions' => array('style' => 'text-align: right;'),
            ),
            array(
                'name' => '35',
                'htmlOptions' => array('style' => 'text-align: right;'),
                'headerHtmlOptions' => array('style' => 'text-align: right;'),
            ),
            array(
                'name' => '36',
                'htmlOptions' => array('style' => 'text-align: right;'),
                'headerHtmlOptions' => array('style' => 'text-align: right;'),
            ),
            array(
                'name' => '37',
                'htmlOptions' => array('style' => 'text-align: right;'),
                'headerHtmlOptions' => array('style' => 'text-align: right;'),
            ),
            array(
                'name' => '38',
                'htmlOptions' => array('style' => 'text-align: right;'),
                'headerHtmlOptions' => array('style' => 'text-align: right;'),
            ),
            array(
                'name' => '39',
                'htmlOptions' => array('style' => 'text-align: right;'),
                'headerHtmlOptions' => array('style' => 'text-align: right;'),
            ),
            array(
                'name' => '40',
                'htmlOptions' => array('style' => 'text-align: right;'),
                'headerHtmlOptions' => array('style' => 'text-align: right;'),
            ),
            array(
                'name' => '41',
                'htmlOptions' => array('style' => 'text-align: right;'),
                'headerHtmlOptions' => array('style' => 'text-align: right;'),
            ),
            array(
                'name' => '42',
                'htmlOptions' => array('style' => 'text-align: right;'),
                'headerHtmlOptions' => array('style' => 'text-align: right;'),
            ),
            array(
                'name' => '43',
                'htmlOptions' => array('style' => 'text-align: right;'),
                'headerHtmlOptions' => array('style' => 'text-align: right;'),
            ),
            array(
                'name' => '44',
                'htmlOptions' => array('style' => 'text-align: right;'),
                'headerHtmlOptions' => array('style' => 'text-align: right;'),
            ),
            array(
                'name' => '45',
                'htmlOptions' => array('style' => 'text-align: right;'),
                'headerHtmlOptions' => array('style' => 'text-align: right;'),
            ),
            array(
                'name' => '46',
                'htmlOptions' => array('style' => 'text-align: right;'),
                'headerHtmlOptions' => array('style' => 'text-align: right;'),
            ),
            array(
                'name' => '47',
                'htmlOptions' => array('style' => 'text-align: right;'),
                'headerHtmlOptions' => array('style' => 'text-align: right;'),
            ),
            array(
                'name' => '48',
                'htmlOptions' => array('style' => 'text-align: right;'),
                'headerHtmlOptions' => array('style' => 'text-align: right;'),
            ),
            array(
                'name' => '49',
                'htmlOptions' => array('style' => 'text-align: right;'),
                'headerHtmlOptions' => array('style' => 'text-align: right;'),
            ),
            array(
                'name' => '50',
                'htmlOptions' => array('style' => 'text-align: right;'),
                'headerHtmlOptions' => array('style' => 'text-align: right;'),
            ),
            array(
                'name' => '51',
                'htmlOptions' => array('style' => 'text-align: right;'),
                'headerHtmlOptions' => array('style' => 'text-align: right;'),
            ),
            array(
                'name' => '52',
                'htmlOptions' => array('style' => 'text-align: right;'),
                'headerHtmlOptions' => array('style' => 'text-align: right;'),
            )
        );
    }

    public static function getSaleOrderColumns()
    {
        return array(
            array('name' => 'sale_id',
                'header' => Yii::t('app', 'Invoice ID'),
                'value' => '$data["sale_id"]',
                'class' => 'yiiwheels.widgets.grid.WhRelationalColumn',
                'url' => Yii::app()->createUrl('Report/saleInvoiceDetail'),
            ),
            array(
                'name' => 'sale_time',
                'header' => Yii::t('app', 'Sale Time'),
                'value' => '$data["sale_time"]',
            ),
            array(
                'name' => 'employee_name',
                'header' => Yii::t('app', 'Sale Rep Name'),
                'value' => '$data["employee_name"]',
            ),
            array(
                'name' => 'customer_name',
                'header' => Yii::t('app', 'Customer Name'),
                'value' => '$data["client_name"]',
            ),
            // array(
            //     'name' => 'payment_term',
            //     'header' => Yii::t('app', 'Payment Term'),
            //     'value' => '$data["payment_term"]',
            // ),
            array(
                'name' => 'sub_total',
                'header' => Yii::t('app', 'Sub Total'),
                'value' => 'number_format($data["sub_total"],Common::getDecimalPlace())',
            ),
            array(
                'name' => 'total',
                'header' => Yii::t('app', 'Total'),
                'value' => 'number_format($data["total"],Common::getDecimalPlace())',
            ),
            array(
                'name' => 'current_balance',
                'header' => Yii::t('app', 'Previous Balance'),
                'value' => 'TbHtml::linkButton(number_format($data["current_balance"]), array(
                        "color" => TbHtml::BUTTON_COLOR_PRIMARY,
                        "size" => TbHtml::BUTTON_SIZE_MINI,
                        "url" => Yii::app()->createUrl("report/BalanceByCustomerId",array(
                                "client_id" => $data["client_id"],
                                "balance" => $data["current_balance"]
                            )
                        ),
                        "class" => "update-dialog-open-link",
                        "data-update-dialog-title" => "Outstanding Balance History",
                 ))',
                'type' => 'raw'
            ),
            array(
                'name' => 'balance',
                'header' => Yii::t('app', 'Outstanding Balance'),
                'value' => 'number_format($data["balance"],Common::getDecimalPlace())',
            ),
            array('name' => 'status',
                'header' => Yii::t('app', 'Status'),
                'value' => '$data["status_f"]',
            ),
            array('class' => 'bootstrap.widgets.TbButtonColumn',
                'header' => 'Action',
                'template' => '<div class="btn-group">{view}{edit}{invalid}{validate}{reject}{complete}{print}{printdo}</div>',
                'buttons' => array(
                    'view' => array(
                        'label' => 'View',
                        'icon' => 'fa fa-eye',
                        'url' => 'Yii::app()->createUrl("saleItem/ViewSaleInvoice",array(
                                   "sale_id" => $data["sale_id"],
                                   "customer_id" => $data["client_id"],
                                   "employee_id" => $data["employee_id"],
                                   "paid_amount" => 0,
                                   "print"=>"false",
                                   "tran_type"=>$data["status"]
                                    )
                        )',
                        'options' => array(
                            'title' => Yii::t('app', 'View Invoice'),
                            'class' => 'btn btn-xs btn-info',
                        ),
                        'visible' => 'true',
                    ),
                    'edit' => array(
                        'label' => 'Edit',
                        'icon' => 'fa fa-edit',
                        'url' => 'Yii::app()->createUrl("saleItem/EditSale",array(
                                   "sale_id" => $data["sale_id"],
                                   "customer_id" => $data["client_id"],
                                   "paid_amount" => 0,
                                   "tran_type"=>$data["status"] == param("sale_validate_status") ? param("sale_complete_status") : $data["status"]
                                    )
                        )',
                        'options' => array(
                            'title' => Yii::t('app', 'Update Invoice'),
                            'class' => 'btn btn-xs btn-info',
                        ),
                        'visible' => '$data["status"] !== param("sale_complete_status") && ckacc("sale.update")',
                    ),
                    'invalid' => array(
                        'label' => 'Invoice Invalid',
                        'icon' => 'fa fa-times',
                        'url' => 'Yii::app()->createUrl("saleItem/saleUpdateStatus", array(
                            "sale_id" => $data["sale_id"], 
                            "tran_type" => param("sale_reject_status")))',
                        'options' => array(
                            'target' => '_blank',
                            'title' => Yii::t('app', 'Invalid'),
                            'class' => 'btn-order btn-order-invalid btn btn-xs btn-danger',
                        ),
                        'visible' => '$data["status"] == param("sale_submit_status") && ckacc("sale.validate")',
                    ),
                    'validate' => array(
                        'label' => 'Validate',
                        'icon' => sysMenuSaleOrderToValidateIcon(),
                        'url' => 'Yii::app()->createUrl("saleItem/saleUpdateStatus", array(
                                    "sale_id"=>$data["sale_id"], 
                                    "tran_type" => param("sale_validate_status")))',
                        'options' => array(
                            'title' => Yii::t('app', 'Validate'),
                            'class' => 'btn-order btn-order-approve btn btn-xs btn-success',
                        ),
                        'visible' => '$data["status"]== param("sale_submit_status") && ckacc("sale.validate")',
                    ),
                    'reject' => array(
                        'label' => 'reject',
                        'icon' => 'fa fa-ban',
                        'url' => 'Yii::app()->createUrl("saleItem/saleUpdateStatus", array(
                            "sale_id"=>$data["sale_id"], 
                            "tran_type" => param("sale_reject_status")))',
                        'options' => array(
                            'target' => '_blank',
                            'title' => Yii::t('app', 'Reject'),
                            'class' => 'btn-order btn-order-reject btn btn-xs btn-danger',
                        ),
                        'visible' => '$data["status"] == param("sale_validate_status") && ckacc("sale.approve")',
                    ),
                    'complete' => array(
                        'label' => 'Complete',
                        'icon' => sysMenuSaleOrderInvoiceIcon(),
                        // 'url' => 'Yii::app()->createUrl("saleItem/SaleUpdateStatus", array(
                        //             "sale_id"=>$data["sale_id"], 
                        //             "tran_type" => param("sale_complete_status",
                        //             "customer_id" => $data["client_id"])))',
                        'url' => 'Yii::app()->createUrl("saleItem/saleUpdateStatus", array(
                                    "sale_id"=>$data["sale_id"], 
                                    "tran_type" => param("sale_complete_status"),
                                    ))',
                        
                        'options' => array(
                            'title' => Yii::t('app', 'Complete'),
                            'class' => 'btn-order btn-order-complete btn btn-xs btn-success',
                        ),
                        'visible' => '$data["status"]=="3" && ckacc("sale.approve")',
                    ),
                    'print' => array(
                        'label' => 'print',
                        'icon' => 'fa fa-print',
                        'url' => 'Yii::app()->createUrl("saleItem/printing", array(
                                    "sale_id" => $data["sale_id"],
                                    "tran_type" => param("sale_print_status"),
                                    "format" => "format_hf",
                                    "print"=>"true",
                                )
                         )',
                        'options' => array(
                            'target' => '_blank',
                            'title' => Yii::t('app', 'Invoice Printing'),
                            'class' => 'btn btn-xs btn-info',
                        ),
                        'visible' => '$data["status"] == "1"',
                    ),
                    'printdo' => array(
                        'label' => 'print',
                        'icon' => 'fa fa-book',
                        'url' => 'Yii::app()->createUrl("saleItem/printing", array(
                                    "sale_id"=>$data["sale_id"],
                                    "tran_type" => param("sale_do_status"),
                                    "format"=>"format_do",
                                    "print"=>"true",
                                )
                         )',
                        'options' => array(
                            'target' => '_blank',
                            'title' => Yii::t('app', 'DO Printing'),
                            'class' => 'btn btn-xs btn-primary',
                        ),
                        'visible' => '$data["status"] == "1"',
                    ),
                ),
            ),
        );
    }

    public static function getInvoiceColumns()
    {
        return array(
            array('name' => 'sale_id',
                'header' => Yii::t('app', 'Invoice ID'),
                'value' => '$data["sale_id"]',
                'class' => 'yiiwheels.widgets.grid.WhRelationalColumn',
                'url' => Yii::app()->createUrl('Report/saleInvoiceDetail'),
            ),
            array(
                'name' => 'sale_time',
                'header' => Yii::t('app', 'Sale Time'),
                'value' => '$data["sale_time"]',
            ),
            array(
                'name' => 'customer_name',
                'header' => Yii::t('app', 'Customer Name'),
                'value' => '$data["client_name"]',
            ),
            array(
                'name' => 'items',
                'header' => Yii::t('app', 'Items'),
                'value' => '$data["items"]',
            ),
            array(
                'name' => 'sub_total',
                'header' => Yii::t('app', 'Sub Total'),
                'value' => 'number_format($data["sub_total"],Common::getDecimalPlace())',
            ),
            array(
                'name' => 'total',
                'header' => Yii::t('app', 'Total'),
                'value' => 'number_format($data["total"],Common::getDecimalPlace())',
            )
        );
    }

    public static function getReceivingItemColumns()
    {
        return array(
            array('name' => 'receive_id',
                'header' => Yii::t('app', 'Receive ID'),
                'value' => '$data["receive_id"]',
                'class' => 'yiiwheels.widgets.grid.WhRelationalColumn',
                'url' => Yii::app()->createUrl('receivingItem/receivingItemDetail'),
            ),
            array(
                'name' => 'receive_time',
                'header' => Yii::t('app', 'Receive Time'),
                'value' => '$data["receive_time"]',
            ),
            array(
                'name' => 'created_by',
                'header' => Yii::t('app', 'Received By'),
                'value' => '$data["created_by"]',
            ),
            array('class' => 'bootstrap.widgets.TbButtonColumn',
                'header' => 'Action',
                'template' => '<div class="btn-group">{view}{edit}{print}</div>',
                'buttons' => array(
                    'view' => array(
                        'label' => 'View',
                        'icon' => 'fa fa-eye',
                        'url' => 'Yii::app()->createUrl("receivingItem/ViewTransactionDetail",array(
                                   "receive_id" => $data["receive_id"],
                                   "employee_id" => $data["employee_id"],
                                   "print"=>"false",
                                   "tran_type"=>$data["status"]
                                    )
                        )',
                        'options' => array(
                            'title' => Yii::t('app', 'View Detail'),
                            'class' => 'btn btn-xs btn-info',
                        ),
                        'visible' => 'true',
                    ),
                    'edit' => array(
                        'label' => 'Edit',
                        'icon' => 'fa fa-edit',
                        'url' => 'Yii::app()->createUrl("receivingItem/EditTransaction",array(
                                   "receive_id" => $data["receive_id"],
                                   "employee_id" => $data["employee_id"],
                                   "tran_type"=>$data["status"]
                                    )
                        )',
                        'options' => array(
                            'title' => Yii::t('app', 'Update Invoice'),
                            'class' => 'btn btn-xs btn-info',
                        ),
                        'visible' => 'ckacc("sale.update")',
                    ),
                    'print' => array(
                        'label' => 'print',
                        'icon' => 'fa fa-print',
                        'url' => 'Yii::app()->createUrl("receivingItem/printing", array(
                                    "receive_id" => $data["receive_id"],
                                   "employee_id" => $data["employee_id"],
                                    "tran_type" => $data["status"],
                                    "format" => "format_hf",
                                    "print"=>"true",
                                )
                         )',
                        'options' => array(
                            'target' => '_blank',
                            'title' => Yii::t('app', 'Invoice Printing'),
                            'class' => 'btn btn-xs btn-info',
                        ),
                        'visible' => 'true',
                    ),
                ),
            ),
        );
    }

    public static function getReceivingItemDetailColumns()
    {
        return array(
            array('name' => 'receive_time',
                'header' => Yii::t('app', 'Receive Time'),
                'value' => '$data["receive_time"]',
            ),
            array('name' => 'item_name',
                'header' => Yii::t('app', 'Item Name'),
                'value' => '$data["item_name"]',
            ),
            array('name' => 'supplier',
                'header' => Yii::t('app', 'Supplier'),
                'value' => '$data["supplier"]',
            ),
            array('name' => 'quantity',
                'header' => Yii::t('app', 'QTY'),
                'value' => 'number_format($data["quantity"],Common::getDecimalPlace(), ".", ",")',
                'htmlOptions' => array('style' => 'text-align: right;'),
                'headerHtmlOptions' => array('style' => 'text-align: right;'),
            ),
            array('name' => 'price',
                'header' => Yii::t('app', 'Price'),
                'value' => 'number_format($data["price"],Common::getDecimalPlace(), ".", ",")',
                'htmlOptions' => array('style' => 'text-align: right;'),
                'headerHtmlOptions' => array('style' => 'text-align: right;'),
            )
        );
    }

    public static function getTransferedItemColumns()
    {
        return array(
            array('name' => 'receive_id',
                'header' => Yii::t('app', 'Transaction ID'),
                'value' => '$data["receive_id"]',
                'class' => 'yiiwheels.widgets.grid.WhRelationalColumn',
                'url' => Yii::app()->createUrl('report/transferDetail'),
            ),
            array(
                'name' => 'reference_name',
                'header' => Yii::t('app', 'Reference Name'),
                'value' => '$data["reference_name"]',
            ),
            array(
                'name' => 'created_date',
                'header' => Yii::t('app', 'Created Date'),
                'value' => '$data["created_date"]',
            ),
            array(
                'name' => 'transfered_by',
                'header' => Yii::t('app', 'Transfered By'),
                'value' => '$data["transfered_by"]',
            ),
            array(
                'name' => 'trans_type',
                'header' => Yii::t('app', 'Status'),
                'value' => '$data["trans_type"]',
            ),
            array(
                'name' => 'status',
                'header' => Yii::t('app', 'Status'),
                'value' => '$data["status"]',
            ),
            array(
                'name' => 'description',
                'header' => Yii::t('app', 'Description'),
                'value' => '$data["from_outlet_id"] == Yii::app()->session["employee_outlet"] ? "Outgoing Transfer" : "Incoming Transfer"',
            ),
            array('class' => 'bootstrap.widgets.TbButtonColumn',
                'header' => 'Action',
                'template' => '<div class="btn-group">{review}{accept}{edit}{cancel}{reject}</div>',
                'buttons' => array(
                    'view' => array(
                        'label' => 'View',
                        'icon' => 'fa fa-eye',
                        'url' => 'Yii::app()->createUrl("receiving/ViewTransactionDetail",array(
                                   "receive_id" => $data["receive_id"],
                                   "employee_id" => $data["employee_id"],
                                   "print"=>"false",
                                   "tran_type"=>$data["status"]
                                    )
                        )',
                        'options' => array(
                            'title' => Yii::t('app', 'View Detail'),
                            'class' => 'btn btn-xs btn-info',
                        ),
                        'visible' => 'true',
                    ),
                    'review' => array(
                        'label' => 'Review',
                        // 'icon' => 'fa fa-edit',
                        'url' => 'Yii::app()->createUrl("receiving/reviewTransferItem",array(
                                   "receive_id" => $data["receive_id"],
                                   "tran_type"=>param("sale_complete_status")
                                    )
                        )',
                        'options' => array(
                            'title' => Yii::t('app', 'Review Item'),
                            'class' => 'btn btn-xs btn-info',
                        ),
                        'visible' => '$data["trans_type_id"] == param("sale_submit_status") && $data["to_outlet_id"]==Yii::app()->session["employee_outlet"]',
                    ),
                    'edit' => array(
                        'label' => 'Edit',
                        // 'icon' => 'fa fa-edit',
                        'url' => 'Yii::app()->createUrl("receiving/reviewTransferItem",array(
                                   "receive_id" => $data["receive_id"],
                                   "tran_type"=>param("sale_submit_status")
                                    )
                        )',
                        'options' => array(
                            'title' => Yii::t('app', 'Review Item'),
                            'class' => 'btn btn-xs btn-info',
                        ),
                        'visible' => '$data["trans_type_id"] == param("sale_submit_status") && $data["from_outlet_id"]==Yii::app()->session["employee_outlet"]',
                    ),
                    'cancel' => array(
                        'label' => 'Cancel',
                        // 'icon' => 'fa fa-edit',
                        'url' => 'Yii::app()->createUrl("receiving/transferUpdateStatus",array(
                                   "receive_id" => $data["receive_id"],
                                   "outlet_id" => $data["from_outlet_id"],
                                   "tran_type"=>param("sale_cancel_status")
                                    )
                        )',
                        'options' => array(
                            'title' => Yii::t('app', 'Review Item'),
                            'class' => 'btn-order btn-order-cancel btn btn-xs btn-danger',
                        ),
                        'visible' => '$data["trans_type_id"] == param("sale_submit_status") && $data["from_outlet_id"]==Yii::app()->session["employee_outlet"]',
                    ),
                    'accept' => array(
                        'label' => 'Accept',
                        // 'icon' => sysMenuSaleOrderToValidateIcon(),
                        'url' => 'Yii::app()->createUrl("receiving/transferUpdateStatus", array(
                                    "receive_id"=>$data["receive_id"], 
                                    "outlet_id" => $data["to_outlet_id"], 
                                    "tran_type" => param("sale_complete_status")))',
                        'options' => array(
                            'title' => Yii::t('app', 'Accept'),
                            'class' => 'btn-order btn-order-approve btn btn-xs btn-success',
                        ),
                        'visible' => '$data["trans_type_id"] == param("sale_submit_status") && $data["to_outlet_id"]==Yii::app()->session["employee_outlet"]',
                    ),
                    'reject' => array(
                        'label' => 'Rejects',
                        // 'icon' => 'fa fa-ban',
                        'url' => 'Yii::app()->createUrl("receiving/transferUpdateStatus", array(
                            "receive_id"=>$data["receive_id"],
                            "outlet_id" => $data["from_outlet_id"], 
                            "tran_type" => param("sale_reject_status")))',
                        'options' => array(
                            'target' => '_blank',
                            'title' => Yii::t('app', 'Reject'),
                            'class' => 'btn-order btn-order-reject btn btn-xs btn-danger',
                        ),
                        'visible' => '$data["trans_type_id"] == param("sale_submit_status") && $data["to_outlet_id"]==Yii::app()->session["employee_outlet"]',
                    ),
                ),
            ),
        );
    }

    public static function getTransferedDetailColumns()
    {
        return array(
            array('name' => 'receive_time',
                'header' => Yii::t('app', 'Trans Time'),
                'value' => '$data["receive_time"]',
            ),
            array('name' => 'item_name',
                'header' => Yii::t('app', 'Item Name'),
                'value' => '$data["item_name"]',
            ),
            array('name' => 'quantity',
                'header' => Yii::t('app', 'QTY'),
                'value' => 'number_format($data["quantity"],Common::getDecimalPlace(), ".", ",")',
                'htmlOptions' => array('style' => 'text-align: right;'),
                'headerHtmlOptions' => array('style' => 'text-align: right;'),
            ),
            array('name' => 'remaining_qty',
                'header' => Yii::t('app', 'Remaining Quantity'),
                'value' => 'number_format($data["remaining_qty"],Common::getDecimalPlace(), ".", ",")',
                'htmlOptions' => array('style' => 'text-align: right;'),
                'headerHtmlOptions' => array('style' => 'text-align: right;'),
            ),
            array('name' => 'cost_price',
                'header' => Yii::t('app', 'Cost'),
                'value' => 'number_format($data["cost_price"],Common::getDecimalPlace(), ".", ",")',
                'htmlOptions' => array('style' => 'text-align: right;'),
                'headerHtmlOptions' => array('style' => 'text-align: right;'),
            ),
            array('name' => 'unit_price',
                'header' => Yii::t('app', 'Price'),
                'value' => 'number_format($data["unit_price"],Common::getDecimalPlace(), ".", ",")',
                'htmlOptions' => array('style' => 'text-align: right;'),
                'headerHtmlOptions' => array('style' => 'text-align: right;'),
            )
        );
    }
}