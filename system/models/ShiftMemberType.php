<?php
Class ShiftMemberType extends Model
{

	public $soft_delete = false;

	public $hasMany = array('ShiftMember');

	public $required = array('name');

	public $rules = array(
		'id' => array('numeric','maxLength' =>11),
		'name' => array('alphaNumeric','maxLength' =>250)
		);


}