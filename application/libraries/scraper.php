<?php
include "curl.php";
include "urls.php";
include "phpQuery-onefile.php";

/**
 * @author Bo Thomsern <bo@illution.dk>
 * @version 1.0
 */
class Scraper {
	/**
	 * The standard request headers
	 * @since 1.0
	 * @access protected
	 * @internal
	 * @var array
	 */
	protected $_headers = array(
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
	protected $_urls = null;

	/**
	 * Twitter username
	 * @since 1.0
	 * @access public
	 * @var string
	 */
	public $username = "";

	/**
	 * Twitter password
	 * @var string
	 * @since 1.0
	 * @access public
	 */
	public $password = "";

	public function __construct ( $username = NULL, $password = NULL ) {
		$this->_urls = new Urls();
		$this->username = $username;
		$this->password = $password;
	}

	/**
	 * Returns the cursor items
	 * @param  string $cursor The cursor string
	 * @return array
	 */
	protected function _get_cursor_elements ( $cursor ) {
		preg_match("/TWEET-(?P<oldest>.*)-(?P<newest>.*)/", $cursor, $matches);

		return array(
			"newest" => $matches["newest"],
			"oldest" => $matches["oldest"]
		);
	}

	/**
	 * Creates the JSON request URL
	 * @param  string $type One of the page types
	 * @param  array $data Page type data
	 * @param  string $cursor The next cursor
	 * @return string
	 */
	protected function _create_url ( $type, $data, $cursor = NULL) {
		switch ( $type ) {
			case 'search':
				$url = 'https://twitter.com/i/search/timeline?q=' . $data["q"] . '&src=typd&f=realtime&include_available_features=1&include_entities=1&last_note_ts=0';
				if ( ! is_null($cursor) ) {
					return  $url . '&scroll_cursor=' . $cursor;
				}

				return $url;
				break;

			case 'trends':
				$url = 'https://twitter.com/i/search/timeline?q=' . $data["q"] .  '&src=tren&include_available_features=1&include_entities=1&last_note_ts=0';

				if ( ! is_null($cursor) ) {
					return  $url . '&&last_note_ts=0&scroll_cursor=TWEET-=' . $cursor;
				}

				return $url;
				break;

			case 'profile':
				$url = 'https://twitter.com/i/profiles/show/' . $data["user"] . '/timeline?include_available_features=1&include_entities=1&last_note_ts=0';
				if ( ! is_null($cursor) ) {
					return  $url . '&max_id=' . $cursor;
				}

				return $url;
				break;

			case 'timeline':
				$url = 'https://twitter.com/i/timeline?include_available_features=1&include_entities=1&last_note_ts=0';
				if ( ! is_null($cursor) ) {
					return  $url . '&max_id=' . $cursor;
				}

				return $url;
				break;

			case 'discover':
				$url = 'https://twitter.com/i/discover/timeline?include_available_features=1&include_entities=1&last_note_ts=0';
				if ( ! is_null($cursor) ) {
					return  $url . '&scroll_cursor=' . $cursor;
				}

				return $url;
				break;
		}
	}

	/**
	 * Scrapes a twitter page, for tweets
	 * @param array $meta Source meta data
	 * @param string &$refresh_cursor A variable to store the newest cursor
	 * @param string $latest_cursor The last read cursor
	 * @param string $type Page type "search", "profile", "timeline", "discover"
	 * @return array|boolean
	 */
	public function scrapeTweets ( $meta, &$refresh_cursor, $latest_cursor = NULL, $type = NULL, $data, $not_first = false, $last_inserted_cursor = NULL, $max_timestamp = NULL ) {
		// If username isset, login to twitter and fetch Cookie information
		if ( isset($this->username) && ! is_null($this->username) ) {
			try {
				$login_con = $this->_auth();
			} catch (Exception $e) {
				echo "Login Failed!";
				throw new Exception("Login failed!", 403);
			}
		}

		// If a cursor has been set, use it ofr the next request
		$cursor = NULL;
		if ( $not_first == true ) {
			if ( ! empty($latest_cursor) ) {
				$cursor = $latest_cursor;
			}
		} else {
			$last_inserted_cursor = $latest_cursor;
		}

		// Create the URL, using type, requests data and a possible cursor
		$url = $this->_create_url($type, $data, $cursor);

		$con = new Connection($url);
		$con->setHeaders($this->_headers);
		$con->createCurl($url);

		// Get the response result
		$object = json_decode(str_replace("\n\n\n\n\n\n\n\n\n\n\n      \u003c", "", $con->webpage()));

		phpQuery::newDocumentHTML($object->items_html);

		$next_page_cursor = false;

		$tweets = array();

		// Loop through all the tweets and extract the information
		foreach ( pq('.js-stream-tweet[data-tweet-id]') as $tweet ) {
			$tweet = pq($tweet);

			$time = "";

			$relative = $tweet->find(".js-relative-timestamp")->attr("data-time");

			if ( ! empty($relative) ) {
				$time = $tweet->find(".js-relative-timestamp")->attr("data-time");
			} else {
				$time = $tweet->find(".js-short-timestamp")->attr("data-time");
			}

			$tweet_array = array(
				"urls" => array(),
				"mentions" => array(),
				"media" => array(),
				"hash_tags" => array(),
				"item_id" => $tweet->attr("data-item-id"),
				"tweet_id" => $tweet->attr("data-tweet-id"),
				"mentions_string" => $tweet->attr("data-mentions"),
				"feedback_key" => $tweet->attr("data-feedback-key"),
				"user_id" => $tweet->attr("data-user-id"),
				"screen_name" => $tweet->attr("data-screen-name"),
				"display_name" => $tweet->attr("data-name"),
				"created_at" => $time,
				"uri" => $tweet->find(".js-details")->attr("href")
			);

			$tweet_id = $tweet->attr("data-tweet-id");

			foreach ( $tweet->find(".media") as $link ) {
				$link = pq($link);
				$tweet_array["media"][] = array(
					"media_url" => $link->attr("data-url"),
					"status_media_url" => $link->attr("href"),
					"large_media_url" => $link->attr("data-resolved-url-large")
				);
			}

			foreach ( pq($tweet->find(".tweet-text"))->find("a") as $link ) {
				$link = pq($link);
				if ( $link->hasClass("twitter-atreply") ) {
					$mention_screen_name = $link->find("b")->html();
					$tweet_array["mentions"][] = array(
						"screen_name" => strip_tags($mention_screen_name)
					);
					$link->replaceWith( "@" . $mention_screen_name );
				} else if ( $link->hasClass("twitter-hashtag") ) {
					$tweet_array["hash_tags"][] = array(
						"hash_tag" => strip_tags($link->find("b")->html()),
						"url" => $link->attr("href")
					);
					$link->replaceWith( "#" . $link->find("b")->html() );
				} else if ( $link->hasClass("twitter-timeline-link") ) {
					$url = $link->attr("data-expanded-url");

					if ( empty($url) ) {
						$url = strip_tags($link->html());
					}

					$tweet_array["urls"][] = array(
						"url" => $url,
						"title" => $link->attr("title"),
						"tco" => $link->attr("href"),
						"text" => strip_tags($link->html())
					);
					$link->replaceWith($link->attr("href"));
				}
			}

			$text = $tweet->find(".tweet-text")->html();

			$tweet_array["text"] = strip_tags($text);

			// Append the tweet to the list
			$tweets[$tweet_id] = array_merge($tweet_array, $meta);
		}

		if ( $not_first == false && property_exists($object, "refresh_cursor") ) {
			$refresh_cursor = $object->refresh_cursor;
		}

		// If more pages available that are newer then the last fetched and newer then the maxed save time, set the next cursor
		$last_element = end($tweets);
		if ( $last_element["created_at"] > (time() - $max_timestamp) ) {
			if ( ! empty($last_inserted_cursor) && property_exists($object, "scroll_cursor") ) {
				if ( $this->_cursor_different($object->scroll_cursor, $last_inserted_cursor, $oldest) ) {
					$next_page_cursor = $oldest;
				}
			} else {
				if ( in_array($type, array("profile", "timeline")) && ! empty($last_inserted_cursor) ) {
					if ( property_exists($object, "max_id") ) {
						$current_request_max_cursor = $object->max_id;
					} else {
						$current_request_max_cursor = $last_element["tweet_id"];
					}

					if ( $current_request_max_cursor > $last_inserted_cursor ) {
						$next_page_cursor = $current_request_max_cursor;
					}
				} else if ( $last_element["created_at"] > (time() - $max_timestamp) ) {
					if ( property_exists($object, "scroll_cursor") ) {
						$next_page_cursor = $object->scroll_cursor;
					} else {
						$next_page_cursor = $last_element["tweet_id"];
					}
				}
			}
		}

		// If more newer pages to load, load em
		if ( $next_page_cursor !== false ) {
			$tweets = array_merge($tweets, $this->scrapeTweets($meta, $old_refresh_cursor, $next_page_cursor, $type, $data, true, $latest_cursor, $max_timestamp ));
		}

		return $tweets;
	}

	/**
	 * Difference check
	 * @param  string[type] $newest   Newest fetched cursor
	 * @param  string $oldest   Oldest fetched cursor
	 * @param  string $smallest The oldest of the two cursors
	 * @return boolean
	 */
	protected function _cursor_different ( $newest, $oldest, &$smallest ) {
		if ( $newest == $oldest ) {
			return false;
		}

		$newest_cursor_elements = $this->_get_cursor_elements($newest);
		$oldest_cursor_elements = $this->_get_cursor_elements($oldest);

		if ( $newest_cursor_elements["newest"] == $oldest_cursor_elements["newest"] ) {
			if ( $newest_cursor_elements["oldest"] > $oldest_cursor_elements["oldest"] ) {
				$smallest = $oldest;
				return true;
			} else if ( $newest_cursor_elements["oldest"] < $oldest_cursor_elements["oldest"] ) {
				$smallest = $newest;
				return true;
			}
		} else if ( $newest_cursor_elements["oldest"] == $oldest_cursor_elements["oldest"] ) {
			if ( $newest_cursor_elements["newest"] > $oldest_cursor_elements["newest"] ) {
				$smallest = $oldest;
				return true;
			} else if ( $newest_cursor_elements["newest"] < $oldest_cursor_elements["newest"] ) {
				$smallest = $newest;
				return true;
			}
		} else {
			if ( ( $newest_cursor_elements["newest"] > $oldest_cursor_elements["newest"] ) && ( $newest_cursor_elements["oldest"] > $oldest_cursor_elements["oldest"] ) ) {
				$smallest = $oldest;
				return true;
			} else if ( ( $newest_cursor_elements["newest"] < $oldest_cursor_elements["newest"] ) && ( $newest_cursor_elements["oldest"] < $oldest_cursor_elements["oldest"] ) ) {
				$smallest = $newest;
				return true;
			} else {
				return false;
			}
		}
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

		phpQuery::newDocumentHTML($con->webpage());

		if ( ! in_array($con->getHttpStatus(), array(200, 304)) ) {
			throw new Exception("Loading of login site failed!", 403);
		}

		$authenticity_token = pq('input[name="authenticity_token"]')->attr("value");

		$con = new Connection($this->_urls->TWITTER_LOGIN_POST_URL);
		$con->setReferer("https://twitter.com/login");
		$con->setHeaders(array_merge($this->_headers, array(":path" => "/sessions",":method" => "POST", "content-type" => "application/x-www-form-urlencoded")));

		if ( ! is_null($this->username) ) {
			$con->setPost(array(
				$this->_urls->TWITTER_USERNAME_OR_EMAIL_FIELD_NAME => $this->username,
				$this->_urls->TWITTER_PASSWORD_FIELD_NAME => $this->password,
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