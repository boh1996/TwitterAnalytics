<?php
/**
 * @author Bo Thomsen <bo@illution.dk>
 * @package Twitter Analytics
 * @category Analytics
 * @uses Codeigniter Uses the Codeigniter Framework
 * @copyright Bo Thomsen, 2014
 * @subpackage User mMnagement
 * @license Microsoft Reference License
 * @version 1.0
 * @filesource
 */
class User_Control{

	/**
	 * A pointer to the current instance of CodeIgniter
	 * @var object
	 * @since 1.0
	 * @access private
	 */
	private $_CI = NULL;

	/**
	 * The current user language
	 * @var string
	 * @since 1.0
	 * @access public
	 */
	public $language = "english";

	/**
	 * The current user
	 * @since 1.0
	 * @access public
	 * @var object
	 */
	public $user = null;

	/**
	 * The standard language files to load
	 * @since 1.0
	 * @access public
	 * @var array
	 */
	public $languageFiles = array("common", "admin", "user");

	/**
	 * This function calls all the needed security functions
	 * @since 1.0
	 * @access public
	 */
	public function __construct(){
		$this->_CI =& get_instance();

		$this->_CI->load->model("base_model");
		$this->_CI->load->model("settings_model");

		date_default_timezone_set($this->_CI->settings_model->fetch_setting("setting_timezone", "Europe/Copenhagen", "scraper"));

		if ( isset($_GET["language"]) && array_key_exists($_GET["language"], $this->_CI->config->item("languages")) ) {
			$this->language = $_GET["language"];
		}
		if ( empty($this->language) ) {
			$this->language = $this->_CI->config->item("language");
		}

		self::batch_load_lang_files($this->languageFiles);
	}

	/**
	 * This function loads up lang files using an array
	 * @param  array  $files The array of file without extension and _lang
	 * @since 1.0
	 * @access public
	 */
	public function batch_load_lang_files ( array $files ) {
		$this->languageFiles = array_unique(array_merge($this->languageFiles,$files));
 		foreach ( $files as $file ) {
 			if ( is_file(FCPATH . "application/language/" . $this->language . "/" . $file . "_lang.php") ) {
 				$this->_CI->lang->load($file, $this->language);
 			}
 		}
	}

	/**
	 * This function changes the current language and reloads the standard language files
	 * @since 1.0
	 * @access public
	 * @param string $language The language to change too
	 */
	public function ReloadLanguageFiles ($language) {
		if ( array_key_exists($language , $this->_CI->config->item("languages")) ) {
			$this->language = $language;
			self::batch_load_lang_files($this->languageFiles);
		}
	}

	/**
	 * This function replaces all the template variables with the desired value
	 * @param array $variables An array of the keys to replace and the values to replace them with
	 * @param string $template  The template as string
	 * @return string
	 * @since 1.0
	 * @access private
	 */
	public function Template ( $variables, $template ) {
		$content = $template;
		foreach ( $variables as $variable => $value ) {
			$content = str_replace($variable, $value, $content);
		}
		return $content;
	}

	/**
	 * Checks if the user is signed in
	 * @return boolean
	 */
	public function is_signed_in () {
		if ( $this->_CI->session->userdata('signed_in') === false ) {
			return false;
		}

		return true;
	}

	/**
	 * This function checks if the current page requires security and if the level of security is full-filled.
	 * @param  string $page The current page
	 * @return boolean       "true" is autherized and "false" is not autherized for the page
	 */
	public function check_security ( $page ) {
		$this->_CI->load->model("access_model");

		if ( $this->_CI->access_model->page_requires_login($page) ) {
			return ( $this->is_signed_in() === true ) ? true : false;
		} else {
			return true;
		}
	}

	/**
	 * This function checks if http should be enabled
	 * @since 1.0
	 * @access public
	 */
	public function CheckHTTPS ($url) {
		$url = str_replace("http://", "", $url);
		$url = str_replace("https://","", $url);
		return ( $this->_CI->config->item("https") == true ) ? "https://" . $url:  "http://" . $url;
	}

	/**
	 * This function loads a view with controller info
	 * @param string $template The name of the template without the templates/ directory
	 * @param array $data
	 * @since 1.0
	 * @access public
	 * @return string
	 */
	public function LoadTemplate ($template, $data = null) {
		return $this->_CI->load->view("templates/".$template, self::ControllerInfo($data),true);
	}

	/**
	 * This function can merge Víew data and Standard view data
	 * @since 1.0
	 * @access public
	 * @param array $params The view data
	 * @return array
	 */
	public function ControllerInfo ($params = null) {
		$this->_CI->load->model("view_model");
		$headers = $this->_CI->view_model->get_pages_ordered_in_sections();
		$languages = $this->_CI->config->item("languages");
		$settings = array(
			"languages" => $languages,
			"language" => $this->language,
			"base_url" => $this->CheckHTTPS(base_url()),
			"asset_url" => $this->CheckHTTPS($this->_CI->config->item("asset_url")),
			"headers" => $headers,
			"signed_in" => $this->is_signed_in()
		);
 		if ( ! is_null($params) ) {
			return array_merge($params, $settings);
		} else {
			return $settings;
		}
	}
}
?>