<?php
/* @var $this StatesController */
/* @var $model States */

$this->breadcrumbs=array(
	'Countries'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List States', 'url'=>array('index')),
	array('label'=>'Manage States', 'url'=>array('admin')),
);
?>

<h1>Create Countries</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>