<script type="text/javascript"  src="<?php echo Yii::app()->theme->baseUrl;?>/js/dashboard-custom.js"></script>		
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<div id="scrollBar" style="max-height:400px">
<div class="pull-left">
		<div class="mr0 col-md-12 fl">
			<div class="mr0  pull-left stream-pref">
				<h1>Detailed Report </h1>
				<p>It is long established fact a reader will be It is long established fact a reader will be
					It is long established fact a reader will be It is long established fact a reader will beIt is long established fact a reader will be
				</p>

			</div>
			
		</div>
		<div class="col-md-12 pull-left inner-padding">
			<div class="col-md-12  pull-left  pd0">
					<div class="col-md-12 fl details-report">
						<h1>Profile Summery</h1>
					</div>
					<div class="col-md-12  pull-left report-border pd0">
						<div class="col-md-6  pull-left left-section pd0">
							<ul>
								<li>Name</li>
								<li>Gender</li>
								<li>Date of birth</li>
								<li>Class</li>
								<li>School</li>
								<li class="lastRow">Email</li>
							</ul>
						</div>	
						<div class="col-md-6  pull-left right-section pd0">
							<ul>
								<li><?php echo $profile->first_name.' '.$profile->last_name;?></li>
								<li><?php echo $profile->gender;?></li>
								<li><?php echo $profile->date_of_birth;?></li>
								<li><?php echo $profile->class;?><i class="user-edu">th</i></li>
								<li class="capitalize"><?php echo $profile->generateGudaakIds->schools->name;?></li>
								<li class="lastRow"><?php echo $profile->email;?></li>
							</ul>
						</div>
						<div class="col-md-6  pull-left">
						</div>
					</div>
					<div class="col-md-12">
                       <div class="clear"></div>
                       <br /><br />
                        <?php foreach($reports as $report){?>
                        <div class="row">
							<ul id="report-bottom-area">
									<li>
										<h1><?php echo $report['name'];?></h1>
										<p><?php echo $report['description'];?></p>
									</li>
									
									
							</ul>
                           
						</div>
                        <div class="clear"></div>
                        <?php if($report['id']==3){?>
                        
<script type="text/javascript">
google.load("visualization", '1.1', {packages:['corechart']});
google.setOnLoadCallback(drawChart);
function drawChart() {
var data = google.visualization.arrayToDataTable([
['Career', 'Score'],
<?php foreach($report['results1'] as $result1){
	foreach($result1 as $result){
	?>
['<?php echo $result['title'];?>', <?php echo $result['score'];?>],
<?php } }?>
]);
var options = {
title: "Score of interest test for Career",
//width: 600,
//height: 400,
bar: {groupWidth: '95%'},
legend: { position: 'none' },
};
var chart = new google.visualization.BarChart(document.getElementById('chart_div'));
chart.draw(data, options);
}
</script>
                        <div id="chart_div" style="width: 90%;"></div>
                        <?php } 
                        
 foreach($report['results'] as $result){?>
	<div class="">
		<div class="clear"></div>
		<?php echo ($report['id']==3)?'<h4>'.$result['title'].'</h4>':'<h4>'.$result['title2'].'</h4>';?>
		<p  class="description-content"><?php echo $result['description'];?></p>
    	<div class="border_b"></div>
	</div>
    <?php if($report['id']==3){?>
	<div class="col-md-12 pd0 fl">
	<?php
		$listCar	=	Career::model()->findAllByAttributes(array('career_categories_id'=>$result['id']));
		foreach($listCar as $data){		?>
		
        
<div class="col-md-6 pdleft career-lib">
	<?php 
			$filename = ''.$data->image.'';
			 $path=Yii::getPathOfAlias('webroot.uploads.career.small') . '/';
			$file=$path.$filename;
			if (file_exists($file)){ ?>
			<?php echo CHtml::link('<img src="'.Yii::app()->baseUrl.'/uploads/career/small/'.$data->image.'"/>',array('user/careerList','id'=>''.$data->id.''),array('class'=>'fl'));?>
	<?php 	}else{ ?>
			<?php echo CHtml::link('<img src="'.Yii::app()->baseUrl.'/uploads/career/small/noimage.jpg"/>',array('user/careerList','id'=>''.$data->id.''),array('class'=>'fl'));?>
		
	<?php } ?>
	<div class="clear"></div>
	<?php echo CHtml::link('<h1>'.substr($data->title,0,20).'..</h1>',array('user/careerList','id'=>''.$data->id.''),array('title'=>$data->title));?>
	<p><?php echo substr($data->description,0,70);?></p>
	<div class="col-md-12 career-hot-links">
	<?php echo CHtml::link('Read more..',array('user/readFull','id'=>''.$data->id.''),array('class'=>'pull-left','title'=>'Read Full.'));?>
		<span class="pull-right"><i class="icon-eye-open"></i>19021</span>
	</div>
</div>


	<?php	}?>
    
    </div>
    <?php 
		}
	}
} ?>
                       
  <!--Table-->                     
<!--<div class="table_w">
  <div class="table_row table_head t_border_bt">
     <div class="table_col">sasa</div>
     <div class="table_col">sasa</div>
     <div class="table_col_last">sasa</div>
  </div>
 <div class="table_row t_border_bt ">
     <div class="table_col">sasa</div>
     <div class="table_col">sasa</div>
     <div class="table_col_last">sasa</div>
  </div>
   <div class="table_row t_border_bt ">
     <div class="table_col">sasa</div>
     <div class="table_col">sasa</div>
     <div class="table_col_last">sasa</div>
  </div>
   <div class="table_row ">
     <div class="table_col">sasa</div>
     <div class="table_col">sasa</div>
     <div class="table_col_last">sasa</div>
  </div>

</div>  --> 
 <!--Table end-->                     
                       


                       
                       
					</div>
					
				
			</div>
			
			
			</div>
		
		</div>
 </div>       

		


	 