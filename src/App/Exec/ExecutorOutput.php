<?php


namespace App\Exec;


class ExecutorOutput
{

	/**
	 * @var string
	 */
	public $command = '';

	/**
	 * @var int
	 */
	public $code;

	/**
	 * @var string
	 */
	public $out;

	/**
	 * @var string
	 */
	public $err;
}
