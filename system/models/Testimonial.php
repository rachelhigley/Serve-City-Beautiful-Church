<?php
Class Testimonial extends Model
{
	public $soft_delete = false;

	public $belongsTo = array('Team');

	public $required = array('team_id','content');

	public $rules = array(
		'id' => array('numeric','maxLength' =>11),
		'team_id' => array('numeric','maxLength' =>11),
		'name' => array('alphaNumeric','maxLength' =>250),
		'photo' => array('alphaNumeric','maxLength' =>250),
		'content' => array()
		);


}