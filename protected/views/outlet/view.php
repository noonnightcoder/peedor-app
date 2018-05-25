<?php
/* @var $this OutletController */
/* @var $model Outlet */
?>

<?php
$this->breadcrumbs=array(
	'Outlets'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Outlet', 'url'=>array('index')),
	array('label'=>'Create Outlet', 'url'=>array('create')),
	array('label'=>'Update Outlet', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Outlet', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Outlet', 'url'=>array('admin')),
);
?>

<h1>View Outlet #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView',array(
    'htmlOptions' => array(
        'class' => 'table table-striped table-condensed table-hover',
    ),
    'data'=>$model,
    'attributes'=>array(
		'id',
		'outlet_name',
		'tax_id',
		'address1',
		'address2',
		'village_id',
		'commune_id',
		'district_id',
		'city_id',
		'country_id',
		'state',
		'postcode',
		'email',
		'phone',
		'status',
		'created_at',
		'updated_at',
		'deleted_at',
	),
)); ?>