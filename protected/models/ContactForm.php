<?php

/**
 * ContactForm class.
 * ContactForm is the data structure for keeping
 * contact form data. It is used by the 'contact' action of 'SiteController'.
 */
class ContactForm extends CFormModel
{
	public $name;
	public $email;
	
	public $institution;
	public $designation;
	public $phone;
	
	
	public $subject;
	public $body;
	public $verifyCode;

	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			// name, email, subject and body are required
			array('name, email, phone, institution,designation,body', 'required'),
			// email has to be a valid email address
			array('email', 'email'),
			array('phone', 'numerical'),
			// verifyCode needs to be entered correctly
			array('designation', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * Declares customized attribute labels.
	 * If not declared here, an attribute would have a label that is
	 * the same as its name with the first letter in upper case.
	 */
	public function attributeLabels()
	{
		return array(
			'verifyCode'=>'Verification Code',
			'institution'=>'Name of Institution',
			'designation'=>'Designation',
		);
	}
}