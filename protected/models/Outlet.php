<?php

/**
 * This is the model class for table "outlet".
 *
 * The followings are the available columns in table 'outlet':
 * @property string $id
 * @property string $outlet_name
 * @property integer $tax_id
 * @property string $address1
 * @property string $address2
 * @property integer $village_id
 * @property integer $commune_id
 * @property integer $district_id
 * @property integer $city_id
 * @property integer $country_id
 * @property string $state
 * @property string $postcode
 * @property string $email
 * @property string $phone
 * @property string $status
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 */
class Outlet extends CActiveRecord
{
     public $outlet_archived;
     public $search;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'outlet';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('outlet_name', 'required'),
			array('tax_id, village_id, commune_id, district_id, city_id, country_id', 'numerical', 'integerOnly'=>true),
			array('outlet_name, address1, address2, state, email', 'length', 'max'=>128),
			array('postcode', 'length', 'max'=>10),
			array('phone', 'length', 'max'=>32),
			array('status', 'length', 'max'=>1),
			array('created_at, updated_at, deleted_at', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, outlet_name, tax_id, address1, address2, village_id, commune_id, district_id, city_id, country_id, state, postcode, email, phone, status, created_at, updated_at, deleted_at, search', 'safe', 'on'=>'search'),
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
            'tax' => array(self::BELONGS_TO, 'Tax', 'tax_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'outlet_name' => 'Outlet Name',
			'tax_id' => 'Tax',
			'address1' => 'Address1',
			'address2' => 'Address2',
			'village_id' => 'Village',
			'commune_id' => 'Commune',
			'district_id' => 'District',
			'city_id' => 'City',
			'country_id' => 'Country',
			'state' => 'State',
			'postcode' => 'Postcode',
			'email' => 'Email',
			'phone' => 'Phone',
			'status' => 'Status',
			'created_at' => 'Created At',
			'updated_at' => 'Updated At',
			'deleted_at' => 'Deleted At',
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
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('outlet_name',$this->outlet_name,true);
		$criteria->compare('tax_id',$this->tax_id);
		$criteria->compare('address1',$this->address1,true);
		$criteria->compare('address2',$this->address2,true);
		$criteria->compare('village_id',$this->village_id);
		$criteria->compare('commune_id',$this->commune_id);
		$criteria->compare('district_id',$this->district_id);
		$criteria->compare('city_id',$this->city_id);
		$criteria->compare('country_id',$this->country_id);
		$criteria->compare('state',$this->state,true);
		$criteria->compare('postcode',$this->postcode,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('created_at',$this->created_at,true);
		$criteria->compare('updated_at',$this->updated_at,true);
		$criteria->compare('deleted_at',$this->deleted_at,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Outlet the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public static function getOutletColumns() {
        return array(
            array(
                'name' => 'outlet_name',
                'value' => '$data->status=="1" ? CHtml::link($data->outlet_name, Yii::app()->createUrl("outlet/update",array("id"=>$data->primaryKey))) : "<s class=\"red\">  $data->outlet_name <span>" ',
                'type' => 'raw',
                'filter' => '',
            ),
            array(
                'name' => 'tax_id',
                'value' => '$data->tax_id==null? " " : $data->tax->name',
                'filter' => '',
                //'filter' => CHtml::listData(Tax::model()->findAll(array('order' => 'taxt_name')), 'id', 'taxt_name'),
            ),
            array(
                'name' => 'address1',
                'filter' => '',
            ),
            array(
                'name' => 'address2',
                'filter' => '',
            ),
            array(
                'class' => 'bootstrap.widgets.TbButtonColumn',
                'header' => Yii::t('app','Action'),
                'template' => '<div class="hidden-sm hidden-xs btn-group">{detail}{delete}{undeleted}</div>',
                'buttons' => array(
                    'detail' => array(
                        'click' => 'updateDialogOpen',
                        'label' => Yii::t('app', 'Stock'),
                        'url' => 'Yii::app()->createUrl("Inventory/admin", array("item_id"=>$data->id))',
                        'options' => array(
                            'data-toggle' => 'tooltip',
                            'data-update-dialog-title' => 'Stock History',
                            'class' => 'btn btn-xs btn-pink',
                            'title' => 'Stock History',
                        ),
                        'visible' => '$data->status=="1" && Yii::app()->user->checkAccess("item.index") ',
                    ),
                    'delete' => array(
                        'label' => Yii::t('app', 'Delete Item'),
                        'icon' => 'bigger-120 fa fa-trash',
                        'options' => array(
                            'class' => 'btn btn-xs btn-danger',
                        ),
                        'visible' => '$data->status=="1" && Yii::app()->user->checkAccess("item.delete")',
                    ),
                    'undeleted' => array(
                        'label' => Yii::t('app', 'Restore Item'),
                        'url' => 'Yii::app()->createUrl("Item/UndoDelete", array("id"=>$data->id))',
                        'icon' => 'bigger-120 glyphicon-refresh',
                        'options' => array(
                            'class' => 'btn btn-xs btn-warning btn-undodelete',
                        ),
                        'visible' => '$data->status=="0" && Yii::app()->user->checkAccess("item.delete")',
                    ),
                ),
            ),
        );
    }
}
