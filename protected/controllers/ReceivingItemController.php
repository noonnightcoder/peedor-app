<?php

class ReceivingItemController extends Controller
{
    //public $layout='//layouts/column1';

    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    public function accessRules()
    {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('view'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('RemoveSupplier','SetComment', 'DeleteItem', 'Add', 'EditItem', 'EditItemPrice', 'Index', 'IndexPara', 'AddPayment', 'CancelRecv', 'CompleteRecv', 'Complete', 'SuspendSale', 'DeletePayment', 'SelectSupplier', 'AddSupplier', 'Receipt', 'SetRecvMode', 'EditReceiving','SetTotalDiscount','InventoryCountCreate','AddCount','GetItemInfo','CountReview','SaveCount'),
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
    
    public function actionIndex($trans_mode = 'receive') 
    {  
        Yii::app()->receivingCart->setMode($trans_mode);
        
        /* To check on performance issue here */
        if ( Yii::app()->user->checkAccess('purchasereceive.read') && Yii::app()->receivingCart->getMode()=='receive' )  {
            $this->reload(); 
        } else if (Yii::app()->user->checkAccess('purchasereturn.read') && Yii::app()->receivingCart->getMode()=='return') {
            $this->reload(); 
        } elseif (Yii::app()->user->checkAccess('stockcount.create') && Yii::app()->receivingCart->getMode()=='adjustment_in') {
            $this->reload(); 
        } elseif (Yii::app()->user->checkAccess('stockcount.create') && Yii::app()->receivingCart->getMode()=='adjustment_out') {
            $this->reload();    
        } 
        // elseif (Yii::app()->user->checkAccess('stock.count') && Yii::app()->receivingCart->getMode()=='physical_count') {
        //     $this->reload(); 
        // } 
        elseif (Yii::app()->user->checkAccess('stockcount.create') && Yii::app()->receivingCart->getMode()=='physical_count') {
            //$this->reload(); 
            authorized('stockcount.create');

            $model = new InventoryCount('search');

            $model->unsetAttributes();  // clear any default values
            if (isset($_GET['InventoryCount'])) {
                $model->attributes = $_GET['InventoryCount'];
            }

            if (isset($_GET['pageSize'])) {
                Yii::app()->user->setState(strtolower(get_class($model)) . '_page_size', (int)$_GET['pageSize']);
                unset($_GET['pageSize']);
            }

            $page_size = CHtml::dropDownList(
                'pageSize',
                Yii::app()->user->getState(strtolower(get_class($model)) . '_page_size', Common::defaultPageSize()),
                Common::arrayFactory('page_size'),
                array('class' => 'change-pagesize')
            );


            $data['model'] = $model;
            $data['grid_id'] = strtolower(get_class($model)) . '-grid';
            $data['main_div_id'] = strtolower(get_class($model)) . '_cart';
            $data['page_size'] = $page_size;
            $data['create_url'] = 'InventoryCountCreate';

            $data['grid_columns'] = InventoryCount::getItemColumns();

            $data['data_provider'] = $model->search();
            $this->render('_list',$data);
        } elseif (Yii::app()->user->checkAccess('stock.count') && Yii::app()->receivingCart->getMode()=='count_detail'){

            authorized('inventorycountdetail.read');

            $model = InventoryCountDetail::getInventoryCountDetail($_GET['id']);

            //$model->unsetAttributes();  // clear any default values
            if (isset($_GET['InventoryCountDetail'])) {
                $model->attributes = $_GET['InventoryCountDetail'];
            }

            if (isset($_GET['pageSize'])) {
                Yii::app()->user->setState(strtolower(get_class($model)) . '_page_size', (int)$_GET['pageSize']);
                unset($_GET['pageSize']);
            }

            $page_size = CHtml::dropDownList(
                'pageSize',
                Yii::app()->user->getState(strtolower('InventoryCountDetail') . '_page_size', Common::defaultPageSize()),
                Common::arrayFactory('page_size'),
                array('class' => 'change-pagesize')
            );


            $data['model'] = $model;
            $data['grid_id'] = strtolower('InventoryCountDetail') . '-grid';
            $data['main_div_id'] = strtolower('InventoryCountDetail') . '_cart';
            $data['page_size'] = $page_size;
            $data['create_url'] = 'InventoryCountCreate';

            $data['grid_columns'] = InventoryCountDetail::getItemColumns();

            $data['data_provider'] = $model;
            $data['count_title']=$_GET['name'];

            $this->render('_detail',$data);
        } else {
            throw new CHttpException(403, 'You are not authorized to perform this action');
        }
    }


    public function actionInventoryCountCreate(){
        //$invcount=new InventoryCount;
        $model = new InventoryCount('search');
        $item = new Item('search');
        $receiveItem = new ReceivingItem;

        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['InventoryCount'])) {
            $model->attributes = $_GET['InventoryCount'];
        }

        if (isset($_GET['pageSize'])) {
            Yii::app()->user->setState(strtolower(get_class($model)) . '_page_size', (int)$_GET['pageSize']);
            unset($_GET['pageSize']);
        }

        $page_size = CHtml::dropDownList(
            'pageSize',
            Yii::app()->user->getState(strtolower(get_class($model)) . '_page_size', Common::defaultPageSize()),
            Common::arrayFactory('page_size'),
            array('class' => 'change-pagesize')
        );


        $data['model'] = $model;
        $data['receiveItem'] = $receiveItem;
        $data['grid_id'] = strtolower(get_class($model)) . '-grid';
        $data['main_div_id'] = strtolower(get_class($model)) . '_cart';
        $data['page_size'] = $page_size;
        $data['create_url'] = 'InventoryCountCreate';

        $data['grid_columns'] = InventoryCount::getItemColumns();

        $data['data_provider'] = $model->search();
        $this->render('create',$data);
    }

