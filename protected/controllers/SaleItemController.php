<?php

class SaleItemController extends Controller
{
    //public $layout='//layouts/column1';

    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations,
            array(
                'ext.starship.RestfullYii.filters.ERestFilter + 
                REST.GET, REST.PUT, REST.POST, REST.DELETE'
            ),
        );
    }

    public function accessRules()
    {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('view'),
                'users' => array('@'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('Add', 'RemoveCustomer', 'SetComment', 'DeleteItem', 'AddItem',
                    'ViewSaleInvoice','EditItem', 'EditItemPrice', 'Index', 'IndexPara', 'AddPayment', 'CancelSale',
                    'CompleteSale', 'Complete', 'SuspendSale', 'DeletePayment', 'SelectCustomer',
                    'AddCustomer', 'Receipt', 'UnsuspendSale', 'EditSale', 'Receipt', 'Suspend',
                    'ListSuspendedSale', 'SetPriceTier', 'SetTotalDiscount', 'DeleteSale', 'SetSaleRep', 'SetGST', 'SetInvoiceFormat',
                    'saleOrder','SaleInvoice','SaleApprove','SetPaymentTerm','saleUpdateStatus','Printing',
                    'list','update','create',// UNLEASED name convenstion it's all about CRUD
                    'REST.GET', 'REST.PUT', 'REST.POST', 'Review','Approve'),
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

    /** To remove change using CRUD name convension List, Create, Update, Delete */
    public function actionIndex($tran_type='1')
    {
        authorized('sale.read') || authorized('sale.create');

        Yii::app()->shoppingCart->setMode($tran_type);

        if (ckacc('sale.create') || ckacc('sale.read') || ckacc('sale.update') || ckacc('sale.delete')) {
            $this->reload();
        } else {
            throw new CHttpException(403, 'You are not authorized to perform this action');
        }
    }

    public function actionCreate($tran_type='2')
    {
        Yii::app()->shoppingCart->setMode($tran_type);

        authorized('sale.create');
        $this->setSession(Yii::app()->session);
        unset($this->session['pre']);
        $this->reload();
    }

    public function actionUpdate($sale_id,$tran_type='2')
    {
        Yii::app()->shoppingCart->setMode($tran_type);

        authorized('sale.create');
        $this->setSession(Yii::app()->session);
        unset($this->session['deleted_item']);
        if($tran_type==param('sale_complete_status')){
            
            $data['cart']['item']=$this->session['cart'];
            $data['cart']['sale_id']=$sale_id;
            // $this->session['previous_cart']=$data;
            $previous_cart=array();
            if(count($data['cart']['item'])>0){
                foreach($data as $cart){
                    foreach($cart['item'] as $item){
                        $previous_cart+=array($item['item_id']=>array('sale_id'=>$cart['sale_id'],'item_id'=>$item['item_id'],'quantity'=>0)); 
                    }
                }
                $this->session['pre']=$previous_cart;
            } 
              
        }
        $this->reload();
    }

    public function actionAdd()
    {
       
        $data=array();
        $item_id = $_POST['SaleItem']['item_id'];
        // $cart=$this->session['cart'];
        // if(array_key_exists($item_id, $cart)){
        //     $this->editSaleTranType1($item_id,1);//update item quantity if item already exist
        // }
        
        if (!Yii::app()->shoppingCart->addItem($item_id)) {
            $data['warning'] = 'Unable to add item to sale';
            Yii::app()->user->setFlash('warning', 'Unable to add item to sale');
        }

        if (Yii::app()->shoppingCart->outofStock($item_id)) {
            //$data['warning'] = 'Warning, Desired Quantity is Insufficient. You can still process the sale, but check your inventory!';
            Yii::app()->user->setFlash('warning', 'Desired Quantity is Insufficient. You can still process the sale, but check your inventory!');
        }
        $this->editSaleTranType1($item_id,1);  
        $this->reload($data);
      
    }

    public function actionIndexPara($item_id)
    {
        if (Yii::app()->user->checkAccess('sale.edit')) {

            Yii::app()->shoppingCart->addItem($item_id);

            $this->reload($item_id);
        } else {
            throw new CHttpException(403, 'You are not authorized to perform this action');
        }
    }

    public function actionDeleteItem($item_id,$quantity=0)
    {
        ajaxRequestPost();

        //new line added on 10/06/2018 by snak
        $this->setSession(Yii::app()->session);
        $deleted_item=$this->session['deleted_item'];//to store deleted item to be roleback quantity
        $deleted_item[]=array('item_id'=>$item_id,'quantity'=>$quantity);//add delete item info into array
        $this->session['deleted_item']=$deleted_item;//pass deleted_item to store in session
        //end ==================================================
        Yii::app()->shoppingCart->deleteItem($item_id);
        
        
        $this->reload();
    }

    public function actionEditItem($item_id)
    {
        ajaxRequestPost();

        $data = array();
        $model = new SaleItem;
        $quantity = isset($_POST['SaleItem']['quantity']) ? $_POST['SaleItem']['quantity'] : null;
        $price = isset($_POST['SaleItem']['price']) ? $_POST['SaleItem']['price'] : null;
        $discount = isset($_POST['SaleItem']['discount']) ? $_POST['SaleItem']['discount'] : null;
        $description = 'test';

        $model->quantity = $quantity;
        $model->price = $price;
        $model->discount = $discount;

        if ($model->validate()) {
            // $price_tier_id=Yii::app()->session['pricebook'];
            // echo "<script>alert('$price_tier_id')</script>";
            // Yii::app()->shoppingCart->setPriceTier($price_tier_id);
            $this->editSaleTranType1($item_id,$quantity);
            Yii::app()->shoppingCart->editItem($item_id, $quantity, $discount, $price, $description);
            Yii::app()->shoppingCart->f5ItemPriceTier();
            
        } else {
            $error = CActiveForm::validate($model);
            $errors = explode(":", $error);
            //$data['warning']=  str_replace("}","",$errors[1]);
            //$data['warning'] = Yii::t('app','Input data type is invalid');
            Yii::app()->user->setFlash('warning', 'Input data type is invalid');
        }

        $this->reload($data);

    }
    protected function editSaleTranType1($item_id,$quantity){
        $this->setSession(Yii::app()->session);
        $pre=$this->session['pre'];
        $cart=$this->session['cart'];
        $sale_id=0;
        if(!empty($pre) or $pre != null){
            foreach($pre as $i){
                $sale_id=$i['sale_id'];//get sale id
                break;
            }
            if(array_key_exists($item_id, $pre)){//check if item is already exist in previous cart
               
                if(strtolower($this->action->id)=='edititem'){//check if action is edit
                    $quantity=$quantity;//if action is edit then set quantity equal to quantity 
                }elseif(strtolower($this->action->id=='add')){//if action is edit then set quantity equal to quantity in cart plus one
                    //when user add new item to sale system automatic add quantity = 1
                    $quantity=$cart[$item_id]['quantity']+1;
                }
                //get previous sale item function use to get previous quantity to be calculate when
                //user made adjustment on any item when in editing mode
                $item=Sale::model()->getPreviouseSaleItem($pre[$item_id]['sale_id'],$item_id,$quantity);
                //set previous quantity equal to new quantity
                //Ex. if the previous sale of item A=4 then user increase quantity to 5
                //then we will get 5-4 = 1 to update in item quantity
                $pre[$item_id]['quantity']=isset($item[0]['quantity']) ? $item[0]['quantity'] : $quantity;
                
            }else{
                //if item not exist in previous sale this is happen when user edit invoice and add some new item
                //so we need to add that item to this cart to merge it as one transaction
                $pre+=array($cart[$item_id]['item_id']=>array('sale_id'=>$sale_id,'item_id'=>$cart[$item_id]['item_id'],'quantity'=>$cart[$item_id]['quantity'])); 
            }
            $this->session['pre']=$pre;
        }      
    }
    public function actionAddPayment()
    {
        ajaxRequestPost();

        $data= array();
        $alt_payment_amount_to_base=0; // KHR amount convert to base currency USD here
        $payment_amount = trim($_POST['payment_amount']) == "" ? 0 : $_POST['payment_amount'];
        $alt_payment_amount = trim($_POST['alt_payment_amount']) == "" ? 0 : $_POST['alt_payment_amount'];

        if (trim($_POST['alt_payment_amount']) !== "") {
            // round two decimal place down 1.268 or 1.264 will round to 1.26
            $alt_payment_amount_to_base =  floor($alt_payment_amount / Yii::app()->settings->get('exchange_rate', 'USD2KHR')*100)/100;
        }

        if ( "" == trim($_POST['payment_amount']) && "" == trim($_POST['alt_payment_amount']) ) {
            //$data['warning']=Yii::t('app',"Please enter value in payment amount");
            Yii::app()->user->setFlash('warning', 'Please enter value in payment amount');
        } else {
            $payment_id = $_POST['payment_id'];
            $payment_amount_total = $payment_amount + $alt_payment_amount_to_base;
            $payment_note = Yii::app()->settings->get('site', 'currencySymbol') . $payment_amount . ';' . '៛' . $alt_payment_amount . ';' . Yii::app()->settings->get('site', 'currencySymbol') . $payment_amount_total . ';' . Yii::app()->settings->get('exchange_rate', 'USD2KHR');
            Yii::app()->shoppingCart->setPaymentNote($payment_note);
            Yii::app()->shoppingCart->addPayment($payment_id, $payment_amount_total);
        }
        $this->reload($data);
    }

    public function actionDeletePayment($payment_id)
    {
        ajaxRequestPost();

        Yii::app()->shoppingCart->deletePayment($payment_id);
        $this->reload();
    }

    public function actionSelectCustomer()
    {
        ajaxRequestPost();

        $client_id = $_POST['SaleItem']['client_id'];
        $client = Client::model()->findByPk($client_id);
        Yii::app()->shoppingCart->setCustomer($client_id);
        Yii::app()->shoppingCart->setPriceTier($client_id);
        Yii::app()->shoppingCart->f5ItemPriceTier();
        $this->reload();
    }

    public function actionRemoveCustomer()
    {
        ajaxRequestPost();

        Yii::app()->shoppingCart->removeCustomer();
        Yii::app()->shoppingCart->clearPriceTier();
        $this->reload();
    }

    public function actionSetComment()
    {
        ajaxRequestPost();

        Yii::app()->shoppingCart->setComment($_POST['comment']);
        echo CJSON::encode(array(
            'status' => 'success',
            'div' => "<div class=alert alert-info fade in>Successfully saved ! </div>",
        ));
    }
    
    public function actionSetTotalDiscount()
    {
        ajaxRequestPost();

        $data= array();
        $model = new SaleItem;
        $total_discount =$_POST['SaleItem']['total_discount'];
        $model->total_discount=$total_discount;

        if ($model->validate()) {
            Yii::app()->shoppingCart->setTotalDiscount($total_discount);
        } else {
            $error=CActiveForm::validate($model);
            $errors = explode(":", $error);
            $data['warning']=  str_replace("}","",$errors[1]);
            Yii::app()->user->setFlash('warning',  $data['warning']);

        }

        $this->reload($data);

    }

    public function actionSetGST()
    {
        if (Yii::app()->request->isPostRequest) {
            $data = array();
            $model = new SaleItem;
            $amount = $_POST['SaleItem']['total_gst'];
            $model->total_gst = $amount;

            if ($model->validate()) {
                Yii::app()->shoppingCart->setTotalGST($amount);
            } else {
                $error = CActiveForm::validate($model);
                $errors = explode(":", $error);
                $data['warning'] = str_replace("}", "", $errors[1]);
                Yii::app()->user->setFlash('warning',  $data['warning']);

            }

            $this->reload($data);
        }
    }

    public function actionSetPriceTier()
    {
        if (Yii::app()->request->isPostRequest && Yii::app()->request->isAjaxRequest) {
            // $this->setSession(Yii::app()->session);

            // $this->session['pricebook']=$_POST['price_tier_id'];//initail data from session
            $price_tier_id = $_POST['price_tier_id'];
            echo $_POST['customer_id'];
            Yii::app()->shoppingCart->setPriceTier($price_tier_id);
            Yii::app()->shoppingCart->f5ItemPriceTier();
            $this->reload();
        }
    }

    public function actionSetPaymentTerm()
    {
        ajaxRequestPost();

        $id = $_POST['payment_term_id'];
        Yii::app()->shoppingCart->setPaymentTerm($id);
        $this->reload();
    }

    public function actionSetSaleRep()
    {
        if (Yii::app()->request->isPostRequest) {
            $employee_id = $_POST['id'];
            Yii::app()->shoppingCart->setSaleRep($employee_id);
            $this->reload();
        }
    }

    public function actionCancelSale()
    {
        ajaxRequestPost();

        Yii::app()->shoppingCart->clearAll();
        $this->reload();
    }

    public function actionCompleteSale()
    {
        $this->layout = '//layouts/column_receipt';

        $data = $this->sessionInfo();
        //$customer = $this->customerInfo($data['customer_id']);
        //$data['cust_fullname'] = $customer !== null ? $customer->first_name . ' ' . $customer->last_name : 'General';

        /*
         * Check if there is payment is less than total sale - Customer Must be defined
         */
        $this->setSession(Yii::app()->session);
        if ($data['amount_change'] > 0 && $data['customer'] == null) {
            $data['warning'] = Yii::t('app', 'Plz, Select Customer');
            Yii::app()->user->setFlash('warning', 'Plz, Select Customer');
            $this->reload($data);
        } elseif (empty($data['items'])) {
            //$data['warning'] = Yii::t('app','There is no item in cart');
            Yii::app()->user->setFlash('warning', "There is no item in cart");
            $this->redirect(array('saleItem/index',array('tran_type' => getTransType())));
        } else {
            //Save transaction to db
            /*
            $data['sale_id'] = Sale::model()->saveSale($data['session_sale_id'], $data['items'], $data['payments'],
                $data['payment_received'], $data['customer_id'], $data['employee_id'], $data['sub_total'], $data['total'],
                $data['comment'], $data['tran_type'], $data['discount_amt'],$data['discount_symbol'],
                $data['total_gst'],$data['salerep_id'],$data['qtytotal']);
            */
                // $status=getTransType();
                
                $data['sale_id'] = Sale::model()->saveSale($data['session_sale_id'], $data['items'], $data['payments'],
                $data['payment_received'], $data['customer_id'], $data['employee_id'], $data['sub_total'], $data['total'],
                $data['comment'], $data['tran_type'], $data['discount_amt'],$data['discount_symbol'],
                $data['total_gst'],$data['salerep_id'],$data['qtytotal'],$data['cust_term']);
                $data['receipt_header_title_kh']=$this->getInvoiceTitle($data['tran_type'],'kh');
                $data['receipt_header_title_en']=$this->getInvoiceTitle($data['tran_type'],'en');

                if($data['tran_type']==param('sale_complete_status')){

                    $this->actionSaleUpdateStatus($data['sale_id'],$data['tran_type'],false);
                }
                
            if (substr($data['sale_id'], 0, 2) == '-1') {
                $data['warning'] = $data['sale_id'];
                Yii::app()->user->setFlash('warning', $data['sale_id']);
                $this->redirect(Yii::app()->user->returnUrl);
                $this->reload($data);
            } else {
                //$this->render('//receipt/index', $data);
                $this->renderRecipe($data);
                Yii::app()->shoppingCart->clearAll();
            }
        }

        unset($this->session['pre']);
        unset($this->session['deleted_item']);
    }
    private function getInvoiceTitle($status,$lang)
    {
        if($lang=='kh'){
            return $status==param('sale_submit_status') ? 'ការបញ្ជាទិញ' : 'វិក័យប័ត្រ';    
        }else{
             return $status==param('sale_submit_status') ? 'Sale Order' : 'Invoice';    
        }
    }
    public function actionListSuspendedSale()
    {
        $model = new Sale;
        $this->render('sale_suspended', array('model' => $model));
    }

    public function actionSuspendSale()
    {
        ajaxRequestPost();

        $data=$this->sessionInfo();

        //Save transaction to db
       //$data['sale_id'] = 'POS ' . Sale::model()->saveSale($data['session_sale_id'], $data['items'], $data['payments'], $data['payment_received'], $data['customer_id'], $data['employee_id'], $data['sub_total'], $data['comment'], Yii::app()->params['sale_suspend_status'], $data['total_discount']);
       $data['sale_id'] = Sale::model()->saveSale($data['session_sale_id'], $data['items'], $data['payments'],
           $data['payment_received'], $data['customer_id'], $data['employee_id'], $data['sub_total'], $data['total'],
           $data['comment'], param('sale_suspend_status'), $data['discount_amt'],$data['discount_symbol'],
           $data['total_gst'],$data['salerep_id'],$data['qtytotal']);

        //$customer = $this->customerInfo($data['customer_id']);
        //$data['cust_fullname'] = $customer !== null ? $customer->first_name . ' ' . $customer->last_name : 'General';

        if ($data['sale_id'] == 'POS -1') {
            echo "NOK";
            Yii::app()->user->setFlash('warning', $data['sale_id']);
            Yii::app()->end();
        } else if (Yii::app()->settings->get('sale', 'receiptPrintDraftSale') == '1') {
            $this->layout = '//layouts/column_receipt';
            $this->render('_receipt_suspend', $data);
            Yii::app()->shoppingCart->clearAll();
        } else {
            Yii::app()->shoppingCart->clearAll();
        }
        $this->reload();
    }

    public function actionUnSuspendSale($sale_id)
    {
        Yii::app()->shoppingCart->clearAll();
        Yii::app()->shoppingCart->copyEntireSuspendSale($sale_id);
        //Sale::model()->saveUnsuspendSale($sale_id); // Roll back stock cut to original stock
        $this->redirect('index');
        exit;
    }

    public function actionViewSaleInvoice($sale_id, $customer_id,$employee_id, $paid_amount,$tran_type)
    {
        authorized('sale.view') || authorized('sale.create') ;

        $this->layout = '//layouts/column_receipt';
            Yii::app()->shoppingCart->setInvoiceFormat('format_hf');
            //Yii::app()->shoppingCart->clearAll();
            Yii::app()->shoppingCart->copyEntireSale($sale_id);
            $data=$this->sessionInfo();

            $data['sale_id'] = $sale_id;
            $data['customer_id'] = $customer_id;
            $data['paid_amount'] = $paid_amount;
            $data['status'] = $tran_type;
            $data['receipt_header_title_kh']=$this->getInvoiceTitle($tran_type,'kh');
                $data['receipt_header_title_en']=$this->getInvoiceTitle($tran_type,'en');

            //Sale::model()->updatePrinter($sale_id,$status);

            if (count($data['items']) == 0) {
                $data['error_message'] = 'Sale Transaction Failed';
            }

            $this->renderRecipe($data);
            Yii::app()->shoppingCart->clearAll();

    }

    public function actionEditSale($sale_id, $customer_id, $paid_amount,$tran_type='2')
    {
        authorized('sale.update') || authorized('sale.create') ;

        if ($paid_amount == 0 || $customer_id == "") {
            //if(Yii::app()->request->isPostRequest)
            //{
            Yii::app()->shoppingCart->clearAll();
            Yii::app()->shoppingCart->copyEntireSale($sale_id);
            Yii::app()->shoppingCart->setSaleMode('EDIT');
            Yii::app()->session->close(); // preventing session clearing due to page redirecting..
            
            $this->redirect(array('update','sale_id'=>$sale_id,'tran_type'=>$tran_type));
            //}
        } else {
            Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_INFO, 'Opp, sorry invoice has been paid, editing is not allowed!');
            $this->redirect(array('report/SaleInvoice'));
        }

    }

    public function actionReceipt($sale_id)
    {
        if (Yii::app()->user->checkAccess('invoice.print')) {
           
            $this->layout = '//layouts/column_receipt';

            Yii::app()->shoppingCart->clearAll();
            Yii::app()->shoppingCart->copyEntireSale($sale_id);

            $data=$this->sessionInfo();
            
            $data['sale_id'] = $sale_id;

            //$customer = $this->customerInfo($data['customer_id']);
            //$data['customer'] = $customer !== null ? $customer->first_name . ' ' . $customer->last_name : '';
         
            if (count($data['items']) == 0) {
                $data['error_message'] = 'Sale Transaction Failed';
            }
            
           //$this->render('//receipt/index', $data);
            $this->renderRecipe($data);
            //$this->render('//receipt/'. $data['receipt_folder'] .'index', $data);
            //Yii::app()->shoppingCart->clearAll();
        } else {
            throw new CHttpException(403, 'You are not authorized to perform this action');
        }
        
    }

    /*
        To remove name changing using CRUD name convension List, Create, Update, Delete
    */
    public function actionSaleOrder()

    {
        /*
        $model = new Sale;
        $grid_columns = Sale::getSaleOrderColumns();

        $data = $this->saleTypeData();
        $data['model'] = $model;
        $data['sale_status'] = param('sale_suspend_status');
        $data['box_title'] = 'Sale Order';
        $data['color_style'] = TbHtml::BUTTON_COLOR_PRIMARY;
        $data['sale_header_icon'] = sysMenuSaleIcon();
        $data['grid_columns'] = $grid_columns;


        $this->render('list', $data);
        */

        $grid_id = 'sale-order-grid';
        $title = 'Sale Order';

        $data = $this->commonData($grid_id,$title,'show');

        $data['grid_columns'] = ReportColumn::getSaleOrderColumns();
        $data['data_provider'] = $data['report']->saleInvoice();

        loadview('report',$data);

    }

    public function actionReview()
    {
        $grid_id = 'sale-order-grid';
        $title = 'Sale Order Review List';

        $data = $this->commonData($grid_id,$title,'show');

        $data['grid_columns'] = ReportColumn::getSaleOrderColumns();
        $data['data_provider'] = $data['report']->saleListByStatusUser(param('sale_submit_status'), getEmployeeId());
        $data['grid_id'] = 'sale-order-grid';
        loadview('review','partialList/_grid_one',$data);

    }

    public function actionApprove()
    {
        $grid_id = 'sale-order-grid';
        $title = 'Sale Order Approval List';

        $data = $this->commonData($grid_id,$title,'show');

        $data['grid_columns'] = ReportColumn::getSaleOrderColumns();
        $data['data_provider'] = $data['report']->saleListByStatus(param('sale_approve_status'));
        $data['grid_id'] = 'sale-order-grid';
        loadview('review','partialList/_grid_one',$data);

    }

    //public function actionList($status,$user_id=null,$title='Sale Order')
    public function actionList()
    {
        $grid_id = 'sale-order-grid';
       //$title = 'Order To Invoice';
        $title = $_GET['title'];
        $tran_type = $_GET['tran_type'];
        $user_id = $_GET['user_id'];

        $data = $this->commonData($grid_id,$title,'show','show');

        $data['grid_columns'] = ReportColumn::getSaleOrderColumns();
        $data['status'] = $tran_type;
        $data['user_id'] = $user_id;
        $data['title'] = $title;

        if ($user_id !==null) {
            $data['data_provider'] = $data['report']->saleListByStatusUser($tran_type, $user_id);
        } else {
            $data['data_provider'] = $data['report']->saleListByStatus($tran_type);
        }

        $data['grid_id'] = 'sale-order-grid';

        loadview('review','//layouts/report/_grid',$data);
    }

    // Old one to be delete too complicated to do process base or wizard form here
    /*
    public function actionList()
    {
        $grid_id = 'sale-order-grid';
        $title = 'Sale Order';

        $data = $this->commonData($grid_id,$title,'show');

        $data['grid_columns'] = ReportColumn::getSaleOrderColumns();
        $data['data_provider'] = $data['report']->saleListAll();
        $data['data_provider2'] = $data['report']->saleListByStatusUser(param('sale_submit_status'), getEmployeeId());
        $data['data_provider3'] = $data['report']->saleListByStatus(param('sale_approve_status'));
        $data['data_provider1'] = $data['report']->saleListByStatus(param('sale_complete_status'));
        $data['grid_id'] = $grid_id;
        $data['grid_id2'] = 'sale-order-wait-grid';
        $data['grid_id3'] = 'sale-order-review-grid';
        $data['grid_id1'] = 'sale-order-complete-grid';
        $data['sale_submit_n'] = $data['report']->saleCountByStatus('2');
        $data['sale_approve_n'] = $data['report']->saleCountByStatus('3');
        $data['sale_complete_n'] = $data['report']->saleCountByStatus('1');

        loadview('report','partialList/_grid',$data);

    }
    */

    public function actionSaleInvoice()
    {
        /*
        $model = new Sale;
        $grid_columns = $grid_columns = Sale::getInvoiceColumns();

        $data = $this->saleTypeData();
        $data['model'] = $model;
        $data['sale_status'] = param('sale_complete_status');
        $data['box_title'] = 'Invoice';
        $data['color_style'] = TbHtml::BUTTON_COLOR_SUCCESS;
        $data['sale_header_icon'] = sysMenuInvoiceIcon();
        $data['grid_columns'] = $grid_columns;

        $this->render('list', $data);
        */
        $grid_id = 'sale-invoice-grid';
        $title = 'Sale Invoice';

        $data = $this->commonData($grid_id,$title,'show');

        $data['grid_columns'] = ReportColumn::getInvoiceColumns();
        $data['data_provider'] = $data['report']->saleInvoice();

        loadview('report',$data);

    }

    public function actionDeleteSale($sale_id,$customer_id)
    {
        $result_id = Sale::model()->deleteSale($sale_id, 'Cancel Suspended Sale', $customer_id,Yii::app()->shoppingCart->getEmployee());

        if ($result_id === -1) {
            Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_SUCCESS,
                '<strong>Oh snap!</strong> Change a few things up and try submitting again.');
        } else {
            Yii::app()->shoppingCart->clearAll();
            Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_SUCCESS,
                '<strong>Well done!</strong> Invoice Id ' . $sale_id . 'have been deleted successfully!');
            $this->redirect('ListSuspendedSale');
        }

    }

    public function actionSetInvoiceFormat()
    {
        ajaxRequestPost();

        $invoice_format = $_POST['id'];
        Yii::app()->shoppingCart->setInvoiceFormat($invoice_format);

        if ($invoice_format=='format3') {
            Yii::app()->shoppingCart->setTotalGST(10);
        }

        $this->reload();
    }

    public function actionSaleUpdateStatus($sale_id,$tran_type,$ajax=true) {
        if($ajax==true){
            ajaxRequest();
        }
        $this->setSession(Yii::app()->session);
        $deleted_item=$this->session['deleted_item'];
        if($tran_type==param('sale_complete_status')){
            $item_id='';
            
            if(count($this->session['pre'])>0){
                foreach($this->session['pre'] as $key=>$value){
                    Sale::model()->updateItemQuantity($value['item_id'],$value['quantity']);
                }    
            }else{
                $sale_item=SaleItem::model()->findAll(array(
                            'condition'=>'`sale_id`=:sale_id',
                            'params'=>array(
                                ':sale_id'=>$sale_id
                            )
                        ));    
                foreach($sale_item as $sale){
                    Sale::model()->updateItemQuantity($sale->item_id,$sale->quantity);    
                }
            }
            if(!empty($deleted_item) or $deleted_item != null){
                foreach ($deleted_item as $d => $i) {
                    Sale::model()->rolebackItemQuantity($i['item_id'],$i['quantity']);
                }
            }
        }
        Sale::model()->updateSaleStatus($sale_id,$tran_type);
    }

    // To be delete change to saleUpdate status function
    public function actionSaleApprove($sale_id,$tran_type,$customer_id,$total) {

        ajaxRequest();

        $payment_received=0;

        // Transaction Date for Inventory, Payment and sale trans date
        $trans_date = date('Y-m-d H:i:s');
        $date_paid = $trans_date;
        $comment = 'Approve Sale Order';
        $trans_code = 'CHSALE';
        $trans_status = '';
        $employee_id = getEmployeeId();

        // Getting Customer Account Info
        $account = Account::model()->getAccountInfo($customer_id);

        Sale::model()-> updateSaleStatus($sale_id,$tran_type);

        // Add hot bill before proceed payment
        Account::model()->depositAccountBal($account,$total);
        SalePayment::model()->payment(null,$customer_id,$employee_id,$account,$payment_received,$date_paid,$comment);
        //Saving Account Receivable for Sale transaction code = 'CHSALE'
        AccountReceivable::model()->saveAccountRecv($account->id, $employee_id, $sale_id, $total,$trans_date,$comment, $trans_code, $trans_status);

        $this->actionList();
    }

    public function actionPrinting($sale_id,$tran_type,$format)
    {
        //if (Yii::app()->request->isPostRequest) {

            $this->layout = '//layouts/column_receipt';
            Yii::app()->shoppingCart->setInvoiceFormat($format);
            Yii::app()->shoppingCart->clearAll();
            Yii::app()->shoppingCart->copyEntireSale($sale_id);

            $data=$this->sessionInfo();

            $data['sale_id'] = $sale_id;

            Sale::model()->updatePrinter($sale_id,$tran_type);

            if (count($data['items']) == 0) {
                $data['error_message'] = 'Sale Transaction Failed';
            }

            $this->renderRecipe($data);
            Yii::app()->shoppingCart->clearAll();
        //}
    }

    private function reload($data=array())
    {
        $this->layout = '//layouts/column_sale';

        $model = new SaleItem;
        $data['model'] = $model;
        $data['status'] = 'success';

        $data=$this->sessionInfo($data);

        $model->comment = $data['comment'];
        $model->total_discount= $data['total_discount'];
        $model->total_gst= $data['total_gst'];

        loadview('index','index',$data);

    }

    protected function sessionInfo($data=array()) 
    {
        //$data = $this->invoiceData();

        //$data=array();
        //$data['receipt_biz_name'] = Yii::app()->params['biz_name'] !='' ? Yii::app()->params['biz_name'] . '/' : '';

        //$data['receipt_folder'] = Yii::app()->params['biz_name'] !='' ? Yii::app()->params['biz_name'] . '/' : '';
        $data['title']=getTransType()==param('sale_submit_status') ? 'Order To Validate' : (getTransType()==param('sale_validate_status') ? 'Order To Invoice' : (getTransType()==param('sale_complete_status') ? 'Order To Deliver' : 'Sale Order'));
        $data['invoice_header_view'] = '_header';
        $data['invoice_header_body_view'] = '_header_body';
        $data['invoice_body_view'] = '_body';
        $data['invoice_body_footer_view'] = '_body_footer';
        $data['invoice_footer_view'] = '_footer';
        $data['invoice_no_prefix'] = Common::getInvoicePrefix();
        //$data['invoice_folder'] = invFolderPath();

        /*$data['receipt_header_view'] =  '_header';
        $data['receipt_body_view'] =  '_body';
        $data['receipt_footer_view'] = null;*/

        $data['tran_type'] = getTransType();
        $tran_type=isset($_GET['tran_type']) ? $_GET['tran_type'] : $data['tran_type'];
        $data['url_back']='saleItem/list?tran_type='.$tran_type.'&user_id='.getEmployeeId().'&title='.$data['title'];
        $data['sale_header'] = $data['tran_type']==param('sale_complete_status')? 'Create Invoice':'Create Sale Order';
        $data['sale_header_icon'] = $data['tran_type']==param('sale_complete_status')? sysMenuInvoiceIcon():sysMenuSaleIcon();
        $data['sale_save_url'] = $data['tran_type']==param('sale_complete_status') ? 'saleItem/CompleteSale':'saleItem/CompleteSale';
        $data['sale_redirect_url'] = $data['tran_type']==param('sale_complete_status')? 'saleItem/SaleInvoice':'saleItem/SaleOrder';
        $data['color_style'] = $data['tran_type']==param('sale_complete_status')? TbHtml::BUTTON_COLOR_SUCCESS:TbHtml::BUTTON_COLOR_PRIMARY;

        $data['items'] = Yii::app()->shoppingCart->getCart();
        $data['count_item'] = Yii::app()->shoppingCart->getQuantityTotal();
        $data['payments'] = Yii::app()->shoppingCart->getPayments();
        $data['count_payment'] = count(Yii::app()->shoppingCart->getPayments());
        $data['payment_received'] = Yii::app()->shoppingCart->getPaymentsTotal();
        $data['sub_total'] = Yii::app()->shoppingCart->getSubTotal();
        $data['total_b4vat'] = Yii::app()->shoppingCart->getTotalB4Vat();
        $data['total'] = Yii::app()->shoppingCart->getTotal();
        $data['total_due'] = Yii::app()->shoppingCart->getTotalDue();
        $data['qtytotal'] = Yii::app()->shoppingCart->getQuantityTotal();
        //$data['amount_change'] = Yii::app()->shoppingCart->getAmountDue(); // This is only work for current invoice
        $data['amount_change'] = Yii::app()->shoppingCart->getTotalDue(); // Outstanding + Current Invoice / Hot Bill - Total Payment
        $data['customer_id'] = Yii::app()->shoppingCart->getCustomer();
        $data['comment'] = Yii::app()->shoppingCart->getComment();
        $data['employee_id'] = Yii::app()->session['employeeid'];
        $data['salerep_id'] = Yii::app()->shoppingCart->getSaleRep();
        $data['transaction_date'] = date('d/m/Y',strtotime(Yii::app()->shoppingCart->getSaleTime())); //date('d/m/Y');
        $data['transaction_time'] = date('h:i:s',strtotime(Yii::app()->shoppingCart->getSaleTime())); //date('h:i:s');
        $data['session_sale_id'] = Yii::app()->shoppingCart->getSaleId();
        //$data['employee'] = ucwords(Yii::app()->session['emp_fullname']);
        $data['total_discount'] = Yii::app()->shoppingCart->getTotalDiscount();
        $data['total_gst'] = Yii::app()->shoppingCart->getTotalGST();
        $data['sale_mode'] = Yii::app()->shoppingCart->getSaleMode();
        $data['cust_term'] = Yii::app()->shoppingCart->getPaymentTerm();

        $data['disable_editprice'] = Yii::app()->user->checkAccess('sale.editprice') ? false : true;
        $data['disable_discount'] = Yii::app()->user->checkAccess('sale.discount') ? false : true;
        $data['colspan'] = Yii::app()->settings->get('sale','discount')=='hidden' ? '2' : '3';

        $data['discount_amount'] = Common::calDiscountAmount($data['total_discount'],$data['sub_total']);
        $data['gst_amount'] = $data['total_b4vat'] * $data['total_gst']/100;

        $discount_arr=Common::Discount($data['total_discount']);
        $data['discount_amt']=$discount_arr[0];
        $data['discount_symbol']=$discount_arr[1];

        /** Rounding a number to a nearest 10 or 100 (Floor : round down, Ceil : round up , Round : standard round 
         *  Ref: http://stackoverflow.com/questions/1619265/how-to-round-up-a-number-to-nearest-10
         *    ** http://stackoverflow.com/questions/6619377/how-to-get-whole-and-decimal-part-of-a-number
         *  Method : using Round method here 
        */
        $data['usd_2_khr'] = Yii::app()->settings->get('exchange_rate', 'USD2KHR');
        $data['total_khr'] = $data['total'] * $data['usd_2_khr']; 
        $data['amount_change_khr'] = $data['amount_change'] * $data['usd_2_khr']; //Stupid PHP passing calculation 0.9-1 * 4000 = -3999.1 ,  (0.9-1) * 4000 = 400 correct
        
        /*
         * Total is to round up [Ceil] - Company In
         * Amount_Change suppose to round done [Floor] but usually this value is minus so using [Ceil] instead
        */
        $data['total_khr_round'] = ceil($data['total_khr']/100)*100;

        $data['amount_change_khr_round'] = ceil($data['amount_change_khr']/100-0.1)*100; // Got no idea why PHP ceil(-0.1/100)*100 = 399

        $data['amount_change_whole'] = ceil($data['amount_change']);  // floor(1.25)=1
        $data['amount_change_fraction_khr'] = ceil( (( $data['amount_change'] -  $data['amount_change_whole'] ) * $data['usd_2_khr'])/100 - 0.1 ) * 100; //Added 0.1 to solve ceil (-0.1/100)*100=399
               
        /*** Customer Account Info ***/
        $account = $this->custAccountInfo($data['customer_id']);
        $customer = Client::model()->clientByID($data['customer_id']);
        $employee = Employee::model()->employeeByID($data['employee_id']);
        $sale_rep = Employee::model()->employeeByID($data['salerep_id']);
        $group_name = Client::model()->groupByID($data['customer_id']);
        $data['account'] = $account;
        $data['customer'] = $customer;
        $data['employee'] = $employee;

        $data['acc_balance'] = $account !== null ? $account->current_balance : '';
        $data['cust_fullname'] = $customer !== null ? $customer->first_name . ' ' . $customer->last_name : 'General';
        $data['group_name'] = $group_name !== null ? $group_name : 'General';
        $data['salerep_fullname'] = $sale_rep !== null ? $sale_rep->first_name . ' ' . $sale_rep->last_name : $employee->first_name . ' '  . $employee->last_name;
        $data['salerep_tel'] = $sale_rep !== null ? $sale_rep->mobile_no : '';
        $data['cust_address1'] = $customer !== null ? $customer->address1 : '';
        $data['cust_address2'] = $customer !== null ? $customer->address2 : '';
        $data['cust_mobile_no'] = $customer !== null ? $customer->mobile_no : '';
        $data['cust_fax'] = $customer !== null ? $customer->fax : '';
        $data['cust_notes'] = $customer !== null ? $customer->notes : '';
        $data['cust_contact_fullname'] = '';

        if ($customer !== null) {

            $data['cust_contact_fullname'] = $customer->contact !== null ? $customer->contact->first_name . ' ' . $customer->contact->last_name : '';
            $data['cust_term'] = $data['cust_term'] == null ? $customer->payment_term : $data['cust_term'];
            //s$data['total_due'] = 0 ;
        }

        return $data;
    }
    
    protected function custAccountInfo($customer_id)
    {
        $model=null;
        if ($customer_id != null) {
            $model = Account::model()->getAccountInfo($customer_id);
        }
        
        return $model;
    }

    protected function renderRecipe($data)
    {
        $this->render('//receipt/'. 'index', $data);
    }

    protected function renderViewRecipe($data)
    {
        $this->renderPartial('//receipt/'. 'index_view', $data);
    }

    private function invoiceData() {

        $data['invoice_header_view'] = '_header';
        $data['invoice_header_body_view'] = '_header_body';
        $data['invoice_body_view'] = 'body';
        $data['invoice_body_foot_view'] = '_body_footer';
        $data['_footer_view'] = '_footer';
        $data['invoice_no_prefix'] = Common::getInvoicePrefix();

        return $data;
    }

    private function saleTypeData() {

        $data['tran_type'] = getTransType();
        $data['sale_header'] = $data['tran_type']=='1'? sysMenuInvoice():sysMenuSale();
        $data['sale_save_url'] = $data['tran_type']=='1'? 'saleItem/CompleteSale':'saleItem/CompleteSale';

        return $data;
    }

    protected function commonData($grid_id,$title,$title_icon,$advance_search=null,$header_view='_header',$grid_view='_grid')
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

    public function setSession($value)
    {
        $this->session = $value;
    }

}
