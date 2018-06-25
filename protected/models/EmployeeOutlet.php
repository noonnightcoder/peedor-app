<?php

class EmployeeOutlet extends CActiveRecord
{

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'employee_outlet';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('employee_id,outlet_id', 'required'),
			array('employee_id,outlet_id', 'numerical', 'integerOnly'=>true),
		);
	}

	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
            
		);
	}

	public function attributeLabels()
	{
		return array(
			'employee_id' => 'Employee',
			'outlet_id' => 'Outlet',
		);
	}

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

}
