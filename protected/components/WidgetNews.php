<?php
class WidgetNews extends CWidget
{
   public $visible=true;
 
   public function init()
   {
       if($this->visible)
       {

       }
   }

   public function run()
   {
       if($this->visible)
       {
           $this->renderContent();
       }
   }  
   protected function renderContent()
   	{
	 	$criteria			=	new CDbCriteria();
		$criteria->condition=	'(published =:published and status =:status )';
		$criteria->params 	=	array('published'=>1,'status'=>1);
		$criteria->order	=	'add_date DESC';
			
		$count				=	News::model()->count($criteria);
		$pages				=	new CPagination($count);
		$pages->pageSize	=	10;
		$pages->applyLimit($criteria);
		$news				=	News::model()->findAll($criteria);
		$this->render('widgetNews',array('pages'=>$pages,'news'=>$news));
	}  

}