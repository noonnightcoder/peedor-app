<?php

class RbacController extends Controller
{
    public function actionIndex()
    {
        $auth = Yii::app()->authManager;

        // add "Sale Order" permission
        $auth->createOperation('sale.create', 'create sale order');
        $auth->createOperation('sale.read', 'view sale order');
        $auth->createOperation('sale.read.all', 'view all sale order');
        $auth->createOperation('sale.update', 'update sale order');
        $auth->createOperation('sale.delete', 'delete a sale order');
        $auth->createOperation('sale.review', 'review a sale order');
        $auth->createOperation('sale.approve', 'approve a sale order');

        // Add "Sale Payment" permission
        $auth->createOperation('payment.sale', 'payment a sale invoice');

        // add "Purchase Order" permission
        $auth->createOperation('purchase.create', 'create a purchase order');
        $auth->createOperation('purchase.read', 'read a purchase order');
        $auth->createOperation('purchase.update', 'update a purchase order');
        $auth->createOperation('purchase.delete', 'delete a purchase order');
        $auth->createOperation('purchase.receive', 'receive a purchase order');
        $auth->createOperation('purchase.return', 'return a purchase order');
        $auth->createOperation('purchase.review', 'review a purchase order');
        $auth->createOperation('purchase.approve', 'approve a purchase order');

        // Add "Purchase Payment" permission
        $auth->createOperation('purchase.payment', 'payment a purchase invoice');

        // add "Inventory" permission
        $auth->createOperation('stock.in', 'in stock');
        $auth->createOperation('stock.out', 'out stock');
        $auth->createOperation('stock.count', 'count stock');
        $auth->createOperation('stock.transfer', 'transfer stock');

        // add "Report" permission
        $auth->createOperation('report.sale', 'view all sale report');
        $auth->createOperation('report.sale.analytic', 'view all sale analytic');
        $auth->createOperation('report.stock', 'view all stock report');
        $auth->createOperation('report.customer', 'view all customer report');
        $auth->createOperation('report.marketing', 'view all marketing related report');
        $auth->createOperation('report.accounting', 'view all accounting related report');

        // add "Dashboard" permission
        $auth->createOperation('dashboard.read', 'view all dashboard');

        // add "Item" permission
        $auth->createOperation('item.create', 'create an item');
        $auth->createOperation('item.read', 'read an item');
        $auth->createOperation('item.update', 'update an item');
        $auth->createOperation('item.delete', 'delete an item');

        // add "Item Setting" permission
        $auth->createOperation('item.price.update', 'update an item price');

        // add "Employee" permission
        $auth->createOperation('employee.create', 'create an customer');
        $auth->createOperation('employee.read', 'read an customer');
        $auth->createOperation('employee.update', 'update an customer');
        $auth->createOperation('employee.delete', 'delete an customer');

        // add "Customer" permission
        $auth->createOperation('customer.create', 'create an customer');
        $auth->createOperation('customer.read', 'read an customer');
        $auth->createOperation('customer.update', 'update an customer');
        $auth->createOperation('customer.delete', 'delete an customer');

        // add "Supplier" permission
        $auth->createOperation('supplier.create', 'create an supplier');
        $auth->createOperation('supplier.read', 'read an supplier');
        $auth->createOperation('supplier.update', 'update an supplier');
        $auth->createOperation('supplier.delete', 'delete an supplier');

        // Biz rule can update only his own sale order
        $bizRule = 'return Yii::app()->user->id==$params["post"]->authID;';
        $task = $auth->createTask('updateOwnSale', 'update a sale by salesperson himself', $bizRule);
        $task->addChild('sale.update');


        // Biz rule can view only his own sale order
        $bizRule = 'return Yii::app()->user->id==$params["post"]->authID;';
        $task = $auth->createTask('readOwnSale', 'read a sale by salesperson himself', $bizRule);
        $task->addChild('sale.read');

        $role = $auth->createRole('stockclerk','stock clerk role');
        $role->addChild('item.read');
        $role->addChild('stock.in');
        $role->addChild('stock.out');
        $role->addChild('stock.count');
        $role->addChild('stock.transfer');
        $role->addChild('report.stock');

        $role = $auth->createRole('salesperson','salesperson role');
        $role->addChild('sale.create');
        $role->addChild('sale.read');
        $role->addChild('sale.update');
        $role->addChild('sale.delete');
        $role->addChild('report.sale');

        $role = $auth->createRole('salesmanager','sale manager role');
        $role->addChild('salesperson');
        $role->addChild('sale.read.all');
        $role->addChild('sale.review');
        $role->addChild('dashboard.read');
        $role->addChild('report.sale.analytic');

        $role = $auth->createRole('accountant','accountant role');
        $role->addChild('salesperson');
        $role->addChild('sale.approve');
        $role->addChild('item.create');
        $role->addChild('item.read');
        $role->addChild('item.update');
        $role->addChild('item.delete');
        $role->addChild('item.price.update');
        $role->addChild('customer.create');
        $role->addChild('customer.read');
        $role->addChild('customer.update');
        $role->addChild('customer.delete');
        $role->addChild('supplier.create');
        $role->addChild('supplier.read');
        $role->addChild('supplier.update');
        $role->addChild('supplier.delete');
        $role->addChild('sale.payment');
        $role->addChild('dashboard.read');
        $role->addChild('report.accounting');
        $role->addChild('report.customer');

        $role = $auth->createRole('hr','human resource role');
        $role->addChild('employee.create');
        $role->addChild('employee.read');
        $role->addChild('employee.update');
        $role->addChild('employee.delete');

        $role = $auth->createRole('admin','admin role');
        $role->addChild('stockclerk');
        $role->addChild('salesmanager');
        $role->addChild('accountant');
        $role->addChild('hr');

        $auth->assign('salesmanager', '4');
        $auth->assign('admin', '3');

    }
}