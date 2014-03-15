<?php $path	=	Yii::app()->theme->baseUrl;?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo Yii::app()->session['setting']['site_meta']?>">
    <meta name="author" content="">
    <!--<link rel="shortcut icon" href="ico/favicon.png">-->
    <title><?php echo CHtml::encode($this->pageTitle);?></title>
    <!-- Bootstrap core CSS -->
	<link href="<?php echo $path;?>/css/dashboard.css" rel="stylesheet">
	<link href="<?php echo $path;?>/css/style.css" rel="stylesheet">
	<link href="<?php echo $path;?>/css/ui-lightness/jquery-ui-1.10.3.custom.css" rel="stylesheet">
	

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="<?php echo $path;?>/js/html5shiv.js"></script>
      <script src="<?php echo $path;?>/js/respond.min.js"></script>
    <![endif]-->
	<?php Yii::app()->clientScript->registerScript(
'myHideEffect',
'$(".flash-success").animate({opacity: 1.0}, 3000).fadeOut("slow");', 
CClientScript::POS_READY
);
Yii::app()->clientScript->registerScript(
	'myHideEffect2',
	'$(".flash-error").animate({opacity: 1.0}, 3000).fadeOut("slow");', 
	CClientScript::POS_READY
);


?>
  </head>

  <body>
	<div class="wrapper">
	<?php  $this->Widget('WidgetDashboardMenu'); ?>
	<section class="main-section">
		<div class="left-main">
			<div class="w100 fl color">
						<div class="breadcrumbs fl">
						<?php $this->widget('zii.widgets.CBreadcrumbs', array(
                'homeLink'=>'Dashboard',
                'links'=>$this->breadcrumbs,
        )); ?><!-- breadcrumbs -->

						
						</div>
						<div class="pull-right dashbord-top-nav ">
							<ul class="nav  top-nav-left pull-left">
							  <!--<li id="talk-btn"><i class="icon-microphone icon-top talk-icon"></i><a href="#">Talk to Counsellor</a></li>-->
							  <li><i class="icon-microphone icon-top talk-icon"></i><?php echo CHtml::link('Talk to Counsellor',array('user/talk'));?></li>
							  <li><i class="news-icon"></i><?php echo CHtml::link('News and Updates',array('user/newsUpdates'));?></li>
							  <li><i class="summary-icon"></i><?php echo CHtml::link('Summary',array('user/summary'));?></li>
							 
							  
							</ul>
							<div class="top-stats-icons fr social-icon-links mr12">
								<a href="<?php echo Yii::app()->session['setting']['fb_link'];?>" target="_blank">
									<i class="icon-facebook"></i>
								</a>
								<a href="<?php echo Yii::app()->session['setting']['twittwe_link'];?>" target="_blank">
									<i class="icon-twitter"></i>
								</a>
								<a href="<?php echo Yii::app()->session['setting']['linkedin_link'];?>" target="_blank">
									<i class="icon-linkedin"></i>
								</a>
					
								 
								
							</div>
						</div>
						 
				
			</div>
			<div class="row white mr0">
				 
				<?php echo $content;?>

		</div>
		</div>
	</section>
	</div>
	<footer id="footer" class="row color mr0">
		 <div class="container">
	
			 <ul class="dashboard-footer nav navbar-nav">
            
				<li><?php echo CHtml::link('Home',array('site/'),array('class'=>'pull-left'));?><i class="pull-right border-l">|</i></li>
				<li><?php echo CHtml::link('About',array('/site/about'),array('class'=>'pull-left'));?><i class="pull-right border-l">|</i></li>
				<!--<li><a class="pull-left" href="#about">Services</a><i class="pull-right border-l">|</i></li>
				<li><a class="pull-left" href="#about">Experts</a><i class="pull-right border-l">|</i></li>-->
				<li><?php echo CHtml::link('Tour',array('user/tour'),array('class'=>'pull-left'));?><i class="pull-right border-l">|</i></li>
				<!--<li><a class="pull-left" href="#about">Assessment Test</a><i class="pull-right border-l">|</i></li>-->
				<li><?php echo CHtml::link('Take Test',array('user/tests'),array('class'=>'pull-left'));?><i class="pull-right border-l">|</i></li>
				<!--<li><a class="pull-left" href="#about">FAQ's</a><i class="pull-right border-l">|</i></li>-->
				<li><?php echo CHtml::link('Contacts',array('site/contact'),array('class'=>'pull-left'));?></li>
				
				
			</ul>
		</div>
      </footer>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    
    <script src="<?php echo $path;?>/js/bootstrap.min.js"></script>
	<script src="<?php echo $path;?>/js/profle-pop-up.js"></script>
	<script src="<?php echo $path;?>/js/jquery-ui-1.10.3.custom.js"></script>
	<script type="text/javascript"  src="<?php echo $path;?>/js/dashboard-custom.js"></script>
	<script type="text/javascript"  src="<?php echo $path;?>/js/rating.js"></script>
	<script src="<?php echo Yii::app()->theme->baseUrl;?>/js/jquery.scrollbox.js" type="text/javascript"></script>
	
