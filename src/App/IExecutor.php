<?php


namespace App;


interface IExecutor
{

	/**
	 * @param string $command
	 *
	 * @return \App\ExecutorOutput
	 */
	public function execute($command);


	/**
	 * @return string|null
	 */
	public function getLastError();
}
