<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Socket prepared to connect into Voipzilla Server
 * 
 * @author Mob Dev Team
 * @version 0.1 
 * @package voipzilla-socket
 * 
 */

require_once( dirname(__FILE__) . '/config.php' );
require_once( dirname(__FILE__) . '/Log_Voipzilla.php' );

class Voipzilla_Socket{
    var $sockConfig;
    var $user;
    var $socket;

    function __construct(){
        global $config;
        $this->sockConfig   = $config["voipzilla"]["socket-config"];
        $this->user         = $config["voipzilla"]["user-info"];
    }

    function __destruct(){
        $this->_disconect();
    }

     /**
     * Set a newline error log
     *
     * @access private
     * @uses Log_Voipzilla::save() Save a newline in log
     */
    private function _logError(){
        $errno = socket_last_error($this->socket);
        Log_Voipzilla::save("[ERROR]".socket_strerror($errno));
    }

     /**
     * Set a newline into log
     * @param string $message 
     * @access private
     * @uses Log_Voipzilla::save() Save a newline in log
     */
    private function _log($message){
        Log_Voipzilla::save("[MESSAGE]".$message);
    }

	/**
	 * Verfify if the socket is connected
	 *
	 * @access public
	 * @return bool is connected or not
	 */
    function isConnected(){
        return (isset($this->socket) or socket_last_error($this->socket) != NULL);
    }

	/**
	 * Create a new connection object
	 *
	 * @access private
	 * @return object|NULL returns socket object or NULL
	 */
    private function _connect(){
        $this->socket = socket_create(
            $this->sockConfig["domain"],
            $this->sockConfig["type"],
            $this->sockConfig["protocol"]);

        if(!socket_connect($this->socket, $this->sockConfig["server"], $this->sockConfig["port"])){
            $this->_logError();
            return NULL;
        }
        else if(!$this->isConnected()){
            return NULL;
        }
        $buff  = socket_read($this->socket, 1024, $this->sockConfig["readtype"]);
        if($buff === false){
            $this->_logError();
            $this->_log("Connection NOT succefully");
            die();
        }
        else $this->_log($buff."<CONNECTED NOW>");

        $login_command      = "login ".$this->user["login"]."\n";
        $password_command   = "password ".$this->user["password"]."\n";

        $res = socket_write($this->socket, $login_command, strlen($login_command)) and
               socket_write($this->socket, $password_command, strlen($password_command));

        if($res){
            $buff = socket_read($this->socket, 1024, $this->sockConfig["readtype"]);
            if($buff === false)
                $this->_logError();
            return NULL;
        }
    }
    
    private function _disconect(){
        if($this->isConnected()){
            socket_write($this->socket, "bye\n", 4);
            socket_close($this->socket);
            $this->_log("<DISCONNECTED NOW>");
        }        
    }

	/**
	 * Send a command to the server and get the response
	 *
	 * @access public
	 * @return string|NULL the server response
	 */
    function command($cmd){
        $this->_connect();
        if(!isset($cmd) or !$this->isConnected()) return NULL;
        $command = "command ".$cmd."\n\n";
        if( !socket_write($this->socket, $command, strlen($command)) ){
            $this->_logError();
            return NULL;
        }
        else
            $res = socket_read($this->socket, 100, $this->sockConfig["readtype"]);
            if($res === false){
                $this->_logError();
                return NULL;
            }
        $this->_disconect();
        return $res;
    }   

}
