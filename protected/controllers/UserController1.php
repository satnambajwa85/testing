<?php
class UserController extends Controller
{
	public function filters(){
        return array( 'accessControl' ); // perform access control for CRUD operations
    }
	public function accessRules() {
		return array(
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('index','editProfile','test','tests','detailedReport','collage','liveChat',
							'articlesList','articles','summary','newsUpdates',
							'exploreColleges','shortListedColleges','dynamicCourse','dynamicSearchResult','userShortlistCollage',
							'search','changePassword','application','questionsAnswer','userProfileUpdate','retakeTest','news','readEvent','summaryDetails',
				),
				'users' => array('@')
					
				),
				array('allow', // allow admin user to perform 'admin' and 'delete' actions
					'actions'=>array('index','streamPreference','userStreamRaitng','userPrefferdCareer','streamExplore','userPreffredStream','streamCareerOptions','finalizedStream',
									'streamList','stream','readFullStream'),
					'expression' =>"Yii::app()->user->userType ==  'below10th'",

					
				),
				array('allow', // allow admin user to perform 'admin' and 'delete' actions
					'actions'=>array('index','career','careerList','careerOptionsAjax', 'careerDetails','userRaitng','finalizedCareer','addCareer','careerPreference','userFinalCareer',
									'readFull','explore','userPrefferdCareer',),
					'expression' =>"Yii::app()->user->userType ==  'upper11th'",
					
				),
				array('deny','actions'=>array(),
					'users'=>array('*')
				)
			 	
			);
		}
	 
	
	//Default Layout will be dashboard for this controler
	public $layout='//layouts/dashboard';
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}
	public function beforeAction($action) 
	{
		if(!isset(Yii::app()->user->profileId)){
			$this->redirect(Yii::app()->createUrl('/site'));
		}
		$data		=	SiteSetting::model()->findByAttributes(array('status'=>1,'published'=>1));
		Yii::app()->session['setting']	=	array('site_meta'=>$data->site_meta,
										'email'=>$data->email,
										'title'=>$data->title,
										'web_site'=>$data->web_site,
										'mobile'=>$data->mobile_no,
										'fax'=>$data->fax,
										'fb_link'=>$data->fb_link,
										'twittwe_link'=>$data->twittwe_link,
										'linkedin_link'=>$data->linkedin_link,
										'logo'=>$data->logo,
											);
		return true;
	}
	public function actionIndex()
	{
		if(!isset(Yii::app()->user->profileId)){
			$this->redirect(Yii::app()->createUrl('/site'));
		}
		$model		=	 UserProfiles::model()->findByPk(Yii::app()->user->profileId);
		if(isset($_POST['UserProfiles'])){
			$model->attributes		=	$_POST['UserProfiles'];
			if($model->save()){
				Yii::app()->user->setFlash('updated',"Sccessfully updated.");
			}
		}
		$this->render('index',array('model'=>$model));
	}
	public function actionUserProfileUpdate()
	{	
		if(isset($_REQUEST['Rid'])){
			if($_REQUEST['Rid']=='language'){
				$user					=	UserProfiles::model()->findByPk(Yii::app()->user->profileId);
				$user->language_known	=	$_REQUEST['profileData'];
				if($user->save()){
					$response		=	array('message'=>'sccessfully updated to language Knows.');
					echo json_encode($response);die;
				}
			}
			if($_REQUEST['Rid']=='medium'){
				$user						=	UserProfiles::model()->findByPk(Yii::app()->user->profileId);
				$user->medium_instruction	=	$_REQUEST['profileData'];
				if($user->save()){
					$response		=	array('message'=>'sccessfully updated to medium instruction.');
					echo json_encode($response);die;
				}
			}
		
		}
		if(isset($_REQUEST['interestID'])){
			$inId					=	$_REQUEST['interestID'];
			echo $inId;die;
			$interest				=	Interests::model()->findByPk($inId);
			$interest->title		=	$_REQUEST['interestValue'];
			$interest->add_date 	=	date('Y-m-d H:i:s');
			$interest->published 	=	1; 	 
			$interest->status	 	=	1;
			if($interest->save()){
				$response		=	array('message'=>'sccessfully updated to '.$interest->title.'.');
				echo json_encode($response);die;
			}
		}
		if(isset($_REQUEST['userInterest'])){
			$interest2				=	new	Interests;
			$interest2->title		=	$_REQUEST['userInterest'];
			$interest2->description	=	'Description here';
			$interest2->add_date 	=	date('Y-m-d H:i:s');
			$interest2->published 	=	1; 	 
			$interest2->status	 	=	1;
			if($interest2->save()){
				$userInterest					=	new UserProfilesHasInterests;
				$userInterest->user_profiles_id =	Yii::app()->user->profileId;
				$userInterest->interests_id 	 =	$interest2->id;
				$userInterest->add_date 	 	 =	date('Y-m-d H:i:s');
				$userInterest->status  	 	 	=	1;
				if($userInterest->save()){
					$response		=	array('message'=>'Saved user interest.');
					echo json_encode($response);die;
				}
			}
			//CVarDumper::dump($interest2,10,1);die;
		}
		if(isset($_REQUEST['subjectId'])){
			$sId					=	$_REQUEST['subjectId'];
			$subjects				=		UserSubjects::model()->findByPk($sId);
			$subjects->title		=	$_REQUEST['subjectIdValue'];
			if($subjects->save()){
				$response		=	array('message'=>'updated existing record.');
				echo json_encode($response);die;
			}
			
		}
		if(isset($_REQUEST['UserProfiles'])){
			$model					=	 UserProfiles::model()->findByPk(Yii::app()->user->profileId);
			$model->attributes		=	$_POST['UserProfiles'];
			if($model->save()){
				Yii::app()->user->setFlash('updated',"Profile scessfully updated.");die;
			}
		}
		if(isset($_REQUEST['subject'])){
			$subjects				=	new	UserSubjects;
			$subjects->title		=	$_REQUEST['subject'];
			$subjects->description	=	'';
			$subjects->add_date		=	date('Y-m-d H:i:s');
			$subjects->published	=	1;
			$subjects->status		=	1;
			if($subjects->save()){
				$uSubjects						=	new	UserProfilesHasUserSubjects;
				$uSubjects->user_profiles_id	=	Yii::app()->user->profileId;
				$uSubjects->user_subjects_id	=	$subjects->id;
				$uSubjects->add_date			=	date('Y-m-d H:i:s');
				$uSubjects->status 				=	1;
				$uSubjects->is_favorite			=	0;
				if($uSubjects->save()){
					$response		=	array('message'=>'Sucessfully updated current subject.');
					echo json_encode($response);die;
					
				}
			}
		
		}if(isset($_REQUEST['favorite'])){
			$subjects				=	new	UserSubjects;
			$subjects->title		=	$_REQUEST['favorite'];
			$subjects->description	=	'';
			$subjects->add_date		=	date('Y-m-d H:i:s');
			$subjects->published	=	1;
			$subjects->status		=	1;
			if($subjects->save()){
				$uSubjects						=	new	UserProfilesHasUserSubjects;
				$uSubjects->user_profiles_id	=	Yii::app()->user->profileId;
				$uSubjects->user_subjects_id	=	$subjects->id;
				$uSubjects->add_date			=	date('Y-m-d H:i:s');
				$uSubjects->is_favorite			=	1;
				if($uSubjects->save()){
					$response		=	array('message'=>'Sucessfully updated favourite.');
					echo json_encode($response);die;
					
				}
			}
		
		}if(isset($_REQUEST['lestFavorite'])){
			$subjects				=	new	UserSubjects;
			$subjects->title		=	$_REQUEST['lestFavorite'];
			$subjects->description	=	'';
			$subjects->add_date		=	date('Y-m-d H:i:s');
			$subjects->published	=	1;
			$subjects->status		=	1;
			if($subjects->save()){
				$uSubjects						=	new	UserProfilesHasUserSubjects;
				$uSubjects->user_profiles_id	=	Yii::app()->user->profileId;
				$uSubjects->user_subjects_id	=	$subjects->id;
				$uSubjects->add_date			=	date('Y-m-d H:i:s');
				$uSubjects->least_favourite		=	1;
				if($uSubjects->save()){
					$response		=	array('message'=>'Sucessfully updated Least favourite.');
					echo json_encode($response);die;
					
				}
			}
		
		}
 
	}
	public function actionEditProfile()
	{	
		if(!Yii::app()->user->profileId){
			$this->redirect(Yii::app()->createUrl('/site/'));
		}
		$model		=	 UserProfiles::model()->findByPk(Yii::app()->user->profileId);
		if(isset($_POST['UserProfiles']))
		{
			
			$model->attributes		=	$_POST['UserProfiles'];
			$model->display_name 	=	$_POST['UserProfiles']['first_name'].' '.$_POST['UserProfiles']['last_name'];
			$targetFolder1 = rtrim($_SERVER['DOCUMENT_ROOT'],'/').Yii::app()->request->baseUrl.'/uploads/user/';
					$targetFolder = Yii::app()->request->baseUrl.'/uploads/user/';
				if (!empty($_FILES['UserProfiles']['name']['image'])) {
					$tempFile = $_FILES['UserProfiles']['tmp_name']['image'];
					$targetPath	=	$_SERVER['DOCUMENT_ROOT'].$targetFolder;
					$targetFile = $targetPath.'/'.$_FILES['UserProfiles']['name']['image'];
					$pat = $targetFile;
					move_uploaded_file($tempFile,$targetFile);
					$absoPath = $pat;
					$newName = time();
					$img = Yii::app()->imagemod->load($pat);
					# ORIGINAL
					$img->file_max_size = 5000000; // 5 MB
					$img->file_new_name_body = $newName;
					$img->process('uploads/user/original/');
					$img->processed;
					#IF ORIGINAL IMAGE NOT LARGER THAN 5MB PROCESS WILL TRUE 	
				if ($img->processed) {
					#LARGE Image
					$img->image_resize      = true;
					$img->image_y         	= 150;
					$img->image_x           = 150;
					$img->file_new_name_body = $newName;
					$img->process('uploads/user/large/');
					
					#STHUMB Image
					$img->image_resize      = true;
					$img->image_y         	= 50;
					$img->image_x           = 50;
					$img->file_new_name_body = $newName;
					$img->process('uploads/user/small/');
					
					 
					$fileName	=	$img->file_dst_name;
					$img->clean();
	
				}
				$model->image	=	$fileName;
				if($_POST['UserProfiles']['oldImage']!=''){
					@unlink($targetFolder1.'original/'.$_POST['UserProfiles']['oldImage']);
					@unlink($targetFolder1.'large/'.$_POST['UserProfiles']['oldImage']);
					@unlink($targetFolder1.'small/'.$_POST['UserProfiles']['oldImage']);
				}
			}
			if($model->save())
				Yii::app()->user->setFlash('updated',"Sccessfully updated.");
				$this->redirect(array('user/editProfile'));
		}
		$this->render('editProfile', array('model'=>$model));
	}
	public function actionTest($id)
	{									
		if(!Yii::app()->user->id){
			$this->redirect(Yii::app()->createUrl('/site/'));
		}
		$preResultTest		=	UserReports::model()->findByAttributes(array('orient_items_id'=>$id,'user_profiles_id'=>Yii::app()->user->profileId));
		if(isset($preResultTest->orient_items_id)==($id)){
			$this->redirect(Yii::app()->createUrl('/user/tests'));
		}
		$criteria				=	new CDbCriteria();
		$criteria->condition 	=	'published  = :published  and status=:status';
		$criteria->params 		=	array(':published'=>1,':status'=>1);
		$testContent			=	OrientItems::model()->findByPk($id,$criteria);
		$questions				=	array();
		$questions				=	Questions::model()->FindAllByAttributes(array('orient_items_id'=>$id,'published'=>1,'status'=>1));
		$quest					=	array();
		$preTestReport			=	array();
						
		foreach($questions as $question){
			$quest[$question->id]['id']						=	$question->id;
			$quest[$question->id]['title']					=	$question->title;
			$quest[$question->id]['testId']					=	$question->orient_items_id;
			$quest[$question->id]['career_categories_id']	=	$question->career_categories_id;
			$options	=	QuestionsHasQuestionOptions::model()->FindAllByAttributes(array('questions_id'=>$question->id));
			if(!empty($options))
				foreach($options as $option){
					$quest[$question->id]['option'][$option->question_options_id]	=	$option->questionOptions->name;
				}
			else
				$quest[$question->id]['option'][]	=	'';
		}
		$model	=	new TestReports;
		if(isset($_POST['TestReports'])||isset($_POST['testReports'])){
			$testReport		=	TestReports::model()->findAllByAttributes(array('user_profiles_id'=>Yii::app()->user->profileId,'test_category'=>$id));
			$total	=	count($testReport);
			if($total!=60){
				$response['status']=0;
				$response['message']='Plsease don not skip any question please.';
				echo json_encode($response); 
				die;
			}
			$model->attributes 				= 	(isset($_POST['TestReports']))?$_POST['TestReports']:$_POST['testReports'];
			$model->questions_id 			= 	(isset($_POST['TestReports']))?$_POST['TestReports']['question_options_id']:$_POST['testReports']['question_options_id'];
			$model->career_categories_id	= 	(isset($_POST['TestReports']))?$_POST['TestReports']['career_categories_id']:$_POST['testReports']['career_categories_id'];
			$score	=	array();
			foreach($model->questions_id as $key=>$value){
				$testReport		=	TestReports::model()->findByAttributes(array('user_profiles_id'=>Yii::app()->user->profileId,'questions_id'=>$key));
				if(empty($testReport))
					$testReport							=	new TestReports;
				$Question								=	$key;
				$Options								=	$value;
				$testReport->comments	 				= 	'';
				$testReport->status		 				=	1;
				$testReport->activation	 				=	1;
				$testReport->questions_id				=	$Question;
				$testReport->question_options_id 		=	$Options;
				$testReport->test_category				=	$id;
				$testReport->user_profiles_id	 		=	Yii::app()->user->profileId;
				$testReport->save();
				if(!isset($score[$testReport->questions->career_categories_id]))
					$score[$testReport->questions->career_categories_id]	=	0;
				else{
					$cate			=	$testReport->questions->career_categories_id;
					$interestVal	=	$testReport->questionOptions->interest_value;
					$score[$cate]	+=	$interestVal;
				}
			}
			unset($score['1']);
			foreach ($score as $key=>$val){
				$userScore							=	new UserScores;
				$userScore->score					=	$val;
				$userScore->career_categories_id 	=	$key;
				$userScore->user_profiles_id	 	=	Yii::app()->user->profileId;
				$userScore->add_date			 	=	date('Y-m-d H:i:s');
				$userScore->test_category		 	=	$id;
				$userScore->save();
			}
			$userTest						=	new UserReports;						
			$userTest->orient_items_id 		=	$id;
			$userTest->user_profiles_id	 	=	Yii::app()->user->profileId;
			$userTest->add_date			 	=	date('Y-m-d H:i:s');
			$userTest->status			 	=	1;
			$userTest->activation			=	1;
			$userTest->save();
			$response['status']=1;
			$response['message']='Plsease wait.';
			echo json_encode($response); 
			die;
			
		}
		$this->render('test', array('questions'=>$quest,'model'=>$model,'testContent'=>$testContent,'preTestReport'=>$preTestReport));
	}
	public function actionTests()
	{	
		if(!Yii::app()->user->id){
			$this->redirect(Yii::app()->createUrl('/site'));
		}
		$model	=	new RetakeTestRequest;
		$criteria				=	new CDbCriteria();
		$criteria->condition 	=	'published  = :published  and status=:status';
		$criteria->params 		=	array(':published'=>1,':status'=>1);
		$testContent			=	OrientItems::model()->findAll($criteria);
		$userTest				=	UserReports::model()->findAllByAttributes(array('user_profiles_id'=>Yii::app()->user->profileId));
		$tests	=	array();
		foreach($userTest as $test){
			$tests[]	=	$test->orient_items_id;
		}
		
		
		$this->render('userTest',array('testContent'=>$testContent,'userTest'=>$tests,'model'=>$model));
	}
	public function actionRetakeTest($id)
	{	
		$findRequest		=	 RetakeTestRequest::model()->countByAttributes(array('user_profiles_id'=>Yii::app()->user->profileId,'orient_items_id'=>$id));
		if($findRequest==1){
			Yii::app()->user->setFlash('updated',"you have already sent request to administrator.");
				$this->redirect(array('user/tests'));
			echo '';
			die;
		}
		else{
			$model		=	 new RetakeTestRequest;
			if(isset($_POST['RetakeTestRequest']))
			{
				$model->attributes			=	$_POST['RetakeTestRequest'];
				$model->orient_items_id		=	$_POST['RetakeTestRequest']['orient_items_id'];
				$model->user_profiles_id	=	Yii::app()->user->profileId;
				$model->add_date			=	date('Y-m-d H:i:s');
				$model->status				=	1;
				if($model->save()){
					Yii::app()->user->setFlash('updated',"Sccessfully sent.");
					$this->redirect(array('user/tests'));
					die;
				}
				
			}
			 
			
		}
	}
	public function actionQuestionsAnswer()
	{	 
		$Qid			=	$_REQUEST['testId'];	
		$Uans			=	$_REQUEST['ans'];	
		$test			=	$_REQUEST['QID'];
		//print_r($_REQUEST);die;
		$score	=	array();
		$testReport1	=	 TestReports::model()->findByAttributes(array('user_profiles_id'=>Yii::app()->user->profileId,'questions_id'=>$Qid));
		if(!isset($testReport1))
			$testReport1	=	new TestReports;
			$testReport1->comments	 				= 	'';
			$testReport1->status		 			=	1;
			$testReport1->activation	 			=	1;
			$testReport1->questions_id				=	$Qid;
			$testReport1->add_date 					=	date('Y-m-d H:i:s');
			$testReport1->question_options_id 		=	$Uans;
			$testReport1->test_category				=	$test;
			$testReport1->user_profiles_id	 		=	Yii::app()->user->profileId;
			if($testReport1->save()){
					echo 'You have answer to '.$testReport1->questions->title;die;
			}
		 
	}
	
	public function actionDetailedReport()
	{	
		$userReports			=	UserReports::model()->findAllByAttributes(array('user_profiles_id'=>Yii::app()->user->profileId));
		$data	=	array();
		
		foreach($userReports as $report){
			$userTest	=	array();
			$data[$report->orient_items_id]['id']=$report->orient_items_id;
			$data[$report->orient_items_id]['name']=$report->orientItems->title;
			$data[$report->orient_items_id]['description']=$report->orientItems->description;
			$userTests	=	UserScores::model()->findAllByAttributes(array('user_profiles_id'=>Yii::app()->user->profileId,'test_category'=>$report->orient_items_id),array('order'=>'score DESC'));
			
			foreach($userTests as $cur){
				$score	=	$cur->score;
				foreach($cur->careerCategories->careerAssessments as $asswssment){
					if($score >= $asswssment->score_start && $score <= $asswssment->score_end){
						$userTest[$asswssment->value][$cur->id]['value']		=	$asswssment->value;
						$userTest[$asswssment->value][$cur->id]['score']		=	$score;	
						$userTest[$asswssment->value][$cur->id]['id']			=	$cur->careerCategories->id;
						$userTest[$asswssment->value][$cur->id]['title']		=	$cur->careerCategories->title;
						$userTest[$asswssment->value][$cur->id]['title2']		=	$asswssment->title;
						$userTest[$asswssment->value][$cur->id]['description']	=	$asswssment->description;
					}
				}
				
			}
		if($report->orient_items_id==3){
			$highCount	=	0;
			$midCount	=	0;
			$final		=	array();
			if(isset($userTest['high'])){
				$highCount	=	count($userTest['high']);
				$final		=	$userTest['high'];
				$final1		=	$userTest['high'];
			}
			if(isset($userTest['moderate']))
				$midCount	=	count($userTest['moderate']);
			if(isset($userTest['moderate']))
				$final1		=	array_merge($final,array_slice($userTest['moderate'], 0, 5));
			
			
			if($highCount ==	0 && isset($userTest['moderate']))
				$final		=	$userTest['moderate'];
			if($highCount>0 && $highCount < 2 && isset($userTest['moderate']))
				$final		=	array_merge($final,array_slice($userTest['moderate'], 0, 1));
			if(isset($userTest['low']))
				$final1		=	array_merge($final,array_slice($userTest['low'], 0, 5));
			$total	=	$highCount+$midCount;
			$data[$report->orient_items_id]['results1']=$final1;
			$data[$report->orient_items_id]['results']=$final;
		}else{
				$final		=	array();
				if(isset($userTest['high'])){
					$final		=	$userTest['high'];
				}
				if(isset($userTest['moderate']))
					$final		=	array_merge($final,array_slice($userTest['moderate'],0,5));
				if(isset($userTest['low']))
					$final		=	array_merge($final,array_slice($userTest['low'],0,5));
				
				$data[$report->orient_items_id]['results']=$final;
			}
			
		}
		$profile		=	 UserProfiles::model()->findByPk(Yii::app()->user->profileId);
		if(Yii::app()->user->userType ==  'below10th')
			$this->render('detailedReport2',array('reports'=>$data,'profile'=>$profile));
		else
			$this->render('detailedReport',array('reports'=>$data,'profile'=>$profile));
	
	}
	public function actionSummaryDetails()
	{	
		$reportId	=	$_REQUEST['id'];
		$report			=	UserReports::model()->findByAttributes(array('user_profiles_id'=>Yii::app()->user->profileId,'orient_items_id'=>$reportId));
		$data	=	array();
		$userTest	=	array();
		$data[$report->orient_items_id]['id']=$report->orient_items_id;
		$data[$report->orient_items_id]['name']=$report->orientItems->title;
		$data[$report->orient_items_id]['description']=$report->orientItems->description;
		$userTests	=	UserScores::model()->findAllByAttributes(array('user_profiles_id'=>Yii::app()->user->profileId,'test_category'=>$report->orient_items_id),array('order'=>'score DESC'));
		foreach($userTests as $cur){
			$score	=	$cur->score;
			foreach($cur->careerCategories->careerAssessments as $asswssment){
				if($score >= $asswssment->score_start && $score <= $asswssment->score_end){
					$userTest[$asswssment->value][$cur->id]['value']		=	$asswssment->value;
					$userTest[$asswssment->value][$cur->id]['score']		=	$score;	
					$userTest[$asswssment->value][$cur->id]['id']			=	$cur->careerCategories->id;
					$userTest[$asswssment->value][$cur->id]['title']		=	$cur->careerCategories->title;
					$userTest[$asswssment->value][$cur->id]['title2']		=	$asswssment->title;
					$userTest[$asswssment->value][$cur->id]['description']	=	$asswssment->description;
				}
			}
			
		}
		if($reportId==3){
			$highCount	=	0;
			$midCount	=	0;
			$final		=	array();
			if(isset($userTest['high'])){
				$highCount	=	count($userTest['high']);
				$final		=	$userTest['high'];
				$final1		=	$userTest['high'];
			}
			if(isset($userTest['moderate']))
				$midCount	=	count($userTest['moderate']);
			if(isset($userTest['moderate']))
				$final1		=	array_merge($final,array_slice($userTest['moderate'], 0, 5));
			
			
			if($highCount ==	0 && isset($userTest['moderate']))
				$final		=	$userTest['moderate'];
			if($highCount>0 && $highCount < 2 && isset($userTest['moderate']))
				$final		=	array_merge($final,array_slice($userTest['moderate'], 0, 1));
			if(isset($userTest['low']))
				$final1		=	array_merge($final,array_slice($userTest['low'], 0, 5));
			$total	=	$highCount+$midCount;
			$data[$report->orient_items_id]['results1']=$final1;
			$data[$report->orient_items_id]['results']=$final;
		}
		else{
			$final		=	array();
			if(isset($userTest['high'])){
				$final		=	$userTest['high'];
			}
			if(isset($userTest['moderate']))
				$final		=	array_merge($final,array_slice($userTest['moderate'],0,5));
			if(isset($userTest['low']))
				$final		=	array_merge($final,array_slice($userTest['low'],0,5));
			
			$data[$report->orient_items_id]['results']=$final;
		}
		$profile		=	 UserProfiles::model()->findByPk(Yii::app()->user->profileId);
		if(Yii::app()->user->userType ==  'below10th')
			$this->renderPartial('_detailedReport2',array('reports'=>$data,'profile'=>$profile), false, true);
		else
			$this->renderPartial('_detailedReport',array('reports'=>$data,'profile'=>$profile), false, true);
	
	}
	public function actionCollage()
	{	
		
		$this->render('collage',true);
	
	}
	
	

	public function actionLiveChat()
	{	
		if(!Yii::app()->user->id){
			$this->redirect(Yii::app()->createUrl('/site'));
		}
		
		$this->render('LiveChat');
	}
	public function actionCareer()
	{	
		if(!Yii::app()->user->id){
			$this->redirect(Yii::app()->createUrl('/site'));
		}
		$criteria 		= new CDbCriteria;
		$criteria->condition = '(published =:published and status=:status)';
		$criteria->params = array(':published'=>1,'status'=>1);
		$dataProvider				=	Career::model()->findAll($criteria);
		
		$this->render('career',array('data'=>$dataProvider));
	}
	
	public function actionCareerList($id)
	{	
		if(!Yii::app()->user->id){
			$this->redirect(Yii::app()->createUrl('/site'));
		}
		$dataBYId		=	Career::model()->FindByPk($id);
		$criteria			=	new CDbCriteria();
		//$criteria->join 	=	'LEFT JOIN user_rating ON user_rating.career_options_id = t.id';
		$criteria->condition= '(published =:published and status =:status  and career_id=:career_id)';
		$criteria->params 	= array('published'=>1,'status'=>1,'career_id'=>$id);
	 	$career				=	Careeroptions::model()->findAll($criteria);
		$this->render('careerList',array('dataBYId'=>$dataBYId,'career' => $career));
	}
	public function actionCareerDetails($id)
	{	
		if(!Yii::app()->user->id){
			$this->redirect(Yii::app()->createUrl('/site'));
		}
		$careerDetails				=	CareerOptions::model()->FindByPk($id);
		$userRateing				=	UserCareerPreference::model()->findByAttributes(array('career_options_id'=>$careerDetails->id,'user_profiles_id'=>Yii::app()->user->profileId));
		$careerDetailsList			=	CareerDetails::model()->findAllByAttributes(array('career_options_id'=>$id,'published'=>1,'status'=>1));
		$this->render('careerDetails',array('careerDetails'=>$careerDetails,'careerDetailsList'=>$careerDetailsList,'userRateing'=>$userRateing));
	}
	public function actionReadFull($id)
	{
		$career		=	Career::model()->FindByPk($id);
		$this->render('readFull',array('career'=>$career));
	}
	public function actionStreamList()
	{
		$data		=array();
		$stream	=	Stream::model()->findAllByAttributes(array('status'=>1,'activation'=>1));
		foreach($stream as $list){
			$data[$list->id]['id']				=	$list->id;
			$data[$list->id]['name']			=	$list->name;
			$data[$list->id]['description']		=	$list->description;
			$data[$list->id]['image']			=	$list->image;
			$data[$list->id]['featured']		=	$list->featured;
			$criteria			=	new CDbCriteria();
			$criteria->condition= '(stream_id =:stream_id and user_profiles_id =:user_profiles_id )';
			$criteria->params 	= array('stream_id'=>$list->id,'user_profiles_id'=>Yii::app()->user->profileId);
			$criteria->order 	 = 'self ASC';
			$userStream	=	UserProfilesHasStream::model()->findAll($criteria);
			foreach($userStream as $list2){
			 	$data[$list->id]['rating']			=	$list2->self;
			  
			}
		}
		//echo '<pre>';print_r($data);die;
		$this->render('streamList',array('data'=>$data));
	}

	public function actionStream($id)
	{
		$streamData			=	array();
		$stream			=	Stream::model()->findByPk($id);
		$userStream			=	UserProfilesHasStream::model()->findByAttributes(array('user_profiles_id'=>Yii::app()->user->profileId,'stream_id'=>$id));
		$Subjects		=	array();
		$subjectList	=	array();
		
		$criteria = new CDbCriteria();
		$criteria->distinct = true;
		
		$StreamHasSubjects	=	StreamHasSubjects::model()->findAllByAttributes(array('stream_id'=>$id));
		foreach($StreamHasSubjects as $subject){
			$subjectList[]	=	$subject->subjects_id;
			$Subjects[$subject->subjects->id]['id']			=	$subject->subjects->id;
			$Subjects[$subject->subjects->id]['title']		=	$subject->subjects->title;
			$Subjects[$subject->subjects->id]['image']		=	$subject->subjects->image;
			$Subjects[$subject->subjects->id]['type']		=	$subject->type_subjects;
			$Subjects[$subject->subjects->id]['description']=	$subject->subjects->description;
		}
		$careerOptions	=	  CareerOptionsHasSubjects::model()->findAllByAttributes(array('subjects_id'=>$subjectList));
		$list	=	array();
		foreach($careerOptions as $careerOption){
			$list[$careerOption->careerOptions->id]	=	$careerOption->careerOptions->title;
		}
		$this->render('stream',array('stream'=>$stream,'subjects'=>$Subjects,'careerOption'=>$list,'streamData'=>$userStream));
	}
	public function actionFinalizedCareer()
	{	
		if(isset($_REQUEST['id'])){
			$career	=	 UserCareerPreference::model()->findAllByAttributes(array('status'=>1,'updated_by'=>1,'user_profiles_id'=>Yii::app()->user->profileId));
			$count			=	count($career);
			if($count==2){
				echo 'Your limit to finalized career are two if you want to exceed more please contact to admin';die;
			}
			$id		=	$_REQUEST['id'];
			$finalCareer	=	 UserCareerPreference::model()->findByAttributes(array('career_options_id'=>$id,'user_profiles_id'=>Yii::app()->user->profileId));
			$finalCareer->modified_date		=	date('Y-m-d H:i:s');
			$finalCareer->status			=	1;
			$finalCareer->updated_by 		=	1;
			if($finalCareer->save()){
				echo 'Sccessfullly added.';die;
		 		 
			}
		}
		$model	=	new UserCareerComments;
		if(isset($_POST['UserCareerComments']))
		{	
			$model->attributes			=	$_POST['UserCareerComments'];
			$model->add_date			=	date('Y-m-d H:i:s');
			$model->user_profiles_id	=	Yii::app()->user->profileId;
			$model->stream_id			=	$_POST['UserCareerComments']['stream_id'];
			
			if($model->save()){
				Yii::app()->user->setFlash('sccess','Sccessfully send your comment.');
			}
		}
		$criteria			=	new CDbCriteria();
		$criteria->condition= '(status =:status  and updated_by=:updated_by and user_profiles_id=:user_profiles_id)';
		$criteria->params 	= array('status'=>1,'updated_by'=>1,'user_profiles_id'=>Yii::app()->user->profileId);
		$criteria->order 	= 'self DESC';
		 
		$data	=	array();
		$preference				=	UserCareerPreference::model()->findAll($criteria);
		foreach($preference as $Crate){
			$data[$Crate->career_options_id]['id']			=	$Crate-> careerOptions->id;
			$data[$Crate->career_options_id]['title']			=	$Crate-> careerOptions->title;
			$data[$Crate->career_options_id]['description']		=	$Crate->careerOptions->description;
			$data[$Crate->career_options_id]['image']			=	$Crate->careerOptions->image;
			$data[$Crate->career_options_id]['rating']			=	$Crate->self;
		 
			 
		}
		 
	 
		$this->render('finalizedCareer',array('data'=>$data,'model'=>$model));
	}
	public function actionFinalizedStream()
	{	
		if(isset($_REQUEST['id'])){
			if(isset($_REQUEST['id'])){
				$stream	=	 UserProfilesHasStream::model()->findAllByAttributes(array('status'=>1,'updated_by'=>1,'user_profiles_id'=>Yii::app()->user->profileId));
				$count			=	count($stream);
				if($count==1){
					echo 'Your have limit to finalized stream is one if you want to exceed more please contact to admin';die;
				}
				else{
					$id		=	$_REQUEST['id'];
					$model	=	 UserProfilesHasStream::model()->findByAttributes(array('stream_id'=>$id,'user_profiles_id'=>Yii::app()->user->profileId));
					$model->modified_date		=	date('Y-m-d H:i:s');
					$model->status				=	1;
					$model->updated_by			=	1;
					if($model->save()){
						echo 'Thank you to final to stream.';die;
					}
				}
			}
		}
		$model	=	new UserStreamComments;
		if(isset($_POST['UserStreamComments']))
		{	
			$model->attributes			=	$_POST['UserStreamComments'];
			$model->add_date			=	date('Y-m-d H:i:s');
			$model->user_profiles_id	=	Yii::app()->user->profileId;
			$model->stream_id			=	$_POST['UserStreamComments']['stream_id'];
			
			if($model->save()){
				Yii::app()->user->setFlash('sccess','Sccessfully send your comment.');
			}
		}
		$data	=	array();
		$criteria			=	new CDbCriteria();
		$criteria->condition= '(status =:status and updated_by=:updated_by and user_profiles_id=:user_profiles_id)';
		$criteria->params 	= array('status'=>1,'updated_by'=>1,'user_profiles_id'=>Yii::app()->user->profileId);
		$criteria->order 	 = 'self DESC';
		$preference				=	UserProfilesHasStream::model()->findAll($criteria);
		foreach($preference as $fCounselor){
			$data[$fCounselor->stream_id]['id']			=	$fCounselor->stream->id;
			$data[$fCounselor->stream_id]['name']			=	$fCounselor->stream->name;
			$data[$fCounselor->stream_id]['description']	=	$fCounselor->stream->description;
			$data[$fCounselor->stream_id]['image']			=	$fCounselor->stream->image;
			$data[$fCounselor->stream_id]['featured']		=	$fCounselor->stream->featured;
			$data[$fCounselor->stream_id]['rating']			=	$fCounselor->self;
	 	}

		$this->render('finalizedStream',array('data'=>$data,'model'=>$model));
	}
	public function actionAddCareer ($id)
	{	
		$count	=	UserCareerPreference::model()->countByAttributes(array('user_profiles_id'=>Yii::app()->user->profileId));
		if($count==2){
			echo 'You have permission to add more career if you want to add more please contact to administrator.';die;
		}
		$record_exists = UserCareerPreference::model()->exists('career_options_id  = :career_options and user_profiles_id=:id', array(':career_options'=>$id,':id'=>Yii::app()->user->profileId ));
		if($record_exists==1)
		{
			echo 'This is already added please choose another.';die;	
		}
		else{
			$rating		=	UserRating::model()->countByAttributes(array('career_options_id'=>$id,'user_profiles_id'=>Yii::app()->user->profileId));
			if($rating==0){
				echo 'Please do rate first thank you.';die;
			}
			$options	=	CareerOptions::model()->findByPk($id);
			$preffred	 = new UserCareerPreference;
			if(isset($_REQUEST)){
				$preffred->career_options_id	=	$id;
				$preffred->user_profiles_id		=	Yii::app()->user->profileId;
				$preffred->add_date				=	date('Y-m-d H:i:s');
				$preffred->self					=	1;
				$preffred->default				=	0;
				$preffred->status				=	0;
				if($preffred->save()){
					echo 'Sccessfully added '.$options->title.' career';die;
				}
	
			}
				echo 'somethig bad';die;
				
		}
		
		
		
	}
	public function actionCareerPreference()
	{
		if(!Yii::app()->user->id){
			$this->redirect(Yii::app()->createUrl('/site'));
		}
		$criteria			=	new CDbCriteria();
		$criteria->condition= '(user_profiles_id=:user_profiles_id)';
		$criteria->params 	= array('user_profiles_id'=>Yii::app()->user->profileId);
		$criteria->order = 'self DESC';
		$data	=	array();
		$preference				=	UserCareerPreference::model()->findAll($criteria);
		foreach($preference as $Crate){
			$data[$Crate->career_options_id]['id']				=	$Crate-> careerOptions->id;
			$data[$Crate->career_options_id]['title']			=	$Crate-> careerOptions->title;
			$data[$Crate->career_options_id]['description']		=	$Crate->careerOptions->description;
			$data[$Crate->career_options_id]['image']			=	$Crate->careerOptions->image;
			$data[$Crate->career_options_id]['uRating']			=	$Crate->self;
			$data[$Crate->career_options_id]['updated_by']		=	$Crate->updated_by;
		 
	 	}
		 
		$model	=	new UserCareerComments;
		if(isset($_POST['UserCareerComments']))
		{	
			$model->attributes			=	$_POST['UserCareerComments'];
			$model->add_date			=	date('Y-m-d H:i:s');
			$model->user_profiles_id	=	Yii::app()->user->profileId;
			$model->career_id			=	$_POST['UserCareerComments']['career_id'];
			if($model->save()){
				Yii::app()->user->setFlash('sccess','Sccessfully send your comment.');
			}
		}
		$data2	=array();
		$finalCounselor	=	UserCareerPreference::model()->findAllByAttributes(array('user_profiles_id'=>Yii::app()->user->profileId,'reccomended'=>1));
		foreach($finalCounselor as $fCounselor){
			$data2[$fCounselor->career_options_id]['id']				=	$fCounselor-> careerOptions->id;
			$data2[$fCounselor->career_options_id]['title']			=	$fCounselor-> careerOptions->title;
			$data2[$fCounselor->career_options_id]['description']	=	$fCounselor->careerOptions->description;
			$data2[$fCounselor->career_options_id]['image']			=	$fCounselor->careerOptions->image;
			$data2[$fCounselor->career_options_id]['rate']			=	$fCounselor->self;
			$data[$preference->stream_id]['updated_by']		=	$preference->updated_by;
	 	}
		 
		//CVarDumper::dump($finalCounselor,10,1);die;
		$this->render('careerPreference',array('data'=>$data,'data2'=>$data2,'model'=>$model,'finalCounselor'=>$finalCounselor));
	}
	public function actionStreamPreference()
	{
		$criteria			=	new CDbCriteria();
		$criteria->condition= '(status =:status  and user_profiles_id=:user_profiles_id)';
		$criteria->params 	= array('status'=>1,'user_profiles_id'=>Yii::app()->user->profileId);
		$criteria->order = 'self DESC';
		$data	=	array();
		$preference				=	UserProfilesHasStream::model()->findAll($criteria,array('order'=>'self ASC'));
		foreach($preference as $preference){
			$data[$preference->stream_id]['id']				=	$preference->stream->id;
			$data[$preference->stream_id]['name']			=	$preference->stream->name;
			$data[$preference->stream_id]['description']	=	$preference->stream->description;
			$data[$preference->stream_id]['image']			=	$preference->stream->image;
			$data[$preference->stream_id]['Urate']			=	$preference->self;
			$data[$preference->stream_id]['updated_by']	=	$preference->updated_by;
	 	}
		 
		$model	=	new UserStreamComments;
		if(isset($_POST['UserStreamComments']))
		{	
			$model->attributes			=	$_POST['UserStreamComments'];
			$model->add_date			=	date('Y-m-d H:i:s');
			$model->user_profiles_id	=	Yii::app()->user->profileId;
			$model->stream_id			=	$_POST['UserStreamComments']['stream_id'];
			
			if($model->save()){
				Yii::app()->user->setFlash('sccess','Sccessfully send your comment.');
			}
		}
		$data2	=	array();
		$finalCounselor	=	UserProfilesHasStream::model()->findAllByAttributes(array('user_profiles_id'=>Yii::app()->user->profileId,'reccomended'=>1));
		foreach($finalCounselor as $fCounselor){
			$data2[$fCounselor->stream_id]['id']			=	$fCounselor->stream->id;
			$data2[$fCounselor->stream_id]['name']			=	$fCounselor->stream->name;
			$data2[$fCounselor->stream_id]['description']	=	$fCounselor->stream->description;
			$data2[$fCounselor->stream_id]['image']			=	$fCounselor->stream->image;
			$rating2		=	UserStreamRating::model()->findAllByAttributes(array('stream_id'=>$fCounselor->stream_id,'user_profiles_id'=>Yii::app()->user->profileId));
			foreach($rating2 as $list2){
				$data2[$fCounselor->stream_id]['uCrate']			=	$list2->rating;
				 
			}
	 	}
		//CVarDumper::dump($finalCounselor,10,1);die;
		$this->render('streamPreference',array('data'=>$data,'data2'=>$data2,'model'=>$model,'finalCounselor'=>$finalCounselor));
	}	
	public function actionUserFinalCareer($id)
	{	 
		$record_exists = UserCareerPreference::model()->findByAttributes(array('id'=>$id,'user_profiles_id'=>Yii::app()->user->profileId));
		if($record_exists->status==1)
		{
			echo 'This is already added please choose another.';die;	
		}
		else{
			$preffred	=  UserCareerPreference::model()->findByPk($id);
			if(isset($_REQUEST)){
				$preffred->career_options_id	=	$id;
				$preffred->user_profiles_id		=	Yii::app()->user->profileId;
				$preffred->add_date				=	date('Y-m-d H:i:s');
				$preffred->default				=	0;
				$preffred->status				=	1;
				if($preffred->save()){
					echo 'Sccessfully added '.$preffred->careerOptions->title.' career';die;
				}
	
			}
				echo 'somethig bad';die;
				
		}
		
		
	}
	public function actionExplore()
	{	 
		$userReports	=	UserReports::model()->findAllByAttributes(array('user_profiles_id'=>Yii::app()->user->profileId));
		$catList		=	array();
		$index	=	0;
		foreach($userReports as $report){
			$userTests	=		UserScores::model()->findAllByAttributes(array('user_profiles_id'=>Yii::app()->user->profileId,'test_category'=>$report->orient_items_id),array('order'=>'score DESC'));
		 	$COUT	=	0;
			foreach($userTests as $userTest){
				if($COUT >= 3)
					break;				
				$subCats		=	Career::model()->findAllByAttributes(array('career_categories_id'=>$userTest->career_categories_id));
				foreach($subCats as $subCat){
					$catList[$index]['id']	=	$subCat->id;
					$catList[$index]['title']	=	$subCat->title;
					$catList[$index]['description']	=	$subCat->description;
					$catList[$index]['image']	=	$subCat->image;
					//$catList[]['id']	=	$subCat->id;
					$index++;
				}
				$COUT++;
			}
		}
		//CVarDumper::dump($catList,10,1);die;
		$this->render('explore',array('data'=>$catList));
	}
	public function actionStreamExplore()
	{	$userReports	=	UserReports::model()->findAllByAttributes(array('user_profiles_id'=>Yii::app()->user->profileId));
		$catList		=	array();
		$index	=	0;
		$subject=array();
		foreach($userReports as $report){
			$userTests	=		UserScores::model()->findAllByAttributes(array('user_profiles_id'=>Yii::app()->user->profileId,'test_category'=>$report->orient_items_id),array('order'=>'score DESC'));
		 	$COUT	=	0;
			foreach($userTests as $userTest){
				if($COUT >= 3)
					break;	
			$Career		=	Career::model()->findAllByAttributes(array('career_categories_id'=>$userTest->career_categories_id));
				foreach($Career as $subCat){
					$subCa		=	CareerOptions::model()->findAllByAttributes(array('career_id'=>$subCat->id));
					foreach($subCa as $subjects){
						$subCats1S		=	CareerOptionsHasSubjects::model()->findAllByAttributes(array('career_options_id'=>$subjects->id));
						foreach($subCats1S as $subCats1){
							$subject[]=$subCats1->subjects_id;	
						
						}
					}
				}
				
				$subCats1S		=	StreamHasSubjects::model()->findAllByAttributes(array('subjects_id'=>$subject));
				foreach($subCats1S as $subCat){
					$catList[$subCat->stream_id]['id']	=	$subCat->stream_id;
					$catList[$subCat->stream_id]['title']	=	$subCat->stream->name;
					$catList[$subCat->stream_id]['description']	=	$subCat->stream->description;
					$catList[$subCat->stream_id]['image']	=	$subCat->stream->image;
				}
				$COUT++;
			}
		}
		 
		$this->render('streamExplore',array('data'=>$catList));
	}
	public function actionReadFullStream($id)
	{
		$readFullStream		=	Stream::model()->FindByPk($id);
		$this->render('readFullStream',array('readFull'=>$readFullStream));
	}
	public function actionUserPreffredStream ($id)
	{	
		$count	=	UserProfilesHasStream::model()->countByAttributes(array('user_profiles_id'=>Yii::app()->user->profileId));
		if($count==2){
			echo 'You have permission to add more stream if you want to add more please contact to administrator.';die;
		}
		$record_exists = UserProfilesHasStream::model()->exists('stream_id  = :stream and user_profiles_id=:uID', array(':stream'=>$id,'uID'=>Yii::app()->user->profileId));
		if($record_exists==1)
		{
			echo 'This is stream allready added please choose another.';die;	
		}
	
		else{
			$rating		=	 UserStreamRating::model()->countByAttributes(array('stream_id'=>$id,'user_profiles_id'=>Yii::app()->user->profileId));
			if($rating==0){
				echo 'Please do rate first thank you.';die;
			}
			$stream	=	Stream::model()->findByPk($id);
			$preffred	 = new UserProfilesHasStream;
			if(isset($_REQUEST)){
				$preffred->stream_id			=	$id;
				$preffred->user_profiles_id		=	Yii::app()->user->profileId;
				$preffred->add_date				=	date('Y-m-d H:i:s');
				$preffred->self					=	1;
				$preffred->default 				=	0;
				$preffred->status	  			=	0;
				if($preffred->save()){
					echo 'Sccessfully added '.$stream->name.' stream';die;
				}
	
			}
				echo 'somethig bad';die;
				
		}
		
		
		$preffred	=	 UserProfilesHasStream::model()->findByAttributes(array('stream_id'=>$id));
		
	}
	
	public function actionStreamCareerOptions($id)
	{	
		$criteria 		= new CDbCriteria;
		//$criteria->join = 'LEFT JOIN career_options_has_subjects ON career_options_has_subjects.career_options_id = t.career_options_id';
		//$criteria->join = 'LEFT JOIN subjects ON career_options_has_subjects.id=subjects.id';
		$criteria->condition = '(t.stream_id =:sID and t.status=:status and t.published=:published)';
		$criteria->params = array(':published'=>1,'status'=>1,'sID'=>$id);
		$stream	=	CareerOptionsHasStream::model()->findAll($criteria);
		$steamData	=	Stream::model()->findByPk($id);
		$this->render('streamCareerOptions',array('stream'=>$stream,'steamData'=>$steamData));
	}
	public function actionUserRaitng()
	{	
		$careeroptions_id				=	$_REQUEST['id'];
		$rating							=	$_REQUEST['rating'];
		$UserRating						=	 UserCareerPreference::model()->findByAttributes(array('user_profiles_id'=>Yii::app()->user->profileId,'career_options_id'=>$careeroptions_id));
		if(empty($UserRating))
			$UserRating						=	new UserCareerPreference;
			$UserRating->self				=	$rating;
			$UserRating->status				=	1;
			$UserRating->updated_by			=	0;
			$UserRating->add_date			=	date('Y-m-d H:s:i');
			$UserRating->user_profiles_id	=	Yii::app()->user->profileId;
			$UserRating->career_options_id 	=	$careeroptions_id;
			if($UserRating->save()){
				$response	=	 array('message'=>'Sccessfully rating.');
				echo CJSON::encode($response);die;
				 	
			}
	}
	public function actionUserStreamRaitng()
	{	
		$stream_id					=	$_REQUEST['id'];
		$rating						=	$_REQUEST['rating'];
		$UserRating					=	  UserProfilesHasStream::model()->findByAttributes(array('user_profiles_id'=>Yii::app()->user->profileId,'stream_id'=>$stream_id));
		if(empty($UserRating))
			$UserRating						=	new UserProfilesHasStream;
			$UserRating->self				=	$rating;
			$UserRating->add_date			=	date('Y-m-d H:s:i');
			$UserRating->user_profiles_id	=	Yii::app()->user->profileId;
			$UserRating->stream_id		 	=	$stream_id;
			if($UserRating->save()){
				$response	=	 array('message'=>'Sccessfully rating.');
				echo CJSON::encode($response);die;
			}
	}
	public function actionArticlesList()
	{	
		$criteria			=	new CDbCriteria();
		$criteria->condition= '(published =:published and status =:status )';
		$criteria->params 	= array('published'=>1,'status'=>1);
		$count				=	Articles::model()->count($criteria);
		$pages				=	new CPagination($count);
		$pages->pageSize	=	5;
		$pages->applyLimit($criteria);
		$articles				=	Articles::model()->findAll($criteria);
		$criteria2			=	new CDbCriteria();
		$criteria2->condition= '(published =:published and status =:status )';
		$criteria2->params 	= array('published'=>1,'status'=>1);
		$count				=	Events::model()->count($criteria2);
		$pages2				=	new CPagination($count);
		$pages2->pageSize	=	5;
		$pages2->applyLimit($criteria2);
		$events				=	Events::model()->findAll($criteria2);
		$this->render('articlesList',array('articles'=>$articles,'pages'=>$pages,'pages2'=>$pages2,'events'=>$events));
	}
	public function actionArticles($id)
	{	
		$result				=	 Articles::model()->findByAttributes(array('id'=>$id));
		
		$this->render('articles',array('articles'=>$result));
	}
	public function actionSummary()
	{	
		$summaryDetails=UserReports::model()->findAllByAttributes(array('user_profiles_id'=>Yii::app()->user->profileId,'activation'=>1,'status'=>1));
		/*$summaryDetails=UserReports::model()->findAll(array(
			'select'=>'t.comments',
			'group'=>'t.comments',
			'distinct'=>true,
		),array('user_profiles_id'=>Yii::app()->user->profileId,));*/
		$this->render('summary',array('summaryDetails'=>$summaryDetails));
	}
	
	public function actionNewsUpdates()
	{	
		$criteria			=	new CDbCriteria();
		$criteria->condition= '(published =:published and status =:status )';
		$criteria->params 	= array('published'=>1,'status'=>1);
		$count				=	News::model()->count($criteria);
		$pages				=	new CPagination($count);
		$pages->pageSize	=	5;
		$pages->applyLimit($criteria);
		$news				=	News::model()->findAll($criteria);
		$criteria2			=	new CDbCriteria();
		$criteria2->condition= '(published =:published and status =:status )';
		$criteria2->params 	= array('published'=>1,'status'=>1);
		$count				=	Events::model()->count($criteria2);
		$pages2				=	new CPagination($count);
		$pages2->pageSize	=	5;
		$pages2->applyLimit($criteria2);
		$events				=	Events::model()->findAll($criteria2);
		$this->render('newsUpdates',array('news'=>$news,'pages'=>$pages,'pages2'=>$pages2,'events'=>$events));
	}

	
	public function actionCareerOptionsAjax($id)
	{	
		
		$resultList	=	CareerOptionsHasSubjects::model()->findAllByAttributes(array('subjects_id'=>$id));
	    $this->renderPartial('_careerOptionsAjax',array('resultList'=> $resultList), false, true);
	}
	public function actionExploreColleges()
	{	
		$model	=	new Institutes;
		$criteria			=	new CDbCriteria();
		$criteria->condition= '(activation =:activation and status =:status )';
		$criteria->params 	= array('activation'=>1,'status'=>1);
		$count				=	Institutes::model()->count($criteria);
		$pages				=	new CPagination($count);
		$pages->pageSize	=	5;
		$pages->applyLimit($criteria);
		$Institutes				=	Institutes::model()->findAll($criteria);

		$this->render('collage',array('model'=>$model,'Institutes'=>$Institutes,'pages'=>$pages));
	}
	public function actionShortListedColleges()
	{	
		$collegesList =	UserProfilesHasInstitutes::model()->findAllByAttributes(array('user_profiles_id'=>Yii::app()->user->profileId,'status'=>1,'published'=>1));
		$this->render('shortListedColleges',array('collegesList'=>$collegesList));
	}
	public function actionDynamicCourse()
	{	
		$getId = '';
			if(!empty($_POST['Institutes']['courses_id'])) 
				$getId 	= $_POST['Institutes']['courses_id'];
				$data	=	CourseStream::model()->findAll('courses_id =:parent_id',array(':parent_id'=>(int) $getId));
				$data	=	CHtml::listData($data,'id','title');
				echo '<option value="0">Please Select</option>';
			foreach($data as $value=>$name){
				echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
				
			}
			
		die;

		
	}
	public function actionDynamicSearchResult()
	{	
		$getId = '';
			if(!empty($_POST['Institutes']['cities_id'])) 
				$city 					= $_POST['Institutes']['cities_id'];
				$courses 				= $_POST['Institutes']['courses_id'];
				$specialisation 		= $_POST['Institutes']['specialisation'];
				$criteria				=	new CDbCriteria();
				$criteria->condition	= '(activation =:activation  and status =:status and cities_id =:cities_id)';
				$criteria->params	 	= array('activation'=>1,'status'=>1,'cities_id'=>$city);
				$collegeData			=	 Institutes::model()->findAll($criteria);
				
				
				
			foreach($collegeData as $list){
			echo '<div class="coll_right_main_outer" >
                     <div class="coll_top_row">
                         <div class="coll_top_part">
                            <div class="coll_logo"><img alt="" src="'.Yii::app()->theme->baseUrl.'/images/coll_logo.png"></div>   
                             <div class="head_text_coll">'.$list->name.'<br>
                              <span>'.$list->address1.'</span>
                             </div>
                        </div>
                      
                        <div class="coll_top_part2">
                            <div class="orange_div">Rating <span>4.5/5</span></div>
                        <div class="orange_div"><input type="checkbox" class="css-checkbox" id="box_11">
						<a href="#" id="'.Yii::app()->createUrl('user/UserShortlistCollage',array('id'=>$list->id)).'" class="add_college'.$list->id.' css-label">Shortlist Collage</a>
				       </div>
                        </div>
                       
                        <div class="content_div">Bachelor of Technology (B.Tech)  <span>  (4 years/ Full Time/ On-campus/ AICTE Approved)</span></div>
                        <div class="content_div">Dual Degree - Bachelor of Technology + Master of Technology  <span> (5 years/ Full Time/ On-campus/ AICTE Approved)</span></div>
                     </div>
					 
                      <script>
						$(".add_college'.$list->id.'").click(function(){
							$url	=	this.id;
							$.ajax({		 
								type:"GET",
								url: $url,
								data: "college",
								success:function(data){
										
										 
								}
							});

						});
				  </script>     
                   </div>';
                 
				
			}
			
		die;

		
	}
	public function actionUserShortlistCollage($id)
	{	
		$record_exists = UserProfilesHasInstitutes::model()->exists('institutes_id = :institutes and user_profiles_id=:id', array(':institutes'=>$id,':id'=>Yii::app()->user->profileId));
		if($record_exists==1)
		{
			echo '<h1>This is College already added please choose another.</h1>';die;	
		}
		else{
			$stream	=	Institutes::model()->findByPk($id);
			$preffred	 = new UserProfilesHasInstitutes;
			if(isset($_REQUEST)){
				$preffred->institutes_id		=	$id;
				$preffred->user_profiles_id		=	Yii::app()->user->profileId;
				$preffred->add_date				=	date('Y-m-d H:i:s');
				$preffred->status				=	1;
				$preffred->published			=	1;
				if($preffred->save()){
					echo '<h1>Sccessfully added '.$stream->name.'College</h1>';die;
				}
	
			}
				echo '<h1>somethig bad</h1>';die;
				
		}
		
		
	}
	public function actionUserPrefferdCareer($id)
	{	
		$career					=	CareerDetails::model()->findAllByAttributes(array('status'=>1,'published'=>1,'career_options_id'=>$id));
		$this->renderPartial('_userPrefferdCareer',array('list'=>$career), false,true);
	}
		
	public function actionNews($id)
	{	
		
		$News			=	News::model()->findByAttributes(array('id'=>$id,'published'=>1,'status'=>1));
	    $this->render('news',array('news'=>$News));
	}
	public function actionApplication()
	{
	
		$this->render('application');
	}
	public function actionReadEvent($id)
	{
		$event		=	Events::model()->findByPk($id);
		$this->render('readEvent',array('event'=>$event));
	}
	public function actionSearch()
	{	

		$qterm	=(isset($_REQUEST['term']))?'%'.$_REQUEST['term'].'%':'%%';
		$criteria->condition = '(name  Like :qterm OR address Like :qterm)';
		$criteria->params = array(':qterm'=>$qterm);
		$dataProvider=new CActiveDataProvider('Schools', array(
							'criteria'=>$criteria,
							'pagination'=>array(
								'pageSize'=>10,
							),
						));
		
		$this->render('search',array('fech_result'=>$dataProvider));
	}
	//Forgot password
		//Change password 
	public function actionChangePassword()
	{	
		$id=Yii::app()->user->userId;
		$model=new Changepassword();
		 
		if(isset($_POST['Changepassword'])){
			$model->attributes = $_POST['Changepassword'];
			if($model->confirmpass != $model->newpassword ){
				Yii::app()->user->setFlash('updated',"New password is not matching with confirm password ");
				$this->redirect(Yii::app()->createUrl('user/changePassword'));
			}
			
			if($model->validate()){
				// Change the posted password to md5 hash to cmpare it with database
				$hashed_password = md5($_POST['Changepassword']['oldpassword']); 
				// Searches for the record in the database for the posted password 
				$record_exists = UserLogin::model()->exists('password = :password', array(':password'=>$hashed_password)); 
				if(!empty($record_exists)){
					//New Password posted through form  
					$posted_new_password = md5($_POST['Changepassword']['newpassword']);
					
					UserLogin::model()->updateAll(array('password'=>$posted_new_password),'id="'.$id.'"');
					Yii::app()->user->setFlash('updated',"Password changed successfully!");
					$this->redirect(Yii::app()->createUrl('user/changePassword'));
				}
				else{ 
					Yii::app()->user->setFlash('updated',"Password provided by you does not exist.Please provide the correct password");
					 $this->redirect(Yii::app()->createUrl('user/changePassword'));
				} 			
			} //validate ends
		} //isset ends
		$this->render('changepassword',array('model'=>$model));
	}
}