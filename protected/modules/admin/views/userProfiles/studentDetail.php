<?php
$this->pageTitle=Yii::app()->name . ' - '.$userInfo->display_name.' Details';
$this->breadcrumbs=array('Detail',);
?>
<link href="<?php echo Yii::app()->theme->baseUrl;?>/css/admin.css" rel="stylesheet">
<div class="container">
	<div class="col-md-10 	 pop-up-border fl col-lg-offset-1 ">
		<div class="row test-bot">
			<?php echo $userInfo->display_name;?>
			<div class="pull-right back-btn"><?php echo CHtml::link('Back to List', Yii::app()->createUrl('/admin/userProfiles/admin'));?></div>
		</div>
		<div class="col-md-12 fl pset_admin">
			<div class="col-md-3 pd0 fl" >
				<div class="rating-history">
					<ul>
						<li class="rating-title"><h2>Last Login</h2></li>
						<li>Last login at <span class="skyBlue"><?php echo $userInfo->userLogin->last_login;?></span></li>
						<li class="rating-title"><h2>Rating History</h2></li>
						<div class="clear"></div>
						
						<?php foreach($ratingHistory as $historyList):?>
						<li><h1><?php echo $historyList->careerOptions->title;?></h1>
							<div class="hRate" id="rating-histroy<?php echo $historyList->career_options_id;?>"  ></div>	
						</li>
							 
							<script type="text/javascript">
								$(document).ready(function(){
									$('#rating-histroy<?php echo $historyList->career_options_id;?>').raty({readOnly: true, score:'<?php echo $historyList->self;?>'});
									
								});
							</script>
						 
						<?php endforeach; ?>
					</ul>
				</div>
			</div>
			<div class="col-md-9 pd0 pull-left">
				<div class="col-md-12 pd0  pull-left">
					<div class="col-md-6 mr0 pd0 pull-left" >
						<?php if(!empty($userFinalStream)){ ?>
						<h1>Finalized Career </h1>
						<p>Your preferred career are listed here.</p>
						<div class="col-md-12 pd0">
							<?php foreach($userFinalStream as $selfSel){?>
								<div class="col-md-12 pull-left fl pd0 pd-b10">
								<div class="col-md-12 fl pd0 ">
									<div class="pull-left pd0 prefered-stream-img2">
			 
										<img  src="<?php echo Yii::app()->baseUrl;?>/uploads/career_options/small/<?php echo (!empty($selfSel->careerOptions->image))?''.$selfSel->careerOptions->image.'':'noimage.jpg';?>" />
									</div>
									<div class="col-md-9 pull-left counselor-stream-description">
										<h1><?php echo $selfSel->careerOptions->title;?></h1>
										<p><?php echo substr($selfSel->careerOptions->description,0,65);?></p>
										 <ul class="star-rating" style="margin:0px;">
										<div id="user-rating-final<?php echo $selfSel->career_options_id;?>"  ></div>
										</ul>
										<script type="text/javascript">
											$(document).ready(function(){
												$('#user-rating-final<?php echo $selfSel->career_options_id;?>').raty({readOnly: true, score:'<?php echo $selfSel->self;?>'});
												
											});
										</script>
										<div class="clear"></div>
										<span><?php // echo ($selfSel->stream->featured)?'Featured':'';?></span>
								   </div>
								</div>
							</div>
							<?php } ?>
						</div>
						<?php } else {?>
						<div class="stream-pref-min-height">
						<h1 class="center">Record Not Found</h1>
						</div>
						<?php } ?>
					</div>
					<div class="col-md-6 mr0  pull-left pd0">
					<?php 
					$countRecom	=	0;
					if (!empty($counsRecoStream)){?>
						<h1>Counsellor Preferred Career </h1>
						<p>Counsellor preferred career are listed here.
						</p>
						<div class="col-md-12 pd0">
						
							<?php foreach($counsRecoStream as $counsellorList){
								$countRecom++;
								?>
								<div class="col-md-12 pull-left fl pd0 pd-b10">
								<div class="col-md-12 fl pd0 ">
									<div class="pull-left pd0 prefered-stream-img2">
			 
										<img  src="<?php echo Yii::app()->baseUrl;?>/uploads/career_options/small/<?php echo (!empty($counsellorList->careerOptions->image))?''.$counsellorList->careerOptions->image.'':'noimage.jpg';?>" />
									</div>
									<div class="col-md-9 pull-left counselor-stream-description">
										<h1><?php echo $counsellorList->careerOptions->title;?></h1>
										<p><?php echo substr($counsellorList->careerOptions->description,0,65);?></p>
										 <ul class="star-rating" style="margin:0px;">
										<div id="user-rate<?php echo $counsellorList->career_options_id;?>"  ></div>
										</ul>
											<script type="text/javascript">
											$(document).ready(function(){
												$('#user-rate<?php echo $counsellorList->career_options_id;?>').raty({readOnly: true, score:'<?php echo $counsellorList->self;?>'});
												
											});
										</script>
										<div class="clear"></div>
										<span><?php //echo ($counsellorList->stream->featured)?'Featured':'';?></span>
								   </div>
								</div>
							</div>
							<?php //echo CHtml::ajaxLink('<i class="glyphicon glyphicon-comment"></i>Counsellor Comments',Yii::app()->createUrl('/school/counsellorComments' ),array('data' =>array( 'userId' =>$counsellorList->user_profiles_id,'stream_id'=>$counsellorList->stream_id),'update'=>'#counsellorComments'),array('class'=>'counsellor-comment')); ?>
								
							 
							<?php }
							if($countRecom<2){
								echo '<div class="clear"></div><div>';
									$form=$this->beginWidget('CActiveForm', array('id'=>'user-career-preference-form','enableAjaxValidation'=>false,));
										echo $form->dropDownList($model,'career_id',CHtml::listData(Career::model()->findAll(),'id','title'), array('empty' => 'Please Select','ajax' => array('type'=>'POST','url'=>CController::createUrl('dynamicCareer'),'update'=>'#CareerDetails_career_options_id',),'class'=>'form-control mb10'));

										echo $form->dropDownlist($model,'career_options_id',CHtml::listData(CareerOptions::model()->findAll(),'id','title'),array('class'=>'form-control mb10','id'=>'CareerDetails_career_options_id'));
										echo $form->textArea($model,'comments',array('rows'=>6,'placeholder'=>'Type your comment here','cols'=>50));

										echo CHtml::submitButton('Save',array('class'=>'btn',"style"=>'float:right;margin-right:50px;margin-top:10px;'));
									
									$this->endWidget();
								echo '</div>';	
								}
							 ?>
						</div>
						<?php }else{ ?>
						<div class="stream-pref-min-height">
						<h1 class="center">Record Not Found</h1>
						</div>
						<?php 
						if($countRecom<2){
							echo '<div class="div_position1">';
							
								$form=$this->beginWidget('CActiveForm', array('id'=>'user-career-preference-form','enableAjaxValidation'=>false,));
									echo $form->dropDownList($model,'career_id',CHtml::listData(Career::model()->findAll(),'id','title'), array('empty' => 'Please Select','ajax' => array('type'=>'POST','url'=>CController::createUrl('dynamicCareer'),'update'=>'#CareerDetails_career_options_id',),'class'=>'form-control mb10'));

									echo $form->dropDownlist($model,'career_options_id',CHtml::listData(CareerOptions::model()->findAll(),'id','title'),array('class'=>'form-control mb10','id'=>'CareerDetails_career_options_id'));
									echo $form->textArea($model,'comments',array('rows'=>6,'placeholder'=>'Type your comment here','cols'=>50));

									echo CHtml::submitButton('Save',array('class'=>'btn',"style"=>'float:right;margin-right:50px;margin-top:10px;'));
									
									
								$this->endWidget();
								echo '</div>';
							}
						
						} ?>
					</div>
				</div>
			<div class="col-md-12 fl pd0">
				<div class="col-md-12 mr0 pull-left stream-pref">
					<h1 class="pull-left mr0 mb10 col-md-3">Summary</h1>
                     <div class="pull-left back-btn">
						<?php echo CHtml::link('User Sessions', Yii::app()->createUrl('admin/userProfiles/sessionList',array('id'=>$userInfo->id)));?>
                    </div>
                    <div class="pull-left back-btn">
						<?php echo CHtml::link('User Sessions', Yii::app()->createUrl('admin/userProfiles/detailedReport',array('id'=>$userInfo->id)));?>
						<?php //echo CHtml::ajaxLink('User Report', Yii::app()->createUrl('/counsellor/detailedReport',array('id'=>$userInfo->id)),array('update'=>'#summeryRecodes'),array('class'=>'summery-left-btn Summary-details')); ?>
                    </div>
				</div>
				<div class="col-md-12 pull-left summery-left pd0 mb10">
					<ul>
						<div class="col-md-12 border pull-left pd0">
							<div class="col-md-3 pull-left pd0 center">
								<h1>Events</h1>
								
							</div>
							<div class="col-md-3 pull-left pd0">
								<h1>Topics</h1>
							</div>
							<div class="col-md-3 pull-left pd0">
								<h1>Date</h1>
							</div>
							<!--<div class="col-md-3 center pull-left pd0">
								<h1>Remarks</h1>
							</div>-->
						</div>
						<?php 
							 $count=1;
						foreach($summaryDetails as $list){ 
							
							if($count%2 == 0)
								$class='light-gray';
							else 
								$class='0';			 
								$count= $count+1;
						
						?>
						<li class="<?php echo $class;?>" style="list-style:none;">
							
							<div class="col-md-12 pull-left pd0">
								<div class="col-md-3 pull-left pd0 center">
									<span>Access</span><br/>
									<?php echo CHtml::link('Online','#')?>
								</div>
								<div class="col-md-3 pull-left pd0">
									<p><?php echo $list->orientItems->title;?></p>
								</div>
								<div class="col-md-3 pull-left pd0">
									<p><?php echo Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($list->add_date, 'yyyy-MM-dd'),'medium',null);?></p>
								</div>
								<div class="col-md-3 center pull-left mar-top10 pd0">
								<?php //echo CHtml::ajaxLink('Summary', Yii::app()->createUrl('/counsellor/summaryDetails' ),array('data' =>array( 'userId' =>$list->user_profiles_id,'orient_items_id'=>$list->orient_items_id),'update'=>'#summeryRecodes'),array('class'=>'summery-left-btn Summary-details')); ?>
								</div>
							</div>
							
						</li>	
						 <?php } ?>
					</ul>
				</div>
			<div class="col-md-6 pull-left summaryDetails ">
				
			</div>
		</div>
			</div>
		</div>
	</div>
