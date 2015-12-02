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
		$video= "sample.mp4";//video file which is in videos folder (this should be outside application folder)
		$title= "your custom title for youtube video v3"; //your title for youtube video
		$desc= "your custom youtube video description"; //your description for youtube video
		$tags=["rahultvn","youtubeapi3"]; //your custom tags for youtube video
		$privacy_status="public"; //video status public or private
		$youtube=$this->google_client_api->youtube_upload($video,$title,$desc,$tags,$privacy_status);
		print_r($youtube);
		//echo "hi";	
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */