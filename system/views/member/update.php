<?php
	$params = isset($member)?$member:array();
	$params["team_names"] = $team_names;
	if(isset($errors)) $params = array_merge($params,$errors);
	View::render('member/_form',$params);
 ?>