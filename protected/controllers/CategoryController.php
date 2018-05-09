<?php

class CategoryController extends Controller
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
				'users'=>array('@'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','admin','delete','GetCategory2','InitCategory','restore','List','Create2','SaveCategory','ReloadCategory','Update2'),
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

        if (!Yii::app()->user->checkAccess('category.create')) {
            throw new CHttpException(403, 'You are not authorized to perform this action');
        }

        $model = new Category;

        if (isset($_POST['Category'])) {
            $model->attributes = $_POST['Category'];
            if ($model->validate()) {
                $transaction = $model->dbConnection->beginTransaction();
                try {
                    $model->modified_date=date('Y-m-d H:i:s');
                    if ($model->save()) {
                        $transaction->commit();
                        Yii::app()->clientScript->scriptMap['jquery.js'] = false;
                        echo CJSON::encode(array(
                            'status' => 'success',
                            'div' => "<div class=alert alert-info fade in> Successfully added ! </div>",
                        ));
                        Yii::app()->end();
                    }
                } catch (Exception $e) {
                    $transaction->rollback();
                    print_r($e);
                }
            }
        }

        if (Yii::app()->request->isAjaxRequest) {
            $cs = Yii::app()->clientScript;
            $cs->scriptMap = array(
                'jquery.js' => false,
                'bootstrap.js' => false,
                'jquery.min.js' => false,
                'bootstrap.notify.js' => false,
                'bootstrap.bootbox.min.js' => false,
            );
            echo CJSON::encode(array(
                'status' => 'render',
                'div' => $this->renderPartial('_form', array('model' => $model), true, true),
            ));
            Yii::app()->end();
        } else {
            $this->render('create', array('model' => $model));
        }

    }
    public function actionCreate2(){
        if (!Yii::app()->user->checkAccess('category.create')) {
            throw new CHttpException(403, 'You are not authorized to perform this action');
        }
        $model = new Category;
        $data['model']=$model;
        $data['parent']=Category::model()->findAll();
        $this->render('create2',$data);
    }
    public function actionSaveCategory(){
        $i=$_POST['id']+1;
        $category_name=isset($_POST['category_name']) ? $_POST['category_name']:'';
        $parent_id=$_POST['parent_id'];
        $category=new Category;
        $criteria = new CDbCriteria();
        $criteria->condition = 'name=:name';
        $criteria->params = array(':name'=>$category_name);
        $exists = $category->exists($criteria);
        $model=Category::model()->findAll();
        $errorMsg='';
        if($exists){
            echo 'existed'; 
            //$errorMsg='Name "'.$category_name.'" has already been taken.';
        }else if($category_name==''){
            echo 'error';
            //$errorMsg='Category name is required';
        }else{
            $category->name=$category_name;
            $category->parent_id=$parent_id;
            $saved=$category->save();
            if($saved>0){
                echo '<input type="hidden" value="'.$category->id.'" id="pid'.($i-1).'">'; 
                echo '<div class="col-sm-11 col-md-11">';
                    echo '<hr>';
                    echo '<h3 id="success">Data Successfully saved.</h3>';
                        echo '<div class="form-group">';
                            echo CHtml::label('Category Name', 1, array('class' => 'control-label')); 
                            echo CHtml::TextField('Category',$category_name,array('class'=>'form-control','id'=>'Category_Name'));
                            echo '<span id="error" class="errorMsg'.($i-1).'"></span>';
                    echo '</div>';
                echo '</div>';
                echo '<div class="col-sm-11 col-md-11">';
                    echo '<div class="form-group">';
                        echo CHtml::label('Parent', 1, array('class' => 'control-label'));
                        echo '<select class="form-control" id="db-category'.($i-1).'" onchange="showDialog(event.target.value)">';
                            echo '<option value="0">--Choose Parent--</option>';
                            $selected='';
                            foreach($model as $key=>$value){
                                if($value['id']==$parent_id){
                                    $selected='selected';
                                    echo '<option value="'.$value['id'].'" '.$selected.'>'.$value['name'].'</option>';
                                }else{
                                    echo '<option value="'.$value['id'].'">'.$value['name'].'</option>';
                                }
                                
                            }
                            echo '<optgroup >';
                                echo '<option value="addnew">';
                                    echo 'Create New';
                                echo '</option>';
                            echo '</optgroup>';
                        echo '</select>';
                    echo '</div>';
                echo '</div>';
            }
        }
        
    }
    public function actionReloadCategory($id=''){
        $model=Category::model()->findAll();
        echo '<option value="0">--Choose Parent--</option>';
        $selected='';
        foreach($model as $key=>$value){
            if($id==$value['id']){
                echo '<option value="'.$value['id'].'" selected>'.$value['name'].'</option>';    
            }else{
                echo '<option value="'.$value['id'].'">'.$value['name'].'</option>';    
            }
        }
        echo '<optgroup >';
            echo '<option value="addnew">';
                echo 'Create New';
            echo '</option>';
        echo '</optgroup>';
    }
	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
    public function actionUpdate($id)
    {
        if (!Yii::app()->user->checkAccess('category.create')) {
            throw new CHttpException(403, 'You are not authorized to perform this action');
        }

        $model = $this->loadModel($id);

        if (isset($_POST['Category'])) {
            $model->attributes = $_POST['Category'];
            if ($model->validate()) {
                $transaction = $model->dbConnection->beginTransaction();
                try {
                    $model->modified_date=date('Y-m-d H:i:s');
                    if ($model->save()) {
                        $transaction->commit();
                        Yii::app()->clientScript->scriptMap['jquery.js'] = false;
                        echo CJSON::encode(array(
                            'status' => 'success',
                            'div' => "<div class=alert alert-info fade in> Successfully updated ! </div>",
                        ));
                        Yii::app()->end();
                    }
                } catch (Exception $e) {
                    $transaction->rollback();
                    print_r($e);
                }
            }
        }

        if (Yii::app()->request->isAjaxRequest) {
            $cs = Yii::app()->clientScript;
            $cs->scriptMap = array(
                'jquery.js' => false,
                'bootstrap.js' => false,
                'jquery.min.js' => false,
                'bootstrap.notify.js' => false,
                'bootstrap.bootbox.min.js' => false,
            );
            echo CJSON::encode(array(
                'status' => 'render',
                'div' => $this->renderPartial('_form', array('model' => $model), true, true),
            ));
            Yii::app()->end();
        } else {
            $data['model']=$model;
            $this->render('update', $data);
        }

    }
    public function actionUpdate2($id){
        if (!Yii::app()->user->checkAccess('category.create')) {
            throw new CHttpException(403, 'You are not authorized to perform this action');
        }
        //echo $_POST['category_name'];
        if(isset($_POST['category_name'])){
            $category = Category::model()->findByPk($id);
            $category->name=$_POST['category_name'];
            $category->modified_date = date('Y-m-d H:i:s');
            $category->parent_id=$_POST['parent_id'];
            $updated=$category->update(array('name','modified_date','parent_id'));
            if($updated){
                echo 'success';
            }
        }else{
            $model = $this->loadModel($id);
            $data['model']=$model;
            $data['parent']=Category::model()->findAll();
            $data['cateId']=$id;
            $this->render('create2', $data);
        }
        
    }
    public function actionDelete($id)
    {
        if (!Yii::app()->user->checkAccess('category.delete')) {
            throw new CHttpException(403, 'You are not authorized to perform this action');
        }

        if (Yii::app()->request->isPostRequest) {
            Category::model()->deleteCategory($id);

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax'])) {
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
            }
        } else {
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
        }
    }

    public function actionRestore($id)
    {
        if (!Yii::app()->user->checkAccess('category.delete')) {
            throw new CHttpException(403, 'You are not authorized to perform this action');
        }

        if (Yii::app()->request->isPostRequest) {
            Category::model()->restoreCategory($id);

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax'])) {
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
            }
        } else {
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
        }
    }

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Category');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Category('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Category']))
			$model->attributes=$_GET['Category'];

		if (isset($_GET['pageSize'])) {
			Yii::app()->user->setState('category_page_size',(int)$_GET['pageSize']);
			unset($_GET['pageSize']);
		}

		if (isset($_GET['archived'])) {
			Yii::app()->user->setState('category_archived', $_GET['archived']);
			unset($_GET['archived']);
		}

		$model->category_archived = Yii::app()->user->getState('category_archived',
			Yii::app()->params['defaultArchived']);

		$page_size = CHtml::dropDownList(
			'pageSize',
			Yii::app()->user->getState('category_page_size', Common::defaultPageSize()),
			Common::arrayFactory('page_size'),
			array('class' => 'change-pagesize',)
		);

		$data['model'] = $model;
		//$data['grid_id'] = strtolower(get_class($model)) . ' -grid';
        $data['grid_id'] = 'category-grid';
		$data['main_div_id'] = strtolower(get_class($model)) . '_cart';
		$data['page_size'] = $page_size;
		$data['modal_header'] = Yii::t('app','New Category');

		$data['grid_columns'] = Category::getCategoryColumn();

		$data['data_provider'] = $model->search();

        $this->render('admin', $data);
	}

    public function actionList()
    {
        $model=new Category('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['Category']))
            $model->attributes=$_GET['Category'];

        if (isset($_GET['pageSize'])) {
            Yii::app()->user->setState('category_page_size',(int)$_GET['pageSize']);
            unset($_GET['pageSize']);
        }

        if (isset($_GET['archived'])) {
            Yii::app()->user->setState('category_archived', $_GET['archived']);
            unset($_GET['archived']);
        }

        $model->category_archived = Yii::app()->user->getState('category_archived',
            Yii::app()->params['defaultArchived']);

        $page_size = CHtml::dropDownList(
            'pageSize',
            Yii::app()->user->getState('category_page_size', Common::defaultPageSize()),
            Common::arrayFactory('page_size'),
            array('class' => 'change-pagesize',)
        );

        $data['model'] = $model;
        //$data['grid_id'] = strtolower(get_class($model)) . ' -grid';
        $data['grid_id'] = 'category-grid';
        $data['main_div_id'] = strtolower(get_class($model)) . '_cart';
        $data['page_size'] = $page_size;
        $data['modal_header'] = Yii::t('app','New Category');

        $data['grid_columns'] = Category::getCategoryColumn();

        $data['data_provider'] = $model->search();

        $this->render('_list', $data);
    }

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Category::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='category-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

    /** Lookup Client for select2
     *
     * @throws CHttpException
     */
    public function actionGetCategory2()
    {
        if (isset($_GET['term'])) {
            $term = trim($_GET['term']);
            $ret['results'] = Category::getCategory2($term); //PHP Example · ivaynberg/select2  http://bit.ly/10FNaXD got stuck serveral hoursss :|
            echo CJSON::encode($ret);
            Yii::app()->end();

        }
    }

    public function actionInitCategory()
    {
        $model = Category::model()->find('id=:category_id', array(':category_id' => (int)$_GET['id']));
        if ($model !== null) {
            echo CJSON::encode(array('id' => $model->id, 'text' => $model->name));
        }
    }
}
