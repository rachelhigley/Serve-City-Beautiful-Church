<?php
	$params = isset($errors)?array_merge($member, $errors,array("teams"=>$teams)):array_merge($member, array("teams"=>$teams));
	View::render('facebook/_form',$params);
?>