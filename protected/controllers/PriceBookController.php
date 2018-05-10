<?php

class PriceBookController extends Controller
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
                'actions' => array('Index','View'),
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
    
    public function actionIndex() 
    {  
        authorized('pricebook.read');

        $model = new PriceBook('search');

        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['PriceBook'])) {
            $model->attributes = $_GET['PriceBook'];
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
        $data['create_url'] = 'Create';

        $data['grid_columns'] = PriceBook::getItemColumns();

        $data['data_provider'] = $model->search();
        $this->render('_list',$data);
    }
    public function actionView($id){
        $priceBook=PriceBook::getPriceBookDetail($id);
        $data['data']=$priceBook;
        $data['count_title']='pricebook';
        $this->render('_pricebookDetail',$data);
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

    public function actionAddItem(){
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
                    <td width="80">
                        <input type="button" value="Remove" class="btn btn-danger" onClick="inventoryCount(2,'.$key.')">
                    </td>
                </tr>
                ';
                            
            }
        echo '
            </tbody>
        </table>
        ';
        
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
        $this->redirect(array('receivingItem/index?trans_mode=physical_count2'));
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
