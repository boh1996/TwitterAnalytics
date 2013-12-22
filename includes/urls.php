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

	/**
	 * The post field to assign the token to
	 */
	const TWITTER_TOKEN_FIELD = "authenticity_token";

	/**
	 * The Front page url where the tweets are displayed
	 */
	const TWITTER_FRONT_PAGE_URL = "https://twitter.com/";

	/**
	 * The Twitter timeline feed URL
	 */
	const TWITTER_TIMELINE = "https://twitter.com/i/timeline?composed_count={{COMPOSED_COUNT}}}&include_available_features={{INCLUDE_AVAILABLE_FEATURES}}&include_entities={{INCLUDE_ENTITIES}}&interval={{INTERVAL}}}&last_note_ts={{LAST_NOTE_TS}}&latent_count={{LATENT_COUNT}}&since_id={{SINCE_ID}}";
}
?>