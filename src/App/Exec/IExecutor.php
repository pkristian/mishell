<?php


namespace App\Exec;


interface IExecutor
{

	/**
	 * @param string $command
	 *
	 * @return \App\Exec\ExecutorOutput
	 */
	public function execute($command);


	/**
	 * @return string|null
	 */
	public function getLastError();
}
