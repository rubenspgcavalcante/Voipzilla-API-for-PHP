<?php //if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Log class to Voipzilla api
 * 
 * @author Mob Dev Team
 * @version 0.1 
 * @package Voipzilla-API-for-PHP
 * 
 */

require_once( dirname(__FILE__) . '/config.php' );

class Log_Voipzilla{
    private static $logConf;

	/**
	 * Saves a newline log
	 *
	 * @access public
	 * @param string $log what will be writen
	 * @return string|NULL what was writed or NULL if wasn't possible open the file
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
		$write = $prefix.$log."\n";
		fwrite($file, $write);
		fclose($file);
		return $write;
	}


}