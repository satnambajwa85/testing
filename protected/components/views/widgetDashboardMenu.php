<?php $path	=	Yii::app()->theme->baseUrl;?>
	<header>
		<div class="logo">
			<?php echo CHtml::link('<img alt="" src="'.$path.'/images/dashboard-logo.png">',array('/site'));?>
		</div><!-- Logo -->
		<div class="welcome-user">
			<?php 
			if(!strpos($userinfo->image,'facebook'))
				echo CHtml::link('<img alt="'.$userinfo->first_name.' '.$userinfo->last_name.'" id="imgPic" src="'.Yii::app()->baseUrl.'/uploads/user/small/'.$userinfo->image.'">',array('user/'),array('class'=>'userImage'));
			else
				echo CHtml::link('<img alt="'.$userinfo->first_name.' '.$userinfo->last_name.'" id="imgPic" src="'.$userinfo->image.'">',array('user/'),array('class'=>'userImage'));
				?>
			<p>Welcome</p>
			<?php echo CHtml::link('<span>'.$userinfo->first_name.' '.$userinfo->last_name.'</span>',array('user/'));?>
			<div class="clear"></div>
			<div class="progress fl ">
			  <div style="width:<?php echo $completeProfile;?> !important;" class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100">
			  </div>
			  <span class="sr-only"></span>
			
			</div>
			  <span class="tolal-process"><?php echo $completeProfile;?> </span>
			<span class="progress-title">Profile Completion</span>
			
		</div>
			<div class="clearfix"></div>
			<div class="user-nav">
				<ul>
					<li class="border-right">
						<?php echo CHtml::Link('<i class="glyphicon glyphicon-user"></i>Profile','javaScript:void(0);',array('class'=>'profile-details'));?>
						
					</li>
					<li class="border-right"><?php echo CHtml::Link('<i class="glyphicon glyphicon-cog"></i>Setting',array('user/changePassword'));?>
				 	</li>
					<li><?php echo CHtml::Link('<i class="glyphicon glyphicon-off"></i>Logout',array('site/logout'));?>
					 
					</li>
				</ul>
			</div>
			<div class="side-navigation">
				<h4 style="background-color:#E88B2D">My Progress</h4>
				<ul>
					<?php
$action	=	Yii::app()->controller->action->id;
$getId='';
if(isset($_REQUEST['id'])){
$getId=$_REQUEST['id'];
}
		 
?>
					<!--<li><?php //echo CHtml::link('<i class="icon-desktop"></i>Orientation Tour',array('user/index'),array('title'=>'Orientation Tour','class'=>''.($action=='index')?'slidebg':''.''))?>
					</li>-->
					<li><?php echo CHtml::link('<i class="glyphicon glyphicon-record"></i>Assess','',array('title'=>'Asses','class'=>''))?>
				
				
						<ul style="<?php echo ($action=='tests'||$action=='DetailedReport')?'display:block':'display:block';?>">
                        	<li><?php echo CHtml::link('Career Test',array('user/tests'),array('title'=>'Asses','class'=>''.($action=='tests')?'slidebg':''.''))?></li>
							<li><?php echo CHtml::link('Career Report',array('user/DetailedReport'))?></li>
						</ul>					
					</li>
					<?php //if(Yii::app()->user->id && Yii::app()->user->userType=='student'){
						?>
					<li><?php  echo CHtml::link('<i class="glyphicon glyphicon-eye-open"></i>Explore',array('user/explore'),array('title'=>'Explore','class'=>''.($action=='career'|| $action=='careerDetails'|| $action == 'liveChat' || $action == 'careerList' || $action == 'explore' || $action =='articlesList')?'slidebg':''.''))?>
						<ul style="<?php echo ($action=='career'||$action=='liveChat' || $action=='explore' || $action=='careerList' || $action=='careerDetails' || $action=='articlesList')?'display:block':'display:block';?>">
                        <li><?php echo CHtml::link('Career Options',array('user/career'),array('class'=>''.($action == 'career' || $action ==  'careerList' || $action ==  'careerDetails')?'currentLink':''.''))?></li>
                        <li><?php echo CHtml::link('Stream Options-for IX & X',array('user/streamList'),array('class'=>''.($action == 'streamList' || $action ==  'stream' )?'currentLink':''.''))?></li>
						<li><?php echo CHtml::link('Articles',array('user/articlesList'),array('class'=>''.($action=='articlesList')?'currentLink':''.''));?></li>
						</ul>
					</li>
					<li><?php echo CHtml::link('<i class="glyphicon glyphicon-thumbs-up"></i>Career Preference',array('user/careerPreference'),array('title'=>'Career Preference','class'=>''.($action=='careerPreference')?'slidebg':''.''))?>
						 					
					</li>
					<?php 
					/*
					} else { ?>
					<li><?php echo CHtml::link('<i class="glyphicon glyphicon-eye-open"></i>Explore',array('user/streamExplore'),array('title'=>'Explore','class'=>''.($action=='streamList'|| $action=='streamExplore'|| $action == 'stream' || $action =='articlesList')?'slidebg':''.''))?>
					
					
						<ul style="<?php echo ($action=='streamList'|| $action == 'stream' || $action == 'streamPreference' || $action =='articlesList')?'display:block':'display:block';?>">
							<li><?php echo CHtml::link('Stream Library',array('user/streamList'),array('class'=>''.($action == 'streamList' || $action ==  'stream' )?'currentLink':''.''))?></li>
							<li><?php echo CHtml::link('Articles',array('user/articlesList'),array('class'=>''.($action=='articlesList')?'currentLink':''.''));?></li>
							
							
						</ul>
					</li>
					<li><?php echo CHtml::link('<i class="glyphicon glyphicon-thumbs-up"></i>Stream Preference',array('user/streamPreference'),array('title'=>'Career Preference','class'=>''.($action=='streamPreference')?'slidebg':''.''))?>
						 					
					</li>
					<?php }*/ ?>
					
				
					<?php //if(Yii::app()->user->id && Yii::app()->user->userType=='student'){
						
						?>
					<li>
						<?php echo CHtml::link('<i class="glyphicon glyphicon-flag"></i>Finalized Career',array('user/finalizedCareer'),array('class'=>''.($action=='finalizedCareer')?'slidebg':''.''));?>
					
					</li>
							<li><?php echo CHtml::link('<i class="icon-location-arrow"></i>Approach','',array('class'=>''.($action=='exploreColleges' ||$action=='shortListedColleges'||$action=='application')?'slidebg':''.''));?>
					
						
						<ul style="<?php echo ($action=='shortListedColleges'||$action=='exploreColleges' || $action=='application')?'display:block':'display:block';?>">
							<li><?php echo CHtml::link('Colleges',array('user/exploreColleges'));?></li>
							<li><?php echo CHtml::link('Shortlisted Colleges',array('user/shortListedColleges'));?></li>
							<li><?php echo CHtml::link('Entrance Exams',array('user/application'));?></li>
						</ul>
					</li>
					<?php 
					
					/*}else{ ?>
					<li>
						<?php echo CHtml::link('<i class="glyphicon glyphicon-flag"></i>Finalized Stream',array('user/finalizedStream'),array('class'=>''.($action=='finalizedStream' || $action=='collage')?'slidebg':''.''));?>
					
					</li>
					<?php }*/ ?>
					
				</ul>
			</div>
		
		
	</header>
	