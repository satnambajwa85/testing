<?php

/**
 * This is the model class for table "orient_items".
 *
 * The followings are the available columns in table 'orient_items':
 * @property integer $id
 * @property string $title
 * @property string $alias
 * @property string $description
 * @property string $test_features
 * @property string $test_faqs
 * @property string $image
 * @property string $video_link
 * @property string $add_date
 * @property integer $published
 * @property integer $status
 * @property integer $orient_categories_id
 *
 * The followings are the available model relations:
 * @property OrientCategories $orientCategories
 * @property Questions[] $questions
 * @property UserReports[] $userReports
 * @property UserTests[] $userTests
 */
class OrientItems extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return OrientItems the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'orient_items';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, alias, description, orient_categories_id', 'required'),
			array('published, status, orient_categories_id', 'numerical', 'integerOnly'=>true),
			array('title, alias', 'length', 'max'=>500),
			array('image', 'length', 'max'=>45),
			array('video_link', 'length', 'max'=>300),
			array('test_features, test_faqs, add_date', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, title, alias, description, test_features, test_faqs, image, video_link, add_date, published, status, orient_categories_id', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'orientCategories' => array(self::BELONGS_TO, 'OrientCategories', 'orient_categories_id'),
			'questions' => array(self::HAS_MANY, 'Questions', 'orient_items_id'),
			'userReports' => array(self::HAS_MANY, 'UserReports', 'orient_items_id'),
			'userTests' => array(self::HAS_MANY, 'UserTests', 'orient_items_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => 'Title',
			'alias' => 'Alias',
			'description' => 'Description',
			'test_features' => 'Test Features',
			'test_faqs' => 'Test Faqs',
			'image' => 'Image',
			'video_link' => 'Video Link',
			'add_date' => 'Add Date',
			'published' => 'Published',
			'status' => 'Status',
			'orient_categories_id' => 'Orient Categories',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('alias',$this->alias,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('test_features',$this->test_features,true);
		$criteria->compare('test_faqs',$this->test_faqs,true);
		$criteria->compare('image',$this->image,true);
		$criteria->compare('video_link',$this->video_link,true);
		$criteria->compare('add_date',$this->add_date,true);
		$criteria->compare('published',$this->published);
		$criteria->compare('status',$this->status);
		$criteria->compare('orient_categories_id',$this->orient_categories_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array(
				'defaultOrder'=>'add_date DESC',
			),
		));
	}
}