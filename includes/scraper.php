<?php
include "curl.php";
include "urls.php";
include "PQLite/PQLite.php";

/**
 * @author Bo Thomsern <bo@illution.dk>
 * @version 1.0
 */
class TwitterScraper {
	/**
	 * The standard request headers
	 * @since 1.0
	 * @access protected
	 * @internal
	 * @var array
	 */
	protected $_headers = (
		"accept" => "text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8",
		":host" => "twitter.com",
		":scheme" => "https",
		":version" => "HTTP/1.1",
		"accept-encodig" => "gzip,deflate,sdch",
		"accept-language" => "da-DK,da;q=0.8,en-US;q=0.6,en;q=0.4",
		"origin" => "https://twitter.com"
	);

	/**
	 * An instance of the URLs container
	 * @var URLs
	 * @since 1.0
	 * @access protected
	 * @internal
	 */
	protected $_urls = new Urls();

	/**
	 * Twitter username
	 * @since 1.0
	 * @access protected
	 * @internal
	 * @var string
	 */
	protected $_username = "";

	/**
	 * Twitter password
	 * @var string
	 * @since 1.0
	 * @access protected
	 * @internal
	 */
	protected $_password = "";

	public function __construct ( $username = NULL, $password = NULL ) {
		$this->_username = $username;
		$this->_password = $password;
	}

	public function scrapeTweets () {
		try {
			$login_con = $this->_auth();
		} catch (Exception $e) {
			throw new Exception("Login failed!", 403);
		}

		$con = new Connection($this->_urls->TWITTER_FRONT_PAGE_URL);
		$con->createCurl();
	}

	public function newTweets () {
		try {
			$login_con = $this->_auth();
		} catch (Exception $e) {
			throw new Exception("Login failed!", 403);
		}

		$con = new Connection($this->_urls->TWITTER_TIMELINE);
		$con->createCurl();
	}

	/**
	 * Authenticates the user with Twitter and gets the session information
	 * @return Connection The auth connection object
	 * @since 1.0
	 * @access public
	 */
	protected function _auth () {
		$con = new Connection($this->_urls->TWITTER_LOGIN_URL);
		$con->createCurl();

		if ( ! in_array($con->getHttpStatus(), array(200, 304)) ) {
			throw new Exception("Loading of login site failed!", 403);
		}

		$PQLite = new PQLite($con->__tostring());

		$authenticity_token = $PQLite->find('input[name="authenticity_token"]')->getAttr("value");

		$con = new Connection($this->_urls->TWITTER_LOGIN_POST_URL);
		$con->setReferer("https://twitter.com/login");
		$con->setHeaders(array_merge($this->_headers, array(":path" => "/sessions",":method" => "POST", "content-type" => "application/x-www-form-urlencoded")));

		if ( ! is_null($this->_username) ) {
			$con->setPost(array(
				$this->_urls->TWITTER_USERNAME_OR_EMAIL_FIELD_NAME => $this->_username,
				$this->_urls->TWITTER_PASSWORD_FIELD_NAME => $this->_password,
				$this->_urls->TWITTER_TOKEN_FIELD => $authenticity_token
			));
		}

		$con->createCurl();

		if ( ! in_array($con->getHttpStatus(), array(200, 304)) ) {
			throw new Exception("Login failed!", 403);
		}

		return $con;
	}
}
?>