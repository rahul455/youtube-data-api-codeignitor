<?php
require_once 'google-api-php-client/src/Google/autoload.php';
session_start();
class Google_client_api {
	protected $OAUTH2_CLIENT_ID;
	protected $OAUTH2_CLIENT_SECRET;
	protected $ci;
    
	public function __construct()
    {
		$this->ci =& get_instance();
		$this->ci->config->load('Google');
		$this->OAUTH2_CLIENT_ID = $this->ci->config->item('OAUTH2_CLIENT_ID');
		$this->OAUTH2_CLIENT_SECRET = $this->ci->config->item('OAUTH2_CLIENT_SECRET');
    }
	
	public function index() {
		return $this->OAUTH2_CLIENT_SECRET;
	}
	
	public function youtube_upload($video="linkedin.mp4",$title="tvn rahul youtube api v3",$desc="tvn rahul youtube api v3 for php",$tags=["rahultvn","youtubeapi3"],$privacy_status="public") {
		$result=[];
		$htmlBody="";
		$OAUTH2_CLIENT_ID = $this->ci->config->item('OAUTH2_CLIENT_ID');//'980811603180-qlbtavji7o0ekejgerqifous319d2he2.apps.googleusercontent.com';
		$OAUTH2_CLIENT_SECRET = $this->ci->config->item('OAUTH2_CLIENT_SECRET');//'sbzALHg38sB9aXEo0a9GG4ZA';

		$client = new Google_Client();
		$client->setClientId($OAUTH2_CLIENT_ID);
		$client->setClientSecret($OAUTH2_CLIENT_SECRET);
		$client->setScopes('https://www.googleapis.com/auth/youtube');
		$redirect = $this->ci->config->item('REDIRECT_URI');//filter_var('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'],
			//FILTER_SANITIZE_URL);
		$client->setRedirectUri($redirect);

		// Define an object that will be used to make all API requests.
		$youtube = new Google_Service_YouTube($client);
			if (isset($_GET['code'])) {
		  if (strval($_SESSION['state']) !== strval($_GET['state'])) {
			die('The session state did not match.');
		  }

		  $client->authenticate($_GET['code']);
		  $_SESSION['token'] = $client->getAccessToken();
		  header('Location: ' . $redirect);
		}

		if (isset($_SESSION['token'])) {
		  $client->setAccessToken($_SESSION['token']);
		}

		// Check to ensure that the access token was successfully acquired.
		if ($client->getAccessToken()) {
                    //echo $client->getAccessToken();
		  try{
			// REPLACE this value with the path to the file you are uploading.
			$videoPath = realpath(APPPATH . '../videos/'.$video);
			//$videoPath = "videos/linkedin.mp4";

			// Create a snippet with title, description, tags and category ID
			// Create an asset resource and set its snippet metadata and type.
			// This example sets the video's title, description, keyword tags, and
			// video category.
			$snippet = new Google_Service_YouTube_VideoSnippet();
			$snippet->setTitle($title);
			$snippet->setDescription($desc);
			$snippet->setTags($tags);

			// Numeric video category. See
			// https://developers.google.com/youtube/v3/docs/videoCategories/list 
			$snippet->setCategoryId("22");

			// Set the video's status to "public". Valid statuses are "public",
			// "private" and "unlisted".
			$status = new Google_Service_YouTube_VideoStatus();
			$status->privacyStatus = $privacy_status;

			// Associate the snippet and status objects with a new video resource.
			$video = new Google_Service_YouTube_Video();
			$video->setSnippet($snippet);
			$video->setStatus($status);

			// Specify the size of each chunk of data, in bytes. Set a higher value for
			// reliable connection as fewer chunks lead to faster uploads. Set a lower
			// value for better recovery on less reliable connections.
			$chunkSizeBytes = 1 * 1024 * 1024;

			// Setting the defer flag to true tells the client to return a request which can be called
			// with ->execute(); instead of making the API call immediately.
			$client->setDefer(true);

			// Create a request for the API's videos.insert method to create and upload the video.
			$insertRequest = $youtube->videos->insert("status,snippet", $video);

			// Create a MediaFileUpload object for resumable uploads.
			$media = new Google_Http_MediaFileUpload(
				$client,
				$insertRequest,
				'video/*',
				null,
				true,
				$chunkSizeBytes
			);
			$media->setFileSize(filesize($videoPath));


			// Read the media file and upload it chunk by chunk.
			$status = false;
			$handle = fopen($videoPath, "rb");
			while (!$status && !feof($handle)) {
			  $chunk = fread($handle, $chunkSizeBytes);
			  $status = $media->nextChunk($chunk);
			}

			fclose($handle);

			// If you want to make other calls after the file upload, set setDefer back to false
			$client->setDefer(false);


			$htmlBody .= "<h3>Video Uploaded</h3><ul>";
			$htmlBody .= sprintf('<li>%s (%s)</li>',
				$status['snippet']['title'],
				$status['id']);

			$htmlBody .= '</ul>';
			$result['id']=$status['id'];
			$result['title']=$status['snippet']['title'];

		  } catch (Google_Service_Exception $e) {
			$htmlBody .= sprintf('<p>A service error occurred: <code>%s</code></p>',
				htmlspecialchars($e->getMessage()));
		  } catch (Google_Exception $e) {
			$htmlBody .= sprintf('<p>An client error occurred: <code>%s</code></p>',
				htmlspecialchars($e->getMessage()));
		  }

		  $_SESSION['token'] = $client->getAccessToken();
		} else {
		  // If the user hasn't authorized the app, initiate the OAuth flow
		  $state = mt_rand();
		  $client->setState($state);
		  $_SESSION['state'] = $state;

		  $authUrl = $client->createAuthUrl();
		  $htmlBody.= "<h3>Authorization Required</h3>";
		  $htmlBody.= "<p>You need to <a href=".$authUrl.">authorize access</a> before proceeding.<p>";
		  $result['authUrl']=$authUrl;
		}
		$result['message']=$htmlBody;
		return $result;
		
	}
}

/* End of file Google_client_api.php */