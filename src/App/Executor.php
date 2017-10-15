<?php


namespace App;


class Executor implements IExecutor
{

	private $lastError;


	/**
	 * @param string $command
	 *
	 * @return string|false
	 */
	public function execute($command)
	{

		ob_start();
		passthru($command . ' 2>&1', $error);
		$output = ob_get_clean();
		if ($error)
		{
			$this->lastError = $output;

			return false;
		}

		return $output;
	}


	/**
	 * @return string|null
	 */
	public function getLastError()
	{
		return $this->lastError;
	}
}
