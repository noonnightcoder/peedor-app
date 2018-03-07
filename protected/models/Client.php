<?php

/**
 * This is the model class for table "client".
 *
 * The followings are the available columns in table 'client':
 * @property integer $id
 * @property integer $contact_id
 * @property integer $price_tier_id
 * @property string $first_name
 * @property string $last_name
 * @property string $mobile_no
 * @property date $dob
 * @property string $address1
 * @property string $address2
 * @property integer $city_id
 * @property string $country_code
 * @property string $email
 * @property string $notes
 * @property string $status
 * @property date $created_at
 * @property date $updated_at
 * @property integer $employee_id
 * @property string $gpr_n
 * @property string $gpr_e
 * @property string $size_biz
 * @property string $main_biz
 *
 * The followings are the available model relations:
 * @property Account[] $accounts
 */
class Client extends CActiveRecord
{
    public $search;
    public $day; //Day : DD
    public $month; // Month : MM
    public $year; // Year - YYYY
    public $client_archived;
    
        /**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'client';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('first_name, mobile_no', 'required'),
			array('city_id, price_tier_id, employee_id, contact_id, district_id,commune_id, village_id', 'numerical', 'integerOnly'=>true),
			array('first_name, last_name, main_biz, size_biz', 'length', 'max'=>100),
            array('gps_e, gps_n', 'length', 'max'=>25),
			array('mobile_no', 'length', 'max'=>15),
			array('payment_term', 'length', 'max'=>10),
			array('address1, address2', 'length', 'max'=>60),
			array('country_code', 'length', 'max'=>2),
			array('email, fax', 'length', 'max'=>30),
			array('status', 'length', 'max'=>1),
			array('notes, day, month, year', 'safe'),
            array('dob ', 'date', 'format'=>array('yyyy-MM-dd'), 'allowEmpty'=>true),
            array('created_at,updated_at', 'default', 'value' => date('Y-m-d H:i:s'), 'setOnEmpty' => true, 'on' => 'insert'),
            array('updated_at', 'default', 'value' => date('Y-m-d H:i:s'), 'setOnEmpty' => false, 'on' => 'update'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, contact_id, price_tier_id, first_name, last_name, mobile_no, address1, address2, city_id, country_code, email, fax, notes, status, search, employee_id', 'safe', 'on'=>'search'),
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
			'accounts' => array(self::HAS_MANY, 'Account', 'client_id'),
            'contact' => array(self::BELONGS_TO, 'Contact', 'contact_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'first_name' => Yii::t('app', 'First Name'),
            'last_name' => Yii::t('app', 'Last Name'),
            'mobile_no' => Yii::t('app', 'Mobile No'),
            'address1' => Yii::t('app', 'Address1'),
            'address2' => Yii::t('app', 'Address2'),
            'city_id' => Yii::t('app', 'City'),
            'district_id' => Yii::t('app', 'District'),
            'commune_id' => Yii::t('app', 'Commune'),
            'village_id' => Yii::t('app', 'Village'),
            'country_code' => Yii::t('app', 'Country Code'),
            'email' => Yii::t('app', 'Email'),
            'fax' => Yii::t('app', 'Fax'),
            'notes' => Yii::t('app', 'Notes'),
            'status' => Yii::t('app', 'Status'),
            'search' => Yii::t('app', 'Search') . Yii::t('app', 'Customer'),
            'dob' => Yii::t('app','Date of Birth'),
            'price_tier_id' => Yii::t('app','Price Tier'),
            'employee_id' => Yii::t('app','Employee'),
            'payment_term' => Yii::t('app','Payment Term'),
        );
    }


    public function search()
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;


        /*if ($client_id !== null) {
            $criteria->compare('id', $client_id);
        }*/

        $criteria->compare('id', $this->id);

        if  ( Yii::app()->user->getState('client_archived', Yii::app()->params['defaultArchived'] ) == 'true' ) {
            $criteria->condition = 'first_name like :first_name or last_name like :last_name or mobile_no like :mobile_no';
            $criteria->params = array(
                ':first_name' =>  '%'. $this->search .  '%',
                ':last_name' => '%'. $this->search . '%',
                ':mobile_no' => $this->search . '%',
            );
        } else {
            $criteria->condition = 'status=:active_status AND (first_name like :first_name or last_name like :last_name or mobile_no like :mobile_no)';
            $criteria->params = array(
                ':active_status' => Yii::app()->params['active_status'],
                ':first_name' =>  '%'. $this->search .  '%',
                ':last_name' => '%'. $this->search .  '%',
                ':mobile_no' => $this->search . '%',
            );
        }

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => Yii::app()->user->getState('client_page_size', Common::defaultPageSize()),
            ),
        ));
    }

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function select2Client($name = '')
    {

        // Recommended: Secure Way to Write SQL in Yii
        $sql = 'SELECT id ,concat_ws(" : ",concat_ws("  ",first_name,last_name),mobile_no) AS text
                    FROM client 
                    WHERE (first_name LIKE :name or last_name like :name or mobile_no like :name)
                    AND status=:active_status';

        $name = '%' . $name . '%';

        return Yii::app()->db->createCommand($sql)->queryAll(true,
            array(':name' => $name, ':active_status' => Yii::app()->params['active_status']));

    }

    protected function getFullname()
    {
        return $this->first_name . ' - ' . $this->last_name;
    }

    public function getClient()
    {
        $model = Client::model()->findAll('status=:status', array(':status' => Yii::app()->params['active_status']));
        $list = CHtml::listData($model, 'id', 'Fullname');

        return $list    ;
    }

    public function deleteClient($id)
    {
        Client::model()->updateByPk($id, array('status' => Yii::app()->params['inactive_status']));
        Account::model()->updateAll(array('status' => Yii::app()->params['inactive_status']), 'client_id=:client_id',
            array(':client_id' => $id));
    }

    public function undodeleteClient($id)
    {
        Client::model()->updateByPk($id, array('status' => Yii::app()->params['active_status']));
        Account::model()->updateAll(array('status' => Yii::app()->params['active_status']), 'client_id=:client_id',
            array(':client_id' => $id));
    }

    public static function clientByID($id)
    {
        $model = Client::model()->findByPk($id);

        return isset($model) ? $model : null;
    }

	public function suggest($keyword,$limit=20)
	{
		$models=$this->findAll(array(
			'condition'=>'(first_name LIKE :keyword or last_name=:keyword or mobile_no like :keyword) and status=:status',
                        'order'=>'first_name',
			'limit'=>$limit,
			'params'=>array(':keyword'=>"%$keyword%",':status'=>Yii::app()->params['active_status'])
		));
		$suggest=array();
		foreach($models as $model) {
			$suggest[] = array(
				'label'=>$model->first_name.' '.$model->last_name.' - '.$model->mobile_no,  // label for dropdown list
				'value'=>$model->first_name,  // value for input field
				'id'=>$model->id,       // return values from autocomplete
			);
		}
		return $suggest;
	}

    public function getClientLink()
    {
        $url = Url::to(['client/view', 'id'=>$this->id]);
        $options = [];
        return Html::a($this->getFullName(), $url, $options);
    }

    protected function afterFind()
    {
        $dob = strtotime($this->dob);

        $this->day = date('d',$dob);
        $this->month = date('m',$dob);
        $this->year = date('Y',$dob);
        return parent::afterFind();
    }
        
}
