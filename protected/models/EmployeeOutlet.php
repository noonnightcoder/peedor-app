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
            'employee' => array(self::BELONGS_TO, 'Employee', 'id'),
		);
	}

	public function updateEmployeeOutlet($employee_id,$outlet_id)
	{
		$sql="update employee_outlet set outlet_id=:outlet_id
		where employee_id=:employee_id";

		$command = Yii::app()->db->createCommand($sql);
        $command->bindParam(":employee_id", $employee_id, PDO::PARAM_INT);
        $command->bindParam(":outlet_id", $outlet_id, PDO::PARAM_INT);
        $command->execute();
	}

	public function getEmployeeOutlet($employee_id)
	{
		$model = EmployeeOutlet::model()->findByAttributes(array('employee_id'=>$employee_id));

		return $model->outlet_id;
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
