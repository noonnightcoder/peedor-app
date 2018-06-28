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
class ItemOutlet extends CActiveRecord
{
    public $search;
    public $brand_archived;
    public $outlet_id;

    /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Brand the static model class
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
		return 'item_outlet';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('item_id,outlet_id,quantity', 'required'),
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
			
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{

	}

    public function suggest($keyword, $limit = 20)
    {

    	$outlet_id = Yii::app()->session['from_outlet'] !==null ? Yii::app()->session['from_outlet'] : Yii::app()->session["employee_outlet"];

        $sql="
            select item_id,outlet_id,`name`,item_number,cost_price,unit_price,quantity
            from v_item_outlet
            where (name like :keyword or item_number=:item_number)
            and outlet_id=:outlet_id
        ";
        $models = Yii::app()->db->createCommand($sql)->queryAll(true,
            array(':keyword' => "%$keyword%", ':item_number' => $keyword,':outlet_id'=>$outlet_id));

        $suggest = array();
        foreach ($models as $model) {
            $suggest[] = array(
                'label' => $model['name'] . ' : ' . Yii::app()->settings->get('site', 'currencySymbol') . $model['unit_price'], //. ' - ' . $model->quantity,
                // label for dropdown list
                'value' => $model['name'],
                // value for input field
                'id' => $model['item_id'],
                // return values from autocomplete
                'unit_price' => $model['unit_price'],
                'quantity' => $model['quantity'],
            );
        }

        return $suggest;
    }

    public function suggestByOutletUser($keyword, $limit = 20)
    {

    	$outlet_id = Yii::app()->session['employee_outlet'];

        $sql="
            select id,outlet_id,`name`,item_number,cost_price,unit_price,quantity
            from v_item_outlet
            where (name like :keyword or item_number=:item_number)
            and outlet_id=:outlet_id
        ";
        $models = Yii::app()->db->createCommand($sql)->queryAll(true,
            array(':keyword' => "%$keyword%", ':item_number' => $keyword,':outlet_id'=>$outlet_id));

        $suggest = array();
        foreach ($models as $model) {
            $suggest[] = array(
                'label' => $model['name'] . ' : ' . Yii::app()->settings->get('site', 'currencySymbol') . $model['unit_price'], //. ' - ' . $model->quantity,
                // label for dropdown list
                'value' => $model['name'],
                // value for input field
                'id' => $model['id'],
                // return values from autocomplete
                'unit_price' => $model['unit_price'],
                'quantity' => $model['quantity'],
            );
        }

        return $suggest;
    }
    
}