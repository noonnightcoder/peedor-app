<?php

/**
 * This is the model class for table "category".
 *
 * The followings are the available columns in table 'category':
 * @property integer $id
 * @property string $name
 * @property string $created_date
 * @property string $modified_date
 *
 * The followings are the available model relations:
 * @property Item[] $items
 */
class Category extends CActiveRecord
{
    public $search;
    public $category_archived;

    /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Category the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'category';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name', 'required'),
            array('name', 'unique'),
            array('name', 'length', 'max' => 50),
            array('created_date, modified_date', 'safe'),
            array('created_date', 'default', 'value' => date('Y-m-d'), 'setOnEmpty' => true, 'on' => 'insert'),
            array(
                'created_date,modified_date',
                'default',
                'value' => new CDbExpression('NOW()'),
                'setOnEmpty' => false,
                'on' => 'update'
            ),
            array('status', 'length', 'max'=>1),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('nam', 'safe', 'on' => 'search'),
        );
    }

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'items' => array(self::HAS_MANY, 'Item', 'category_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => Yii::t('app','Name'), //'Name',
            'parent_id' => Yii::t('app','Parent'), //'Name',
			'created_date' => Yii::t('app','Created Date'), //'Created Date',
			'modified_date' => Yii::t('app','Modified Date'), //'Modified Date',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		$criteria=new CDbCriteria;

		//$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);

        if  ( Yii::app()->user->getState('category_archived', Yii::app()->params['defaultArchived'] ) == 'true' ) {
            $criteria->condition = 'name like :search';
            $criteria->params = array(
                ':search' => '%' . $this->search . '%',
            );
        } else {
            $criteria->condition = 'status=:active_status AND (name like :search)';
            $criteria->params = array(
                ':active_status' => Yii::app()->params['active_status'],
                ':search' => '%' . $this->search . '%',
            );
        }

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'pagination' => array(
                'pageSize' => Yii::app()->user->getState('category_page_size', Common::defaultPageSize()),
            ),
            'sort'=>array( 'defaultOrder'=>'name')
        ));

	}

    protected function getCategoryInfo()
    {
        return $this->name;

    }

    public function getCategory()
    {
        $model = Category::model()->findAll();
        $list = CHtml::listData($model, 'id', 'CategoryInfo');
        return $list;
    }

    // Get Item Category for select 2 -- cannot finding the style of normal select and button next to it
    public static function getCategory2($name = '')
    {

        // Recommended: Secure Way to Write SQL in Yii
        $sql = "SELECT id ,name AS text 
                    FROM category 
                    WHERE (name LIKE :name)";

        $name = '%' . $name . '%';
        return Yii::app()->db->createCommand($sql)->queryAll(true, array(':name' => $name));

    }

    public function saveCategory($category_name)
    {
        $category_id = null;
        $exists = Category::model()->exists('CONVERT(id,CHAR(3))=:category_id', array(':category_id' => $category_name));
        if (!$exists) {
            $category = new Category;
            $category->name = $category_name;
            $category->save();
            $category_id = $category->id;
        }

        return $category_id;
    }

    public function deleteCategory($id)
    {
        Category::model()->updateByPk((int)$id, array('status' => Yii::app()->params['inactive_status'] ));
    }

    public function restoreCategory($id)
    {
        Category::model()->updateByPk((int)$id, array('status' => Yii::app()->params['active_status'] ));
    }

    public static function getCategoryColumn()
    {
        return
            array(
                array(
                    'name' => 'name',
                    'value' => '$data->status=="1" ? $data->name : "<s class=\"red\">  $data->name <s>" ',
                    'type' => 'raw',
                ),
                'modified_date',
                array(
                    'class' => 'bootstrap.widgets.TbButtonColumn',
                    'header' => Yii::t('app', 'Action'),
                    'template' => '<div class="hidden-sm hidden-xs btn-group">{update}{delete}{restore}</div>',
                    'buttons' => array(
                        'update' => array(
                            //updateDialogOpen
                            'click' => '',
                            'url' => 'Yii::app()->createUrl("category/update2", array("id"=>$data->id))',
                            'label' => 'Update Category',
                            'icon' => 'ace-icon fa fa-edit',
                            'options' => array(
                                'data-update-dialog-title' => Yii::t('app', 'Update Price Tier'),
                                'data-refresh-grid-id' => 'category-grid',
                                'class' => 'btn btn-xs btn-info',
                            ),
                            'visible' => '$data->status=="1" && Yii::app()->user->checkAccess("category.update2")',
                        ),
                        'delete' => array(
                            'label' => Yii::t('app', 'Delete Category'),
                            'options' => array(
                                'data-update-dialog-title' => Yii::t('app', 'Delete Category'),
                                'titile' => 'Delete Category',
                                'class' => 'btn btn-xs btn-danger',
                            ),
                            'visible' => '$data->status=="1" && Yii::app()->user->checkAccess("category.delete")',
                        ),
                        'restore' => array(
                            'label' => Yii::t('app', 'Restore Category'),
                            'url' => 'Yii::app()->createUrl("category/restore", array("id"=>$data->id))',
                            'icon' => 'bigger-120 glyphicon-refresh',
                            'options' => array(
                                'class' => 'btn btn-xs btn-warning btn-undodelete',
                            ),
                            'visible' => '$data->status=="0" && Yii::app()->user->checkAccess("category.delete")',
                        ),
                    ),
                ),
            );
    }
}