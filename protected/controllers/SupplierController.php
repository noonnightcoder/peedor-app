<?php

class SupplierController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';

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
				'actions'=>array('create','update','admin','delete','undoDelete','AddSupplier','GetSupplier'),
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
            if (Yii::app()->request->isAjaxRequest) {
               
                Yii::app()->clientScript->scriptMap['*.js'] = false;
           
                echo CJSON::encode(array(
                    'status' => 'render',
                    'div' => $this->renderPartial('view', array('model' => $this->loadModel($id)), true, false),
                ));

                Yii::app()->end();
            } else {
                $this->render('view',array(
                        'model'=>$this->loadModel($id),
                ));
            }
	}
        
        /**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionAddSupplier()
	{
		$model=new Supplier;

		if (Yii::app()->user->checkAccess('supplier.create'))
                {
                    if(isset($_POST['Supplier']))
                    {
                            $model->attributes=$_POST['Supplier'];
                            if($model->validate())
                            {
                                if($model->save())
                                {
                                    Yii::app()->clientScript->scriptMap['jquery.js'] = false;
                                    Yii::app()->receivingCart->setSupplier($model->id);
                                    $this->redirect(array('receivingItem/index'));
                                }
                            }
                    }
                }
                else
                    throw new CHttpException(403, 'You are not authorized to perform this action');
                

		if(Yii::app()->request->isAjaxRequest)
                {
                    Yii::app()->clientScript->scriptMap['*.js'] = false;
                    //Yii::app()->clientScript->scriptMap['*.cs'] = false;

                    echo CJSON::encode( array(
                        'status' => 'render',
                        'div' => $this->renderPartial( '_form', array('model' => $model),true,false),
                    ));

                    Yii::app()->end();
                }
                else
                {
                    $this->render('_form',array('model' => $model)); 
                }
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate($recv_mode='N',$trans_mode=null)
	{
		$model=new Supplier;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
                if (Yii::app()->user->checkAccess('supplier.create'))
                {    
                    if(isset($_POST['Supplier']))
                    {
                            $model->attributes=$_POST['Supplier'];
                            if($model->validate())
                            {
                                $transaction=Yii::app()->db->beginTransaction();
                                try 
                                {
                                    if($model->save())
                                    { 
                                        AccountSupplier::model()->saveAccount($model->id,$model->company_name); 
                                        $transaction->commit();

                                        if ($recv_mode == 'N') {
                                            Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_SUCCESS,'Supplier : <strong>' . $model->company_name . '</strong> have been saved successfully!' );
                                            $this->redirect(array('create'));
                                        } else {
                                            Yii::app()->receivingCart->setSupplier($model->id);
                                            $this->redirect(array('receivingItem/index','trans_mode'=>$trans_mode));
                                        }

                                        /*
                                        Yii::app()->clientScript->scriptMap['jquery.js'] = false;
                                        echo CJSON::encode(array(
                                           'status'=>'success',
                                           'div'=>"<div class=alert alert-info fade in>Successfully added ! </div>",
                                           ));
                                        Yii::app()->end();
                                         * 
                                        */    
                                    }
                                } catch (CDbException $e) {
                                   $transaction->rollback();
                                   Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_WARNING,'Oop something wrong : <strong>' . $e->getMessage());
                                }     

                            }
                    }
                } else {
                    throw new CHttpException(403, 'You are not authorized to perform this action');
                }    


                if(Yii::app()->request->isAjaxRequest)
                {
                    Yii::app()->clientScript->scriptMap['*.js'] = false;

                    echo CJSON::encode( array(
                        'status' => 'render',
                        'div' => $this->renderPartial( '_form', array('model' => $model),true,false),
                    ));

                    Yii::app()->end();
                }
                else
                {
                    $this->render('create',array('model' => $model)); 
                }
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id,$recv_mode='N',$trans_mode=null)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
                if (Yii::app()->user->checkAccess('supplier.update'))
                {
                    if(isset($_POST['Supplier']))
                    {
                        $model->attributes=$_POST['Supplier'];
                        if ($model->validate())
                        {    
                            $transaction=$model->dbConnection->beginTransaction(); 
                            try {
                                if ($model->save())
                                {  
                                    $transaction->commit(); 
                                    
                                    if ($recv_mode=='Y') {
                                            Yii::app()->receivingCart->setSupplier($id);
                                            $this->redirect(array('receivingItem/index','trans_mode'=>$trans_mode));
                                    } else {
                                         Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_SUCCESS,'<strong>' . ucfirst($model->company_name) . '</strong> have been saved successfully!' );
                                        $this->redirect(array('admin'));
                                    }
                                        
                               
                                }
                            }catch(Exception $e)
                            {
                                $transaction->rollback();
                                Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_WARNING,'Oop something wrong : <strong>' . $e->getMessage());
                            } 
                        }

                    }
                } else {
                    throw new CHttpException(403, 'You are not authorized to perform this action');
                }
                
                $this->render('update',array('model' => $model)); 

	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
    public function actionDelete($id)
    {
        if (Yii::app()->user->checkAccess('supplier.delete')) {
            if (Yii::app()->request->isPostRequest) {
                // we only allow deletion via POST request
                //$this->loadModel($id)->delete();
                Supplier::model()->deleteSupplier($id);

                // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
                if (!isset($_GET['ajax'])) {
                    $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
                }
            } else {
                throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
            }
        } else {
            throw new CHttpException(403, 'You are not authorized to perform this action');
        }
    }
        
        /**
	 * Undo Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionUndoDelete($id)
	{
                if (Yii::app()->user->checkAccess('supplier.delete'))
                {
                    if(Yii::app()->request->isPostRequest)
                    {
                            // we only allow deletion via POST request
                            Supplier::model()->undodeleteSupplier($id);

                            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
                            if(!isset($_GET['ajax']))
                                    $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
                    } else {
                            throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
                    }
                } else {
                    throw new CHttpException(403, 'You are not authorized to perform this action');
                }
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Supplier');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
    public function actionAdmin()
    {
        $model = new Supplier('search');

        if (!Yii::app()->user->checkAccess(strtolower(get_class($model)) . '.index') || !Yii::app()->user->checkAccess(strtolower(get_class($model)) . '.create') || !Yii::app()->user->checkAccess(strtolower(get_class($model)) . '.update') || !Yii::app()->user->checkAccess(strtolower(get_class($model)) . '.delete')) {
            $this->redirect(array('site/ErrorException','err_no'=>403));
        }


        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Item'])) {
            $model->attributes = $_GET['Item'];
        }

        if (isset($_GET['pageSize'])) {
            Yii::app()->user->setState(strtolower(get_class($model)) . '_page_size', (int)$_GET['pageSize']);
            unset($_GET['pageSize']);
        }

        if (isset($_GET['archived'])) {
            Yii::app()->user->setState(strtolower(get_class($model)) . '_archived', $_GET['archived']);
            unset($_GET['archived']);
        }

        $model->supplier_archived = Yii::app()->user->getState(strtolower(get_class($model)) . '_archived', Yii::app()->params['defaultArchived']);

        $page_size = CHtml::dropDownList(
            'pageSize',
            Yii::app()->user->getState('employee_page_size', Common::defaultPageSize()),
            Common::arrayFactory('page_size'),
            array('class' => 'change-pagesize')
        );

        $data['model'] = $model;
        $data['grid_id'] = strtolower(get_class($model)) . '-grid';
        $data['main_div_id'] = strtolower(get_class($model)) . '_cart';
        $data['page_size'] = $page_size;

        $data['grid_columns'] = array(
            array(
                'name' => 'company_name',
                'value' => 'CHtml::link($data->company_name, Yii::app()->createUrl("supplier/update",array("id"=>$data->primaryKey)))',
                'type' => 'raw',
            ),
            'first_name',
            'last_name',
            array(
                'name' => 'mobile_no',
            ),
            array(
                'name' => 'address1',
            ),
            array(
                'name' => 'status',
                'type' => 'raw',
                'value' => '$data->status=="1" ? TbHtml::labelTb("Active", array("color" => TbHtml::LABEL_COLOR_SUCCESS)) : TbHtml::labelTb("Inactive", array("color" => TbHtml::LABEL_COLOR_DEFAULT))',
            ),
            array(
                'class' => 'bootstrap.widgets.TbButtonColumn',
                'header' => Yii::t('app', 'Action'),
                'template' => '<div class="hidden-sm hidden-xs btn-group">{view}{update}{delete}{undeleted}</div>',
                'htmlOptions' => array('class' => 'nowrap'),
                'buttons' => array(
                    'view' => array(
                        'click' => 'updateDialogOpen',
                        'url' => 'Yii::app()->createUrl("supplier/view/",array("id"=>$data->id))',
                        'options' => array(
                            'class' => 'btn btn-xs btn-success',
                            'data-update-dialog-title' => Yii::t('app', 'View Supplier'),
                        ),
                    ),
                    'update' => array(
                        'icon' => 'ace-icon fa fa-edit',
                        'label' => Yii::t('app', 'Update'),
                        'options' => array(
                            'class' => 'btn btn-xs btn-info',
                        ),
                    ),
                    'delete' => array(
                        'label' => Yii::t('app', 'Delete'),
                        'options' => array(
                            'class' => 'btn btn-xs btn-danger',
                        ),
                        'visible' => '$data->status=="1" && Yii::app()->user->checkAccess("supplier.delete")',
                    ),
                    'undeleted' => array(
                        'label' => Yii::t('app', 'Undo Delete Item'),
                        'url' => 'Yii::app()->createUrl("Supplier/UndoDelete", array("id"=>$data->id))',
                        'icon' => 'bigger-120 glyphicon-refresh',
                        'options' => array(
                            'class' => 'btn btn-xs btn-warning btn-undodelete',
                        ),
                        'visible' => '$data->status=="0" && Yii::app()->user->checkAccess("supplier.delete")',
                    ),
                ),
            ),
        );

        $data['data_provider'] = $model->search();

        $this->render('admin', $data);
    }

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Supplier::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='supplier-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
        
        /** Lookup Supplier for autocomplete 
         * 
         * @throws CHttpException
         */
        public function actionGetSupplier() { 
            if (isset($_GET['term'])) {
                 $term = trim($_GET['term']);
                 $ret['results'] = Supplier::select2Supplier($term); //PHP Example · ivaynberg/select2  http://bit.ly/10FNaXD got stuck serveral hoursss :|
                 echo CJSON::encode($ret);
                 Yii::app()->end();

            }
        }
}
