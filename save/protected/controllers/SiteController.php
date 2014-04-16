<?php
class SiteController extends Controller
{
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

	/**
	 * This is the pre load function 
	 * 
	 */
	public function beforeAction($action) 
	{
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
		
		$this->render('index');
	}	
	public function actionIndex2()
	{
		
		$this->render('index2');
	}
	public function actionIndex3()
	{
		
		$this->render('index3');
	}
	public function actionIndex4()
	{
		
		$this->render('index4');
	}
	public function actionWhat()
	{	
		
		$this->render('_whatGudaak');
	
	}
	public function actionWhy()
	{	
		$this->render('_whyGudaak');
	
	}
	public function actionArticles(){
		$criteria			=	new CDbCriteria();
		$criteria->condition= '(published =:published and status =:status )';
		$criteria->params 	= array('published'=>1,'status'=>1);
		$count				=	Articles::model()->count($criteria);
		$pages				=	new CPagination($count);
		$pages->pageSize	=	5;
		$pages->applyLimit($criteria);
		$articles			=	Articles::model()->findAll($criteria);
		
		$this->render('articals',array('articles'=>$articles,'pages'=>$pages));
	}
	
	public function actionArticle($id)
	{	
		$result				=	 Articles::model()->findByAttributes(array('id'=>$id));
		
		$this->render('article',array('articles'=>$result));
	}
	/**
	 * This is the Register  User 'userRegister' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
 
	public function actionAutoCompleteLookup()
	{  
		$getId = '';
		if(!empty($_POST['Register']['gudaak_id'])) {
			$getId	 		= $_POST['Register']['gudaak_id'];
			$record_exists	= GenerateGudaakIds::model()->exists('gudaak_id  = :gudaak ', array(':gudaak'=>$getId ));
			$gudaakId		=	GenerateGudaakIds::model()->findByAttributes(array('gudaak_id'=>$getId));	
			if($record_exists==1 AND $getId !='' ){
				$findGudakID			=	UserProfiles::model()->exists('generate_gudaak_ids_id= :GDK ', array(':GDK'=>$gudaakId->id)); 
				if($findGudakID==1){
					$response	=	array();
					$response['status']=0;
					$response['data']='Gudaak ID already in use';
					echo json_encode($response); 
					die;
				}
				else{
					$dataR	=	UserClass::model()->findAll('orderBy =:orderBy',array(':orderBy'=>(int) $gudaakId->user_role_id));
					$data	=	CHtml::listData($dataR,'id','title');
					
					$classes	=	array();
					$response	=	array();
					$response['status']=1;
					$response['data']='';
					foreach($data as $value=>$name){
						$response['data'].=CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
					}
					foreach($dataR as $aa){
						$classes[]=$aa->id;
					}
					$response['medium']='';	
					$medimumR	=	UserAcademicMedium::model()->findAllByAttributes(array('user_class_id'=>$classes));
					$medimum	=	CHtml::listData($medimumR,'id','title');
					foreach($medimum as $value=>$name){
						$response['medium'].=CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
					}
					echo json_encode($response); 
					die;
				}
			}
			else{
				$response	=	array();
				$response['status']=0;
				$response['data']='Please fill correct Gudaak Id';
				echo json_encode($response); 
				die;
			}
		}
	}
	public function actionUserRegister()
	{	
		$this->layout='//layouts/main2';
		if(Yii::app()->user->id){
			$this->redirect(array('site/'));
		}
		$model	=	new Register;
		if(isset($_POST['Register']))
		{	
			$model->attributes		=	$_POST['Register'];
			$model->display_name	=	$model->first_name.' '.$model->last_name;
			$model->image			=	'noimage.jpg';
			$model->user_class_id	=	$_POST['Register']['class'];
			$model->user_academic_id=	$_POST['Register']['medium'];
			$gender					=	$_POST['Register']['gender'];
			if($gender==1){
			$model->gender			=	'Male';
			}
			if($gender==0){
			$model->gender			=	'Female';
			}
			if($model->user_class_id==1||$model->user_class_id==2||$model->user_class_id==3){
			$userRole				=	2;
			}
			if($model->user_class_id==4||$model->user_class_id==5){
			$userRole				=	3;
			}
			$model->add_date		=	date('Y-m-d H:i:s');
			$model->semd_mail		=	1;
			$gudaak_id				=	$_POST['Register']['gudaak_id'];
			$record_exists = GenerateGudaakIds::model()->exists('gudaak_id  = :gudaak ', array(':gudaak'=>$gudaak_id )); 
			$gudaakId	=	GenerateGudaakIds::model()->findByAttributes(array('gudaak_id'=>$gudaak_id));
			if($record_exists==1 AND $gudaak_id !='' ){
				$userC					=   UserLogin::model()->exists('username = :email',array(':email'=>$_POST['Register']['email']));
				if($userC==1){
				
						Yii::app()->user->setFlash('create','Email address is already in use.');
						$this->redirect(array('site/userRegister'));
				}
				$findGudakID			=	UserProfiles::model()->exists('generate_gudaak_ids_id= :GDK ', array(':GDK'=>$gudaakId->id)); 
				if($findGudakID==1){
				
						Yii::app()->user->setFlash('create','Gudaak ID already in use.');
						$this->redirect(array('site/userRegister'));
				}
				else{
					$user					= new  UserLogin();
					$user->username			=	$_POST['Register']['email'];
					$user->password			=	md5($_POST['Register']['password']);
					$user->add_date			=	date('Y-m-d H:i:s');
					$user->block			=	0;
					$Uclass					=	$_POST['Register']['class'];
					$user->activation		=	0;
					$user->user_role_id		=	$userRole;
					$model->user_login_id	=	1;
					$model->generate_gudaak_ids_id	=	1;
					$valid					=	$model->validate();
					$valid					=	$user->validate() && $valid;
					if($valid){
						if($user->save()){
							
							$model->user_login_id			=	$user->id;
							$model->generate_gudaak_ids_id	=	$gudaakId->id;
							
							if($model->save()){
								 
								//Start  mail Function 
								$data['name']		=	$model->display_name;
								$data['email']		=	$user->username;
								$data['password']	=	$user->password;
								$data['code']	=	$this->createAbsoluteUrl('site/checkUser',array('email'=>base64_encode($user->username)));
								$this->sendMail($data,'register');
								//End  mail Function  
								Yii::app()->user->setFlash('create','Thank you for join us check your email and activate your account.');
								$this->redirect(array('site/userRegister'));
								die;
							}
							else {
									
								Yii::app()->user->setFlash('error','Please fill up carefully all field are mandatory.');
								$this->redirect(array('site/userRegister'));
								die;
							}
						}
					}
				}
			}
			else{
					Yii::app()->user->setFlash('create','Please fill accurate information.');
					$this->redirect(array('site/userRegister'));
			}		
		}	
		$this->render('userRegister',array('model'=>$model));
	}
	public function actionCheckUser($email)
	{	
		$user		=	base64_decode($email);
		$record_exists = UserLogin::model()->exists('username = :email', array(':email'=>$user));   				
		if($record_exists==1){ 
			$record = UserLogin::model()->findByAttributes(array('username'=>$user)); 
			$record->activation	=	1;
			if($record->save()){
				Yii::app()->user->setFlash('login','Thank you for join us your account is activated.');
				$this->redirect(array('site/login'));
			
			}
			 
		}else{
		
			Yii::app()->user->setFlash('create','Not record found.');
			$this->redirect(array('site/userRegister'));
		}
		
			
		
	}
	//Forgot password
	public function actionForgetPassword()
	{	$this->layout='//layouts/main2';
		$model=new ForgotpasswordForm;
		if(isset($_POST['ForgotpasswordForm'])){
			$model->attributes=$_POST['ForgotpasswordForm'];
			if($model->validate()){
				//Searches for the record in the database for the posted email 
				$record_exists = UserLogin::model()->exists('username = :email', array(':email'=>$_POST['ForgotpasswordForm']['email']));   				
				if($record_exists==1){
					$record = UserLogin::model()->findByAttributes(array('username'=>$_POST['ForgotpasswordForm']['email'])); 
					//Generates a random number  
					$random_number = rand(99999,9999999);
					/*  Actual Code to be used  */
				  	$new_password = md5($random_number);
						UserLogin::model()->updateAll(array('password'=>$new_password),'id="'.$record->id.'"');
					//Start  mail Function 
						$data['name']		=	'Dear user';
						$data['email']		=	$record->username;
						$data['password']	=	$record->password;
						$this->sendMail($data,'forget'); 
						Yii::app()->user->setFlash('new_password_message','Your new password has been sent to your email address.');
						$this->refresh();
				 		Yii::app()->user->setFlash('new_password_message',"Sorry mail could not be sent this time!Please try again.");					
					}
				else{
						Yii::app()->user->setFlash('error',"The details provided by you does not match our records!");
				}
			} //validate ends
		}
		$this->render('forgetPassword', array('model'=>$model));
		
	}
	
	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{	
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
		
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{	$this->layout='//layouts/main2';
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$model->email}>\r\n".
					"Reply-To: {$model->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-Type: text/plain; charset=UTF-8";

				mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}
	
	public function actionAbout()
	{
		
		$this->render('about');
	}
	public function actionStudents()
	{
		
		$this->render('features');
	}
	public function actionSchools()
	{
		
		$this->render('schoolsFeatures');
	}
	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{	$this->layout='//layouts/main2';
		$model=new LoginForm;
		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
		
		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			if($model->login()){
				if(isset(Yii::app()->user->userType)){
					if(Yii::app()->user->userType=='admin'){
						$this->redirect(Yii::app()->createUrl('/admin/admin'));
					}
					if(Yii::app()->user->userType=='school'){
						$this->redirect(Yii::app()->createUrl('/school/'));
					}
					if(Yii::app()->user->userType=='counsellor'){
						$this->redirect(Yii::app()->createUrl('/counsellor/'));
					}
					if(Yii::app()->user->userType=='upper11th'|| Yii::app()->user->userType=='below10th'){
						$this->redirect(Yii::app()->createUrl('/user/'));
					}
					
				}
				else{
					Yii::app()->user->setFlash('login','Email or password not valid.');
					}
			}
			else{
				Yii::app()->user->setFlash('login','Email or password not valid.');
				$this->redirect(Yii::app()->createUrl('/site/login'));
			}
			
		}
		
		$this->render('login',array('model'=>$model));
	}
	
	/**
	 * Logs out the current user and redirect to homepage.
	 */
	 
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
	public function sendMail($data,$type)
	{
		switch($type){
			case 'contact':
				$subject = 'Contact Us';
				$body = $this->renderPartial('/mails/contact_tpl',
										array('name' => $data['name']), true);
			break;
			case 'forget':
				$subject = 'Forgot Password';
				$body = $this->renderPartial('/mails/forgot_tpl',
										array(	'name' => $data['name'],
												'email'=>$data['email'],
												'password'=>$data['password']), true);
			break;
			case 'register':
				$subject = 'Register';
				$body = $this->renderPartial('/mails/register_tpl',
										array(	'name' => $data['name'],
												'email'=>$data['email'],
												'code'=>$data['code'],
												'password'=>$data['password']), true);
			break;
			default:
			break;			
		}
		$from		=	Yii::app()->params['adminEmail'];
		$to			=	$data['email'];
		$mail		=	Yii::app()->Smtpmail;
        $mail->SetFrom($from,'Gudaak');
        $mail->Subject	=	$subject;
        $mail->MsgHTML($body);
        $mail->AddAddress($to, "");		
        if(!$mail->Send()) {
           echo 'No';die; return 0;
        }else {
			return 1;
        }
	}
}