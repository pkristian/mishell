<?php


namespace App;


class Executor implements IExecutor
{

	private $lastError;


	/**
	 * @param string $command
	 *
	 * @return \App\ExecutorOutput
	 */
	public function execute($command)
	{
		$r = new ExecutorOutput();
		$r->command = $command;


		$descriptorspec = [
			0 => ["pipe", "r"],  // stdin
			1 => ["pipe", "w"],  // stdout
			2 => ["pipe", "w"],  // stderr
		];

		$process = proc_open($command, $descriptorspec, $pipes, getcwd(), null);

		$stdout = stream_get_contents($pipes[1]);
		fclose($pipes[1]);

		$stderr = stream_get_contents($pipes[2]);
		fclose($pipes[2]);

		$r->code = proc_close($process);
		$r->out = trim($stdout);
		$r->err = trim($stderr);

		return $r;
	}


	/**
	 * @return string|null
	 */
	public function getLastError()
	{
		return $this->lastError;
	}
}
