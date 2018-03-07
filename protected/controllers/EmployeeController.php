<?php

class EmployeeController extends Controller
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
                'actions' => array('view', 'InlineUpdate'),
                'users' => array('@'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('index','create', 'update', 'admin', 'delete', 'undodelete', 'UploadImage'),
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

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model = new Employee('search');

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

        $model->employee_archived = Yii::app()->user->getState(strtolower(get_class($model)) . '_archived', Yii::app()->params['defaultArchived']);

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
                'name' => 'login_id',
                'header' => 'Login ID',
                'value' => array($this, "gridLoginIDColumn"),
            ),
            'first_name',
            'last_name',
            array(
                'name' => 'mobile_no',
            ),
            array(
                'name' => 'adddress1',
            ),
            array(
                'name' => 'address2',
            ),
            array(
                'class' => 'bootstrap.widgets.TbButtonColumn',
                'header' => Yii::t('app','Action'),
                'template' => '<div class="btn-group">{view}{update}{delete}{undeleted}</div>',
                'htmlOptions' => array('class' => 'nowrap'),
                'buttons' => array(
                    'view' => array(
                        'options' => array(
                            'class' => 'btn btn-xs btn-success',
                        ),
                    ),
                    'update' => array(
                        'icon' => 'ace-icon fa fa-edit',
                        'options' => array(
                            'class' => 'btn btn-xs btn-info',
                        ),
                    ),
                    'delete' => array(
                        'label' => 'Delete',
                        'options' => array(
                            'class' => 'btn btn-xs btn-danger',
                        ),
                        'visible' => '$data->status=="1" && Yii::app()->user->checkAccess("employee.delete")',
                    ),
                    'undeleted' => array(
                        'label' => Yii::t('app', 'Undo Delete Item'),
                        'url' => 'Yii::app()->createUrl("Employee/UndoDelete", array("id"=>$data->id))',
                        'icon' => 'bigger-120 glyphicon-refresh',
                        'options' => array(
                            'class' => 'btn btn-xs btn-warning btn-undodelete',
                        ),
                        'visible' => '$data->status=="0" && Yii::app()->user->checkAccess("employee.delete")',
                    ),
                ),
            ),
        );

        $data['data_provider'] = $model->search();

        $this->render('admin', $data);
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id)
    {
        $user = RbacUser::model()->find('employee_id=:employeeID', array(':employeeID' => (int) $id));

        $this->render('view', array(
            'model' => $this->loadModel($id),
            'user' => $user,
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $model = new Employee;
        $user = new RbacUser;
        $disabled = ""; 
     
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (Yii::app()->user->checkAccess('employee.create')) {

            if (isset($_POST['Employee'])) {
                $model->attributes = $_POST['Employee'];
                $user->attributes = $_POST['RbacUser'];
                //$location_id = $_POST['Employee']['location'];

                if ( $_POST['Employee']['year'] !== "" || $_POST['Employee']['month'] !== "" || $_POST['Employee']['day'] !== "" ) {
                    $dob = $_POST['Employee']['year'] . '-' . $_POST['Employee']['month'] . '-' . $_POST['Employee']['day'];
                    $model->dob = $dob;
                }
          
                // validate BOTH $a and $b
                $valid = $model->validate();
                $valid = $user->validate() && $valid;

                if ($valid) {
                    $transaction = $model->dbConnection->beginTransaction();
                    try {
                        if ($model->save()) {
                            $user->employee_id = $model->id;
                            
                            if ($user->save()) {

                                $assignitems = $this->authItemPermission();

                                foreach ($assignitems as $assignitem) {
                                    if (!empty($_POST['RbacUser'][$assignitem])) {
                                        foreach ($_POST['RbacUser'][$assignitem] as $itemId) {
                                            $authassigment = new Authassignment;
                                            $authassigment->userid = $user->id;
                                            $authassigment->itemname = $itemId;

                                            if (!$authassigment->save()) {
                                                $transaction->rollback();
                                                print_r($authassigment->errors);
                                            }
                                        }
                                    }
                                }

                                $transaction->commit();
                                Yii::app()->user->setFlash('success', '<strong>Well done!</strong> successfully saved.');
                                //$this->redirect(array('view', 'id' => $model->id));
                                $this->redirect(array('admin'));
                            } else {
                                Yii::app()->user->setFlash('error', '<strong>Oh snap!</strong> Change a few things up and try submitting again.');
                            }
                        }
                    } catch (Exception $e) {
                        $transaction->rollback();
                        Yii::app()->user->setFlash('error', '<strong>Oh snap!</strong> Change a few things up and try submitting again.' . $e);
                    }
                }
            }
        } else {
            throw new CHttpException(403, 'You are not authorized to perform this action');
        }

        $this->render('create', array('model' => $model, 'user' => $user, 'disabled' => $disabled ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        $disabled = "";
        if (Yii::app()->user->checkAccess('employee.update')) {

            $model = $this->loadModel($id);
            $user = RbacUser::model()->find('employee_id=:employeeID', array(':employeeID' => (int) $id));
        
            $criteria = new CDbCriteria;
            $criteria->condition = 'userid=:userId';
            $criteria->select = 'itemname';
            $criteria->params = array(':userId' => $user->id);
            $authassigment = Authassignment::model()->findAll($criteria);

            $auth_items = array();
            foreach ($authassigment as $auth_item) {
                $auth_items[] = $auth_item->itemname;
            }

            $user->items = $auth_items;
            $user->sales = $auth_items;
            $user->employees = $auth_items;
            $user->customers = $auth_items;
            $user->store = $auth_items;
            $user->suppliers = $auth_items;
            $user->receivings = $auth_items;
            $user->reports = $auth_items;
            $user->invoices = $auth_items;
            $user->payments = $auth_items;
            $user->rptprofits = $auth_items;
            $user->categories = $auth_items;

            // Uncomment the following line if AJAX validation is needed
            // $this->performAjaxValidation($model);

            if (isset($_POST['Employee'])) {
                $model->attributes = $_POST['Employee'];
                $user->attributes=$_POST['RbacUser'];

                if ( $_POST['Employee']['year'] !== "" || $_POST['Employee']['month'] !== "" || $_POST['Employee']['day'] !== "" ) {
                    $dob = $_POST['Employee']['year'] . '-' . $_POST['Employee']['month'] . '-' . $_POST['Employee']['day'];
                    $model->dob = $dob;
                }
                
                // validate BOTH $a and $b
                $valid = $model->validate();
                $valid=$user->validate() && $valid;

                if ($valid) {
                    $transaction = $model->dbConnection->beginTransaction();
                    try {
                        if ($model->save()) {
                            
                            if ($user->save()) {
                                // Delete all existing granted module 
                                Authassignment::model()->deleteAuthassignment($user->id);

                                $assignitems = $this->authItemPermission();

                                foreach ($assignitems as $assignitem) {
                                    if (!empty($_POST['RbacUser'][$assignitem])) {
                                        foreach ($_POST['RbacUser'][$assignitem] as $itemId) {
                                            $authassigment = new Authassignment;
                                            $authassigment->userid = $user->id;
                                            $authassigment->itemname = $itemId;
                                            $authassigment->save();
                                        }
                                    }
                                }
                          
                                $transaction->commit();
                                Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_SUCCESS,'Employee : <strong>' . ucwords($model->last_name . ' ' .$model->first_name) . '</strong> have been saved successfully!' );
                                $this->redirect(array('admin'));
                            } else {
                               Yii::app()->user->setFlash('error', '<strong>Oh snap!</strong> Change a few things up and try submitting again.');
                            }
                        }
                    } catch (Exception $e) {
                        $transaction->rollback();
                        Yii::app()->user->setFlash('error', '<strong>Oh snap!</strong> Change a few things up and try submitting again.' . $e);
                    }
                }
            }
        } else {
            throw new CHttpException(403, 'You are not authorized to perform this action');
        }
        
        if (strtolower($user->user_name) == strtolower('admin') || strtolower($user->user_name) == strtolower('super')) {
             $disabled = "true";
        }

        $this->render('update', array('model' => $model, 'user' => $user, 'disabled' => $disabled));
    }

    public function actionInlineUpdate()
    {
        if (Yii::app()->user->checkAccess('employee.update')) {
            $model = $this->loadModel((int) $_POST['pk']);
            $attribute = $_POST['name'];
            $model->$attribute = $_POST['value'];
            try {
                $model->save();
            } catch (CException $e) {
                echo CJSON::encode(array('success' => false, 'msg' => $e->getMessage()));
                return;
            }
            echo CJSON::encode(array('success' => true));
        }
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id)
    {
        if (Yii::app()->user->checkAccess('employee.delete')) {
            if (Yii::app()->request->isPostRequest) { // we only allow deletion via POST request
                
                $user = RbacUser::model()->find('employee_id=:employeeID', array(':employeeID' => (int) $id));

                if (strtolower($user->user_name) == strtolower('admin') || strtolower($user->user_name) == strtolower('super')) {
                    throw new CHttpException(400, 'Cannot delete owner user system. Please do not repeat this request again.');
                } else {
                    Employee::model()->deleteEmployee($id);
                }

                // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
                if (!isset($_GET['ajax'])) {
                    $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
                }
            }
            else {
                throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
            }
        } else {
            throw new CHttpException(403, 'You are not authorized to perform this action');
        }
    }
    
    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionundoDelete($id)
    {
        if (Yii::app()->user->checkAccess('employee.delete')) {
            if (Yii::app()->request->isPostRequest) { // we only allow deletion via POST request
                
                $user = RbacUser::model()->find('employee_id=:employeeID', array(':employeeID' => (int) $id));

                if (strtolower($user->user_name) == strtolower('admin') || strtolower($user->user_name) == strtolower('super')) {
                    throw new CHttpException(400, 'Cannot delete owner user system. Please do not repeat this request again.');
                } else {
                    Employee::model()->undodeleteEmployee($id);
                }

                // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
                if (!isset($_GET['ajax'])) {
                    $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
                }
            }
            else {
                throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
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
        if (Yii::app()->user->checkAccess('employee.index')) {
        
            $dataProvider = new CActiveDataProvider('Employee');
            $this->render('index', array(
                'dataProvider' => $dataProvider,
            ));
        } else {
            throw new CHttpException(403, 'You are not authorized to perform this action');
        }
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id)
    {
        $model = Employee::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'employee-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    protected function gridLoginIDColumn($data, $row)
    {
        $model = RbacUser::model()->find('employee_id=:employeeID', array(':employeeID' => $data->id));

        echo ucwords($model->user_name);
    }

    public function actionUploadImage($employee_id)
    {
        
        $model = new Employee;
        $image_model = EmployeeImage::model()->find('employee_id=:employee_id', array(':employee_id' => (int)$employee_id));

        if (!$image_model) {
            $image_model = new EmployeeImage;
        }

        if ($file = CUploadedFile::getInstance($model, 'image')) {
            $rnd = rand(0, 9999);  // generate random number between 0-9999

            $image_model->filetype = $file->type;
            $image_model->size = $file->size;
            $image_model->photo = file_get_contents($file->tempName);

            $fileName = "{$rnd}_{$file}";  // random number + file name
            $model->image = $fileName;
            $path = Yii::app()->basePath . '/../ximages/' . strtolower(get_class($model)) . '/' . $employee_id;
            $name = $path . '/' . $fileName;

            if (!is_dir($path)) {
                mkdir($path, 0777, true);
            }

            $file->saveAs($name);  // image will uplode to rootDirectory/ximages/{ModelName}/{Model->id}
           
            $image = Yii::app()->image->load($name);
            $image->resize(160, 160);
            $image->save();

            /*
            $image_model->item_id = $employee_id;
            $image_model->filename = $fileName;
            $image_model->path = '/../ximages/' . strtolower(get_class($model)) . '/' . $employee_id;
            $image_model->thumbnail = file_get_contents($name);
            if (!$image_model->save()) {
                $transaction->rollback();
                print_r($image_model->errors);
            }
             * 
            */
        }
    }


    protected function authItemPermission() {
        return array('items', 'sales', 'employees', 'customers', 'suppliers', 'store', 'receivings', 'reports', 'invoices', 'payments','rptprofits','categories');
    }
   

}
