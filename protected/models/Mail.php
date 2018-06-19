<?php

/**
 * This is the model class for table "sale_item".
 *
 * The followings are the available columns in table 'sale_item':
 * @property integer $id
 * @property integer $sale_id
 * @property integer $item_id
 * @property string $description
 * @property integer $line
 * @property double $quantity
 * @property double $cost_price
 * @property double $unit_price
 * @property double $price
 * @property double $discount_amount
 * @property integer $discount_type
 *
 * The followings are the available model relations:
 * @property Item $item
 * @property Sale $sale
 */
class Mail extends CActiveRecord
{

    public $mail_from;
    public $mail_to;
    public $mail_cc;
    public $mail_body;
    public $mail_subject;
    public $attach_receipt;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Mail the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'mail';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('mail_to,mail_from,', 'required'),
            array('mail_from,mail_to,mail_cc', 'email'),
            array('mail_to,mail_from,mail_body,mail_subject,mail_cc', 'safe', 'on' => 'search'),
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
            'mail_from' => 'From',
            'mail_to' => 'To',
            'mail_subject' => 'Subject',
            'mail_cc' => 'CC',
            'mail_body' => 'Body',
            'attach_receipt' => 'Send with receipt attachment?'
        );
    }

}