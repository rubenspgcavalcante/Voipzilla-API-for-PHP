<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Socket configuration to access voipzilla servers
 * 
 * @author Mob Dev Team
 * @version 0.1 
 * @package voipzilla-socket
 * 
 */

if(!isset($config)){
    /**
    * Config variable
    * @var Array
    */
    var $config = new array();
}

//-----------------------------------
//
// Voipzilla access info
//
//-----------------------------------
$config["voipzilla"] =
array(
    "server"    => "", // server adress
    "port"      => "8080", //default port
);


