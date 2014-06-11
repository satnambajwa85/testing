<?php
$this->breadcrumbs=array(
	'Counselors'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Counselor', 'url'=>array('index')),
	array('label'=>'Create Counselor', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('counselor-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Counselors</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php //echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><?php echo CHtml::link('Create',array('/admin/counselor/create'),array('class'=>'pull-right btn btn-s-md btn-success')); ?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'counselor-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'first_name',
		'last_name',
		'image',
		'date_of_birth',
		'gender',
		/*
		'address',
		'postcode',
		'email',
		'work_email',
		'alternative_email',
		'official_email',
		'work_phone_no',
		'mobile_no',
		'contact_no',
		'alternative_mobile_no',
		'official_contact_no',
		'fax',
		'shot_description',
		'description',
		'about',
		'other_details',
		'resume',
		'activation',
		'status',
		'user_login_id',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
