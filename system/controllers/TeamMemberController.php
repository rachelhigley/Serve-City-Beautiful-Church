<?php
/**
 * The TeamMember Controller
 */

/**
 * The TeamMember Controller
 * @category   Controllers
 * @package    Serve | City Beautiful Church
 * @subpackage Controllers
 * @author     Rachel Higley
 */
 Class TeamMemberController extends Controller
{
	/**
	 * Get all the TeamMembers
	 * @return array all the TeamMembers
	 */
	public function index($id=NULL)
	{

		// load the model
		$this->loadModel("TeamMember");

		// only get this table
		$this->TeamMember->options['recursive'] = 0;

		if($id) {
			// get all the TeamMembers for a member
			$team_members = $this->TeamMember->findByMemberId($id);
		}

		else {
			// get all the TeamMembers
			$team_members = $this->TeamMember->findAll($id);
		}

		//set the success
		$this->view_data('success',$this->TeamMember->success);

		// if the call was successful
		if($this->TeamMember->success)
		{

			// set the information for the view
			$this->view_data("team_members",$team_members);

			// return the information
			return $team_members;

		}

		return false;
	}
	/**
	 * Get one TeamMember
	 * @param  int the id of the TeamMember to get
	 * @return one TeamMember
	*/
	public function get($id)
	{
		if($id)
		{

			// load the model
			$this->loadModel("TeamMember");

			// only ge the member table
			$this->TeamMember->belongsTo = array("Member");

			// only get this table
			$this->TeamMember->options['recursive'] = 1;

			$this->TeamMember->options['fields'] = array("TeamMember"=>array("id"),"Member"=>array("id","email"));

			// get all the TeamMembers
			$team_members = $this->TeamMember->findByTeamId($id);


			//set the success
			$this->view_data('success',$this->TeamMember->success);

			// if the call was successful
			if($this->TeamMember->success)
			{

				// set the information for the view
				$this->view_data("team_members",$team_members);

				// return the information
				return $team_members;
			}
			return false;
		}

	}
	/**
	 * Create new TeamMember
	 * @param  array $team_member all the information to save
	 * @return boolean if it was successfull
	 */
	public function post($team_member=NULL)
	{
		//if information was sent
		if($team_member)
		{
			// load the model
			$this->loadModel("TeamMember");

			// save the new TeamMember
			$this->TeamMember->save($team_member);

			// set the success
			$this->view_data("success",$this->TeamMember->success);

			if(!$this->TeamMember->success) $this->view_data("errors",$this->TeamMember->error);
			else 	header("Location: ".$_SERVER['HTTP_REFERER']);
			// return the success
			return $this->TeamMember->success;
		}
	}
	/**
	 * Update a TeamMember
	 * @param  array $team_member all the information to update, including id
	 * @return boolean if it was successfull
	 */
	public function update($team_member_id=NULL,$team_member=NULL)
	{

		// if information was sent
		if($team_member)
		{
			// load the model
			$this->loadModel("TeamMember");

			// save the new TeamMember
			$this->TeamMember->save($team_member);

			// set the success
			$this->view_data("success",$this->TeamMember->success);

			// if the save was not successful
			if(!$this->TeamMember->success)
			{
				// set the errors
				$this->view_data("errors",$this->TeamMember->error);
			}
		}

		// if there is an id
		if($team_member_id)
		{

			// get a TeamMember
			$this->get($team_member_id);

		}


	}
	/**
	 * Delete a TeamMember
	 * @param  int $team_member_id id of the TeamMember to delete
	 * @return boolean if it was successfull
	 */
	public function delete($team_member_id=NULL)
	{
		// if there was an id sent
		if($team_member_id)
		{

			// load the model
			$this->loadModel("TeamMember");

			// save the new TeamMember
			$this->TeamMember->delete($team_member_id);

			// set the success
			$this->view_data("success",$this->TeamMember->success);

			// return the success
			$this->TeamMember->success;

		}
	}

	public function available($info)
	{

		// load the group model
		$this->loadModel("Grouping");

		// on get this table
		$this->Grouping->options['recursive'] = 0;

		// only get the id and name
		$this->Grouping->options['fields'] = array("Grouping"=>array("id","name"));

		// get the group names
		$group_names = $this->Grouping->findAll();

		// set the teams for the view
		$this->view_data("group_names",$group_names);

		$timestamp = strtotime($info['date']);

		$info['start_date'] = date('m/01/y', $timestamp);

		$info['end_date'] = date('m/t/y', $timestamp);

		switch ($info['date']) {
			case date("m/d/y",strtotime("First Sunday of ".date('F',$timestamp))):
				$info['week_id'] = 1;
				break;
			case date("m/d/y",strtotime("Second Sunday of ".date('F',$timestamp))):
				$info['week_id'] = 2;
				break;
			case date("m/d/y",strtotime("Third Sunday of ".date('F',$timestamp))):
				$info['week_id'] = 3;
				break;
			case date("m/d/y",strtotime("Fourth Sunday of ".date('F',$timestamp))):
				$info['week_id'] = 4;
				break;
			case date("m/d/y",strtotime("Fifth Sunday of ".date('F',$timestamp))):
				$info['week_id'] = 5;
				break;
		}

		$this->loadModel('TeamMember');

		// recommended membrs
		$rec = $this->_get_recommended($info);

		$this->view_data('recommened', $rec);

		// members who are already serving
		$serving = $this->_get_serving($info);

		$this->view_data('serving',$serving);

		// members who don't like this sunday
		$sunday = $this->_get_sunday($info);

		$this->view_data('sunday',$sunday);

		// members who have reached there max number of sundays
		$max = $this->_get_max($info);

		$this->view_data('max',$max);

		// members who have been archived
		$archived = $this->_get_archived($info);

		$this->view_data('archived',$archived);

		// members who have invitations are pending
		$pending = $this->_get_pending($info);

		$this->view_data("pending",$pending);

		// members who have invitations are declined
		$declined = $this->_get_declined($info);

		$this->view_data("declined",$declined);

		// set the information of this shift
		$this->view_data('date',$info['date']);

		$this->view_data('shift_id',$info['shift_id']);

		if(isset($info['team_name']))
		{
			$this->view_data('team_name',$info['team_name']);
		}

		$this->view_data('time',$info['time']);

		if(isset($info['group']))
		{
			$this->view_data('current_group',$info['group']);
		}

		return array("recommened"=>$rec,"serving"=>$serving,"sunday"=>$sunday,"max"=>$max,"archived"=>$archived);

	}

	private function _get_recommended($info)
	{
		$this->TeamMember->options['fields'] = array("Member"=>array("id","name","email","phone","profile_pic","times","facebook_id"));
		$this->TeamMember->options['recursive'] = 1;
		$this->TeamMember->belongsTo = array("Member");
		$this->TeamMember->options['joins'] = array(array("MemberWeek","Member"));
		$this->TeamMember->options['where'] = array(
			"Member.times > (SELECT COUNT(*) from (SELECT DISTINCT shift_member.member_id, date.id from shift_member JOIN shift on shift.id = shift_member.shift_id JOIN date on date.id = shift.date_id WHERE date.date BETWEEN '".$info['start_date']."' AND '".$info['end_date']."' AND shift_member.shift_member_type_id <> 4) dates  WHERE dates.member_id = TeamMember.member_id)",
			"MemberWeek.week_id in (".$info['week_id'].",6)",
			"TeamMember.team_member_type_id !=  4",
			"TeamMember.member_id NOT IN (SELECT shift_member.member_id from shift_member JOIN shift on shift.id = shift_member.shift_id WHERE shift.date_id = ".$info['date_id']."  AND shift_member.shift_member_type_id <> 4)"
		);
		$this->TeamMember->options['addToEnd'] = "GROUP BY TeamMember.id";
		if(isset($info['group']))
		{
			array_push($this->TeamMember->options['joins'],array("GroupingMember","Member"));
			array_push($this->TeamMember->options['where'], "GroupingMember.grouping_id = ".$info['group']);
		}

		$members = $this->TeamMember->findByTeamId($info['team_id']);

		if($members) return $members;

		return false;
	}

	private function _get_serving($info)
	{
		$this->TeamMember->options['fields'] = array("Member"=>array("id","name","email","phone","profile_pic","times","facebook_id"),"Team"=>array("id","name"),"Shift"=>array("id","time","team_id"),"TeamMember"=>array('id'));
		$this->TeamMember->options['recursive'] = 3;
		$this->TeamMember->hasMany = array();
		$this->TeamMember->belongsTo = array("Member");
		$this->TeamMember->options['joins'] = array(array("MemberWeek","Member"),array('ShiftMember','Member'),array('ShiftMember','Shift','LEFT',true),array('Shift','Team','LEFT',true));
		$this->TeamMember->options['where'] = array(
			"MemberWeek.week_id in (".$info['week_id'].",6)",
			"TeamMember.team_member_type_id !=  4",
			"TeamMember.member_id IN ( SELECT shift_member.member_id from shift_member JOIN shift on shift.id = shift_member.shift_id WHERE shift.date_id = ".$info['date_id']." AND shift_member.member_id NOT IN (SELECT member_id from shift_member WHERE shift_member.shift_id = ".$info['shift_id'].") AND shift_member.shift_member_type_id <> 4)",
			"date_id"=>array($info['date_id'],"Shift")
		);
		$this->TeamMember->options['key'] = array("Team"=>"id");

		if(isset($info['group']))
		{
			array_push($this->TeamMember->options['joins'],array("GroupingMember","Member"));
			array_push($this->TeamMember->options['where'], "GroupingMember.grouping_id = ".$info['group']);
		}

		$members = $this->TeamMember->findByTeamId($info['team_id']);

		if($members) return $members;

		return false;
	}

	private function _get_sunday($info)
	{
		$this->TeamMember->options['fields'] = array("Member"=>array("id","name","email","phone","profile_pic","times","facebook_id"));
		$this->TeamMember->options['recursive'] = 1;
		$this->TeamMember->belongsTo = array("Member");
		$this->TeamMember->options['joins'] = array(array("MemberWeek","Member"));
		$this->TeamMember->options['where'] = array(
			"Member.times > (SELECT COUNT(*) from (SELECT DISTINCT shift_member.member_id, date.id from shift_member JOIN shift on shift.id = shift_member.shift_id JOIN date on date.id = shift.date_id WHERE date.date BETWEEN '".$info['start_date']."' AND '".$info['end_date']."' AND shift_member.shift_member_type_id <> 4) dates  WHERE dates.member_id = TeamMember.member_id)",
			"TeamMember.member_id NOT IN (SELECT member_id from member_week WHERE member_week.member_id = TeamMember.member_id AND member_week.week_id IN (".$info['week_id'].",6))",
			"TeamMember.team_member_type_id !=  4",
			"TeamMember.member_id NOT IN (SELECT shift_member.member_id from shift_member JOIN shift on shift.id = shift_member.shift_id WHERE shift.date_id = ".$info['date_id']." AND shift_member.shift_member_type_id <> 4)"
		);
		$this->TeamMember->options['addToEnd'] = "GROUP BY TeamMember.id";
		if(isset($info['group']))
		{
			array_push($this->TeamMember->options['joins'],array("GroupingMember","Member"));
			array_push($this->TeamMember->options['where'], "GroupingMember.grouping_id = ".$info['group']);
		}

		$members = $this->TeamMember->findByTeamId($info['team_id']);

		if($members) return $members;

		return false;
	}

	private function _get_max($info)
	{
		$this->TeamMember->options['fields'] = array("Member"=>array("id","name","email","phone","profile_pic","times","facebook_id"));
		$this->TeamMember->options['recursive'] = 1;
		$this->TeamMember->belongsTo = array("Member");
		$this->TeamMember->options['joins'] = array(array("MemberWeek","Member"));
		$this->TeamMember->options['where'] = array(
			"Member.times <= (SELECT COUNT(*) from (SELECT DISTINCT shift_member.member_id, date.id from shift_member JOIN shift on shift.id = shift_member.shift_id JOIN date on date.id = shift.date_id WHERE date.date BETWEEN '".$info['start_date']."' AND '".$info['end_date']."' AND shift_member.shift_member_type_id <> 4) dates  WHERE dates.member_id = TeamMember.member_id)",
			"MemberWeek.week_id IN (".$info['week_id'].",6)",
			"TeamMember.team_member_type_id !=  4",
			"TeamMember.member_id NOT IN (SELECT shift_member.member_id from shift_member JOIN shift on shift.id = shift_member.shift_id WHERE shift.date_id = ".$info['date_id']." AND shift_member.shift_member_type_id <> 4)"
		);
		$this->TeamMember->options['addToEnd'] = "GROUP BY TeamMember.id";
		if(isset($info['group']))
		{
			array_push($this->TeamMember->options['joins'],array("GroupingMember","Member"));
			array_push($this->TeamMember->options['where'], "GroupingMember.grouping_id = ".$info['group']);
		}

		$members = $this->TeamMember->findByTeamId($info['team_id']);

		if($members) return $members;

		return false;
	}
	private function _get_archived($info)
	{

		$this->TeamMember->options['fields'] = array("Member"=>array("id","name","email","phone","profile_pic","times","facebook_id"));
		$this->TeamMember->options['recursive'] = 1;
		$this->TeamMember->belongsTo = array("Member");
		$this->TeamMember->options['where'] = array(
			"TeamMember.team_member_type_id =  4",
		);
		$this->TeamMember->options['addToEnd'] = "GROUP BY TeamMember.id";
		if(isset($info['group']))
		{
			array_push($this->TeamMember->options['joins'],array("GroupingMember","Member"));
			array_push($this->TeamMember->options['where'], "GroupingMember.grouping_id = ".$info['group']);
		}

		$members = $this->TeamMember->findByTeamId($info['team_id']);

		if($members) return $members;

		return false;

	}

	private function _get_pending($info)
	{
		$this->loadModel("ShiftMember");
		$this->ShiftMember->options['fields'] = array("Member"=>array("id","name","email","phone","profile_pic","times","facebook_id"),"ShiftMember"=>array("id","shift_member_type_id"));
		$this->ShiftMember->options['recursive'] = 1;
		$this->ShiftMember->belongsTo = array("Member");
		$members = $this->ShiftMember->findByShiftIdAndShiftMemberTypeId($info['shift_id'],3);

		if($members) return $members;

		return false;

	}

	private function _get_declined($info)
	{
		$this->loadModel("ShiftMember");
		$this->ShiftMember->options['fields'] = array("Member"=>array("id","name","email","phone","profile_pic","times","facebook_id"),"ShiftMember"=>array("id","shift_member_type_id"));
		$this->ShiftMember->options['recursive'] = 1;
		$this->ShiftMember->belongsTo = array("Member");
		$members = $this->ShiftMember->findByShiftIdAndShiftMemberTypeId($info['shift_id'],4);

		if($members) return $members;

		return false;

	}
}