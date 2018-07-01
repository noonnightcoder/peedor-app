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
class ReceivingItem extends CActiveRecord
{
    public $supplier_id;
    public $payment_type;
    public $comment;
    public $payment_amount;
    public $name;
    public $discount;
    public $sub_total;
    public $expire_date;
    public $search;
    public $total_discount;
    public $outlet;
        
        /**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'receiving_item';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			//array('receive_id, item_id', 'required'),
			array('receive_id, item_id, line', 'numerical', 'integerOnly'=>true),
			array('quantity, cost_price, unit_price, price, discount_amount', 'numerical'),
			array('discount_type', 'length', 'max'=>2),
			array('expire_date', 'date', 'format'=>array('dd/MM/yyyy','d/MM/yyyy')),
			array('description', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('receive_id, item_id, description, line, quantity, cost_price, unit_price, price, discount_amount, discount_type, expire_date, total_discount', 'safe', 'on'=>'search'),
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
			'item' => array(self::BELONGS_TO, 'Item', 'item_id'),
			'receiving' => array(self::BELONGS_TO, 'Receiving', 'receive_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
    public function attributeLabels()
    {
        return array(
            'receive_id' => Yii::t('app', 'Receiving'), //'Sale',
            'item_id' => Yii::t('app', 'Item'), //'Item',
            'description' => Yii::t('app', 'Description'), //'Description',
            'line' => Yii::t('app', 'Line'), //'Line',
            'quantity' => Yii::t('app', 'Quantity'), //'Quantity',
            'cost_price' => Yii::t('app', 'Buy Price'), //'Cost Price',
            'unit_price' => Yii::t('app', 'Sell Price'), // 'Unit Price',
            'price' => Yii::t('app', 'Price'), //'Price',
            'discount_amount' => Yii::t('app', 'Discount'), // 'Discount Amount',
            'discount_type' => Yii::t('app', 'Discount Type'),//'Discount Type',
            'name' => Yii::t('app', 'Item Name'),
            'payment_type' => Yii::t('app', 'Payment Type'),
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
	public function search($status)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		//$criteria->compare('receive_id',$this->receive_id);
		$criteria->compare('item_id',$this->item_id);
		//$criteria->compare('description',$this->description,true);
		//$criteria->compare('line',$this->line);
		//$criteria->compare('quantity',$this->quantity);
		$criteria->compare('cost_price',$this->cost_price);
		$criteria->compare('unit_price',$this->unit_price);
		//$criteria->compare('price',$this->price);
		//$criteria->compare('discount_amount',$this->discount_amount);
		//$criteria->compare('discount_type',$this->discount_type,true);
                
        $criteria->condition="receive_id=:receive_id";
        $criteria->params = array(':receive_id' => $this->search);

		return new CActiveDataProvider($this, array(
			'criteria'=>array(
	            'with'=>array(
		            'item', 'receiving' 
		        ),
            	'together'=>true,  
            	'condition'=>'receiving.status=:status',
            	'params'=>array(':status'=>$status)
            ),

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

    public function getReceivingItem($receiving_id)
    {
        $model = ReceivingItem::model()->findAll('receive_id=:receivingId', array(':receivingId' => $receiving_id));

        return $model;
    }

    public function getTransferItem($receive_id)
    {

        $sql = "
            SELECT receive_id,item_id,employee_id,`status`,reference_name,delivery_due_date,quantity,cost_price,unit_price,price,
                from_outlet,to_outlet,trans_type
            FROM receiving r JOIN receiving_item ri
            ON r.id=ri.receive_id
            WHERE receive_id=:receive_id";

         $result = Yii::app()->db->createCommand($sql)->queryAll(true, array(
                    ':receive_id' => $receive_id
            ));

        return $result;

    }

    public function getItemTransactionColumn()
    {
    	return array(
            array(
                'name' => 'name',
                'value' => '$data->receiving["name"]',
                'type' => 'raw',
                'filter' => '',
            ),
            array(
                'name' => 'quantity',
                'value' => '$data->quantity',
                'type' => 'raw',
                'filter' => '',
            ),
            array(
                'name' => 'supplier',
                'value' => '$data->receiving["supplier"]["company_name"]',
                'type' => 'raw',
                'filter' => '',
            ),
            array(
                'class' => 'bootstrap.widgets.TbButtonColumn',
                'header' => Yii::t('app','Action'),
                'template' => '<div class="hidden-sm hidden-xs btn-group">{view}{edit}{print}</div>',
                'buttons' => array(
                    'edit' => array(
                        'label' => Yii::t('app', 'Update Item'),
                        'url' => 'Yii::app()->createUrl("Item/updateImage", array("id"=>$data->receive_id))',
                        'icon' => 'ace-icon fa fa-edit',
                        'options' => array(
                            'class' => 'btn btn-xs btn-info',
                            'data-update-dialog-title' => 'Update Item',
                            'title' => 'Update Item',
                        ),
                        //'click' => 'updateDialogOpen',
                        'visible' => '(Yii::app()->user->checkAccess("purchasereceive.update"))',
                    ),
                    'view' => array(
                        'label' => 'View',
                        'icon' => 'fa fa-eye',
                        'url' => 'Yii::app()->createUrl("saleItem/Receipt", array("employee_id"=>$data->receive_id,"print"=>"true"))',
                        'options' => array(
                            'target' => '_blank',
                            'title' => Yii::t('app', 'Invoice Printing'),
                            'class' => 'btn btn-xs btn-success',
                        ),
                        // 'visible' => 'Yii::app()->user->checkAccess("invoice.print")',
                    ),
                    'print' => array(
                        'label' => 'print',
                        'icon' => 'glyphicon-print',
                        'url' => 'Yii::app()->createUrl("saleItem/Receipt", array("employee_id"=>$data->receive_id,"print"=>"true"))',
                        'options' => array(
                            'target' => '_blank',
                            'title' => Yii::t('app', 'Invoice Printing'),
                            'class' => 'btn btn-xs btn-success',
                        ),
                        // 'visible' => 'Yii::app()->user->checkAccess("invoice.print")',
                    ),
                )
            ),
        );
    }

}