    public function actionGetItemInfo(){
        $item_id = $_POST['ReceivingItem']['item_id'];
        $model = Item::model()->findbyPk($item_id);
        var_dump($model);

    }

    public function actionAddCount(){
        $info=Item::model()->findbyPk($_POST['itemId']);
        // var_dump($info['quantity']);
        $this->setSession(Yii::app()->session);
        
        $data=$this->session['latestCount'];//initail data from session
        $exist="";
        if($_POST['opt']==1){
            $itemId=$_POST['itemId'];
            $itemName=$_POST['name'];
            $countNum=$_POST['countNum'];
            $countDate=$_POST['countDate'];
            $countTime=$_POST['countTime'] ? $_POST['countTime'] : date('H:i:s');
            $countName=$_POST['countName'];
            $this->session['countheader']=array('name'=>$countName.' '.$countTime,'created_date'=>$countDate.' '.$countTime);
            if(!empty($data)){//check if data is not empty

                foreach($data as $k=>$v){
                    $exist=array_search($itemName,$data[$k]);//search array by proName
                    if($v['name']==$itemName){//update number of quantity count when item already counted
                        $data[$k]['countNum']+=$countNum;//update array data
                    }
                }

            }
            if($exist==""){
                $data[]=array('itemId'=>$itemId,'name'=>$itemName,'expected'=>$info['quantity'],'cost'=>$info['cost_price'],'countNum'=>$countNum);
            }
            $this->session['latestCount']=$data;//after update or add item to data then update the session
            
        }elseif($_POST['opt']==2){//remove counted item
            unset($_SESSION['latestCount'][$_POST['idx']]); 
        }elseif($_POST['opt']==3){

            if(!empty($data)){//check if data is not empty

                foreach($data as $k=>$v){
                    if($v['itemId']==$_POST['itemId']){//update number of quantity count when item already counted
                        $data[$k]['countNum']=$_POST['newCount'];//update array data
                    }
                }

            }
            $this->session['latestCount']=$data;//after update or add item to data then update the session

        }
        $latest=$this->session['latestCount'];
        //refresh list 
            echo '
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Counted</th>
                        <th style="text-align: right;">Action</th>
                    </tr>
                </thead>
                <tbody>';
            foreach($latest as $key=>$value){
                
                echo'
                <tr>
                    <td width="30">'.$value['itemId'].'</td>
                    <td>'.$value['name'].'</td>
                    <td width="100">
                        <div class="col-sm-12">
                            <input type="number" onkeypress="updateCount('.$value['itemId'].')" class="txt-counted'.$value['itemId'].' form-control" value="'.$value['countNum'].'"></td>
                        </div>
                    <td width="80" align="center">
                        <a class="delete-item btn btn-danger btn-xs" onClick="inventoryCount(2,'.$key.')">
                            <span class="glyphicon glyphicon glyphicon-trash "></span>
                        </a>
                    </td>
                </tr>
                ';
                            
            }
        echo '
            </tbody>
        </table>
        ';
        
    }
    
