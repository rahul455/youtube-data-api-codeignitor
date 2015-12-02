<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
//adding config items. get google auth clietn id,secret keys from http://console.developers.google.com
$config['OAUTH2_CLIENT_ID'] = 'YOUR_CLIENT_ID_HERE'; //your auth 2.0 client id 
$config['OAUTH2_CLIENT_SECRET'] = 'YOUR_CLIENT_SECRET_HERE';//your auth 2,0 client secret 
$config['REDIRECT_URI'] = 'http://www.YOUR_DOMAIN.com/welcome/youtube'; //Authorized redirect URIs a callback url which you should save in google console
