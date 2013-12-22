<?php
/**
 * @author Bo Thomsen <bo@illution.dk>
 * @version 1.0
 * @link https://illution.dk Author URL
 * @uses cURL Uses the cURL library
 */
class Connection {
	/**
	 * The desired user agent for the requests
	 * @var string
	 * @since 1.0
	 * @access protected
	 */
	protected $_useragent = 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/34.0.1753.0 Safari/537.36';

	/**
	 * Stores the requested URL
	 * @var string
	 * @internal An interval variable, storing the requested URL
	 * @access protected
	 * @since 1.0
	 */
	protected $_url;

	/**
	 * If the requests should follow redirect locations
	 * @var boolean
	 * @since 1.0
	 * @access protected
	 * @internal An interval boolean, to control if the request shuld follow HTTP redirect locations
	 */
	protected $_followlocation;

	/**
	 * The max number of seconds to wait before timeout
	 * @var integer
	 * @since 1.0
	 * @access protected
	 * @internal An interval variable, to control the max timeout time
	 */
	protected $_timeout;

	/**
	 * The maximum number of HTTP redirects before timeout
	 * @since 1.0
	 * @access protected
	 * @var integer
	 * @internal An internal variable, to control the max number of HTTP redirects before timeout
	 */
	protected $_maxRedirects;

	/**
	 * The file location where to store the cookie file
	 * @var string
	 * @since 1.0
	 * @access protected
	 * @internal An internal variable to control the cookie file location
	 */
	protected $_cookieFileLocation = './cookie.txt';

	/**
	 * If the request is a post Request
	 * @var boolean
	 * @since 1.0
	 * @internal An internal boolean to set if the request is a post request
	 * @access protected
	 */
	protected $_post;

	/**
	 * The data to post
	 * @var array
	 * @since 1.0
	 * @access protected
	 * @internal An array containing the post data
	 */
	protected $_postFields;

	/**
	 * The referer header string to send
	 * @var string
	 * @internal An internal variable storing the referer URL
	 * @access protected
	 * @since 1.0
	 */
	protected $_referer ="http://www.google.com";

	/**
	 * The RAW website text
	 * @var String
	 * @access protected
	 * @since 1.0
	 * @internal An internal variable storing the RAW website text
	 */
	protected $_webpage;

	/**
	 * The HTTP headers to send
	 * @var array
	 * @since 1.0
	 * @access protected
	 * @internal
	 */
	protected $_headers = NULL;

	/**
	 * If headers should be included
	 * @var boolean
	 * @since 1.0
	 * @access protected
	 * @internal An interval boolean, storing if headers should be sent
	 */
	protected $_includeHeader;

	/**
	 * The response cookies from the last request
	 * @since 1.0
	 * @access protected
	 * @internal
	 * @var array
	 */
	protected $_response_cookies = NULL;

	/**
	 * The cookies to send
	 * @var array
	 * @since 1.0
	 * @access protected
	 * @internal
	 */
	protected $_request_cookies = NULL;

	/**
	 * A boolen to set if the body should not be included
	 * @var boolean
	 * @since 1.0
	 * @access protected
	 * @internal An internal boolean to set if the HTTP bodt should be included
	 */
	protected $_noBody;

	/**
	 * The recieved HTTP Status code
	 * @var integer
	 * @since 1.0
	 * @access protected
	 * @internal An internal variable storing the recieved HTTP Status code
	 */
	protected $_status;

	/**
	 * If the request data should be transfered in binary format
	 * @var boolean
	 * @since 1.0
	 * @access protected
	 * @internal An internal boolean, to set if the data should be transfered in binary format
	 */
	protected $_binaryTransfer;

	/**
	 * If the request should be authenticated
	 * @var integer
	 * @since 1.0
	 * @access public
	 */
	public    $authentication = 0;

	/**
	 * Basic Auth username
	 * @var string
	 * @since 1.0
	 * @access public
	 */
	public    $auth_name      = '';

	/**
	 * Basic auth password
	 * @var string
	 * @since 1.0
	 * @access public
	 */
	public    $auth_pass      = '';

	/**
	 * If Basic auth should be used
	 * @param  integer $use 1 Means yes
	 * @since 1.0
	 * @access public
	 */
	public function useAuth ( $use ) {
		$this->authentication = 0;
		if ( $use == true ) $this->authentication = 1;
	}

	/**
	 * Change the Basic Auth username
	 * @param String $name The username
	 * @since 1.0
	 * @access public
	 */
	public function setName ( $name ) {
		$this->auth_name = $name;
	}

	/**
	 * Set the Basic Auth password
	 * @param String $pass The password
	 * @since 1.0
	 * @access public
	 */
	public function setPass ( $pass ) {
		$this->auth_pass = $pass;
	}

	/**
	 * Sets the internal header field
	 * @param array $headers The headers to set
	 * @since 1.0
	 * @access public
	 */
	public function setHeaders ( $headers = array() ) {
		$this->_headers() = $headers;
	}

