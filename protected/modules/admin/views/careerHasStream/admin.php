<?php
/* @var $this CareerHasStreamController */
/* @var $model CareerHasStream */

$this->breadcrumbs=array(
	'Career Has Streams'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List CareerHasStream', 'url'=>array('index')),
	array('label'=>'Create CareerHasStream', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#career-has-stream-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Career Has Streams</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'career-has-stream-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'career_id',
		'stream_id',
		'add_date',
		'published',
		'status',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
