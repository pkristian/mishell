<?php


namespace App;


class ProfileRunner
{

	/**
	 * @var \Monolog\Logger
	 */
	public $log;

	/**
	 * @var \App\Runtime
	 */
	public $runtime;


	/**
	 * @var \App\IExecutor
	 */
	public $executor;


	/**
	 * @var \App\Profile
	 */
	public $profile;


	/**
	 * ProfileRunner constructor.
	 *
	 * @param \Monolog\Logger $log
	 * @param \App\Runtime $runtime
	 */
	public function __construct(\Monolog\Logger $log, \App\Runtime $runtime, IExecutor $executor)
	{
		$this->log = $log;
		$this->runtime = $runtime;
		$this->executor = $executor;

		$this->profile = $this->runtime->profile;
	}


	public function runProfile()
	{
		if ($this->profile->logFile)
		{
			/** @var \App\Log\StreamHandler $logFileHandler */
			$logFileHandler = clone $this->log->getHandlers()[0];
			$logFileHandler->setUrl(
				$this->runtime->workingDirectory . DIRECTORY_SEPARATOR . $this->runtime->profile->logFile
			);
			$logFileHandler->setLevel($this->runtime->profile->logLevel);
			$this->log->pushHandler($logFileHandler);
		}

		$this->log->info("* * Starting profile: " . $this->profile->name);
		$this->checkUser();
		$this->changeDirectory();
		$this->fetch();
		$targetCommit = $this->targetCommit();


		if ($targetCommit)
		{
			$this->deploy();
		}
	}


	/* privates */

	private function checkUser()
	{
		$this->log->info("* Checking user...");

		$requiredUser = $this->profile->requiredUser;
		$this->log->debug("required user: " . $requiredUser);
		if ($requiredUser)
		{
			$currentUser = get_current_user();
			$this->log->debug("current user: " . $currentUser);
			if ($this->profile->requiredUser != $currentUser)
			{
				$this->log->error("user mismatch");
				throw new Exception("wrong user: '$currentUser' should been '$requiredUser'");
			}
		}
	}


	private function changeDirectory()
	{
		$dir = $this->profile->repositoryDirectory;
		$this->log->info("* cd " . $dir);

		/* cd to directory */
		$good = chdir($dir);
		if (!$good)
		{
			$message = "Cannot cd to '$dir'";
			$this->log->err($message);
			throw new Exception($message);
		}
	}


	private function fetch()
	{
		$this->log->info('* Fetching...');

		$remote = $this->profile->repositoryRemote;
		$branch = $this->profile->repositoryBranch;

		if (!$this->profile->repositoryRemote)
		{
			$this->log->notice('remote is not set');

			return;
		}

		$command = "git fetch $remote $branch";
		$this->log->info(">>\$ $command");
		$fetched = $this->executor->execute($command);
		if (!$fetched)
		{
			$this->log->err("cannot fetch");
			throw new Exception(
				"Could not fetch from remote '$remote' branch '$branch':"
				. $this->executor->getLastError()
			);
		}

	}


	/**
	 * @return string|null
	 * @throws \App\Exception
	 */
	private function targetCommit()
	{
		$this->log->info('* Checking right revision...');

		/* current */
		$command = 'git rev-parse HEAD';
		$this->log->debug(">>\$ $command");
		$commitCurrent = $this->executor->execute($command);

		if ($commitCurrent->code)
		{
			$message = 'Cannot get hash of current commit: ' . $this->executor->getLastError();
			$this->log->error($message);
			throw new Exception($message);
		}
		$commitCurrentHash = $commitCurrent->out;
		$this->log->debug("current commit: $commitCurrentHash");


		/* target */
		$command = "git show-ref {$this->profile->getFullBranch()} | awk '{print $1}'";
		$this->log->debug(">>\$ $command");
		$commitTarget = $this->executor->execute($command);
		if ($commitTarget->code)
		{
			$message = 'Cannot get hash of target commit: ' . $this->executor->getLastError();
			$this->log->error($message);
			throw new Exception($message);
		}
		$commitTargetHash = $commitTarget->out;
		$this->log->debug("target commit:  $commitTargetHash");


		/* ?? deploy */
		$commitsSame = $commitTargetHash === $commitCurrentHash;
		if ($commitsSame)
		{
			$this->log->debug('commits are same');

			return null;
		}

		$this->log->debug('commits differ');

		return $commitTargetHash;
	}


	private function deploy()
	{
		$this->log->info("* * Deploying...");

		$commandBefore = $this->profile->commandBefore;
		$commandDeploy = "git checkout -f {$this->profile->getFullBranch()}";
		$commandAfter = $this->profile->commandAfter;


		if ($commandBefore)
		{
			$this->log->debug(">>\$ $commandBefore");
			$this->executor->execute($commandBefore);
		}

			$this->log->debug(">>\$ $commandDeploy");
			$this->executor->execute($commandDeploy);
;

		if ($commandAfter)
		{
			$this->log->debug(">>\$ $commandAfter");
			$this->executor->execute($commandAfter);
		}
	}

	/* privates */


}
