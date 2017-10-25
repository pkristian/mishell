<?php


namespace App\Exec;


interface IExecutor
{

	/**
	 * @param string $command
	 * @param null|string $user
	 *
	 * @return \App\Exec\ExecutorOutput
	 */
	public function execute($command, $user = null);


	/**
	 * @return string|null
	 */
	public function getLastError();
}
