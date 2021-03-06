<?php

class StreamController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='/layouts/admin';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','admin','delete'),
				'expression' =>"Yii::app()->user->userType ==  'admin'",
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Stream;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Stream']))
		{
			$model->attributes=$_POST['Stream'];
			$targetFolder = Yii::app()->request->baseUrl.'/uploads/stream/';
			if (!empty($_FILES['Stream']['name']['image'])) {
				$tempFile = $_FILES['Stream']['tmp_name']['image'];
				$targetPath	=	$_SERVER['DOCUMENT_ROOT'].$targetFolder;
				$targetFile = $targetPath.'/'.$_FILES['Stream']['name']['image'];
				$pat = $targetFile;
				move_uploaded_file($tempFile,$targetFile);
				$absoPath = $pat;
				$newName = time();
				$img = Yii::app()->imagemod->load($pat);
				# ORIGINAL
				$img->file_max_size = 5000000; // 5 MB
				$img->file_new_name_body = $newName;
				$img->process('uploads/stream/original/');
				$img->processed;
				#IF ORIGINAL IMAGE NOT LARGER THAN 5MB PROCESS WILL TRUE 	
				if ($img->processed) {
					#THUMB Image
					$img->image_resize      = true;
					$img->image_y         	= 304;
					$img->image_x           = 304;
					$img->file_new_name_body = $newName;
					$img->process('uploads/stream/large/');
					
					#STHUMB Image
					$img->image_resize      = true;
					$img->image_y         	= 115;
					$img->image_x           = 265;
					$img->file_new_name_body = $newName;
					$img->process('uploads/stream/small/');
				 
					$fileName	=	$img->file_dst_name;
					$img->clean();
	
				}
				$model->image	=	$fileName;
			}
			if($model->save()){
				if(!empty($_POST['Stream']['subjects']))
				foreach($_POST['Stream']['subjects'] as $subject=>$val){
					if($val){
						$modl				=	new StreamHasSubjects;
						$modl->subjects_id	=	$subject;
						$modl->stream_id	=	$model->id;
						$modl->type_subjects=	$_POST['subjects'][$subject];
						$modl->add_date		=	date('Y-m-d H:i:s');
						$modl->status		=	1;
						$modl->save();
					}
				}
				
				$this->redirect(array('view','id'=>$model->id));
			}
		}
		$subjectList		=	array();
		$subjectListType	=	array();
		foreach($model->streamHasSubjects as $sub){
			$subjectList[]	=	$sub->subjects_id;
			if($sub->type_subjects=='compulsory')
				$subjectListType[]	=	$sub->subjects_id;
		}
		$this->render('create',array(
			'model'=>$model,'subjectList'=>$subjectList,'subjectListType'=>$subjectListType
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Stream']))
		{
			$model->attributes=$_POST['Stream'];
			$targetFolder1 = rtrim($_SERVER['DOCUMENT_ROOT'],'/').Yii::app()->request->baseUrl.'/uploads/stream/';
					$targetFolder = Yii::app()->request->baseUrl.'/uploads/stream/';
				if (!empty($_FILES['Stream']['name']['image'])) {
					$tempFile = $_FILES['Stream']['tmp_name']['image'];
					$targetPath	=	$_SERVER['DOCUMENT_ROOT'].$targetFolder;
					$targetFile = $targetPath.'/'.$_FILES['Stream']['name']['image'];
					$pat = $targetFile;
					move_uploaded_file($tempFile,$targetFile);
					$absoPath = $pat;
					$newName = time();
					$img = Yii::app()->imagemod->load($pat);
					# ORIGINAL
					$img->file_max_size = 5000000; // 5 MB
					$img->file_new_name_body = $newName;
					$img->process('uploads/stream/original/');
					$img->processed;
					#IF ORIGINAL IMAGE NOT LARGER THAN 5MB PROCESS WILL TRUE 	
				if ($img->processed) {
					#THUMB Image
					$img->image_resize      = true;
					$img->image_y         	= 304;
					$img->image_x           = 304;
					$img->file_new_name_body = $newName;
					$img->process('uploads/stream/large/');
					
					#STHUMB Image
					$img->image_resize      = true;
					$img->image_y         	= 115;
					$img->image_x           = 265;
					$img->file_new_name_body = $newName;
					$img->process('uploads/stream/small/');
					
					 
					$fileName	=	$img->file_dst_name;
					$img->clean();
	
				}
				$model->image	=	$fileName;
				if($_POST['Stream']['oldImage']!=''){
					@unlink($targetFolder1.'original/'.$_POST['Stream']['oldImage']);
					@unlink($targetFolder1.'large/'.$_POST['Stream']['oldImage']);
					@unlink($targetFolder1.'small/'.$_POST['Stream']['oldImage']);
				}
			}
			else
				$model->image	=	$_POST['Stream']['oldImage'];
				
			if($model->save()){
				StreamHasSubjects::model()->deleteAllByAttributes(array('stream_id'=>$model->id));
				if(!empty($_POST['Stream']['subjects']))
				foreach($_POST['Stream']['subjects'] as $subject=>$val){
					if($val){
						$modl				=	new StreamHasSubjects;
						$modl->subjects_id	=	$subject;
						$modl->stream_id	=	$model->id;
						$modl->type_subjects=	$_POST['subjects'][$subject];
						$modl->add_date		=	date('Y-m-d H:i:s');
						$modl->status		=	1;
						$modl->save();
					}
				}
				$this->redirect(array('view','id'=>$model->id));
			}
		}
		$subjectList	=	array();
		$subjectListType	=	array();
		foreach($model->streamHasSubjects as $sub){
			$subjectList[]	=	$sub->subjects_id;
			if($sub->type_subjects=='compulsory')
				$subjectListType[]	=	$sub->subjects_id;
		}
		$this->render('create',array(
			'model'=>$model,'subjectList'=>$subjectList,'subjectListType'=>$subjectListType
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Stream');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Stream('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Stream']))
			$model->attributes=$_GET['Stream'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Stream the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Stream::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Stream $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='stream-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
