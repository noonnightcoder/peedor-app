<?php

class StockTransferController extends Controller
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
				'actions'=>array('create','update','admin','delete',
					'ItemTransfer',
					'AddItemToTransfer',
                    'DeleteItemToTransfer',
                    'EditItemToTransfer',
                    'PreviewItemToTransfer',
                    'resetItemToTransfer', 
                    'processTransfer',
                    'Pdf'
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
		$model=new Inventory;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Inventory']))
		{
			$model->attributes=$_POST['Inventory'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->trans_id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Inventory']))
		{
			$model->attributes=$_POST['Inventory'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->trans_id));
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

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Inventory');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin($item_id)
	{
		$model=new Inventory('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Inventory']))
			$model->attributes=$_GET['Inventory'];
                
                $item=Item::model()->getItemInfo($item_id);
                
                if(Yii::app()->request->isAjaxRequest)
                {   
                    $cs=Yii::app()->clientScript;
                    $cs->scriptMap=array(
                        'jquery.js'=>false,
                        'bootstrap.js'=>false,
                        'jquery.ba-bbq.min.js'=>false,
                        'jquery.yiigridview.js'=>false,
                        'bootstrap.min.js'=>false,
                        'jquery.min.js'=>false,
                        'bootstrap.notify.js'=>false,
                        'bootstrap.bootbox.min.js'=>false,
                    );
                    
                    Yii::app()->clientScript->scriptMap['*.js'] = false;
                    //Yii::app()->clientScript->scriptMap['*.css'] = false;
                    
                    if (isset($_GET['ajax']) && $_GET['ajax'] == 'inventory-grid')
                    {
                         $this->render('admin',array(
                            'model'=>$model,'item_id'=>$item_id,'item'=>$item
                        ));
                    }
                    else
                    {
                        echo CJSON::encode( array(
                            'status' => 'render',
                            'div' => $this->renderPartial( 'admin', array('model' => $model,'item_id'=>$item_id,'item'=>$item),true,true),
                        ));

                        Yii::app()->end();
                    }
                }
                else
                {    
                    $this->render('admin',array(
                            'model'=>$model,'item_id'=>$item_id,'item'=>$item
                    ));
                }
	}

	public function actionItemTransfer()
	{

		$model = new StockTransfer;
		$items_model = new Item;
    	$items=Yii::app()->shoppingCart->getItemToTransfer();

    	$this->performAjaxValidation($model);

    	if (isset($_POST['StockTransfer'])) {
            $model->attributes = $_POST['StockTransfer'];

            if($model->validate()){

            	if ($model->save()) {

					if($model->id>0){//check if item id exist after saved to table
						//echo '<script>alert("Saved")</script>';
					}
					Yii::app()->shoppingCart->emptyItemToTransfer();
					//$this->redirect('stockTransfer/ItemTransfers');

				}
            }

        }
        $data['model'] = $model;
        $data['items'] = $items;
        $data['items_model'] = $items_model;
        $this->render('index',$data);

	}

	public function actionAddItemToTransfer()
    {
       
        $data=array();
        $header=array();
        $model = new StockTransfer;
		$items_model = new Item;
        $item_id = $_POST['Item']['id'];

 		$this->performAjaxValidation($model);
 		
 		if(isset($_POST['StockTransfer'])){
 			$header['name'] = $_POST['StockTransfer']['name'];
	        $header['delivery_due_date'] = $_POST['StockTransfer']['delivery_due_date'];
	        $header['from_outlet'] = $_POST['StockTransfer']['from_outlet'];
	        $header['to_outlet'] = $_POST['StockTransfer']['to_outlet'];	
 		}
        

        if (!Yii::app()->shoppingCart->addItemToTransfer($item_id,$header)) {
            Yii::app()->user->setFlash('warning', 'Unable to add item to cart');
        }

        $items=Yii::app()->shoppingCart->getItemToTransfer();

        $data['model'] = $model;
        $data['items_model'] = $items_model;
        $data['items'] = $items;

        $this->reload($data);
    }

    public function actionEditItemToTransfer($item_id){

        ajaxRequestPost();
        $data = array();
        $model = new StockTransfer;
		$items_model = new Item;
        $quantity = isset($_POST['StockTransfer']['quantity']) ? $_POST['StockTransfer']['quantity'] : null;

        Yii::app()->shoppingCart->editItemToTransfer($item_id, $quantity);

        $items=Yii::app()->shoppingCart->getItemToTransfer();

        $data['model'] = $model;
        $data['items_model'] = $items_model;
        $data['items'] = $items;

        $this->reload($data);

    }

    public function actionDeleteItemToTransfer($item_id,$quantity)
    {
        ajaxRequestPost();

        Yii::app()->shoppingCart->deleteItemToTransfer($item_id);

        $this->reload();
    }

    public function actionResetItemToTransfer(){

        ajaxRequestPost();

        Yii::app()->shoppingCart->emptyItemToTransfer();
        $this->reload();
    }

    public function actionProcessTransfer()
    {
    	
    	$model = new StockTransfer;
    	$items=Yii::app()->shoppingCart->getItemToTransfer();

    	$this->performAjaxValidation($model);
    	
    	var_dump($items);

    }

    public function actionPdf(){
        $file=$this->renderPartial('_to_delete/_test_pdf', array('name'), true);
        $c=Yii::app()->pdfGenerator->PdfCreate($file);        
        // Yii::app()->pdfGenerator->PdfToEmail('test','sovotanakpath579@gmail.com','sovotanakpath579@gmail.com',$file,'Hello','A4');

    }

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Inventory::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='inventory-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	private function reload($data=array())
    {
        $this->layout = '//layouts/column_sale';

        loadview('index','index',$data);

    }
}
