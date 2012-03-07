<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Log class to Voipzilla api
 * 
 * @author Mob Dev Team
 * @version 0.1 
 * @package voipzilla-socket
 * 
 */

require_once( dirname(__FILE__) . '/config.php' );

class Log_Voipzilla{
    private static $logConf;

	/**
	 * Verfify if the socket is connected
	 *
	 * @access public
	 * @return bool is connected or not
	 */
	static function save($log){
		global $config;
		self::$logConf = $config["log"]["structure"];
		$file = dirname(__FILE__)."/".self::$logConf["directory"].date(self::$logConf["name-format"]).self::$logConf["extension"];
		@$file = fopen($file, "a");
		if(!$file){
			return NULL;
		}
		$prefix = date(self::$logConf["log-prefix"]);
		fwrite($file, $prefix.$log."\n");
		fclose($file);
	}


}