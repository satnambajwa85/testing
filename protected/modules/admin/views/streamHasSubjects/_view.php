<?php
/* @var $this StreamHasSubjectsController */
/* @var $data StreamHasSubjects */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('stream_id')); ?>:</b>
	<?php echo CHtml::encode($data->stream_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('subjects_id')); ?>:</b>
	<?php echo CHtml::encode($data->subjects_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('type_subjects')); ?>:</b>
	<?php echo CHtml::encode($data->type_subjects); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode($data->status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('add_date')); ?>:</b>
	<?php echo CHtml::encode($data->add_date); ?>
	<br />


</div>