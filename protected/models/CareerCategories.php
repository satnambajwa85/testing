<?php

/**
 * This is the model class for table "career_categories".
 *
 * The followings are the available columns in table 'career_categories':
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property string $image
 * @property string $add_date
 * @property integer $published
 * @property integer $status
 *
 * The followings are the available model relations:
 * @property Career[] $careers
 * @property CareerAssessment[] $careerAssessments
 * @property Questions[] $questions
 * @property UserScores[] $userScores
 */
class CareerCategories extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'career_categories';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title', 'required'),
			array('published, status', 'numerical', 'integerOnly'=>true),
			array('title', 'length', 'max'=>350),
			array('image', 'length', 'max'=>45),
			array('description, add_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, title, description, image, add_date, published, status', 'safe', 'on'=>'search'),
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
			'careers' => array(self::HAS_MANY, 'Career', 'career_categories_id'),
			'careerAssessments' => array(self::HAS_MANY, 'CareerAssessment', 'career_categories_id'),
			'questions' => array(self::HAS_MANY, 'Questions', 'career_categories_id'),
			'userScores' => array(self::HAS_MANY, 'UserScores', 'career_categories_id'),
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
			'description' => 'Description',
			'image' => 'Image',
			'add_date' => 'Add Date',
			'published' => 'Published',
			'status' => 'Status',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('image',$this->image,true);
		$criteria->compare('add_date',$this->add_date,true);
		$criteria->compare('published',$this->published);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array(
				'defaultOrder'=>'add_date DESC',
			),
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CareerCategories the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