    public function actionCountReview(){
        $this->setSession(Yii::app()->session);
        $data['items']=$this->session['latestCount'];//initail data from session
        $data['header']=$this->session['countheader'];
        $this->render('_count_review',$data);
    }

    public function actionSaveCount(){
        $this->setSession(Yii::app()->session);
        $data=$this->session['latestCount'];//initail data from session
        $header=$this->session['countheader'];//initail data from session
        $employeeid=Yii::app()->session['employeeid'];

        //save inventory count
        $inventoryCount=new InventoryCount;
        $inventoryCount->name=$header['name'];
        $inventoryCount->created_date=$header['created_date'];
        $inventoryCount->save();

        //save detail and history
        $connection = Yii::app()->db;
        foreach($data as $key=>$value){
            if($value['expected']<0){
                $qty_b4_trans=(-1)*($value['countNum'])-$value['expected'];
                $qty_b4_trans=(-1)*$qty_b4_trans;
            }else{
                $qty_b4_trans=$value['countNum']-$value['expected'];
            }
            $qty_af_trans=$qty_b4_trans+$value['expected'];
            $cost=$qty_b4_trans*$value['cost'];
            $invSql="insert into inventory_count_detail
            (item_id,count_id,expected,counted,unit,cost)
            values(".$value['itemId'].",".$inventoryCount->id.",".$value['expected'].",".$value['countNum'].",".$qty_b4_trans.",".$cost.")";
            $command = $connection->createCommand($invSql);
            $insert = $command->execute(); // execute the non-query SQL


            //save to inventory
            $sql = "insert into inventory
            (trans_items,trans_user,trans_date,trans_comment,trans_inventory,trans_qty,qty_b4_trans,qty_af_trans) 
            values(" .$value['itemId']. ",'".$employeeid."','" .$header['created_date']. "','" .$header['name']. "','".$value['expected']."','".$value['countNum']."','" .$qty_b4_trans. "','".$qty_af_trans."')";
            $command1 = $connection->createCommand($sql);
            $insert1 = $command1->execute(); // execute the non-query SQL

            //update item quantity
            $updateSql="update item set quantity=".$value['countNum']." where id=".$value['itemId'];
            $command2 = $connection->createCommand($updateSql);
            $insert2 = $command2->execute(); // execute the non-query SQL
        }
        unset(Yii::app()->session['latestCount']);
        unset(Yii::app()->session['countheader']);
        $this->redirect(array('receivingItem/index?trans_mode=physical_count'));
    }

    public function actionAdd()
    {   
        //$data=array();
        $item_id = $_POST['ReceivingItem']['item_id'];
        if (Yii::app()->user->checkAccess('purchase.receive') && Yii::app()->receivingCart->getMode()=='receive') {
            $data['warning']=$this->addItemtoCart($item_id);
        } else if (Yii::app()->user->checkAccess('purchase.return') && Yii::app()->receivingCart->getMode()=='return') {
           $data['warning']=$this->addItemtoCart($item_id);
        } else if (Yii::app()->user->checkAccess('stock.in') && Yii::app()->receivingCart->getMode()=='adjustment_in') {
           $data['warning']=$this->addItemtoCart($item_id);  
        } else if (Yii::app()->user->checkAccess('stock.out') && Yii::app()->receivingCart->getMode()=='adjustment_out') {
           $data['warning']=$this->addItemtoCart($item_id);   
        } else if (Yii::app()->user->checkAccess('stock.count') && Yii::app()->receivingCart->getMode()=='physical_count') {
            $data['warning']=$this->addItemtoCart($item_id);     
        } else {
            throw new CHttpException(403, 'You are not authorized to perform this action');
        }
         
        $this->reload($data);
    }
    
    protected function addItemtoCart($item_id)
    {
        $msg=null;
        if (!Yii::app()->receivingCart->addItem($item_id)) {
            $msg = 'Unable to add item to receiving';
        } 
        return $msg;
    }

