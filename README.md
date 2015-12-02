# YouTube Data API v3 CodeIgniter libray for uploading a video 

A YouTube API 3 Library for uploading a video to youtube  for CodeIgniter PHP Framework (3.x)

## Usage:
* Change client auth id secret and Authorized redirect URI in application/config/Google.php and copy in the appropriate directory in your project.
* Add videos folder(which contains a sample video for testing purpose) outside application folder ,i.e. in you root directory.
* Add google-api-php-client folder and Google_client_api.php in application/libraries folder in your project.
* A sample controller welcome.php contains an example to call the custom library Google_client_api.Path is application/controllers.


## Compatibility:

The library has been tested successfully with the below mentioned environment:

- [Codeignitor 3.x](https://www.codeigniter.com/)
- [Apache 2.x]
- [PHP 5.6.x](http://php.net/)


## Requirements:

* Codeignitor Framework >= 2.x

## Installation:

The most common flow is:

1. add Google.php in application/config folder in you rproject and change accordingly.
2. add google-api-php-client folder and Google_client_api.php in application/libraries folder in your project.
3. Modify default controller Welcome.php with the given controller in application/controllers folder in your project.
4. get client id,client secret and redirect uri from https://console.developers.google.com
Simple example:
	
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
## License
This library is licensed under the MIT license.

## Author

- [TVN RAHUL](http://alleyglobal.com)

## Testing
- [BALAJI ONGOLE] (https://www.facebook.com/balaji.new.984)