<script src="<?php echo $path;?>/js/jquery-ui-1.10.3.custom.js"></script>
<!-- jquery jcarousel --> 

<!-- end Scripts --> 
<script type="text/javascript">
 var url	=	'<?php echo Yii::app()->createUrl('/user/userProfileUpdate');?>';
 var test	=	'<?php echo Yii::app()->createUrl('user/test');?>';
</script>
<?php  $this->Widget('WidgetUserProfile'); ?>
	
<div id="talk-coun" class="modal fade">
    	<div class="modal-dialog">
        	<div class="modal-content">
            <!-- dialog body -->
            	<div class="modal-body">
                		<div class="site-logo"></div>
						<div class="row white ">
                        	<div class="col-md-12 pd13 ">
                            	  <div  class="col-md-12 pull-left">
								<a data-dismiss="modal" class="btn btn-info pull-right ">close</a>
								kdsnfklsdjfklsdklfjksdjf
								fsd
								fsd
								fs
								df
								sdf
								
                                    <div id="">
                                        <?php /*  
                                        $form=$this->beginWidget('CActiveForm', array(
                                                                        'id'=>'retake-test-form'.$list->id.'',
																		 'action'=>Yii::app()->createUrl('/user/retakeTest&id='.''.$list->id.''),
                                                                        'enableClientValidation'=>true,
                                                                        'clientOptions'=>array('validateOnSubmit'=>true,)));?>
                                    <?php echo $form->hiddenField($model,'orient_items_id',array('value'=>''.$list->id.''));
                                   ?>
                                    <h4 class="form-signin-heading ">Send Request To Retake To Test</h4>
                                    <?php echo $form->textField($model,'title',array('class'=>'form-control','placeholder'=>'Title','autofocus'=>true));
                                    echo $form->error($model,'title');?>
                                    <div class="pd4"></div>
                                    <?php echo $form->textArea($model,'description',array('class'=>'form-control','placeholder'=>'description'));
                                    echo $form->error($model,'description');?>
                                    <div class="pd4"></div>
                                     
                                    <div class="clearfix"></div>
                                    <div align="center" class="col-md-3  pd0 ">
                                        <?php echo CHtml::submitButton('Submit',array('class'=>'btn btn-warning fl login'));?>
                                        <div class="clearfix"></div>
                                        <!--<div class="or">or</div>-->
                                        <?php //echo CHtml::link('<i class="posi-bt icon-facebook"></i>Login with your<br/><strong>Facebook Account</strong>',array('/site/forgetPassword'),array('class'=>'btn btn-lg btn-primary fb'));?>
                                        </div>
                                        <?php $this->endWidget(); */?>
                            
                                </div>
                                 </div>
                               
							</div>
						</div>
	   			</div>
		<!-- dialog buttons -->
		 
		</div>
	</div>
    </div>

  </body>
</html>
