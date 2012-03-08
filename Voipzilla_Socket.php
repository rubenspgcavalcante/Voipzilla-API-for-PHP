<?php

/**
 * Socket prepared to connect into Voipzilla Server
 * 
 * @author Mob Dev Team
 * @version 0.1 
 * @package voipzilla-API-for-PHP
 * 
 */

require_once( dirname(__FILE__) . '/config.php' );
require_once( dirname(__FILE__) . '/Log_Voipzilla.php' );

class Voipzilla_Socket{
    var $sockConfig;
    var $user;
    var $socket;
    var $verbose;
    var $alive;

    /**
    * Class constructor
    * @param bool $verbose optional verbose, default false
    */
    function __construct($verbose = false){
        global $config;
        $this->sockConfig   = $config["voipzilla"]["socket-config"];
        $this->user         = $config["voipzilla"]["user-info"];
        $this->verbose      = $verbose;
        $this->alive        = false;
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
        // Tranforming multiple lines in just one
        $message = preg_replace("/(\r\n|\n|\r)+/", " ", socket_strerror($errno));
        $res = Log_Voipzilla::save("[ERROR]".$message);
        if($this->verbose) echo $res;
    }

     /**
     * Set a newline into log
     * @access private
     * @param string $message 
     * @uses Log_Voipzilla::save() Save a newline in log
     */
    private function _log($message){
        // Tranforming multiple lines in just one
        $message = preg_replace("/(\r\n|\n|\r)+/", " ", $message);
        $res = Log_Voipzilla::save("[MESSAGE]".$message);
        if($this->verbose) echo $res;
    }

	/**
	 * Verfify if the socket is connected
	 *
	 * @access public
	 * @return bool is connected or not
	 */
    function isConnected(){
        return (isset($this->socket) and $this->alive);
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
        $buff  = socket_read($this->socket, 1024, $this->sockConfig["readtype"]);
        if($buff === false){
            $this->_logError();
            $this->_log("Connection NOT succefully");
            $this->_disconect();
            return NULL;
        }
        else $this->_log($buff."<CONNECTED NOW>");

        $login_command      = "login ".$this->user["login"]."\n";
        $password_command   = "password ".$this->user["password"]."\n\n";

        $this->_log("Trying user ".$this->user["login"]);

        /* 
        * We write the login and password in the socket and verify if all the bytes
        * was really send to the server.
        */
        $res = socket_write($this->socket, $login_command, strlen($login_command)) +
               socket_write($this->socket, $password_command, strlen($password_command));

        if($res != strlen($login_command)+strlen($password_command)){
            $this->_logError("Can't send all the bytes.");
            $this->_disconect();
        }

        $buff = socket_read($this->socket, 1024, $this->sockConfig["readtype"]);
        if($buff === false){
            $this->_logError();
            $this->_disconect();
        }
        else{
            $this->alive = true;
        }
        return NULL;

    }
    
    private function _disconect(){
        if($this->isConnected()){
            $this->alive = false;
            socket_write($this->socket, "bye\n", 4);
            socket_close($this->socket);
            $this->_log("<DISCONNECTED NOW>");
        }        
    }

	/**
	 * Send a command to the server and get the response
	 *
	 * @access public
     * @param string $cmd command
     * @param array $params("prefix","data") parameters to the command
	 * @return string|NULL the server response
	 */
    function command($cmd, $params){
        $this->_connect();
        if(!isset($cmd) or !$this->isConnected()) return NULL;
        
        /*
        * First we send the command that we want
        */
        $command = "command ".$cmd."\n";
        $this->_log("Trying ".$command);
        $res = socket_write($this->socket, $command, strlen($command));
        if($res != strlen($command)){
            $this->_logError();
            return NULL;
        }

        $request = $params["prefix"]." ".$params["data"]."\n\n\n";
        $res = socket_write($this->socket, $request, strlen($request));
        if($res != strlen($request)){
            $this->_logError();
            $this->_disconect();
            return NULL;
        }
        else{
            $res = socket_read($this->socket, 1024, $this->sockConfig["readtype"]);
            if($res === false){
                $this->_logError();
                $this->_disconect();
                return NULL;
            }        
        }
        $this->_disconect();
        return $res;
    }   

}
