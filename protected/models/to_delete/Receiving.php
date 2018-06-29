<?php

/**
 * This is the model class for table "receiving".
 *
 * The followings are the available columns in table 'receiving':
 * @property integer $id
 * @property string $receive_time
 * @property integer $supplier_id
 * @property integer $employee_id
 * @property double $sub_total
 * @property string $payment_type
 * @property string $status
 * @property string $remark
 * @property double $discount_amount
 * @property integer $discount_percent
 *
 * The followings are the available model relations:
 * @property Item[] $items
 */
class Receiving extends CActiveRecord
{

    public $quantity;

    public function tableName()
    {
        return 'receiving';
    }

    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            //array('receive_time', 'required'),
            array('supplier_id, employee_id', 'numerical', 'integerOnly' => true),
            array('sub_total, discount_amount', 'numerical'),
            array('payment_type', 'length', 'max' => 255),
            array('status', 'length', 'max' => 30),
            array(
                'receive_time',
                'default',
                'value' => new CDbExpression('NOW()'),
                'setOnEmpty' => true,
                'on' => 'insert'
            ),
            array('remark, discount_type', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array(
                'id, receive_time, supplier_id, employee_id, sub_total, payment_type, status, remark, discount_amount, discount_type',
                'safe',
                'on' => 'search'
            ),
        );
    }

    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'items' => array(self::MANY_MANY, 'Item', 'receiving_item(receive_id, item_id)'),
            'supplier' => array(self::BELONGS_TO, 'Supplier', 'supplier_id'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'receive_time' => 'Receive Time',
            'supplier_id' => 'Supplier',
            'employee_id' => 'Employee',
            'sub_total' => 'Sub Total',
            'payment_type' => 'Payment Type',
            'status' => 'Status',
            'remark' => 'Remark',
        );
    }

    public function search()
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;
        $criteria->compare('id', $this->id);
        $criteria->compare('receive_time', $this->receive_time, true);
        $criteria->compare('supplier_id', $this->supplier_id);
        $criteria->compare('employee_id', $this->employee_id);
        $criteria->compare('sub_total', $this->sub_total);
        $criteria->compare('payment_type', $this->payment_type, true);
        $criteria->compare('status', $this->status, true);
        $criteria->compare('remark', $this->remark, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function saveRevc($items, $payments, $supplier_id, $employee_id, $sub_total, $total, $comment, $trans_mode, $discount_amount,$discount_type)
    {
        if (count($items) == 0) {
            return '-1';
        }

        $model = new Receiving;
        $payment_types = '';

        foreach ($payments as $payment_id => $payment) {
            $payment_types = $payment_types . $payment['payment_type'] . ': ' . $payment['payment_amount'] . '<br />';
        }

        $transaction = $model->dbConnection->beginTransaction();
        try {
            $model->supplier_id = $supplier_id;
            $model->employee_id = $employee_id;
            $model->payment_type = $payment_types;
            $model->remark = $comment;
            $model->sub_total = $sub_total;
            $model->status = $this->transactionHeader();
            $model->discount_amount = $discount_amount === null ? 0 : $discount_amount;
            $model->discount_type = $discount_type === null ? '%' : $discount_type;

            if ($model->save()) {
                $receiving_id = $model->id;
                $trans_date = date('Y-m-d H:i:s');

                // Saving & Updating Account and Account Receivable either transaction 'receive' or 'return'
                $this->saveAccountAR($employee_id, $receiving_id, $supplier_id, $total, $trans_date, $trans_mode);

                // Saving receiving item to receiving_item table
                $this->saveReceiveItem($items, $receiving_id, $employee_id, $trans_date);

                $message = $receiving_id;
                $transaction->commit();
            }
        } catch (Exception $e) {
            $transaction->rollback();
            $message = '-1' . $e;
        }

        return $message;

    }

    // Updating [account_supplier] table & saving to [account_receivable_supplier] only for either 'receiv' or 'return' transaction
    protected function saveAccountAR($employee_id, $receiving_id, $supplier_id, $total, $trans_date, $trans_mode)
    {
        if ($trans_mode == 'receive' || $trans_mode == 'return') {

            $sub_total = $trans_mode == 'receive' ? $total : -$total;
            // Updating current_balance in account table
            $account = $this->updateAccount($supplier_id, $total);
            if ($account) {
                // Saving to Account Receivable (Payment, Sale Transaction ..)
                $trans_code = $this->transactionCode($trans_mode);
                $this->saveAR($account->id, $employee_id, $receiving_id, $total, $trans_date, $trans_code);
            }
        }
    }

    protected function updateAccount($supplier_id, $purchase_amount)
    {
        $account = AccountSupplier::model()->find('supplier_id=:supplier_id',
            array(':supplier_id' => (int)$supplier_id));
        if ($account) {
            $account->current_balance = $account->current_balance + $purchase_amount;
            $account->save();
        }

        return $account;
    }

    protected function saveAR($account_id, $employee_id, $receiving_id, $purchase_amount, $trans_date, $trans_code)
    {
        //Saving Receivng AR Transaction
        $account_receivable = new AccountReceivableSupplier;
        $account_receivable->account_id = $account_id;
        $account_receivable->employee_id = $employee_id;
        $account_receivable->trans_id = $receiving_id;
        $account_receivable->trans_amount = $purchase_amount;
        $account_receivable->trans_code = $trans_code;
        $account_receivable->trans_datetime = $trans_date;
        $account_receivable->save();

    }

    protected function saveReceiveItem($items, $receiving_id, $employee_id, $trans_date)
    {
        foreach ($items as $line => $item) {
            $item_id = $item['item_id'];
            $cost_price = $item['cost_price'];
            $unit_price = $item['unit_price'];
            $quantity = $item['quantity'];
            $remarks = $this->transactionHeader() . ' ' . $receiving_id;

            $cur_item_info = Item::model()->findbyPk($item_id);
            $qty_in_stock = $cur_item_info->quantity;
            $cur_unit_price = $cur_item_info->unit_price;

            $stock_quantity = $this->stockQuantiy($qty_in_stock, $quantity);
            $discount_arr = Common::Discount($item['discount']);
            $discount_amount = $discount_arr[0];
            $discount_type = $discount_arr[1];

            $receiving_item = new ReceivingItem;

            $receiving_item->receive_id = $receiving_id;
            $receiving_item->item_id = $item_id;
            $receiving_item->line = $line;
            $receiving_item->quantity = $quantity;
            $receiving_item->cost_price = $cost_price;
            $receiving_item->unit_price = $cur_item_info->unit_price;
            $receiving_item->price = $unit_price; // Not used for Receiving Module
            $receiving_item->discount_amount = $discount_amount == null ? 0 : $discount_amount;
            $receiving_item->discount_type = $discount_type;

            $receiving_item->save();

            // Updating Price (Cost & Resell) to item table requested by owner
            $this->updateItem($cur_item_info, $cost_price, $unit_price, $stock_quantity[0]);

            // Product Price (retail price) history
            $this->updateItemPrice($item_id, $cur_unit_price, $unit_price, $employee_id, $trans_date);

            //Ramel Inventory Tracking
            $this->saveInventory($item_id, $employee_id, $stock_quantity[1], $trans_date, $remarks, $quantity,
                $qty_in_stock, $stock_quantity[0]);

            // Save Item Expire for tracking
            if (!empty($item['expire_date'])) {
                $this->saveItemExpire($item['expire_date'], $receiving_id, $item_id, $employee_id, $quantity,
                    $trans_date, $remarks);
            }
        }
    }

    protected function updateItem($cur_item_info, $cost_price, $unit_price, $quantity)
    {
        $cur_item_info->cost_price = $cost_price;
        $cur_item_info->unit_price = $unit_price;
        $cur_item_info->quantity = $quantity;
        $cur_item_info->save();
    }

    protected function updateItemPrice($item_id, $cur_unit_price, $unit_price, $employee_id, $trans_date)
    {
        if ($cur_unit_price <> $unit_price) {
            $item_price = new ItemPrice;
            $item_price->item_id = $item_id;
            $item_price->old_price = $cur_unit_price;
            $item_price->new_price = $unit_price;
            $item_price->employee_id = $employee_id;
            $item_price->modified_date = $trans_date;
            $item_price->save();
        }
    }

    protected function saveInventory(
        $item_id,
        $employee_id,
        $rev_quantity,
        $trans_date,
        $remarks,
        $trans_qty,
        $qty_b4_trans,
        $qty_af_trans
    )
    {
        $inventory = new Inventory;
        $inventory->trans_items = $item_id;
        $inventory->trans_user = $employee_id;
        $inventory->trans_comment = $remarks;
        $inventory->trans_inventory = $rev_quantity;
        $inventory->trans_date = $trans_date;
        $inventory->trans_qty = $trans_qty;
        $inventory->qty_b4_trans = $qty_b4_trans;
        $inventory->qty_af_trans = $qty_af_trans;
        $inventory->save();
    }

    protected function saveItemExpire(
        $item_expire_date,
        $receiving_id,
        $item_id,
        $employee_id,
        $quantity,
        $trans_date,
        $remarks
    ) {
        if (!empty($item_expire_date)) {

            /*$item_expire = ItemExpire::model()->find('item_id=:item_id and expire_date=:expire_date',
                array(':item_id' => (int)$item_id, ':expire_date' => str_to_date($item_expire_date, '%d/%m/%Y')));*/

            $sql = "SELECT * FROM item_expire WHERE item_id=:item_id and expire_date= str_to_date(:expire_date,'%d/%m/%Y')";

            $item_expire = ItemExpire::model()->findBySql($sql,array(':item_id' => (int) $item_id, ':expire_date' => $item_expire_date));

            if (!$item_expire) {
                $item_expire = new ItemExpire;
                $qty_in_stock = 0;
            } else {
                $qty_in_stock = $item_expire->quantity;
            }

            $stock_quantity = $this->stockQuantiy($qty_in_stock, $quantity);

            //Update Item expiry date & quantity
            $item_expire->item_id = $item_id;
            $item_expire->expire_date = $item_expire_date;
            $item_expire->quantity = $stock_quantity[0];
            $item_expire->save();

            $item_expire_dt = new ItemExpireDt;
            $item_expire_dt->item_expire_id = $item_expire->id;
            $item_expire_dt->trans_id = $receiving_id;
            $item_expire_dt->trans_qty = $stock_quantity[0];
            $item_expire_dt->trans_comment = $remarks;
            $item_expire_dt->modified_date = $trans_date;
            $item_expire_dt->employee_id = $employee_id;
            $item_expire_dt->save();
        }
    }

    public function deleteReceiving($receiving_id)
    {
        $model = new Receiving;

        $transaction = $model->dbConnection->beginTransaction();
        try {
            $receiving = Receiving::model()->findbyPk($receiving_id);
            $receiving->delete(); // use constraint PK on cascade delete no need to select item & payment table
            $transaction->commit();
        } catch (Exception $e) {
            return -1;
            $transaction->rollback();
        }

    }

    public function transactionHeader()
    {
        if (Yii::app()->receivingCart->getMode() === 'receive') //+Quantity
        {
            $data['trans_header'] = sysMenuPurchaseReceive();
        } elseif (Yii::app()->receivingCart->getMode() === 'return') //-Quantity
        {
            $data['trans_header'] = sysMenuPurchaseReturn();
        } elseif (Yii::app()->receivingCart->getMode() === 'adjustment_in') //+Quantity
        {
            $data['trans_header'] = sysMenuInventoryAdd();
        } elseif (Yii::app()->receivingCart->getMode() === 'adjustment_out') // -Quantity
        {
            $data['trans_header'] = sysMenuInventoryMinus();
        } elseif (Yii::app()->receivingCart->getMode() === 'physical_count') // Physical count
        {
            $data['trans_header'] = sysMenuInventoryCount();
        }

        return $data['trans_header'];
    }

    protected function transactionCode($trans_mode)
    {
        if ($trans_mode == 'receive') {
            $trans_code = 'CHRECV'; //Charge Receiving
        } else {
            if ($trans_mode == 'return') {
                $trans_code = 'RERECV'; //Reverse / Debit Receiving
            }
        }

        return $trans_code;
    }

    protected function stockQuantiy($qty_in_stock, $new_quantity)
    {
        if (Yii::app()->receivingCart->getMode() === 'receive') {
            $quantity = $qty_in_stock + $new_quantity;
            $inv_quantity = $new_quantity;
        } elseif (Yii::app()->receivingCart->getMode() === 'return') //-Quantity
        {
            $quantity = $qty_in_stock - $new_quantity;
            $inv_quantity = -$new_quantity;
        } elseif (Yii::app()->receivingCart->getMode() === 'adjustment_in') //+Quantity
        {
            $quantity = $qty_in_stock + $new_quantity;
            $inv_quantity = $new_quantity;
        } elseif (Yii::app()->receivingCart->getMode() === 'adjustment_out') // -Quantity
        {
            $quantity = $qty_in_stock - $new_quantity;
            $inv_quantity = -$new_quantity;
        } elseif (Yii::app()->receivingCart->getMode() === 'physical_count') // Input Quantity
        {
            $quantity = $new_quantity;
            $inv_quantity = $new_quantity - $qty_in_stock;
        }

        return array($quantity, $inv_quantity);
    }

    public function saveItemToTransfer($model,$data,$items)
    {
        
        $id = null;
        $exists = Receiving::model()->exists('reference_name=:reference_name', array(':reference_name' => $data['reference_name']));
        if(!$exists){
            
            foreach($data as $key=>$value){

                $model->$key = $value;

            }

            $model->save(); 
            $id = $model->id;

            if($id>0){

                $this->saveToInventory($items,$data['from_outlet'],$id);

            }
        }
        
        return $id;
    }

    protected function saveToInventory($items,$outlet_id,$transfer_id,$trans_type=2)
    {

        $trans_comment = Yii::app()->receivingCart->getTransferHeader('trans_type')!==null ? Yii::app()->receivingCart->getTransferHeader('trans_type') : 'Stock Transfer';

        foreach($items as $item){

            $inventory_data = array(
                'trans_items' => $item['item_id'],
                'trans_user' => $item['employee_id'],
                'trans_comment' => $trans_comment,
                'trans_inventory' => (-$item['quantity']),
                'trans_qty' => $item['quantity'],
                'qty_b4_trans' => $item['current_quantity'] , // for tracking purpose recording the qty before operation effected
                'qty_af_trans' => ($item['current_quantity']-$item['quantity']),
                'trans_date' => date('Y-m-d H:i:s'),
                'outlet_id' => $outlet_id,
            );
            
            Sale::model()->updateItemQuantity($item['item_id'],$outlet_id,$item['quantity']);

            Sale::model()->saveSaleTransaction(new Inventory,$inventory_data,$outlet_id);   

            $data['receive_id'] = $transfer_id;
            $data['item_id'] = $item['item_id'];
            $data['quantity'] = $item['quantity'];
            $data['unit_price'] = $item['unit_price'];
            $data['cost_price'] = $item['cost_price'];
            $data['price'] = $item['price'];
            Sale::model()->saveSaleTransaction(new ReceivingItem,$data);

        }

    }

    protected function insertTransferItem($transfer_id,$items)
    {
        // $sql = "insert into transfer_item(transfer_id,item_id,quantity)
        // values(:transfer_id,:item_id,:quantity)";

        // $command = Yii::app()->db->createCommand($sql);
        // $command->bindParam(":transfer_id", $transfer_id, PDO::PARAM_INT);
        // $command->bindParam(":item_id", $items['item_id'], PDO::PARAM_INT);
        // $command->bindParam(":quantity", $items['quantity'], PDO::PARAM_INT);
        // $command->execute();

        $items['receive_id'] = $transfer_id;

        Sale::model()->saveSaleTransaction(new ReceivingItem,$items);

    }

    public function updateItemToDestinationOutlet($transfer_id)
    {
        $sql="SELECT t.receive_id,item_id,from_outlet,to_outlet,quantity
                FROM receiving_item t JOIN receiving s
                ON t.receive_id=s.id 
                where t.receive_id=:transfer_id";

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
                        UPDATE item_outlet io JOIN receiving_item ti
                        ON io.item_id=ti.item_id JOIN receiving st
                        ON ti.receive_id=st.id
                        AND io.outlet_id=st.to_outlet
                        SET io.quantity = io.quantity+ti.quantity
                        where ti.receive_id=:transfer_id
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

            $stock_model = Receiving::model()->findByPk($transfer_id);
            $stock_model->trans_type=param('sale_complete_status');
            $stock_model->save();

        }
    }

    public function rolebackSourceOutletQuantity($transfer_id,$outlet_id,$trans_type)
    {

        $sql="SELECT io.outlet_id,io.item_id,io.quantity qty_b4_trans,ti.quantity trans_qty
            FROM item_outlet io JOIN receiving_item ti
            ON io.item_id = ti.item_id
            where ti.receive_id=:transfer_id
            and io.outlet_id=:outlet_id
        ";

        $result = Yii::app()->db->createCommand($sql)->queryAll(true, array(
            ':transfer_id' => $transfer_id,
            ':outlet_id' => $outlet_id
        ));

        if($result){
            $trans_comment = $trans_type == param('sale_reject_status') ? 'Reject Transfer' : 'Cancel Transfer';
            foreach($result as $value){

                $inventory_data = array(
                    'trans_items' => $value['item_id'],
                    'trans_user' => Yii::app()->session['employeeid'],
                    'trans_comment' => $trans_comment,
                    'trans_inventory' => $value['trans_qty'],
                    'trans_qty' => $value['trans_qty'],
                    'qty_b4_trans' => $value['qty_b4_trans'] , // for tracking purpose recording the qty before operation effected
                    'qty_af_trans' => $value['trans_qty']+$value['qty_b4_trans'],
                    'trans_date' => date('Y-m-d H:i:s'),
                    'outlet_id' => $value['outlet_id'],
                );

                Sale::model()->saveSaleTransaction(new Inventory,$inventory_data);//save to inventory

                //role back quantity to source outlet
                $roleback_sql="UPDATE item_outlet io JOIN receiving_item ti
                    ON io.item_id=ti.item_id
                    SET io.quantity = io.quantity+ti.quantity
                    WHERE ti.receive_id=:transfer_id
                    AND io.item_id=:item_id
                    AND io.outlet_id=:outlet_id";

                    $command = Yii::app()->db->createCommand($roleback_sql);
                    $command->bindParam(":transfer_id", $transfer_id, PDO::PARAM_INT);
                    $command->bindParam(":item_id", $value['item_id'], PDO::PARAM_INT);
                    $command->bindParam(":outlet_id", $value['outlet_id'], PDO::PARAM_INT);
                    $command->execute();

                //update status to reject status in stock transfer table
                $stock_model = Receiving::model()->findByPk($transfer_id);
                $stock_model->trans_type=$trans_type;
                $stock_model->save();

                /*$delete_sql="DELETE FROM transfer_item
                where transfer_id=:transfer_id";

                $command1 = Yii::app()->db->createCommand($delete_sql);
                $command1->bindParam(":transfer_id", $transfer_id, PDO::PARAM_INT);
                $command1->execute();*/

            }

        }

    }

}