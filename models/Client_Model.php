<?php

/**
 * Voipzilla client model
 * 
 *
 * @author Mob Dev Team
 * @version 0.1 
 * @package voipzilla-API-for-PHP
 * 
 */

require_once( dirname(__FILE__) . '/../Voipzilla_Socket.php' );

 class Client_Model{
	
	var $sock;

	function __construct(){
		$this->sock = new Voipzilla_Socket();
	}

    /**
    * Search attribute from a client
    *
    * @access public
    * @param string $attr Attribute that will be searched
    * @param array $data the params and datas ("param1" => "data1", "param2" => "data2", ...)
    * @uses Voipzilla_Socket::command() to get the information
    * @return string|NULL response of the server
    */
	public function search($attr, $data){
		if(!isset($attr) or !isset($data)) return NULL;
		switch ($attr) {
			case 'cnpj_cpf':
				//Data needs to have a valid cpf or cnpj
				if(!array_key_exists("cnpj_cpf", $data)){
					return NULL;
				}
				$res = $this->sock->command("cli-search-cnpj_cpf", $data);
				break;

			case 'auth':
				//Data needs to have a valid auth
				if(!array_key_exists("auth", $data)){
					return NULL;
				}
				if(array_key_exists("password", $data)){
					// Search with auth and password
					$res = $this->sock->command("cli-search-auth-pwd", $data);
				}
				else{
					// Search only with auth
					$res = $this->sock->command("cli-search-auth", $data);
				}
				break;
			
			default:
				return "Command not found";
		}
		return $res;
	}

    /**
    * Search attribute from a client
    *
    * @access public
    * @param string $attr Attribute that will be searched
    * @param array $data the params and datas ("param1" => "data1", "param2" => "data2", ...)
    * @uses Voipzilla_Socket::command() to get the information
    * @return string|NULL response of the server
    */
	public function retrieve($attr, $data){
		if(!isset($attr) or !isset($data)) return NULL;
		switch ($attr) {
			case 'data':
				//Data needs to have a valid client-id
				if(!array_key_exists("cliente", $data)){
					return NULL;
				}
				$param = array($data);
				$res = $this->sock->command("cli-retrieve-data");
				break;

			case 'ani':
				//Data needs to have a valid client-id
				if(!array_key_exists("cliente", $data)){
					return NULL;
				}
				if(array_key_exists("ani", $data)){
					// Search with client-id and ani-id
					$res = $this->sock->command("cli-retrieve-ani", $data); 
				}
				else{
					// Search only with client-id
					$res = $this->sock->command("cli-retrieve-ani", $data);
				}
				break;

			case 'auth':
				//Data needs to have a valid client-id
				if(!array_key_exists("cliente", $data)){
					return NULL;
				}
				// Search with client-id and/or ani-id
				$res = $this->sock->command("cli-retrieve-auth", $data); 
				break;

			case 'cdr':
				//Data needs to have a valid client-id, and begin/end dates in YYYY-MM-DD format
				if(	!array_key_exists("cliente", $data) and
					!array_key_exists("data_inicio", $data) and
					!array_key_exists("data_fim", $data) ){
					return NULL;
				}
				// Search with cliente-id and ani-id
				$res = $this->sock->command("cli-retrieve-cdr", $data); 
				break;

			case 'baltrans':
				//Data needs to have a valid client-id, and begin/end dates in YYYY-MM-DD format
				if(	!array_key_exists("cliente", $data) and
					!array_key_exists("ultimas", $data) ){
					return NULL;
				}
				// Search with cliente-id and ani-id
				$res = $this->sock->command("cli-retrieve-baltrans", $data); 
				break;

			default:
				return "Command not found";
		}
		return $res;
	}

    /**
    * Blocks a auth or ani from a client
    *
    * @access public
    * @param string $attr Attribute that will be searched
    * @param array $data the params and datas ("param1" => "data1", "param2" => "data2", ...)
    * @uses Voipzilla_Socket::command() to set the information
    * @return string|NULL response of the server
    */
	public function block($attr, $data){
		//Data needs to have a valid client-id, and a auth or ani
		if(	!array_key_exists("cliente", $data) and
			!array_key_exists("auth", $data)){
			return NULL;
		}
		// Search with cliente-id and ani-id
		$res = $this->sock->command("cli-block", $data); 
		break;
	}

}