</div>


    <div id="myModal" class="modal fade">
		<div class="modal-dialog">
        	<div class="modal-content border-layer">
            <!-- dialog body -->
            	<div class="modal-body cons-pop ">
				<a data-dismiss="modal" class="btn schoo-bt-color pull-right">Go Back</a>
    	
					<div class="col-md-12  " id="counsellorComments">
					 
					</div>
				</div>
			<!-- dialog buttons -->
			 
			</div>
		</div>
    </div>
	
<div id="Summary-details" class="modal fade">
    	<div class="mt50 col-sm-offset-2 col-md-8">
        	<div class="modal-content">
            <!-- dialog body -->
            	<div class="modal-body">
                		<div class="site-logo"></div>
						<div class="row white ">
                        	<div class="col-md-12 pd13 ">
							<a data-dismiss="modal" class="btn schoo-bt-color pull-right">Go Back</a>
    		
                            	 <div  class="col-md-12 pd0 login-box pull-left" id="scrollBar" style="max-height:500px;width:97%;">
									<div id="summeryRecodes">
									
									</div>
									 
                                 </div>
                               
							</div>
						</div>
	   			</div>
		<!-- dialog buttons -->
		 
		</div>
	</div>
</div>
<script src="<?php echo Yii::app()->theme->baseUrl;?>/js/bootstrap.min.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl;?>/js/profle-pop-up.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl;?>/js/jquery-ui-1.10.3.custom.js"></script>
<script type="text/javascript"  src="<?php echo Yii::app()->theme->baseUrl;?>/js/dashboard-custom.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl;?>/js/jquery.scrollbox.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->theme->baseUrl;?>/js/jquery.flot.min.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl;?>/js/jquery.knob.js"></script>