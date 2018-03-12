<?php

class ReportController extends Controller
{

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column1';

    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules()
    {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('index', 'view'),
                'users' => array('*'),
            ),
            array(
                'allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array(
                    'create',
                    'update',
                    'ReportTab',
                    'SaleInvoiceItem',
                    'SaleInvoice',
                    'SaleInvoiceAlert',
                    'SaleDaily',
                    'SaleReportTab',
                    'SaleSummary',
                    'Payment',
                    'TopItem',
                    'SaleHourly',
                    'Inventory',
                    'ItemExpiry',
                    'ProfitDailySum',
                    'ItemInactive',
                    'Transaction',
                    'TransactionItem',
                    'ItemAsset',
                    'SaleItemSummary',
                    'StockCount',
                    'StockCountPrint',
                    'UserLogSummary',
                    'UserLogDt',
                    'OutStandingInvoice',
                    'SaleSumBySaleRep',
                    'PaymentReceiveByEmployee',
                    'ProfitByInvoice',
                    'SaleInvoiceDetail',
                    'SaleWeeklyByCustomer',
                    'BalanceByCustomerId',
                ),
                'users' => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'delete'),
                'users' => array('admin'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function actionReportTab()
    {

        $report = new Report;
        $report->unsetAttributes();  // clear any default values
        $date_view = 0; //indicate no date picker from_date & to_date, default view is today 
        $filter = 'all';
        $mfilter = '1';

        if (isset($_GET['Report'])) {
            $report->attributes = $_GET['Report'];
            $from_date = $_GET['Report']['from_date'];
            $to_date = $_GET['Report']['to_date'];
        } else {
            $from_date = date('d-m-Y');
            $to_date = date('d-m-Y');
        }

        $report->from_date = $from_date;
        $report->to_date = $to_date;

        $this->render('_report_tab', array('report' => $report, 'from_date' => $from_date, 'to_date' => $to_date, 'date_view' => $date_view, 'filter' => $filter, 'mfilter' => $mfilter));
    }

    public function actionSaleReportTab()
    {

        $report = new Report;
        $report->unsetAttributes();  // clear any default values

        if (isset($_GET['Report'])) {
            $report->attributes = $_GET['Report'];
            $from_date = $_GET['Report']['from_date'];
            $to_date = $_GET['Report']['to_date'];
        } else {
            $from_date = date('01-m-Y');
            $to_date = date('d-m-Y');
        }

        $report->from_date = $from_date;
        $report->to_date = $to_date;

        if (Yii::app()->request->isAjaxRequest) {
            Yii::app()->clientScript->scriptMap['*.js'] = false;
            Yii::app()->clientScript->scriptMap['*.css'] = false;
            $this->renderPartial('_sale_report_tab', array('report' => $report), true, true);
            Yii::app()->end();
        } else {
            $this->render('_sale_report_tab', array('report' => $report, 'from_date' => $from_date, 'to_date' => $to_date));
        }
    }

    public function actionSaleInvoice()
    {
        if (!Yii::app()->user->checkAccess('invoice.index') || !Yii::app()->user->checkAccess('invoice.print') || !Yii::app()->user->checkAccess('invoice.delete') || !Yii::app()->user->checkAccess('invoice.update')) {
            throw new CHttpException(403, 'You are not authorized to perform this action');
        }

        $grid_id = 'rpt-sale-invoice-grid';
        $title = 'Sale Invoice';

        $data = $this->commonData($grid_id,$title,'show');

        $data['grid_columns'] = ReportColumn::getSaleInvoiceColumns();
        $data['data_provider'] = $data['report']->saleInvoice();

        $this->renderView($data);

    }

    public function actionSaleInvoiceDetail($id)
    {
        if (!Yii::app()->user->checkAccess('invoice.index')) {
            throw new CHttpException(403, 'You are not authorized to perform this action');
        }

        $report = new Report;

        $data['report'] = $report;
        $data['sale_id'] = $id;

        $data['grid_id'] = 'rpt-sale-invoice-grid';
        $data['title'] = Yii::t('app','Detail #') .' ' . $id  ;

        $data['grid_columns'] = ReportColumn::getSaleInvoiceDetailColumns();

        $report->sale_id = $id;
        $data['data_provider'] = $report->saleInvoiceDetail();

        $this->renderView($data);

    }

    public function actionSaleDaily()
    {
        $this->canViewReport();


        $grid_id = 'rpt-sale-daily-grid';
        $title = 'Sale Daily';

        $data = $this->commonData($grid_id,$title);

        $data['grid_columns'] = ReportColumn::getSaleDailyColumns();
        $data['data_provider'] = $data['report']->saleDaily();

        $this->renderView($data);
    }

    public function actionSaleHourly()
    {
        $this->canViewReport();

        $grid_id = 'rpt-sale-hourly-grid';
        $title = 'Sale Hourly';

        $data = $this->commonData($grid_id,$title);

        $data['grid_columns'] = ReportColumn::getSaleHourlyColumns();
        $data['data_provider'] = $data['report']->saleHourly();

        $this->renderView($data);
    }

    public function actionSaleSummary()
    {

        $this->canViewReport();

        $grid_id = 'rpt-sale-summary-grid';
        $title = 'Sale Summary';

        $data = $this->commonData($grid_id,$title);

        $data['grid_columns'] = ReportColumn::getSaleSummaryColumns();
        $data['data_provider'] = $data['report']->saleSummary();

        $this->renderView($data);
    }

    public function actionSaleSumBySaleRep()
    {
        $this->canViewReport();

        $grid_id = 'rpt-sale-by-sale-rep-grid';
        $title = 'Sale Summary By Sale Rep';

        $data = $this->commonData($grid_id,$title);

        $data['grid_columns'] = ReportColumn::getSaleSumBySaleRepColumns();

        $data['data_provider'] = $data['report']->saleSummaryBySaleRep();

        $this->renderView($data);
    }

    public function actionSaleWeeklyByCustomer()
    {
        $this->canViewReport();


        $grid_id = 'rpt-sale-weekly-by-customer-grid';
        $title = 'Sale Weekly By Customer';

        $data = $this->commonData($grid_id,$title);

        $data['grid_columns'] = ReportColumn::getSaleWeeklyByCusotmer();
        $data['data_provider'] = $data['report']->saleWeeklyByCustomer();

        $this->renderView($data);
    }

    public function actionSaleInvoiceItem($sale_id, $employee_id)
    {
        if (Yii::app()->user->checkAccess('report.index')) {
        
            $model = new SaleItem('search');
            $model->unsetAttributes();  // clear any default values

            $payment = new SalePayment('search');
            //$payment->unsetAttributes();
            //$employee=Employee::model()->findByPk((int)$employee_id);
            //$cashier=$employee->first_name . ' ' . $employee->last_name;

            if (isset($_GET['SaleItem']))
                $model->attributes = $_GET['SaleItem'];

            if (Yii::app()->request->isAjaxRequest) {

                Yii::app()->clientScript->scriptMap['*.js'] = false;
                //Yii::app()->clientScript->scriptMap['*.css'] = false;

                if (isset($_GET['ajax']) && $_GET['ajax'] == 'sale-item-grid') {
                    $this->render('sale_item', array(
                        'model' => $model,
                        'payment' => $payment,
                        'sale_id' => $sale_id,
                        'employee_id' => $employee_id
                    ));
                } else {
                    echo CJSON::encode(array(
                        'status' => 'render',
                        'div' => $this->renderPartial('sale_item', array('model' => $model, 'payment' => $payment, 'sale_id' => $sale_id, 'employee_id' => $employee_id), true, true),
                    ));

                    Yii::app()->end();
                }
            } else {
                $this->render('sale_item', array('model' => $model));
            }
        } else {
            throw new CHttpException(403, 'You are not authorized to perform this action');
        }
    }

    public function actionTransaction()
    {
        $this->canViewReport();

        $report = new Report;
        $report->unsetAttributes();  // clear any default values
        //$date_view = 0;

        if (!empty($_GET['Report']['sale_id'])) {
            $report->sale_id = $_GET['Report']['sale_id'];
        }

        if (isset($_GET['Report'])) {
            $from_date = $_GET['Report']['from_date'];;
            $to_date = $_GET['Report']['to_date'];;
        } else {
            $from_date = date('d-m-Y');
            $to_date = date('d-m-Y');
        }

        $data['report'] = $report;
        $data['from_date'] = $from_date;
        $data['to_date'] = $to_date;
        $data['grid_id'] = 'sale-summary-grid';
        $data['title'] = 'Sale Summary' .' ' .  Yii::t('app','From') . ' ' . $from_date . '  ' . Yii::t('app','To') . ' ' . $to_date;

        $data['grid_columns'] = ReportColumn::getTransactionColumns();

        $report->from_date = $from_date;
        $report->to_date = $to_date;
        $data['data_provider'] = $report->saleSummary();

        $this->renderView($data,'index_2');


    }

    public function actionTransactionItem($receive_id, $employee_id, $remark)
    {
        $model = new ReceivingItem('search');
        $model->unsetAttributes();  // clear any default values
        //$employee=Employee::model()->findByPk((int)$employee_id);
        //$cashier=$employee->first_name . ' ' . $employee->last_name;

        if (isset($_GET['SaleItem']))
            $model->attributes = $_GET['SaleItem'];

        if (Yii::app()->request->isAjaxRequest) {

            Yii::app()->clientScript->scriptMap['*.js'] = false;
            //Yii::app()->clientScript->scriptMap['*.css'] = false;

            if (isset($_GET['ajax']) && $_GET['ajax'] == 'receive-item-grid') {
                $this->render('receive_item', array('model' => $model, 'receive_id' => $receive_id, 'employee_id' => $employee_id, 'remark' => $remark));
            } else {
                echo CJSON::encode(array(
                    'status' => 'render',
                    'div' => $this->renderPartial('receive_item', array('model' => $model, 'receive_id' => $receive_id, 'employee_id' => $employee_id, 'remark' => $remark), true, true),
                ));

                Yii::app()->end();
            }
        } else {
            $this->render('receive_item', array('model' => $model, 'receive_id' => $receive_id, 'employee_id' => $employee_id, 'remark' => $remark));
        }
    }

    public function actionPayment()
    {
        $this->canViewReport();

        $report = new Report;
        $report->unsetAttributes();  // clear any default values

        if (isset($_GET['Report'])) {
            $report->attributes = $_GET['Report'];
            $from_date = $_GET['Report']['from_date'];
            $to_date = $_GET['Report']['to_date'];
        } else {
            $from_date = date('d-m-Y');
            $to_date = date('d-m-Y');
        }

        $report->from_date = $from_date;
        $report->to_date = $to_date;

        if (Yii::app()->request->isAjaxRequest) {
            /*
              Yii::app()->clientScript->scriptMap['*.js'] = false;
              Yii::app()->clientScript->scriptMap['*.css'] = false;
              $this->renderPartial('sale_daily', array('report' => $report,'from_date'=>$from_date,'to_date'=>$to_date),false,true);
              Yii::app()->end();
             * 
             */
            echo CJSON::encode(array(
                'status' => 'success',
                'div' => $this->renderPartial('payment_ajax', array('report' => $report, 'from_date' => $from_date, 'to_date' => $to_date), true, false),
            ));
        } else {
            $this->render('payment', array('report' => $report, 'from_date' => $from_date, 'to_date' => $to_date));
        }
    }

    public function actionPaymentReceiveByEmployee()
    {
        $this->canViewReport();

        $grid_id = 'rpt-payment-by-employee-grid';
        $title = 'Payment Receive By Employee';

        $data = $this->commonData($grid_id,$title);

        $data['grid_columns'] = ReportColumn::getPaymentReceiveByEmployeeColumns();
        $data['data_provider'] = $data['report']->paymentReceiveByEmployee();

        $this->renderView($data);

    }

    public function actionProfitDailySum()
    {
        $this->canViewReport();

        $grid_id = 'rpt-profit-daily-sum-grid';
        $title = 'Profit Daily Sum';

        $data = $this->commonData($grid_id,$title);

        $data['grid_columns'] = ReportColumn::getProfitDailyColumns();
        $data['data_provider'] = $data['report']->profitDailySum();

        $this->renderView($data);
    }

    public function actionProfitByInvoice($id)
    {
        $this->canViewReport();

        $report = new Report;

        $from_date = $id;

        $data['report'] = $report;
        $data['from_date'] = $from_date;
        //$data['to_date'] = $to_date;
        $data['grid_id'] = 'rpt-profit-by-invoice-grid';
        $data['title'] = 'Profit By Invoice' .' ' .  Yii::t('app','@') . ' ' . $from_date;

        $data['grid_columns'] = ReportColumn::getProfitByInvoiceColumns();

        $report->from_date = $from_date;
        //$report->to_date = $to_date;
        $data['data_provider'] = $report->profitByInvoice();

        $this->renderView($data);
    }

    public function actionTopItem()
    {
        if (!Yii::app()->user->checkAccess('report.index')) {
            throw new CHttpException(403, 'You are not authorized to perform this action');
        }

        $grid_id = 'rpt-top-item-grid';
        $title = 'Top Item';

        $data = $this->commonData($grid_id,$title);

        $data['grid_columns'] = ReportColumn::getTopItemColumns();
        $data['data_provider'] = $data['report']->topItem();

        $this->renderView($data);
    }

    public function actionItemExpiry($filter = '1')
    {
        $this->canViewReport();

        $grid_id = 'rpt-item-expiry-grid';
        $title = 'Item Expiry';

        $data = $this->commonData($grid_id,$title,null,'_header_3');
        $data['filter'] = $filter;

        $data['header_tab'] = ReportColumn::getItemExpiryHeaderTab($filter);
        $data['grid_columns'] = ReportColumn::getItemExpiryColumns();

        $data['data_provider'] = $data['report']->ItemExpiry($filter);

        $this->renderView($data);
    }

    public function actionInventory($filter = 'all')
    {
        $this->canViewReport();

        $grid_id = 'rpt-inventory-grid';
        $title = 'Inventory';

        $data = $this->commonData($grid_id,$title,'show','_header_3');
        $data['filter'] = $filter;

        $data['header_tab'] = ReportColumn::getInventoryHeaderTab($filter);
        $data['grid_columns'] = ReportColumn::getInventoryColumns();

        $data['data_provider'] = $data['report']->Inventory($filter);

        $this->renderView($data);

    }
    
    public function actionStockCount($filter = 1)
    {
        $this->canViewReport();

        $report = new Report;
        $report->unsetAttributes();  // clear any default values

        if (Yii::app()->request->isAjaxRequest) {

            Yii::app()->shoppingCart->setDayinterval($filter);

            Yii::app()->clientScript->scriptMap['*.js'] = false;
            Yii::app()->clientScript->scriptMap['*.css'] = false;

            if (isset($_GET['ajax']) && $_GET['ajax'] == 'stockcount-grid') {
                $this->render('stock_count', array('report' => $report, 'filter' => $filter));
            } else {
                echo CJSON::encode(array(
                    'status' => 'success',
                    'div' => $this->renderPartial('stock_count_ajax', array('report' => $report, 'filter' => $filter), true, true),
                ));

                Yii::app()->end();
            }
        } else {
            $this->render('stock_count', array('report' => $report, 'filter' => $filter));
        }
    }
    
    public function actionStockCountPrint()
    {
        $this->canViewReport();
       
        $report = new Report;
        $data['report'] = $report;
        $data['filter'] = Yii::app()->shoppingCart->getDayinterval();
        $data['employee'] = ucwords(Yii::app()->session['emp_fullname']);
        $data['trans_date'] = Date('d-m-Y'); 
        $data['save_id'] = Item::model()->saveStockCount(Yii::app()->shoppingCart->getDayinterval());
        $data['items'] = Item::model()->stockItem(Yii::app()->shoppingCart->getDayinterval());
         
        if (count($data['items']) == 0) {
            $data['warning'] = Yii::t('app','There is no item to print...');
            $this->render('stock_count', $data);
        } else {
            $this->layout = '//layouts/column_receipt';
            $this->render('_stock_count_print', $data);
        }
         
    }

    public function actionItemInactive($mfilter = '1')
    {
        $this->canViewReport();

        $report = new Report;
        $report->unsetAttributes();  // clear any default values

        if (Yii::app()->request->isAjaxRequest) {
            Yii::app()->clientScript->scriptMap['*.js'] = false;
            Yii::app()->clientScript->scriptMap['*.css'] = false;

            if (isset($_GET['ajax']) && $_GET['ajax'] == 'rpt-item-inactive-grid') {
                $this->render('item_expiry', array('report' => $report, 'mfilter' => $mfilter));
            } else {
                echo CJSON::encode(array(
                    'status' => 'success',
                    'div' => $this->renderPartial('item_inactive_ajax', array('report' => $report, 'mfilter' => $mfilter), true, true),
                ));

                Yii::app()->end();
            }
        } else {
            $this->render('item_inactive', array('report' => $report, 'mfilter' => $mfilter));
        }
    }

    public function actionItemAsset()
    {
        $report = new Report;
        $this->render('item_asset', array('report' => $report));
    }

    public function actionSaleItemSummary()
    {
        $this->canViewReport();

        $grid_id = 'rpt-sale-item-summary-grid';
        $title = 'Sale Item Summary';

        $data = $this->commonData($grid_id,$title);

        $data['grid_columns'] = ReportColumn::getSaleItemSummaryColumns();
        $data['data_provider'] = $data['report']->saleItemSummary();

        $this->renderView($data);
    }
    
    public function actionUserLogSummary($period = 'today')
    {
        $this->canViewReport();

        $report = new Report;
  
        if (isset($_GET['Report'])) {
            $report->attributes = $_GET['Report'];
            $from_date = $_GET['Report']['from_date'];
            $to_date = $_GET['Report']['to_date'];
        } else {
            $from_date = date('d-m-Y');
            $to_date = date('d-m-Y');
        }

        $report->from_date = $from_date;
        $report->to_date = $to_date;

        if (Yii::app()->request->isAjaxRequest) {
            Yii::app()->clientScript->scriptMap['*.js'] = false;
            Yii::app()->clientScript->scriptMap['*.css'] = false;
            echo CJSON::encode(array(
                'status' => 'success',
                'div' => $this->renderPartial('user_log_sum_ajax', array('report' => $report, 'from_date' => $from_date, 'to_date' => $to_date), true, false),
            ));
        } else {
            $this->render('user_log_sum', array('report' => $report, 'from_date' => $from_date, 'to_date' => $to_date));
        }
    }
    
    public function actionUserLogDt($employee_id,$full_name)
    {
        $this->canViewReport();

        $model = new UserLog('search');
        $model->unsetAttributes();  // clear any default values

        if (isset($_GET['UserLog']))
            $model->attributes = $_GET['UserLog'];

        if (Yii::app()->request->isAjaxRequest) {

            Yii::app()->clientScript->scriptMap['*.js'] = false;
     
            if (isset($_GET['ajax']) && $_GET['ajax'] == 'user-log-dt-grid') {
                $this->render('user_log_dt', array(
                    'model' => $model,
                    'employee_id' => $employee_id,
                    'full_name' => $full_name,
                ));
            } else {
                echo CJSON::encode(array(
                    'status' => 'render',
                    'div' => $this->renderPartial('user_log_dt', array('model' => $model,'employee_id' => $employee_id,'full_name' => $full_name,), true, true),
                ));

                Yii::app()->end();
            }
        } else {
            $this->render('user_log_dt', array('model' => $model,'employee_id' => $employee_id,'full_name' => $full_name,));
        }
    }

    public function actionOutStandingInvoice()
    {
        $this->canViewReport();

        $grid_id = 'rpt-outstanding-inv-grid';
        $title = 'Outstanding Balance';

        $data = $this->commonData($grid_id,$title,'show');


        $data['grid_columns'] = ReportColumn::getOutStandingInvoiceColumns();
        $data['data_provider'] = $data['report']->outstandingInvoice();

        $this->renderView($data);
    }

	public function actionSaleItemSumbyCust($period = 'today')
    {
        $this->canViewReport();

        $report = new Report;
        //$report->unsetAttributes();  // clear any default values

        if (isset($_GET['Report'])) {
            $report->attributes = $_GET['Report'];
            $from_date = $_GET['Report']['from_date'];
            $to_date = $_GET['Report']['to_date'];
        } else {
            $from_date = date('d-m-Y');
            $to_date = date('d-m-Y');
        }

        $report->from_date = $from_date;
        $report->to_date = $to_date;

        $this->renderView($data);
    }

    public function actionBalanceByCustomerId($client_id,$balance)
    {

        $model = new SalePayment;

        $cs = Yii::app()->clientScript;
        $cs->scriptMap = array(
            'jquery.js' => false,
            'bootstrap.js' => false,
            'jquery.min.js' => false,
            'bootstrap.notify.js' => false,
        );

        echo CJSON::encode(array(
            'status' => 'render',
            'div' => $this->renderPartial('//salePayment/partial/_invoice_his', array(
                'model' => $model,
                'client_id' => $client_id,
                'balance' => $balance,
            ), true, true),
        ));
    }

    protected function renderView($data, $view_name='index')
    {
        if (Yii::app()->request->isAjaxRequest && !isset($_GET['ajax']) ) {
            Yii::app()->clientScript->scriptMap['*.css'] = false;
            Yii::app()->clientScript->scriptMap['*.js'] = false;

            /*
            echo CJSON::encode(array(
                'status' => 'success',
                'div' => $this->renderPartial('partial/_grid', $data, true, false),
            ));
            */
            $this->renderPartial('partial/_grid', $data);
        } else {
            $this->render($view_name, $data);
        }
    }

    protected function renderSubView($data)
    {
        $this->renderPartial('partial/_grid', $data);
    }

    protected function canViewReport()
    {
        if (!Yii::app()->user->checkAccess('report.index')) {
            throw new CHttpException(403, 'You are not authorized to perform this action');
        }
    }

    /**
     * @param $grid_id
     * @param $title
     * @param $advance_search :  to indicate whether there is an advance search text box
     * @param $header_view
     * @param $grid_view
     * @return mixed
     */
    protected function commonData($grid_id,$title,$advance_search=null,$header_view='_header',$grid_view='_grid')
    {
        $report = new Report;

        $data['report'] = $report;
        $data['from_date'] = isset($_GET['Report']['from_date']) ? $_GET['Report']['from_date'] : date('d-m-Y');
        $data['to_date'] = isset($_GET['Report']['to_date']) ? $_GET['Report']['to_date'] : date('d-m-Y');
        $data['search_id'] = isset($_GET['Report']['search_id']) ? $_GET['Report']['search_id'] : '';
        $data['advance_search'] = $advance_search;
        $data['header_tab'] = '';

        $data['grid_id'] = $grid_id;
        $data['title'] = Yii::t('app', $title) . ' ' . Yii::t('app',
                'From') . ' ' . $data['from_date'] . '  ' . Yii::t('app', 'To') . ' ' . $data['to_date'];
        $data['header_view'] = $header_view;
        $data['grid_view'] = $grid_view;

        $data['report']->from_date = $data['from_date'];
        $data['report']->to_date = $data['to_date'];
        $data['report']->search_id = $data['search_id'];

        return $data;
    }


}
