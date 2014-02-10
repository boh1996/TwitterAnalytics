<?php
class Core {

		/**
	 * This function generates a random string
	 * @param  integer $Length The length of the random string
	 * @param  string  $Chars  The Charset to use
	 * @return string
	 * @author Kyle Florence <kyle.florence@gmail.com>
	 */
	function rand_str($Length = 32, $Chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890')
	{
	    $Chars_Length = (strlen($Chars) - 1);
	    $String = $Chars{rand(0, $Chars_Length)};
	    for ($I = 1; $I < $Length; $I = strlen($String))
	    {
	        $R = $Chars{rand(0, $Chars_Length)};
	        if ($R != $String{$I - 1}) $String .=  $R;
	    }
	    return $String;
	}

	// Function to validate the post data
	function validate_database_post($data)
	{
		/* Validating the hostname, the database name and the username. The password is optional. */
		return !empty($data['hostname']) && !empty($data['username']) && !empty($data['database']) && !empty($data['port']);
	}

	function validate_app_post ( $data ) {
		return ! empty($data['base_url']);
	}

	// Function to show an error
	function show_message($type,$message) {
		return $message;
	}

	// Function to write the config file
	function write_database_config($data) {

		// Config path
		$template_path 	= 'config/database.php';
		$output_path 	= '../application/config/database.php';

		// Open the file
		$database_file = file_get_contents($template_path);

		$new  = str_replace("%HOSTNAME%",$data['hostname'],$database_file);
		$new  = str_replace("%USERNAME%",$data['username'],$new);
		$new  = str_replace("%PASSWORD%",$data['password'],$new);
		$new  = str_replace("%DATABASE%",$data['database'],$new);
		$new  = str_replace("%PORT%",$data['port'],$new);

		// Write the new database.php file
		$handle = fopen($output_path,'w+');

		// Chmod the file, in case the user forgot
		@chmod($output_path,0777);

		// Verify file permissions
		if(is_writable($output_path)) {

			// Write the file
			if(fwrite($handle,$new)) {
				return true;
			} else {
				return false;
			}

		} else {
			return false;
		}
	}

	function validate ( $data ) {
		return $this->validate_database_post($data);
	}

	function write_config ($data) {
		return $this->write_database_config($data) && $this->write_login_config($data) && $this->write_app_config($data);
	}

	function write_login_config($data) {

		// Config path
		$template_path 	= 'config/login.php';
		$output_path 	= '../application/config/login.php';

		// Open the file
		$file = file_get_contents($template_path);

		$new  = str_replace("%APP_HASHING_SALT%",$this->rand_str(32),$file);
		$new  = str_replace("%LOGIN_SECRET%",$this->rand_str(32),$new);

		// Write the new database.php file
		$handle = fopen($output_path,'w+');

		// Chmod the file, in case the user forgot
		@chmod($output_path,0777);

		// Verify file permissions
		if(is_writable($output_path)) {

			// Write the file
			if(fwrite($handle,$new)) {
				return true;
			} else {
				return false;
			}

		} else {
			return false;
		}
	}

	function write_app_config($data) {

		// Config path
		$template_path 	= 'config/config.php';
		$output_path 	= '../application/config/config.php';

		// Open the file
		$file = file_get_contents($template_path);

		$new  = str_replace("%SESSION_ENCRYPT_KEY%",$this->rand_str(16),$file);
		$new  = str_replace("%ENCRYPT_KEY%",$this->rand_str(32),$new);
		$new  = str_replace("%ENCRYPT_SALT%",$this->rand_str(32),$new);
		$new  = str_replace("%BASE_URL%",$data['base_url'],$new);

		// Write the new database.php file
		$handle = fopen($output_path,'w+');

		// Chmod the file, in case the user forgot
		@chmod($output_path,0777);

		// Verify file permissions
		if(is_writable($output_path)) {

			// Write the file
			if(fwrite($handle,$new)) {
				return true;
			} else {
				return false;
			}

		} else {
			return false;
		}
	}
}