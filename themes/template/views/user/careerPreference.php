
	<div class="career-bot pull-left">
						<?php if(Yii::app()->user->hasFlash('sccess')): ?>
						<div class="alert alert-success">
						  <button data-dismiss="alert" class="close" type="button">×</button>
						  <strong><?php echo Yii::app()->user->getFlash('sccess'); ?></strong>
						</div>
							 
					<?php endif; ?>	
		<div class="mr0 col-md-12 fl">
			<div class="mr0  pull-left stream-pref">
				<h1>Career Preference</h1>
				<p>It is long established fact a reader will be It is long established fact a reader will be
					It is long established fact a reader will be It is long established fact a reader will beIt is long established fact a reader will be
				</p>

			</div>
			
		</div>
        
        <div class="col-md-12 fl pd0">
			<?php if(!empty($data)) {?>
            <div class="mr0 col-md-6 fl br-right">
				
					<div class="mr0  pull-left middle-format-left">
						<h1>Your  Prefered Career </h1>
						<p>Your prefered career are listed here.
						</p>
						<p id="flashMessage"></p>
						

					</div>
				<div class="col-md-12 pdleft  fl">
			
				<div id="scrollBar">
                <?php foreach($data as $list){ ?>
				<div class="col-md-12 fl pd0 br-all mt-10">
							<div class="col-md-5 pull-left fl pd0">
									<div class="br-right">
										<div class="col-md-12 pull-left pd0 stream-img">
										<?php 
												$filename = ''.$list['image'].'';
												 $path=Yii::getPathOfAlias('webroot.uploads.career_options.small') . '/';
												$file=$path.$filename;
												if (file_exists($file)){ ?>
												<?php echo CHtml::link('<img src="'.Yii::app()->baseUrl.'/uploads/career_options/small/'.$list['image'].'"/>',array('user/careerDetails','id'=>''.$list['id'].''));?>
												<?php 	}else{ ?>
												<?php echo CHtml::link('<img src="'.Yii::app()->baseUrl.'/uploads/career_options/small/noimage.jpg"/>',array('user/careerDetails','id'=>''.$list['id'].''));?>
											
										<?php } ?>
								
										<?php echo CHtml::link('<h1 class="stream-img-title">'.$list['title'].'</h1>',array('user/careerDetails','id'=>$list['id']));?>
										
										</div>
										 
									</div>
						
							</div>
            <div class="col-md-3 pull-left stream-ratting pd5">
        		<span>Your rating for this career</span>
               		   	 <ul class="star-rating" style="margin:0px;">
							<div id="user-rating<?php echo $list['id'];?>"  ></div>
						</ul>
								 	  <script type="text/javascript">
										$(document).ready(function(){
											$('#user-rating<?php echo $list['id'];?>').raty({readOnly:true,score:'<?php echo $list['uRating'];?>'});
										});
									</script> 
									 
									 
	        </div>
            
            <div class="col-md-4 pull-left stream-ratting pd5 br-left h-110">
        		<span>Do you think this is the best career for you</span>
                <div class="clear"></div>
				<?php if($list['updated_by']==0){?>
									<?php echo CHtml::ajaxLink('Make Final',array('user/finalizedCareer','id'=>$list['id']),
																		array('type'=>'POST','success'=>'function(data){alert(data)}'),
																		array('confirm'=>'Are you sure you want to make final this item?',
																				'class'=>'white-text btn btn-warning',
																				'id'=>'final_item-'.$list['id']));  ?>
									<?php }else{ ?>
									<?php echo CHtml::ajaxLink('Finalized','javaScript:void(0);',
																		array('type'=>'POST','success'=>'function(data){alert(data)}'),
																		array('confirm'=>'Already Finalized.',
																				'class'=>'white-text btn btn-warning',
																				'id'=>'final_item-'.$list['id']));  ?>
									<?php } ?>
	        </div>
        
        </div>
						
				 <?php } ?>
			 
				</div>
				
				
			<!-- <div class="col-md-12 pull-left below-info">
					<p>if ypou have any different idea to choose a stream then just change your idea bu having a conversation with counselor. </p>
					<?php //echo CHtml::link('Still confused',array('user/'),array('class'=>'white-text btn btn-warning'));?>
				</div>-->
				
				<div class="col-md-12 pd0 pull-left user-feedback">
					<h1>Feedback</h1>
					<p>Your valuable idea about this Career Explore. </p>
					<span class="fl">1.Weather counselling with counselor satisfactory?</span>
					<div class="clear"></div>
					<?php $form=$this->beginWidget('CActiveForm', array(
																		'id'=>'comment-info-form',
																		    'enableClientValidation'=>true,
																			'clientOptions'=>array(
																					'validateOnSubmit'=>true,
																					
																				)
																	)); ?>		
					       <div class="form-controles fl">
						   <?php echo $form->radioButtonList($model,'user_responce',array('Satisfied'=>'Satisfied','Average'=>'Average','Note_at_all'=>'Note at all'),array('separator'=>'')); ?>
						   <?php echo $form->error($model,'user_responce');?>
						   </div>
							<div class="clear"></div>
							<select id="UserComments_stream_id" class="form-control" name="UserCareerComments[career_id]">
								<?php foreach($data as $list){?>
								<option value="<?php echo $list['id'];?>"><?php echo $list['title'];?></option>
								<?php } ?>
							</select>
							<div class="form-controles">
							<?php echo $form->textArea($model,'comments',array('class'=>'form-control','placeholder'=>'Enter comment here..'));?>
							 <?php echo $form->error($model,'comments');?>	
							</div>
							<?php echo CHtml::submitButton('submit',array('class'=>'btn btn-warning fr','id'=>'comment-info-form-btn'));?>
					<?php $this->endWidget();?>
				</div>
				
				
			</div>
         </div>
		  <?php } else{ ?>
			<div class="mr0 col-md-6 fl br-right">
				
					<div class="mr0  pull-left middle-format-left">
						<h1>Recode not found.</h1>
						 

					</div>
			</div>
			<?php } ?>
		<?php if(!empty($data2)){ ?>
			<div class="col-md-6 pull-left">
				<div class="col-md-12 fl">
					<div class="mr0  pull-left middle-format-left">
						<h1>Counselor  Prefered career options </h1>
						<p>Counselor prefered career options are listed here.
						</p>

					</div>
					<?php foreach($data2 as $dataList){?>
					<div class="col-md-12 pull-left fl pd-b10">
						<div class="col-md-12 fl pd0 ">
							<div class="pull-left pd0 prefered-stream-img">
	 
								<img  src="<?php echo Yii::app()->baseUrl;?>/uploads/career_options/small/<?php echo $dataList['image'];?>" />
							</div>
							<div class="col-md-9 pull-left  counselor-stream-description">
								<h1><?php echo substr($dataList['title'],0,50);?></h1>
								<p><?php echo substr($dataList['description'],0,100);?>..</p>
								 <ul class="star-rating" style="margin:0px;">
										<div id="user-rating2_<?php echo $dataList['id'];?>"  ></div>
									</ul>
									<script type="text/javascript">
										$(document).ready(function(){
											$('#user-rating2_<?php echo $dataList['id'];?>').raty({readonly:true,score:'<?php echo $dataList['rate'];?>'});
										});
									</script> 
								<div class="clear"></div>
								<span><?php // echo ($selfSel->careerOptions->featured)?'Featured':'';?></span>
						   </div>
						</div>
					</div>
                    <?php } ?>
					<div class="col-md-12 pull-left fl pd0">
						<div class="mr0  pull-left counselor-views">
							<h1>Counselor  Comments </h1>
							<p>Counselor prefered career are listed here.
							</p>
							<datetime class="date-time">
								29-jan-2014
							</datetime>
							<p>Counsellor prefered career are listed here Counselor prefered career are listed here Counselor prefered career are listed here Counselor prefered stream are listed here Counselor prefered stream are listed here Counselor prefered stream are listed here Counselor prefered stream are listed here Counselor prefered stream are listed here Counselor prefered stream are listed here Counselor prefered stream are listed here Counselor prefered stream are listed here Counselor prefered stream are listed here 
							</p>
							<?php echo CHtml::link('<i class="icon-microphone "></i> Talk to Counselor',array('user/'),array('class'=>'orange'))?>
						</div>
					</div>
				</div>
		   </div>
            <?php } else{  ?>
				<div class="mr0 col-md-6 fl ">
					
						<div class="mr0  pull-left middle-format-left">
							<h1>Counsellor has not recommend any career yet.</h1>
							<p>Please contact to your counsellor.</p>

						</div>
				</div>
			<?php } ?>
		
</div>
</div>
	<div class="news pd0 pull-right">
		<?php  $this->Widget('WidgetNews'); ?>
	</div>