<?php

/**
 * Voipzilla ppcc model
 * 
 *
 * @author Mob Dev Team
 * @version 0.1 
 * @package voipzilla-API-for-PHP
 * 
 */

require_once( dirname(__FILE__) . '/../Voipzilla_Socket.php' );

 class Ppcc_Model{
	
	var $sock;

	function __construct(){
		$this->sock = new Voipzilla_Socket();
	}

}