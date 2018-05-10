<?php

/**
 * This is the model class for table "receiving_item".
 *
 * The followings are the available columns in table 'receiving_item':
 * @property integer $receive_id
 * @property integer $item_id
 * @property string $description
 * @property integer $line
 * @property double $quantity
 * @property double $cost_price
 * @property double $unit_price
 * @property double $price
 * @property double $discount_amount
 * @property string $discount_type
 */

class PriceBook extends CActiveRecord
{
	public $search;
        
        /**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'price_book';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('price_book_name, outlet_id', 'required'),
			array('start_date,end_date', 'date', 'format'=>array('dd/MM/yyyy','d/MM/yyyy')),
			array('price_book_name, item_id', 'safe', 'on'=>'search'),
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
			'pricings' => array(self::HAS_MANY, 'Pricing', 'price_book_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
    public function attributeLabels()
    {
        return array(
            'id' => Yii::t('app', 'ID'), //'ID',
            'price_book_name' => Yii::t('app', 'Name'), //'Name',
            'start_date' => Yii::t('app', 'Start Date'), //'Start Date',
            'end_date' => Yii::t('app', 'End Date'), //'End Date',
            'outlet_id' => Yii::t('app', 'Outlet'), //'Outlet',
        );
    }

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        
        if  ( Yii::app()->user->getState('item_archived', Yii::app()->params['defaultArchived'] ) == 'true' ) {
            $criteria->condition = 'price_book_name LIKE :name';
            $criteria->params = array(
                ':name' => '%' . $this->search . '%'
            );
        } else {
            $criteria->condition = 'status=:active_status AND (price_book_name LIKE :name)';
            $criteria->params = array(
                ':active_status' => param('active_status'),
                ':name' => '%' . $this->search . '%'
            );
        }

        //$criteria->addSearchCondition('status',param('active_status'));

        //$criteria->condition='deleted=:is_deleted';
        //$criteria->params=array(':is_deleted'=>$this::_item_not_deleted);

        $criteria->compare('outlet_id',$this->outlet_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => Yii::app()->user->getState('item_page_size', Common::defaultPageSize()),
            ),
            'sort' => array('defaultOrder' => 'price_book_name')
        ));
    }

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ReceivingItem the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function getPriceBook($id)
    {
        $model = PriceBook::model()->findAll('id=:id', array(':id' => $id));

        return $model;
    }
    public static function getPriceBookDetail($id){
        $sql1 = "SELECT pb.id  price_book_id,price_book_name,outlet_name,date_format(start_date,'%d-%m-%Y') valid_from,date_format(end_date,'%d-%m-%Y') valid_to
                   FROM price_book pb ,outlet o 
                   WHERE pb.outlet_id=o.id
                   AND pb.id=:id";
        $sql2 = "SELECT name 'item name',retail_price 'retail price',min_unit 'from quantity',max_unit 'to quantity'
                   FROM item i ,pricings p 
                   WHERE i.id=p.item_id
                   AND p.price_book_id=:price_book_id";
        $rawData = Yii::app()->db->createCommand($sql1)->queryAll(true, array(':id' => $id));
        $data=array();
        foreach($rawData as $key=>$value){
            $data['data'] = $value;
            $itemRawData = Yii::app()->db->createCommand($sql2)->queryAll(true, array(':price_book_id' => $value['price_book_id']));
            foreach($itemRawData as $k=>$v){
                $data['data']['item'][]=$v;
            }
        }
        return $data;
    }
    public static function getItemColumns() {
        return array(
            array(
                'name' => 'price_book_name',
                'value' => '$data->status=="1" ? CHtml::link($data->price_book_name, Yii::app()->createUrl("pricebook/view",array("id"=>$data->primaryKey))) : "<s class=\"red\">  $data->price_book_name <span>" ',
                'type' => 'raw',
                'filter' => '',
            ),
            array(
            	'name'=>'Valid From',
            	'value'=>'$data->start_date',
            	'type'=>'raw',
            	'filter'=>''
        	),
            array(
                'name'=>'Valid To',
                'value'=>'$data->end_date',
                'type'=>'raw',
                'filter'=>''
            )
        );
    }
}