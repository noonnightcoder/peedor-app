<?php

class ReceivingController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

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
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array(
					'create',
					'update',
					'ItemTransfer',
					'AddItemToTransfer',
                    'DeleteItemToTransfer',
                    'EditItemToTransfer',
                    'PreviewItemToTransfer',
                    'resetItemToTransfer', 
                    'setReferenceName',
                    'setOutlet',
                    'saveItemToTransfer',
                    'itemTransferSubmited',
                    'TransferDetail',
                    'TransferUpdateStatus',
				),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		authorized('purchase.create');

	    $model=new Receiving;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Receiving']))
		{
			$model->attributes=$_POST['Receiving'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}


	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Receiving']))
		{
			$model->attributes=$_POST['Receiving'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	public function actionItemTransfer()
	{

    	if (isset($_POST['Receiving'])) {

            $model->attributes = $_POST['Receiving'];

        	if ($model->save()) {

				if($model->id>0){//check if item id exist after saved to table
					//echo '<script>alert("Saved")</script>';
				}
				Yii::app()->shoppingCart->emptyItemToTransfer();
				//$this->redirect('Receiving/ItemTransfers');

			}
        }

        $this->reload();

	}

	public function actionSetReferenceName()
	{

    	if (isset($_POST['Receiving']['reference_name'])) {
    		$referenceName = $_POST['Receiving']['reference_name'];
            Yii::app()->shoppingCart->setTransferHeader($referenceName,'reference_name');
             $exists = Receiving::model()->exists('reference_name=:name', array(':name' => $referenceName));

            if($exists){

            	Yii::app()->user->setFlash('warning', 'Reference Name has already been taken');	
            }

        }

        $this->reload();

	}

	public function actionSetOutlet()
	{

    	if (isset($_POST['Receiving'])) {

            $from_outlet = $_POST['Receiving']['from_outlet'];
            Yii::app()->shoppingCart->setTransferHeader($from_outlet,'from_outlet');
            
        	$to_outlet = $_POST['Receiving']['to_outlet'];
            Yii::app()->shoppingCart->setTransferHeader($to_outlet,'to_outlet');

        }

        $from_outlet = Yii::app()->shoppingCart->getTransferHeader('from_outlet');
    	$to_outlet = Yii::app()->shoppingCart->getTransferHeader('to_outlet');

    	if($from_outlet==$to_outlet){

    		Yii::app()->user->setFlash('warning', 'From and To Outlet must difference!!!');
    	}

        $this->reload();
	}

	public function actionAddItemToTransfer()
    {
       
        $data=array();
        $header=array();

        $item_id = $_POST['ItemOutlet']['id'];
    	if(isset($_POST['Receiving'])){
 			$header['reference_name'] = $_POST['Receiving']['reference_name'];
	        $header['delivery_due_date'] = $_POST['Receiving']['delivery_due_date'];
	        $header['from_outlet'] = $_POST['Receiving']['from_outlet'];
	        $header['to_outlet'] = $_POST['Receiving']['to_outlet'];	
 		}

        if (!Yii::app()->shoppingCart->addItemToTransfer($item_id,$header)) {

            Yii::app()->user->setFlash('warning', 'Unable to add item to cart');

        }

        $items=Yii::app()->shoppingCart->getItemToTransfer();

        $this->reload();
    }

    public function actionEditItemToTransfer($item_id){

        ajaxRequestPost();

        $data = array();
        $quantity = isset($_POST['Receiving']['quantity']) ? $_POST['Receiving']['quantity'] : null;

        Yii::app()->shoppingCart->editItemToTransfer($item_id, $quantity);

        $this->reload();

    }

    public function actionDeleteItemToTransfer($item_id,$quantity)
    {
        ajaxRequestPost();

        Yii::app()->shoppingCart->deleteItemToTransfer($item_id);

        $this->reload();
    }

    public function actionResetItemToTransfer(){

        ajaxRequestPost();

        Yii::app()->shoppingCart->clearItemToTransfer();

        $this->reload();
    }

    public function actionSaveItemToTransfer()
    {

    	$header_data['reference_name'] = Yii::app()->shoppingCart->getTransferHeader('reference_name');
    	$header_data['from_outlet'] = Yii::app()->shoppingCart->getTransferHeader('from_outlet');
    	$header_data['to_outlet'] = Yii::app()->shoppingCart->getTransferHeader('to_outlet');
    	$header_data['status'] = 'Stock Transfer';
    	$header_data['trans_type'] = param('sale_submit_status');
    	$header_data['employee_id'] = Yii::app()->session['employeeid'];
    	$header_data['receive_time'] = date('Y-m-d H:i:s');//transfer time
    	$header_data['created_date'] = date('Y-m-d H:i:s');
    	$header_data['modified_date'] = date('Y-m-d H:i:s');

		if(($header_data['from_outlet']=='' || $header_data['from_outlet'] == null) || ($header_data['to_outlet']=='' || $header_data['to_outlet'] == null)){

			Yii::app()->user->setFlash('warning', 'Outlet must be specific to make item transfer');

		}else if($header_data['from_outlet'] == $header_data['to_outlet']){

    		Yii::app()->user->setFlash('warning', 'From and To Outlet must difference!!!');

    	}else{

    		$items = $items=Yii::app()->shoppingCart->getItemToTransfer();
    		$model = Receiving::model()->saveItemToTransfer(new Receiving,$header_data,$items);

    		if($model==null){

    			Yii::app()->user->setFlash('warning', 'Reference Name has already been taken');

    		}else{

    			Yii::app()->shoppingCart->clearItemToTransfer();
    			$this->redirect(array('Receiving/itemTransfer'));
    		}
    	}

        $this->reload();

    }

    public function actionItemTransferSubmited($tran_type)
    {

    	$grid_id = 'receiving-item-grid';
        $title = 'Stock Transfer List';

        $data = $this->commonData($grid_id,$title,'show','show');

        $data['grid_columns'] = ReportColumn::getTransferedItemColumns();
        $data['user_id'] = Yii::app()->session['employeeid'];
        $data['title'] = $title;


        $data['data_provider'] = $data['report']->tranferedListByStatusUser($data['user_id'],$tran_type);
       
        $data['grid_id'] = $grid_id;
        // var_dump($data['data_provider']);
        loadview('review','//layouts/report/_grid',$data);

    }

    public function actionTransferLetter($transfer_id, $transfered_by='',$tran_type,$pdf=0,$email=0)
    {
            authorized('sale.read') || authorized('sale.create') ;

            $data = $this->receiptData($sale_id,$customer_id,$tran_type);

            if (count($data['items']) == 0) {
                $data['error_message'] = 'Sale Transaction Failed';
            }

            $this->renderRecipe($data);
            
            Yii::app()->shoppingCart->clearAll();

    }

    public function actionTransferUpdateStatus($receive_id,$tran_type,$ajax=true) {

        if($ajax){
            ajaxRequest();    
        }

        if($tran_type==param('sale_complete_status')){

        	Receiving::model()->updateItemToDestinationOutlet($receive_id);

        }elseif($tran_type==param('sale_reject_status')){

        	Receiving::model()->rolebackSourceOutletQuantity($receive_id);

        }

    }

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Receiving');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Receiving('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Receiving']))
			$model->attributes=$_GET['Receiving'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Receiving::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='receiving-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	private function reload($data=array())
    {
        $this->layout = '//layouts/column_sale';
        $model = new Receiving;
		$items_model = new ItemOutlet;
    	$items=Yii::app()->shoppingCart->getItemToTransfer();
    	$from_outlet = Yii::app()->shoppingCart->getTransferHeader('from_outlet');
    	$to_outlet = Yii::app()->shoppingCart->getTransferHeader('to_outlet');

        $data['model'] = $model;
        $data['items_model'] = $items_model;
        $data['items'] = $items;
        $data['from_outlet'] = isset($from_outlet) ? $from_outlet : '' ;
    	$data['to_outlet'] = isset($to_outlet) ? $to_outlet : '';

        loadview('index_transfer','index_transfer',$data);

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
}
