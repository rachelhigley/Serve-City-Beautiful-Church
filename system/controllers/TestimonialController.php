<?php
/**
 * The Testimonial Controller
 */

/**
 * The Testimonial Controller
 * @category   Controllers
 * @package    Serve | City Beautiful Church
 * @subpackage Controllers
 * @author     Rachel Higley
 */
 Class TestimonialController extends Controller
{
	/**
	 * Get all the Testimonials
	 * @return array all the Testimonials
	 */
	public function index($id=null)
	{

		// load the model
		$this->loadModel("Testimonial");

		// only get this table
		$this->Testimonial->options['recursive'] = 0;

		if($id) {
			// get all the Testimonials for a team
			$testimonials = $this->Testimonial->findByTeamId($id);
		}

		else {
			// get all the Testimonials
			$testimonials = $this->Testimonial->findAll($id);
		}

		//set the success
		$this->view_data('success',$this->Testimonial->success);

		// if the call was successful
		if($this->Testimonial->success)
		{

			// set the information for the view
			$this->view_data("testimonials",$testimonials);

			// return the information
			return $testimonials;

		}
	}
	/**
	 * Get one Testimonial
	 * @param  int the id of the Testimonial to get
	 * @return one Testimonial
	*/
	public function get($id)
	{
		if($id)
		{

			// load the model
			$this->loadModel("Testimonial");

			// only get this table
			$this->Testimonial->options['recursive'] = 0;

			// get all the Testimonials
			$testimonial = $this->Testimonial->findById($id);

			//set the success
			$this->view_data('success',$this->Testimonial->success);

			// if the call was successful
			if($this->Testimonial->success)
			{

				// set the information for the view
				$this->view_data("testimonial",$testimonial[0]);

				// return the information
				return $testimonial[0];
			}
			return false;
		}

	}
	/**
	 * Create new Testimonial
	 * @param  array $testimonial all the information to save
	 * @return boolean if it was successfull
	 */
	public function post($team_id=NULL, $testimonial=NULL)
	{
		if(is_array($team_id))
		{
			$testimonial = $team_id;
			$team_id = NULL;
		}
		$this->view_data('team_id',$team_id);

		//if information was sent
		if($testimonial)
		{
			// set the team id
			$testimonial['team_id'] = $team_id;

			// if there is a profile pic upload
			if(isset($_FILES['photo']) && !empty($_FILES['photo']['name']))
			{
				$extension = pathinfo($_FILES['photo']['name']);
				$file_name = "testimonial_pics/pic-".time().".".$extension['extension'];
				move_uploaded_file($_FILES["photo"]['tmp_name'], WEBROOT_PATH."/".Asset::$paths['img'].$file_name);

				$testimonial["photo"] = $file_name;

			}
			// if they didn't upload a new profile pic and there was already one set it
			else
			{
				unset($testimonial['photo']);

			}

			// load the model
			$this->loadModel("Testimonial");

			// save the new Testimonial
			$this->Testimonial->save($testimonial);

			// set the success
			$this->view_data("success",$this->Testimonial->success);
			if(!$this->Testimonial->success) return $this->view_data("errors",$this->Testimonial->error);


			if($this->Testimonial->success) Core::redirect("team","get",array($team_id));
			// return the success
			return $this->Testimonial->success;
		}
	}
	/**
	 * Update a Testimonial
	 * @param  array $testimonial all the information to update, including id
	 * @return boolean if it was successfull
	 */
	public function update($testimonial_id=NULL,$testimonial=NULL)
	{

		// if information was sent
		if($testimonial)
		{
			// load the model
			$this->loadModel("Testimonial");

			// save the new Testimonial
			$this->Testimonial->save($testimonial);

			// set the success
			$this->view_data("success",$this->Testimonial->success);

			// if the save was not successful
			if(!$this->Testimonial->success)
			{
				// set the errors
				$this->view_data("errors",$this->Testimonial->error);
			}
		}

		// if there is an id
		if($testimonial_id)
		{

			// get a Testimonial
			$this->get($testimonial_id);

		}


	}
	/**
	 * Delete a Testimonial
	 * @param  int $testimonial_id id of the Testimonial to delete
	 * @return boolean if it was successfull
	 */
	public function delete($testimonial_id=NULL)
	{
		// if there was an id sent
		if($testimonial_id)
		{

			// load the model
			$this->loadModel("Testimonial");

			// save the new Testimonial
			$this->Testimonial->delete($testimonial_id);

			// set the success
			$this->view_data("success",$this->Testimonial->success);

			// return the success
			$this->Testimonial->success;

		}
	}
}