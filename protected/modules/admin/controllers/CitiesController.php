<?php

class CitiesController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '/layouts/admin', meaning
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
				'actions'=>array('create','update','admin','delete','adminView'),
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
	public function actionCreate($id)
	{	
		$model=new Cities;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Cities']))
		{
			$model->attributes=$_POST['Cities'];
			$targetFolder = Yii::app()->request->baseUrl.'/uploads/cities/';
			if (!empty($_FILES['Cities']['name']['image'])) {
				$tempFile = $_FILES['Cities']['tmp_name']['image'];
				$targetPath	=	$_SERVER['DOCUMENT_ROOT'].$targetFolder;
				$targetFile = $targetPath.'/'.$_FILES['Cities']['name']['image'];
				$pat = $targetFile;
				move_uploaded_file($tempFile,$targetFile);
				$absoPath = $pat;
				$newName = time();
				$img = Yii::app()->imagemod->load($pat);
				# ORIGINAL
				$img->file_max_size = 5000000; // 5 MB
				$img->file_new_name_body = $newName;
				$img->process('uploads/cities/original/');
				$img->processed;
				#IF ORIGINAL IMAGE NOT LARGER THAN 5MB PROCESS WILL TRUE 	
				if ($img->processed) {
					#THUMB Image
					$img->image_resize      = true;
					$img->image_y         	= 500;
					$img->image_x           = 500;
					$img->file_new_name_body = $newName;
					$img->process('uploads/cities/large/');
					
					#STHUMB Image
					$img->image_resize      = true;
					$img->image_y         	= 100;
					$img->image_x           = 100;
					$img->file_new_name_body = $newName;
					$img->process('uploads/cities/small/');
			 
					$fileName	=	$img->file_dst_name;
					$img->clean();
	
				}
				$model->image	=	$fileName;
			}
			if($model->save())
				$this->redirect(array('adminView','id'=>$model->states_id));
		}

		$this->render('form',array('model'=>$model,'id'=>$id));
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

		if(isset($_POST['Cities']))
		{
			$model->attributes=$_POST['Cities'];
					$targetFolder = Yii::app()->request->baseUrl.'/uploads/cities/';
				if (!empty($_FILES['Cities']['name']['image'])) {
					$tempFile = $_FILES['Cities']['tmp_name']['image'];
					$targetPath	=	$_SERVER['DOCUMENT_ROOT'].$targetFolder;
					$targetFile = $targetPath.'/'.$_FILES['Cities']['name']['image'];
					$pat = $targetFile;
					move_uploaded_file($tempFile,$targetFile);
					$absoPath = $pat;
					$newName = time();
					$img = Yii::app()->imagemod->load($pat);
					# ORIGINAL
					$img->file_max_size = 5000000; // 5 MB
					$img->file_new_name_body = $newName;
					$img->process('uploads/cities/original/');
					$img->processed;
					#IF ORIGINAL IMAGE NOT LARGER THAN 5MB PROCESS WILL TRUE 	
				if ($img->processed) {
						#THUMB Image
						$img->image_resize      = true;
						$img->image_y         	= 500;
						$img->image_x           = 500;
						$img->file_new_name_body = $newName;
						$img->process('uploads/cities/large/');
						
						#STHUMB Image
						$img->image_resize      = true;
						$img->image_y         	= 100;
						$img->image_x           = 100;
						$img->file_new_name_body = $newName;
						$img->process('uploads/cities/small/');
				 
					 
					$fileName	=	$img->file_dst_name;
					$img->clean();
	
				}
				$model->image	=	$fileName;
				if($_POST['Cities']['oldImage']!=''){
					@unlink($targetFolder1.'original/'.$_POST['Cities']['oldImage']);
					@unlink($targetFolder1.'large/'.$_POST['Cities']['oldImage']);
					@unlink($targetFolder1.'small/'.$_POST['Cities']['oldImage']);
			 
				}
			}
			else
				$model->image	=	$_POST['Cities']['oldImage'];
			if($model->save())
				$this->redirect(array('adminView','id'=>$model->states_id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		GenerateGudaakIds::model()->deleteAllByAttributes(array('cities_id'=>$id));
		Institutes::model()->deleteAllByAttributes(array('cities_id'=>$id));
		
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
		$dataProvider=new CActiveDataProvider('Cities');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Cities('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Cities']))
			$model->attributes=$_GET['Cities'];

		$this->render('admin2',array(
			'model'=>$model,
		));
	}
	public function actionAdminView()
	{
		$id	=	$_REQUEST['id'];
		$model=new Cities('search');
		if(isset($id))
			$model->states_id=$id;  // clear any default values
		if(isset($_GET['Cities']))
			$model->attributes=$_GET['Cities'];

		$this->render('admin',array(
			'model'=>$model,'id'=>$id
		));
	}
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Cities the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Cities::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Cities $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='cities-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}