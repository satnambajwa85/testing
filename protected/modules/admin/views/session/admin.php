<?php
$this->breadcrumbs=array(
	'Sessions'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Session', 'url'=>array('index')),
	array('label'=>'Create Session', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('session-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Sessions</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Create',array('create'),array('class'=>'pull-right')); ?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'session-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'name',
		'description',
		'add_date',
		'other',
		'status',
		array(
			//'type'=>'raw',
			//'name'=>'Questions',
			'value'=>'CHtml::link("Questions",array("/admin/sessionQuestions/adminView","id"=>$data->id))',
		),
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
