<?php


namespace App;


interface IExecutor
{

	/**
	 * @param string $command
	 *
	 * @return string|false
	 */
	public function execute($command);


	/**
	 * @return string|null
	 */
	public function getLastError();
}
