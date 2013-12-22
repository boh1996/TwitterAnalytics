<?php
class Urls {
	/**
	 * The url to post Username and Password to, when login in
	 */
	const TWITTER_LOGIN_POST_URL = "https://twitter.com/sessions";

	/**
	 * The name of the post field for the username/email
	 */
	const TWITTER_USERNAME_OR_EMAIL_FIELD_NAME = "session[username_or_email]";

	/**
	 * The name of the password post field
	 */
	const TWITTER_PASSWORD_FIELD_NAME = "session[password]";

	/**
	 * The Twitter login page, to get the authentication token from
	 */
	const TWITTER_LOGIN_URL = "https://twitter.com/login";

	const TWITTER_TOKEN_FIELD = "authenticity_token";
}
?>