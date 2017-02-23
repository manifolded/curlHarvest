<?php
// modified the following PHP code from
// http://www.jacobward.co.uk/using-php-to-scrape-javascript-jquery-json-websites/
// 2017-02-21


// URL of a simple cookie-based authentication server provided by the author 
// of the book "Web Scraping with Python" for testing codes like this.
//$loginUrl = 'http://pythonscraping.com/pages/cookies/login.html';
$loginUrl = 'http://pythonscraping.com/pages/cookies/welcome.php';


    class curlPostLogin {
 
        // Class constructor method
        function __construct() {

            $this->useragent = 'Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10.5; en-US; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3';    // Setting useragent of a popular browser
 
            $handle = fopen('cookie.txt', 'w') or exit('Unable to create or open cookie.txt file.'."\n");   // Opening or creating cookie file
            fclose($handle);    // Closing cookie file
            $this->cookie = 'cookie.txt';    // Setting a cookie file to store cookie
            $this->timeout = 30; // Setting connection timeout in seconds
 
        }


        // User login method
        public function login() {
 
            // Login values to POST as array
            $postValues = http_build_query(
                array(
		    'username' => 'fishheads',
		    'password' => 'password',
//                    'RememberMe' => 'true',
//                    'IsAjaxRequest' => 'false'
                )
            );
 
	    // Making cURL POST request
	    global $loginUrl;
            $request = $this->curlPostFields($loginUrl, $postValues);
	    var_dump($request);

	    // The server replies with the html of the next page it is sending
	    // us to.  
	    // So far I have only failed to login and gotten back:
	    /*
	    <h2>Welcome to the Website!</h2>
Whoops! You logged in wrong. Try again with any username, and the password "password"<br><a href="login.html">Log in here</a>
            */

        }

        // Method to make a POST request using form fields
        public function curlPostFields($postUrl, $postValues) {
            $_ch = curl_init(); // Initialising cURL session
 
            // Setting cURL options
            curl_setopt($_ch, CURLOPT_SSL_VERIFYPEER, FALSE);   // Prevent cURL from verifying SSL certificate
            curl_setopt($_ch, CURLOPT_FAILONERROR, TRUE);   // Script should fail silently on error
            curl_setopt($_ch, CURLOPT_COOKIESESSION, TRUE); // Use cookies
            curl_setopt($_ch, CURLOPT_FOLLOWLOCATION, TRUE);    // Follow Location: headers
            curl_setopt($_ch, CURLOPT_RETURNTRANSFER, TRUE);    // Returning transfer as a string
            curl_setopt($_ch, CURLOPT_COOKIEFILE, $this->cookie);    // Setting cookiefile
            curl_setopt($_ch, CURLOPT_COOKIEJAR, $this->cookie); // Setting cookiejar
            curl_setopt($_ch, CURLOPT_USERAGENT, $this->useragent);  // Setting useragent
            curl_setopt($_ch, CURLOPT_URL, $postUrl);   // Setting URL to POST to
            curl_setopt($_ch, CURLOPT_CONNECTTIMEOUT, $this->timeout);   // Connection timeout
            curl_setopt($_ch, CURLOPT_TIMEOUT, $this->timeout); // Request timeout
 
            curl_setopt($_ch, CURLOPT_POST, TRUE);  // Setting method as POST
            curl_setopt($_ch, CURLOPT_POSTFIELDS, $postValues); // Setting POST fields (array)
 
            $results = curl_exec($_ch); // Executing cURL session
            curl_close($_ch);   // Closing cURL session
 
            return $results;
        }
 
 
        // Class destructor method
        function __destruct() {
            // Empty
        }
    }
 
    // Let's run it!
    $test = new curlPostLogin();   // Instantiating new object
 
    $test->login();    // Logging into server
