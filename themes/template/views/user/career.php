<?php $this->pageTitle='Career Library'; $this->breadcrumbs=array('Career'=>array('user/career'));?>
	<div class="career-bot pull-left">
		<div class="mr0 pd0 col-md-12 fl">
			<div class="mr0  pull-left middle-format-left">
				<!--<h1>Career library</h1>-->
                <?php $this->widget('zii.widgets.CBreadcrumbs', array('homeLink'=>'Dashboard','links'=>$this->breadcrumbs,));?>
				<!--<p>It is long established fact a reader will be It is long established fact a reader will be
					It is long established fact a reader will be It is long established fact a reader will beIt is long established fact a reader will be
				</p>-->
				<?php //echo CHtml::Link('Konw more about Career Library',array(''),array('title'=>'Konw more about Career Library'));?>
			</div>
			
		</div>
		<div class="clear"></div>
		<div class="career-area fl">
		<div id="scrollBar" class="col-md-12" style="padding:7px">
			<?php $count=0;
			foreach($data	as $data){?>
				<div class="col-md-3 career-lib mb0">
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
						<h4>&nbsp;</h4>
                        <p><?php echo substr(strip_tags($data->description),0,100);?></p>
					<div class="col-md-12 career-hot-links">
					<?php echo CHtml::link(substr($data->title,0,100),array('user/careerList','id'=>''.$data->id.''),array('class'=>'pull-left','title'=>$data->title));?>
					<?php //echo CHtml::link('Read more..',array('user/readFull','id'=>''.$data->id.''),array('class'=>'pull-left','title'=>'Read Full.'));?>
						<!--<span class="pull-right"><i class="icon-eye-open"></i>19021</span>-->
					</div>
				</div>
				<?php $count++; if($count%4==0){ ?>
				<div class="clear"></div>
			<?php } ?>
				
				 
		
			<?php }?>
		</div>
	</div>
</div>
	<div class="news pd0 fl">
		<?php  $this->Widget('WidgetNews'); ?>
	</div>
			
	
			