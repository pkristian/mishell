<?php


namespace App;


class MiException extends \Exception
{

	public function __construct($message = "", $code = \Monolog\Logger::ERROR, \Throwable $previous = null)
	{
		parent::__construct($message, $code, $previous);
	}
}
