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
                'actions' => array('Index','View','Create','AddItem','SavePriceBook'),
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
    public function actionCreate(){
        //$invcount=new InventoryCount;
        $model = new PriceBook('search');
        $item = new Item('search');
        $outlet = Outlet::model()->findAll();;

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
        $data['outlet'] = $outlet;
        $data['grid_id'] = strtolower(get_class($model)) . '-grid';
        $data['main_div_id'] = strtolower(get_class($model)) . '_cart';
        $data['page_size'] = $page_size;
        $data['create_url'] = 'InventoryCountCreate';

        $data['grid_columns'] = PriceBook::getItemColumns();

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

         $data=$this->session['itemsApplied'];//initail data from session

         if($_POST['opt']==1){

            $itemId=$_POST['itemId'];//item id
            $itemName=$_POST['proName'];//item name
            $start_date=$_POST['start_date'];//price book valid start date
            $end_date=$_POST['end_date'];//price book valid end date
            $outlet=$_POST['outlet'];//price book apply to outlet
            $price_book_name=$_POST['price_book_name'];//price book name

            $this->session['pricebookHeader']=array('name'=>$price_book_name,'outlet'=>$outlet,'start_date'=>$start_date,'end_date'=>$end_date);
           
            $data[]=array('itemId'=>$itemId,'name'=>$itemName,'cost'=>$info['cost_price'],'markup'=>0,'discount'=>0,'retail_price'=>0,'min_qty'=>0,'max_qty'=>0);
         
            $this->session['itemsApplied']=$data;//after update or add item to data then update the session
            
        }elseif($_POST['opt']==2){//remove counted item
            unset($_SESSION['itemsApplied'][$_POST['idx']]); 
        }elseif($_POST['opt']==3){
            $val=$_POST['val'];
            $idx=$_POST['idx'];
            echo $idx;
            if(!empty($data)){//check if data is not empty

                foreach($data as $k=>$v){
                    if($k==$idx){//update number of quantity count when item already counted
                        if($val=='markup'){
                            $data[$k]['markup']=$_POST['markup'];//update array data
                            $data[$k]['retail_price']=$data[$k]['cost']+($data[$k]['cost']*($_POST['markup']/100));
                        }elseif($val=='retail_price'){

                            $data[$k]['retail_price']=$_POST['retail_price'];
                            $data[$k]['markup']=($_POST['retail_price']*100)-100;//update array data

                        }elseif($val=='discount'){

                            $data[$k]['discount']=$_POST['discount'];
                            $data[$k]['retail_price']=$data[$k]['retail_price']-($data[$k]['retail_price']*($_POST['discount']/100));

                        }elseif($val=='min_qty'){

                            $data[$k]['min_qty']=$_POST['min_qty'];

                        }elseif($val=='max_qty'){

                            $data[$k]['max_qty']=$_POST['max_qty'];

                        }
                        
                    }
                }

            }
            $this->session['itemsApplied']=$data;//after update or add item to data then update the session

        }
        $itemsApplied=$this->session['itemsApplied'];
        //refresh list 
            echo '
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Cost</th>
                        <th>Markup<small>(%)</small></th>
                        <th>Discount<small>(%)</small></th>
                        <th>Retail Price<br><small>Exclude Tax</small></th>
                        <th>Min Quantity</th>
                        <th>Max Quantity</th>
                        <th style="text-align: right;">Action</th>
                    </tr>
                </thead>
                <tbody>';
            foreach($itemsApplied as $key=>$value){
                
                echo'
                <tr>
                    <td width="30">'.$value['itemId'].'</td>
                    <td>'.$value['name'].'</td>
                    <td>'.$value['cost'].'</td>
                    <td width="100">
                        <div class="col-sm-12">
                            <input type="number" onkeypress="updateItem('.$value['itemId'].',\'markup\','.$key.')" class="txt-markup'.$key.' form-control" value="'.$value['markup'].'">
                        </div>
                    </td>
                    <td width="100">
                        <div class="col-sm-12">
                            <input type="number" onkeypress="updateItem('.$value['itemId'].',\'discount\','.$key.')" class="txt-discount'.$key.' form-control" value="'.$value['discount'].'">
                        </div>
                    </td>
                    <td width="100">
                        <div class="col-sm-12">
                            <input type="number" onkeypress="updateItem('.$value['itemId'].',\'retail_price\','.$key.')" class="txt-retail-price'.$key.' form-control" value="'.$value['retail_price'].'">
                        </div>
                    </td>
                    <td width="100">
                        <div class="col-sm-12">
                            <input type="number" onkeypress="updateItem('.$value['itemId'].',\'min_qty\','.$key.')" class="txt-min-qty'.$key.' form-control" value="'.$value['min_qty'].'">
                        </div>
                    </td>
                    <td width="100">
                        <div class="col-sm-12">
                            <input type="number" onkeypress="updateItem('.$value['itemId'].',\'max_qty\','.$key.')" class="txt-max-qty'.$key.' form-control" value="'.$value['max_qty'].'">
                        </div>
                    </td>
                    <td width="80">
                        <input type="button" value="X" class="btn btn-danger" onClick="priceBook(2,'.$key.')">
                    </td>
                </tr>
                ';
                            
            }
        echo '
            </tbody>
        </table>
        ';
        
    }

    public function actionSavePriceBook(){
        $this->setSession(Yii::app()->session);
        $data=$this->session['itemsApplied'];//initail data from session
        $header=$this->session['pricebookHeader'];//initail data from session

        //save inventory count
        $priceBook=new PriceBook;

        $criteria = new CDbCriteria();
        $criteria->condition = 'price_book_name=:name';
        $criteria->params = array(':name'=>$header['name']);
        $exists = $priceBook->exists($criteria);
        if($exists){
            echo 'Price Book "'.$header['name'].'" already taken!';
        }else{
            $priceBook->price_book_name=$header['name'];
            $priceBook->start_date=$header['start_date'];
            $priceBook->end_date=$header['end_date'];
            $priceBook->outlet_id=$header['outlet'];
            $saveHeader=$priceBook->save();
            //save detail and history
            $connection = Yii::app()->db;
            foreach($data as $key=>$value){
               
                $invSql="insert into pricings
                (price_book_id,item_id,cost,markup,discount,retail_price,min_unit,max_unit)
                values(".$priceBook->id.",".$value['itemId'].",".$value['cost'].",".$value['markup'].",".$value['discount'].",".$value['retail_price'].",".$value["min_qty"].",".$value['max_qty'].")";
                $command = $connection->createCommand($invSql);
                $insert = $command->execute(); // execute the non-query SQL
                // echo $invSql;
            }
            unset(Yii::app()->session['itemsApplied']);
            unset(Yii::app()->session['pricebookHeader']);
            $this->redirect(array('/pricebook'));
        }
        
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