    public function actionIndexPara($item_id)
    {
        if (Yii::app()->user->checkAccess('purchase.receive') && Yii::app()->receivingCart->getMode()=='receive') {
            //$recv_mode = Yii::app()->receivingCart->getMode();
            //$quantity = $recv_mode=="receive" ? 1:1; // Change as immongo we will place minus or plus when saving to database
            Yii::app()->receivingCart->addItem($item_id);
            $this->reload($item_id);
        } else if (Yii::app()->user->checkAccess('purchase.return') && Yii::app()->receivingCart->getMode()=='return') {
            Yii::app()->receivingCart->addItem($item_id);
            $this->reload($item_id);
        } else if (Yii::app()->user->checkAccess('stock.in') && Yii::app()->receivingCart->getMode()=='adjustment_in') {
            Yii::app()->receivingCart->addItem($item_id);
            $this->reload($item_id);
        } else if (Yii::app()->user->checkAccess('stock.out') && Yii::app()->receivingCart->getMode()=='adjustment_out') {
            Yii::app()->receivingCart->addItem($item_id);
            $this->reload($item_id);  
        } else if (Yii::app()->user->checkAccess('stock.count') && Yii::app()->receivingCart->getMode()=='physical_count') {
            Yii::app()->receivingCart->addItem($item_id);
            $this->reload($item_id);
        } else {
            throw new CHttpException(403, 'You are not authorized to perform this action');
        }    
    }

    public function actionDeleteItem($item_id)
    {
        if ( Yii::app()->request->isPostRequest && Yii::app()->request->isAjaxRequest ) {
            Yii::app()->receivingCart->deleteItem($item_id);
            $this->reload();
        } else {
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
        } 
    }

    public function actionEditItem($item_id)
    {
        if (Yii::app()->request->isPostRequest && Yii::app()->request->isAjaxRequest) {

            $data = array();
            $model = new ReceivingItem;

            $quantity = isset($_POST['ReceivingItem']['quantity']) ? $_POST['ReceivingItem']['quantity'] : null;
            $unit_price = isset($_POST['ReceivingItem']['unit_price']) ? $_POST['ReceivingItem']['unit_price'] : null;
            $cost_price = isset($_POST['ReceivingItem']['cost_price']) ? $_POST['ReceivingItem']['cost_price'] : null;
            $discount = isset($_POST['ReceivingItem']['discount']) ? $_POST['ReceivingItem']['discount'] : null;
            $expire_date = isset($_POST['ReceivingItem']['expire_date']) ? $_POST['ReceivingItem']['expire_date'] : null;
            $description = 'test';

            $model->quantity = $quantity;
            $model->unit_price = $unit_price;
            $model->cost_price = $cost_price;
            $model->discount = $discount;
            $model->expire_date = $expire_date;

            if ($model->validate()) {
                Yii::app()->receivingCart->editItem($item_id, $quantity, $discount, $cost_price, $unit_price,
                    $description, $expire_date);
            } else {
                $error = CActiveForm::validate($model);
                $errors = explode(":", $error);
                $data['warning'] = str_replace("}", "", $errors[1]);
                Yii::app()->user->setFlash('danger',$data['warning']);
            }
            $this->reload($data);
        } else {
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
        }
    }

    public function actionAddPayment()
    {
        if (Yii::app()->request->isPostRequest) {
            if (Yii::app()->request->isAjaxRequest) {
                $payment_id = $_POST['payment_id'];
                $payment_amount = $_POST['payment_amount'];
                //$this->addPaymentToCart($payment_id, $payment_amount);
                Yii::app()->receivingCart->addPayment($payment_id, $payment_amount);
                $this->reload();
            }
        } else {
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
        }    
    }

