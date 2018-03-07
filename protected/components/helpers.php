<?php

    function bizName() {
        return param('biz_name');
    }

    function bizNameFirstUpper() {
        return ucfirst(param('biz_name'));
    }

    function bizWebsite()
    {
        return 'http://peedor.com';
    }

    function bizVision()
    {
        return "To bring new exciting experience and creative innovation to all parent business";
    }

    function companyName() {
        return param('company_name');
    }

    function companyNameUpper() {
        return strtoupper(param('company_name'));
    }

    function companyNameFirstUpper() {
        return ucfirst(param('company_name'));
    }

    function companySlogan() {
        return param('company_slogan');
    }

    function companySloganUcwords() {
        return ucwords(param('company_slogan'));
    }

    function ddmonyyyy() {
        return date('d M Y');
    }

    function freeTrialText()
    {
        return 'Start Free Trail';
    }

    function invFolderPath()
    {
        return Yii::app()->shoppingCart->getInvoiceFormat();
    }

    function invIfSaleRep(){

        if (Yii::app()->settings->get('receipt', 'printSaleRep')=='1'){
            return true;
        }

        return false;
    }

    function invIfCompanyLogo(){

        if (Yii::app()->settings->get('receipt', 'printcompanyLogo')=='1'){
            return true;
        }

        return false;
    }

    function invIfCompanyName(){

        if (Yii::app()->settings->get('receipt', 'printcompanyName')=='1'){
            return true;
        }

        return false;
    }

    function invIfCompanyPhone(){

        if (Yii::app()->settings->get('receipt', 'printcompanyPhone')=='1'){
            return true;
        }

        return false;
    }

    function invIfCompanyAdd(){

        if (Yii::app()->settings->get('receipt', 'printcompanyAddress')=='1'){
            return true;
        }

        return false;
    }

    function invIfCompanyAdd1(){

        if (Yii::app()->settings->get('receipt', 'printcompanyAddress1')=='1'){
            return true;
        }

        return false;
    }

    function invIfTransTime(){

        if (Yii::app()->settings->get('receipt', 'printtransactionTime')=='1'){
            return true;
        }

        return false;
    }

    function curcurrencySympbol() {
        return Yii::app()->settings->get('site', 'currencySymbol');
    }

    function invNumInterval() {
        return Yii::app()->settings->get('system', 'invoiceNumInterval');
    }

    function invNumPrefix() {
        return Yii::app()->settings->get('site', 'invoicePrefix') . date('y') . '-00000';
    }

    function sysMenuDashboard() {
        return strtoupper(t(param('menu_dashboard'),'app'));
    }

    function sysMenuItem() {
        return strtoupper(t(param('menu_item'),'app'));
    }

    function sysMenuItemAdd() {
        return ucwords(t(param('menu_item_add'),'app'));
    }

    function sysMenuItemView() {
        return ucwords(t(param('menu_item_view'),'app'));
    }

    function sysMenuItemImpExp() {
        return ucwords(t(param('menu_item_imp_exp'),'app'));
    }

    function sysMenuItemMarkupPrice() {
        return ucwords(t(param('menu_item_markup_price'),'app'));
    }

    function sysMenuInventory() {
        return strtoupper(t(param('menu_inventory'),'app'));
    }

    function sysMenuInventoryAdd() {
        return ucwords(t(param('menu_inventory_add'),'app'));
    }

    function sysMenuInventoryMinus() {
        return ucwords(t(param('menu_inventory_minus'),'app'));
    }

    function sysMenuInventoryCount() {
        return ucwords(t(param('menu_inventory_count'),'app'));
    }

    function sysMenuPurchase() {
        return strtoupper(t(param('menu_purchase'),'app'));
    }

    function sysMenuPurchaseReceive() {
        return ucwords(t(param('menu_purchase_receive'),'app'));
    }

    function sysMenuPurchaseReturn() {
        return ucwords(t(param('menu_purchase_return'),'app'));
    }

    function sysMenuSale() {
        return ucwords(t(param('menu_sale'),'app'));
    }

    function sysMenuSaleAdd() {
        return ucwords(t(param('menu_sale_add'),'app'));
    }

    function sysMenuSaleView() {
        return ucwords(t(param('menu_sale_view'),'app'));
    }

    function sysMenuInvoice() {
        return ucwords(t(param('menu_invoice'),'app'));
    }

    function getTransType() {
        return Yii::app()->shoppingCart->getMode();
    }

    function getEmployeeId()
    {
        return Yii::app()->session['employeeid'];
    }

    function sysFormatNumberDecimal($value) {
        return number_format($value,Common::getDecimalPlace());
    }

    function sysMenuSaleIcon() {
        return 'menu-icon fa fa-usd';
    }

    function sysMenuInvoiceIcon() {
        return 'menu-icon fa fa-usd';
    }



