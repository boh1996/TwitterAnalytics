<?php
require_once "curl.php";
require_once "urls.php";
require_once "phpQuery-onefile.php";

/**
 * @author Bo Thomsern <bo@illution.dk>
 * @version 1.0
 */
class Live_Scraper {
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

	public function __construct () {
		$this->_urls = new Urls();
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
				$url = 'https://twitter.com/i/search/timeline?q=' . urlencode($data["q"]) . '&src=typd&f=realtime';
				if ( ! is_null($cursor) ) {
					return  $url . '&scroll_cursor=' . $cursor;
				}

				return $url;
				break;

			case 'trends':
				$url = 'https://twitter.com/i/search/timeline?q=' . urlencode($data["q"]) .  '&src=tren';

				if ( ! is_null($cursor) ) {
					return  $url . '&scroll_cursor=TWEET-=' . $cursor;
				}

				return $url;
				break;

			case 'profile':
				$url = 'https://twitter.com/i/profiles/show/' . urlencode($data["user"]) . '/timeline';
				if ( ! is_null($cursor) ) {
					return  $url . '?max_id=' . $cursor;
				}

				return $url;
				break;

			case 'timeline':
				$url = 'https://twitter.com/i/timeline';
				if ( ! is_null($cursor) ) {
					return  $url . '?max_id=' . $cursor;
				}

				return $url;
				break;

			case 'discover':
				$url = 'https://twitter.com/i/discover/timeline';
				if ( ! is_null($cursor) ) {
					return  $url . '?scroll_cursor=' . $cursor;
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
		try {
			$con->createCurl($url);
		} catch (Exception $e) {
			throw $e;
		}

		if ( $con->error == True ) {
			throw new Exception("Failed to load webpage!" . $url, 403);
		}

		if ( ! is_object($con) ) {
			throw new Exception("Failed to load webpage!" . $url, 403);
		}

		// Get the response result
		$object = json_decode(str_replace("\n\n\n\n\n\n\n\n\n\n\n      \u003c", "", $con->webpage()));

		if ( ! is_object($object) ) {
			throw new Exception("Failed to parse webpage!" . $url . ": " . $con->webpage(), 403);
		}

		phpQuery::newDocumentHTML($object->items_html);

		$next_page_cursor = false;

		$tweets = array();

		// Loop through all the tweets and extract the information
		foreach ( pq('.js-stream-tweet[data-tweet-id]') as $tweet ) {
			$tweet = pq($tweet);

			if ( is_object($tweet) ) {

				$time = "";

				$relative = $tweet->find(".js-relative-timestamp")->attr("data-time");

				if ( ! empty($relative) ) {
					$time = $tweet->find(".js-relative-timestamp")->attr("data-time");
				} else {
					$time = $tweet->find(".js-short-timestamp")->attr("data-time");
				}

				$tweet_array = array(
					"tweet_id" => $tweet->attr("data-tweet-id"),
					"created_at" => $time,
				);

				$tweet_id = $tweet->attr("data-tweet-id");

				// Append the tweet to the list
				$tweets[$tweet_id] = array_merge($tweet_array, $meta);
			}
		}

		if ( $not_first == false && property_exists($object, "refresh_cursor") ) {
			$refresh_cursor = $object->refresh_cursor;
		} else if ( $not_first == false && in_array($type, array("profile", "timeline")) ) {
			$first = current($tweets);
			$refresh_cursor = $first["tweet_id"];
		}

		// If more pages available that are newer then the last fetched and newer then the maxed save time, set the next cursor
		$last_element = end($tweets);
		if ( $last_element["created_at"] > (time() - $max_timestamp) ) {
			if ( ! empty($last_inserted_cursor) && property_exists($object, "scroll_cursor") ) {
				if ( $this->_cursor_different($object->scroll_cursor, $last_inserted_cursor, $oldest) && $last_element["created_at"] > ( time() - $max_timestamp ) ) {
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
				}
			}
		}

		// If more newer pages to load, load em
		if ( $next_page_cursor !== false && $last_element["created_at"] > ( time() - $max_timestamp ) ) {
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
}
?>