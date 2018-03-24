<?php 
//La siguiente clase es construida con patron siggletone
//Esto es una sola instancia de la clase en toda la sesion
namespace App;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class Log {
	private static $_logger = null;

	private static function getLogger(){
		//si ya se inició el logger solo se regresa
		if(!self::$_logger) {
			//iniciar logger
			self::$_logger = new Logger('App Log');
		}
		return self::$_logger;
	}

	public static function logError($error){
		//pushHandler es obtener un archivo donde
		//se va a guardar el log
		//streamHandler(log, direccion de archivo, tipo de archivo)
		self::getLogger()->pushHandler(
			new StreamHandler('../logs/application.log',Logger::ERROR));

		//guardar
		self::getLogger()->addError($error);
	}

	public static function infoError($info){

	self::getLogger()->pushHandler(
		new StreamHandler('../logs/application.log',Logger::INFO));
	self::getLogger()->addInfo($info);
	}
}