	/**
	 * The class constructor method, constructs the class and can be used to set settings
	 * @param String  $url            The request url
	 * @param boolean $followlocation If the request should follow redirect locations
	 * @param integer $timeOut        The max timeout time
	 * @param integer $maxRedirecs    The max number of redirects
	 * @param boolean $binaryTransfer If the request should be send in binary format
	 * @param boolean $includeHeader  If the request should include headers
	 * @param boolean $noBody         If no request body should be send(True)
	 */
	public function __construct ( $url, $followlocation = true, $timeOut = 30, $maxRedirecs = 4, $binaryTransfer = false, $includeHeader = false, $noBody = false ) {
		$this->_url = $url;
		$this->_followlocation = $followlocation;
		$this->_timeout = $timeOut;
		$this->_maxRedirects = $maxRedirecs;
		$this->_noBody = $noBody;
		$this->_includeHeader = $includeHeader;
		$this->_binaryTransfer = $binaryTransfer;

		$this->_cookieFileLocation = dirname(__FILE__).'/cookie.txt';

	}

	/**
	 * Change the referer URL
	 * @param String $referer The new referer URL
	 * @since 1.0
	 * @access public
	 */
	public function setReferer ( $referer ) {
		$this->_referer = $referer;
	}

	/**
	 * Returns the response cookies
	 * @since 1.0
	 * @access public
	 * @return array An assoc key-value array
	 */
	public function getCookies () {
		return $this->_response_cookies;
	}

	/**
	 * Sets the internal cookies variable
	 * @since 1.0
	 * @access public
	 * @param array $cookies The cookies to set
	 */
	public  function setCookies ( $cookies ) {
		$this->_request_cookies = $cookies;
	}

	/**
	 * Change the file location of the cookie file
	 * @param String $path The new cookie file path
	 */
	public function setCookiFileLocation ( $path ) {
		$this->_cookieFileLocation = $path;
	}

	/**
	 * Change the request to a post request and assign post data
	 * @param array $postFields The post data
	 * @since 1.0
	 * @access public
	 */
	public function setPost ( $postFields ) {
		$this->_post = true;
		$this->_postFields = $postFields;
	}

	/**
	 * A setter method, to change the user agent string
	 * @since 1.0
	 * @access public
	 * @param String $userAgent The new user agent string
	 */
	public function setUserAgent ( $userAgent ) {
		$this->_useragent = $userAgent;
	}

	/**
	 * Creates and executes the cURL connection
	 * @param  String $url The url to request
	 * @access public
	 * @since 1.0
	 */
	public function createCurl ( $url = NULL ) {
		if ( ! is_null($url) ) {
		  $this->_url = $url;
		}

		$s = curl_init();

		curl_setopt($s,CURLOPT_URL,$this->_url);
		curl_setopt($s,CURLOPT_HTTPHEADER,$this->_headers);
		curl_setopt($s,CURLOPT_TIMEOUT,$this->_timeout);
		curl_setopt($s,CURLOPT_MAXREDIRS,$this->_maxRedirects);
		curl_setopt($s,CURLOPT_RETURNTRANSFER,true);
		curl_setopt($s,CURLOPT_FOLLOWLOCATION,$this->_followlocation);
		curl_setopt($s,CURLOPT_COOKIEJAR,$this->_cookieFileLocation);
		curl_setopt($s,CURLOPT_COOKIEFILE,$this->_cookieFileLocation);

		if ( $this->authentication == 1) {
			curl_setopt($s, CURLOPT_USERPWD, $this->auth_name.':'.$this->auth_pass);
		}

		if ( $this->_post ) {
			$fields_string = "";

			foreach( $this->_postFields as $key=> $value ) {
				$fields_string .= $key.'='.$value.'&';
			}

			rtrim($fields_string, '&');

			curl_setopt($s,CURLOPT_POST,true);
			curl_setopt($s,CURLOPT_POSTFIELDS,$fields_string);

		}

		if ( $this->_includeHeader ) {
			curl_setopt($s,CURLOPT_HEADER,true);
		}

		if ( $this->_noBody ) {
			curl_setopt($s,CURLOPT_NOBODY,true);
		}

		if ( $this->_binary) {
			curl_setopt($s,CURLOPT_BINARYTRANSFER,true);
		}

		curl_setopt($s,CURLOPT_USERAGENT,$this->_useragent);
		curl_setopt($s,CURLOPT_REFERER,$this->_referer);

		if ( ! is_null($this->_request_cookies) ) {
			$cookie_string = "";
			foreach ( $this->_request_cookies as $key => $value ) {
				$cookie_string += $key + "=" + $value + ";";
			}

			curl_setopt( $s, CURLOPT_COOKIE, $cookie_string);
		}

		$this->_webpage = curl_exec($s);
		$this->_status = curl_getinfo($s,CURLINFO_HTTP_CODE);

		preg_match('/^Set-Cookie:\s*([^;]*)/mi', $this->_webpage, $m);

		parse_str($m[1], $this->_response_cookies);

		curl_close($s);
	}

	/**
	 * Returns the HTTP Status Code for the request
	 * @return integer The HTTP Status Code
	 * @access public
	 * @since 1.0
	 */
	public function getHttpStatus () {
		return $this->_status;
	}

	/**
	 * Returns the RAW website text in string format
	 * @return String The website text
	 * @access public
	 * @since 1.0
	 */
   	public function __tostring () {
		return $this->_webpage;
   	}
}
?>