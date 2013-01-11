<?php

Class Caching {

	// id to use to create cached version
	public static $id;

	// create the cached view after logic has been run
	public static function create($view,$file_name,$id="")
	{

		if(empty($id))$id=self::$id;

		$file_name = explode("/", $file_name);

		// if the directory doesn't exist
		if(!is_dir("../RDCache/".$file_name[0]))
		{

			// create the directory
			mkdir("../RDCache/".$file_name[0]);

		}

		// the path to the cached view
		$file_name= "../RDCache/".$file_name[0]."/".$file_name[1]."-".$id.".html";

		// create the file from the view
		file_put_contents($file_name,$view,LOCK_EX);

	}

	// check the cache to see if the file exists
	public function check_cache($controller)
	{

		// path to view
		$file_name= "../RDCache/".$controller::$controller_name."/".$controller::$view_name."-".self::$id.".html";

		// get the cached page and check if it does exist
		if($view = View::get_contents($file_name))
		{

			// echo out the view
			echo $view;

			// stop the rest of the logic from happening
			return false;
		}

		// continue with the logic
		return true;


	}

}