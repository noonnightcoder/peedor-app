<?php

/**
 * This is the model class for table "inventory".
 *
 * The followings are the available columns in table 'inventory':
 * @property integer $trans_id
 * @property integer $trans_items
 * @property integer $trans_user
 * @property string $trans_date
 * @property string $trans_comment
 * @property double $trans_inventory
 * @property double $trans_qty
 * @property double $qty_b4_trans
 * @property double $qty_af_trans
 */
class StockTransfer extends CActiveRecord
{

	public $search;
	public $quantity;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'stock_transfer';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name,from_outlet,to_outlet', 'required'),
			array('from_outlet,to_outlet', 'numerical', 'integerOnly'=>true),
			array('to_outlet', 'compare', 'compareAttribute' => 'from_outlet',
				'operator'=>'!=','message'=>'From and To Outlet must difference'
			),
			array('from_outlet', 'compare', 'compareAttribute' => 'to_outlet',
				'operator'=>'!=','message'=>'From and To Outlet must difference'
			),
            array('name', 'unique'),
			array('name', 'safe', 'on'=>'search'),
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
			'transItems' => array(self::BELONGS_TO, 'Item', 'trans_items'),
                        'employee' => array(self::BELONGS_TO, 'Employee', 'trans_user'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'name' => 'Reference',
			'delivery_due_date' => 'Delivery Due',
			'from_outlet' => 'From',
			'to_outlet' => 'To'
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
	public function search2()
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria=new CDbCriteria;

        $criteria->compare('types','InvCount');
        // $criteria['distinct']=true;
        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

	public function search($item_id)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('trans_id',$this->trans_id);
		$criteria->compare('trans_items',$this->trans_items);
		$criteria->compare('trans_user',$this->trans_user);
		$criteria->compare('trans_date',$this->trans_date,true);
		$criteria->compare('trans_comment',$this->trans_comment,true);
		$criteria->compare('trans_inventory',$this->trans_inventory);
		$criteria->compare('trans_qty',$this->trans_qty);
		$criteria->compare('qty_b4_trans',$this->qty_b4_trans);
        $criteria->compare('qty_af_trans',$this->qty_af_trans);
        
        $criteria->condition="trans_items=:trans_items";
        $criteria->params = array(':trans_items' => $item_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'sort'=>array( 'defaultOrder'=>'trans_date desc')
		));
	}

	public function saveItemToTransfer($model,$data,$items)
	{
		
		$id = null;
		$exists = StockTransfer::model()->exists('name=:name', array(':name' => $data['name']));
		if(!$exists){
			foreach($data as $key=>$value){

				$model->$key = $value;

			}
			$model->status = param('sale_submit_status');
			$model->transfered_by = Yii::app()->session['employeeid'];
			$model->save();	
			$id = $model->id;

			if($id>0){

				$this->saveToInventory($items,$data['from_outlet'],$id);

			}
		}
		
		return $id;
	}

	protected function saveToInventory($items,$outlet_id,$transfer_id)
	{

		foreach($items as $item){

			$inventory_data = array(
		        'trans_items' => $item['item_id'],
		        'trans_user' => $item['employee_id'],
		        'trans_comment' => 'Stock Transfer',
		        'trans_inventory' => (-$item['quantity']),
		        'trans_qty' => $item['quantity'],
		        'qty_b4_trans' => $item['current_quantity'] , // for tracking purpose recording the qty before operation effected
		        'qty_af_trans' => $item['quantity_after_trans'],
		        'trans_date' => date('Y-m-d H:i:s'),
		        'outlet_id' => $outlet_id,
		    );

			Sale::model()->updateItemQuantity($item['item_id'],$outlet_id,$item['quantity']);

		    Sale::model()->saveSaleTransaction(new Inventory,$inventory_data,$outlet_id);	

		    $this->insertTransferItem($transfer_id,$item);	

		}

	}

	protected function insertTransferItem($transfer_id,$items)
	{
		$sql = "insert into transfer_item(transfer_id,item_id,quantity)
		values(:transfer_id,:item_id,:quantity)";

		$command = Yii::app()->db->createCommand($sql);
        $command->bindParam(":transfer_id", $transfer_id, PDO::PARAM_INT);
        $command->bindParam(":item_id", $items['item_id'], PDO::PARAM_INT);
        $command->bindParam(":quantity", $items['quantity'], PDO::PARAM_INT);
        $command->execute();

	}

	public function updateItemToDestinationOutlet($transfer_id)
	{
		$sql="SELECT t.transfer_id,item_id,to_outlet,quantity
				FROM transfer_item t JOIN stock_transfer s
				ON t.transfer_id=s.id 
				where t.transfer_id=:transfer_id";

		$result = Yii::app()->db->createCommand($sql)->queryAll(true, array(':transfer_id' => $transfer_id));

		if($result){

			foreach($result as $value){

				$item_outlet_model = ItemOutlet::model()->findAll('`item_id`=:item_id and (`outlet_id`=:outlet_id)',array(':item_id'=>$value['item_id'],':outlet_id'=>$value['to_outlet'])
				);

				
				if(!empty($item_outlet_model)){

					foreach($item_outlet_model as $item){

						$inventory_data = array(
					        'trans_items' => $value['item_id'],
					        'trans_user' => Yii::app()->session['employeeid'],
					        'trans_comment' => 'Receive Transfer',
					        'trans_inventory' => $value['quantity'],
					        'trans_qty' => $value['quantity'],
					        'qty_b4_trans' => $item['quantity'] , // for tracking purpose recording the qty before operation effected
					        'qty_af_trans' => $item['quantity']+$value['quantity'],
					        'trans_date' => date('Y-m-d H:i:s'),
					        'outlet_id' => $value['to_outlet'],
					    );

						Sale::model()->saveSaleTransaction(new Inventory,$inventory_data);

					}

					$update_sql="
						update item_outlet io join transfer_item ti
						on io.item_id=ti.item_id join stock_transfer st
						on ti.transfer_id=st.id
						and io.outlet_id=st.to_outlet
						SET io.quantity = io.quantity+ti.quantity
						where ti.transfer_id=:transfer_id
						and io.item_id=:item_id
					";

					$command = Yii::app()->db->createCommand($update_sql);
			        $command->bindParam(":transfer_id", $transfer_id, PDO::PARAM_INT);
			        $command->bindParam(":item_id", $value['item_id'], PDO::PARAM_INT);
			        $command->execute();

				}else{

					$model = new ItemOutlet;
					$model->item_id = $value['item_id'];
					$model->outlet_id = $value['to_outlet'];
					$model->quantity = $value['quantity'];
					$model->save();

					$inventory_data = array(
				        'trans_items' => $value['item_id'],
				        'trans_user' => Yii::app()->session['employeeid'],
				        'trans_comment' => 'Receive Transfer',
				        'trans_inventory' => $value['quantity'],
				        'trans_qty' => $value['quantity'],
				        'qty_b4_trans' => 0 , // for tracking purpose recording the qty before operation effected
				        'qty_af_trans' => $value['quantity'],
				        'trans_date' => date('Y-m-d H:i:s'),
				        'outlet_id' => $value['to_outlet'],
				    );

					Sale::model()->saveSaleTransaction(new Inventory,$inventory_data);

				}

			}

			$stock_model = StockTransfer::model()->findByPk($transfer_id);
			$stock_model->status=param('sale_complete_status');
			$stock_model->save();

		}
	}

	public function rolebackSourceOutletQuantity($transfer_id)
	{

		$sql="SELECT io.outlet_id,io.item_id,io.quantity qty_b4_trans,ti.quantity trans_qty
			FROM item_outlet io JOIN transfer_item ti
			ON io.item_id = ti.item_id
			where ti.transfer_id=:transfer_id
		";

		$result = Yii::app()->db->createCommand($sql)->queryAll(true, array(':transfer_id' => $transfer_id));

		if($result){

			foreach($result as $value){

				$inventory_data = array(
			        'trans_items' => $value['item_id'],
			        'trans_user' => Yii::app()->session['employeeid'],
			        'trans_comment' => 'Reject Transfer',
			        'trans_inventory' => $value['trans_qty'],
			        'trans_qty' => $value['trans_qty'],
			        'qty_b4_trans' => $value['qty_b4_trans'] , // for tracking purpose recording the qty before operation effected
			        'qty_af_trans' => $value['trans_qty']+$value['qty_b4_trans'],
			        'trans_date' => date('Y-m-d H:i:s'),
			        'outlet_id' => $value['outlet_id'],
			    );

				Sale::model()->saveSaleTransaction(new Inventory,$inventory_data);//save to inventory

				//role back quantity to source outlet
				$roleback_sql="UPDATE item_outlet io JOIN transfer_item ti
					ON io.item_id=ti.item_id
					SET io.quantity = io.quantity+ti.quantity
					WHERE ti.transfer_id=:transfer_id
					AND io.item_id=:item_id
					AND io.outlet_id=:outlet_id";

					$command = Yii::app()->db->createCommand($roleback_sql);
			        $command->bindParam(":transfer_id", $transfer_id, PDO::PARAM_INT);
			        $command->bindParam(":item_id", $value['item_id'], PDO::PARAM_INT);
			        $command->bindParam(":outlet_id", $value['outlet_id'], PDO::PARAM_INT);
			        $command->execute();

			    //update status to reject status in stock transfer table
			    $stock_model = StockTransfer::model()->findByPk($transfer_id);
				$stock_model->status=param('sale_reject_status');
				$stock_model->save();

				/*$delete_sql="DELETE FROM transfer_item
				where transfer_id=:transfer_id";

				$command1 = Yii::app()->db->createCommand($delete_sql);
		        $command1->bindParam(":transfer_id", $transfer_id, PDO::PARAM_INT);
		        $command1->execute();*/

			}

		}

	}

	protected function rolebackItemQuantity($in_sale_id){
        $sql1 = "UPDATE item t1 
                    INNER JOIN sale_item t2 
                         ON t1.id = t2.item_id
                SET t1.quantity = t1.quantity+t2.quantity
                WHERE t2.sale_id=:sale_id";

        $command1 = Yii::app()->db->createCommand($sql1);
        $command1->bindParam(":sale_id", $in_sale_id, PDO::PARAM_INT);
        $command1->execute();
    }

	public static function getItemColumns() {
        return array(
            array(
                'name' => 'name',
                'value' => 'CHtml::link($data->trans_comment, Yii::app()->createUrl("receivingItem/index?trans_mode=count_detail&id=$data->trans_comment",array())) ',
                'type' => 'raw',
                'filter' => '',
            ),
            array(
                'name' => 'trans_date',
                'type' => 'raw',
                'filter' => '',
            )
        );
    }

    public static function getItemDetailColumns() {
        return array(
            array(
                'name' => 'count_name',
                'type' => 'raw',
                'filter' => '',
            ),
        );
    }

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Inventory the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