    public function actionDeletePayment($payment_id)
    {
        if (Yii::app()->request->isPostRequest) {
            Yii::app()->receivingCart->deletePayment($payment_id);
            $this->reload();
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    public function actionSelectSupplier()
    {        
         if ( Yii::app()->request->isPostRequest && Yii::app()->request->isAjaxRequest ) {
            $supplier_id = $_POST['ReceivingItem']['supplier_id'];
            Yii::app()->receivingCart->setSupplier($supplier_id);
            $this->reload();
        } else {
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
        }
    }

    public function actionRemoveSupplier()
    {
        if ( Yii::app()->request->isPostRequest && Yii::app()->request->isAjaxRequest ) {
            Yii::app()->receivingCart->removeSupplier();
            $this->reload();
        } else {
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
        }
    }

    public function actionSetComment()
    {
        Yii::app()->receivingCart->setComment($_POST['comment']);
        echo CJSON::encode(array(
            'status' => 'success',
            'div' => "<div class=alert alert-info fade in>Successfully saved ! </div>",
        ));
    }

    public function actionSetTotalDiscount()
    {
        if (Yii::app()->request->isPostRequest) {
            $data= array();
            $model = new ReceivingItem;
            $total_discount =$_POST['ReceivingItem']['total_discount'];
            $model->total_discount=$total_discount;

            if ($model->validate()) {
                Yii::app()->receivingCart->setTotalDiscount($total_discount);
            } else {
                $error=CActiveForm::validate($model);
                $errors = explode(":", $error);
                $data['warning']=  str_replace("}","",$errors[1]);
            }

            $this->reload($data);
        }
    }

    public function actionSetRecvMode()
    {
        Yii::app()->receivingCart->setMode($_POST['recv_mode']);
        echo CJSON::encode(array(
            'status' => 'success',
            'div' => "<div class=alert alert-info fade in>Successfully saved ! </div>",
        ));
    }

    private function reload($data=array())
    {
        $this->layout = '//layouts/column_sale';
        
        $model = new ReceivingItem;
        $data['model'] = $model;
       
        $data=$this->sessionInfo($data);
        
        //echo $data['trans_header']; die();
        
        //$data['n_item_expire']=ItemExpir::model()->count('item_id=:item_id and quantity>0',array('item_id'=>(int)$item_id));
        
        $model->comment = $data['comment'];
        $model->total_discount= $data['total_discount'];
        
        if ($data['supplier_id'] != null) {
            $supplier = Supplier::model()->findbyPk($data['supplier_id']);
            $data['supplier'] = $supplier;
            //$data['company_name'] = $supplier->company_name;
            //$data['full_name'] = $supplier->first_name . ' ' . $supplier->last_name;
            //$data['mobile_no'] = $supplier->mobile_no;
        }
           
        if (Yii::app()->request->isAjaxRequest) {
            $cs = Yii::app()->clientScript;
            $cs->scriptMap = array(
                'jquery.js' => false,
                'bootstrap.js' => false,
                'jquery.min.js' => false,
                'bootstrap.notify.js' => false,
                'bootstrap.bootbox.min.js' => false,
                'bootstrap.min.js' => false,
                'jquery-ui.min.js' => false,
                //'jquery.mask.js' => false,
                'EModalDlg.js'=>false,
            );

            Yii::app()->clientScript->scriptMap['jquery-ui.css'] = false; 
            Yii::app()->clientScript->scriptMap['box.css'] = false; 
            $this->renderPartial('index', $data, false, true);
        } else {
            $this->render('index', $data);
        }
    }

    public function actionCancelRecv()
    {
        if (Yii::app()->request->isPostRequest && Yii::app()->request->isAjaxRequest) {
            Yii::app()->receivingCart->clearAll();
            $this->reload();
        } else {
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
        }
    }

    public function actionCompleteRecv()
    {
        $data = $this->sessionInfo();

        if (empty($data['items'])) {
            $this->redirect(array('receivingItem/index'));
        } else {
            //Save transaction to db
            $data['receiving_id'] = Receiving::model()->saveRevc($data['items'], $data['payments'],
                $data['supplier_id'], $data['employee_id'], $data['sub_total'], $data['total'], $data['comment'], $data['trans_mode'],
                $data['discount_amt'],$data['discount_symbol']
            );

            if (substr($data['receiving_id'], 0, 2) == '-1') {
                $data['warning'] = $data['receiving_id'];
                Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_SUCCESS,
                    '<strong>Oh snap!</strong>' . $data['receiving_id']);
                $this->reload();
            } else {
                //$trans_mode = Yii::app()->receivingCart->getMode();
                Yii::app()->receivingCart->clearAll();
                $this->redirect(array('receivingItem/index', 'trans_mode' => $data['trans_mode']));
            }
        }
    }

    public function actionSuspendRecv()
    {
        $data['items'] = Yii::app()->receivingCart->getCart();
        $data['payments'] = Yii::app()->receivingCart->getPayments();
        $data['sub_total'] = Yii::app()->receivingCart->getSubTotal();
        $data['total'] = Yii::app()->receivingCart->getTotal();
        $data['supplier_id'] = Yii::app()->receivingCart->getSupplier();
        $data['comment'] = Yii::app()->receivingCart->getComment();
        $data['employee_id'] = Yii::app()->session['employeeid'];
        $data['transaction_time'] = date('m/d/Y h:i:s a');
        $data['employee'] = ucwords(Yii::app()->session['emp_fullname']);

        //Save transaction to db
        $data['sale_id'] = 'POS ' . SaleSuspended::model()->saveSale($data['items'], $data['payments'], $data['supplier_id'], $data['employee_id'], $data['sub_total'], $data['comment']);

        if ($data['sale_id'] == 'POS -1') {
            echo CJSON::encode(array(
                'status' => 'failed',
                'message' => '<div class="alert in alert-block fade alert-error">Transaction Failed.. !<a class="close" data-dismiss="alert" href="#">&times;</a></div>',
            ));
        } else {
            Yii::app()->receivingCart->clearAll();
            $this->reload();
        }
    }

    public function actionUnsuspendRecv($sale_id)
    {
        Yii::app()->receivingCart->clearAll();
        Yii::app()->receivingCart->copyEntireSuspendSale($sale_id);
        SaleSuspended::model()->deleteSale($sale_id);
        //$this->reload();
        $this->redirect('index');

    }

    public function actionEditReceiving($receiving_id)
    {
        if(Yii::app()->request->isPostRequest)
        {
            Yii::app()->receivingCart->clearAll();
            Yii::app()->receivingCart->copyEntireReceiving($receiving_id);
            Receiving::model()->deleteReceiving($receiving_id);
            //$this->reload();
            $this->redirect('index');
        } else {
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
        }
        
    }
    
    protected function sessionInfo($data=array()) 
    {
        $data['supplier'] = null;

        $data['trans_mode'] = Yii::app()->receivingCart->getMode();
        $data['trans_header'] = Receiving::model()->transactionHeader();
        $data['status'] = 'success';
        $data['items'] = Yii::app()->receivingCart->getCart();
        $data['payments'] = Yii::app()->receivingCart->getPayments();
        $data['payment_total'] = Yii::app()->receivingCart->getPaymentsTotal();
        $data['count_item'] = Yii::app()->receivingCart->getQuantityTotal();
        $data['count_payment'] = count(Yii::app()->receivingCart->getPayments());
        $data['sub_total']=Yii::app()->receivingCart->getSubTotal();
        $data['total'] = Yii::app()->receivingCart->getTotal();
        $data['amount_due'] = Yii::app()->receivingCart->getAmountDue();
        $data['comment'] = Yii::app()->receivingCart->getComment();
        $data['supplier_id'] = Yii::app()->receivingCart->getSupplier();
        $data['employee_id'] = Yii::app()->session['employeeid'];
        $data['total_discount'] = Yii::app()->receivingCart->getTotalDiscount();
        $data['discount_amount'] = Common::calDiscountAmount($data['total_discount'],$data['sub_total']);

        $discount_arr=Common::Discount($data['total_discount']);
        $data['discount_amt']=$discount_arr[0];
        $data['discount_symbol']=$discount_arr[1];

        $data['hide_editprice'] = Yii::app()->user->checkAccess('transaction.editprice') ? '' : 'hidden';
        $data['hide_editcost'] = Yii::app()->user->checkAccess('transaction.editcost') ? '' : 'hidden';

        $data['disable_discount'] = Yii::app()->user->checkAccess('sale.discount') ? false : true;


        if (Yii::app()->settings->get('item', 'itemExpireDate') == '1') {
            $data['expiredate_class']='';
        } else {
            $data['expiredate_class']='hidden';
        } 
        
      
        return $data;
    }

    public function setSession($value)
    {
        $this->session = $value;
    }

}
