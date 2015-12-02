<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$this->load->view('welcome_message');
	}
	
	public function youtube() {
		
		$this->load->library('google_client_api');
		///echo $this->rahul->my_function();
		//exit;
		$video= "linkedin.mp4";
		$title= "final test add youtube video v3";
		$desc= "this is a final test youtube video desc";
		$tags=["rahultvn","youtubeapi3"];
		$privacy_status="public";
		$youtube=$this->google_client_api->youtube_upload($video,$title,$desc,$tags,$privacy_status);
		print_r($youtube);
		//echo "hi";
		
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
