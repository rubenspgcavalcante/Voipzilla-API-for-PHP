<?php

/**
 * API class hight level
 * 
 *
 * @author Mob Dev Team
 * @version 0.1 
 * @package voipzilla-API-for-PHP
 * 
 */

//TODO: dinamic model loading
require_once( dirname(__FILE__) . '/models/Client_Model.php' );
require_once( dirname(__FILE__) . '/models/Ppcc_Model.php' );
require_once( dirname(__FILE__) . '/Log_Voipzilla.php' );
require_once( dirname(__FILE__) . '/config.php' );

class Voipzilla_API{
	var $client;
	var $ppcc;
	var $daemonConf;

	/**
    * Daemon counter
    * @var Array
    */
	var $cnt;

	function __construct(){
		global $config;
		$this->daemonConf	= $config["voipzilla"]["daemon"];
		$this->cnt 			= 1;
		//TODO: dinamic model loading
		$this->client 	= new Client_Model();
		$this->ppcc 	= new Ppcc_Model();

	}

	/**
    * Evaluates if a model exists
    *
    * @access private
    * @return bool exists or not
    */
	private function _modelExist($name){
		$format = strtoupper($name[0]).substr($name, 1);
		$path = dirname(__FILE__)."/models/".$format."_Model.php";
		return file_exists($path);
	}

	/**
    * Connection daemon
    * Recursive method to try connect again.
    * The number of retries are in the config file
    *
    * @access private
    * @param string $method the method from this own object who will be called
    * @param array $pack the atributes required to run the method again, in format (model, method, data)
    * @uses Log_Voipzilla::save() saves in the log the number of tries
    * @return string|NULL response of the server
    */
	private function _connDaemon($call, $pack){
		$model = $pack["model"];
		$attr = $pack["attr"];
		$data = $pack["data"];
		$log = "[Message][API Daemon] ";

		if($this->cnt < $this->daemonConf["retries"]){

			$delay = $this->daemonConf["delay"];
			Log_Voipzilla::save($log."Sleeping $delay seconds");
			sleep($delay);
			Log_Voipzilla::save($log."Trying $call $attr again. Try number: $this->cnt");
			$this->cnt++;
			$this->$call($model, $attr, $data);

		}
		else{
			$log .= "Tried too much!";
			Log_Voipzilla::save($log);
		}
	}

    /**
    * Search method from models
    *
    * @access public
    * @param string $model Wich model instance will be used
    * @param string $atr wich attr from the model instance will be used
    * @param array $data the params and datas ("param1" => "data1", "param2" => "data2", ...)
    * @uses self::_connDaemon() daemon to try to connect again
    * @return string|NULL response of the server
    */
	public function search($model, $attr, $data){
		
		$vars = get_class_vars(get_class($this));

		/**
		* We'll try catch any exception trowed in the model files by the "Voipzilla_Socket"
		* instances. If catch any, we'll call the daemon method to recall the process. There's
		* a maximum number of recalls. If tried too much, the API will stops the calls.
		*/
		try{
			if(!$this->_modelExist($model)) return NULL;
			/**
			* Now, we call the apropriated model, if any exception occur we call the same
			* method again, until the maximum tries was reached.
			*/
			$res = $this->$model->search($attr, $data);
			$this->cnt = 1; // Everything OK! Reseting retries...
			return $res;
		}
		catch(Exception $e){
			$pack = array("model" => $model, "attr" => $attr, "data" => $data);
			$this->_connDaemon(__FUNCTION__, $pack);
			return NULL;
		}

	}

}