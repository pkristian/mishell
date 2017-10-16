<?php


namespace App;


class Main
{

	/**
	 * @var \App\Runtime
	 */
	public $runtime;


	/**
	 * @var \App\IExecutor
	 */
	public $executor;


	/**
	 * Main constructor.
	 */
	public function __construct($arguments)
	{
		$this->runtime = new Runtime($arguments);
		$this->executor = new Executor();


		$this->runProfile($this->runtime->profile);
	}


	private function runProfile(Profile $profile)
	{
		/* check user */
		if ($profile->requiredUser)
		{
			$currentUser = get_current_user();
			if ($profile->requiredUser != $currentUser)
			{
				throw new Exception("wrong user: '$currentUser' should been '$profile->requiredUser'");
			}
		}

		/* cd to directory */
		$good = chdir($profile->repositoryDirectory);
		if (!$good)
		{
			throw new Exception("Cannot cd to '$profile->repositoryDirectory'");
		}

		/* fetch */
		if ($profile->repositoryRemote)
		{
			$fetched = $this->executor->execute("git fetch $profile->repositoryRemote $profile->repositoryBranch");
			if (!$fetched)
			{
				throw new Exception(
					"Could not fetch from remote '$profile->repositoryRemote' branch '$profile->repositoryBranch':"
					. $this->executor->getLastError()
				);
			}
		}

		/* on right commit? */
		$commitCurrent = $this->executor->execute('git rev-parse HEAD');
		if ($commitCurrent->code)
		{
			throw new Exception('Cannot get hash of current commit: ' . $this->executor->getLastError());
		}
		$commitCurrentHash = $commitCurrent->out;

		$commitTarget = $this->executor->execute("git show-ref {$profile->getFullBranch()} | awk '{print $1}'");
		if ($commitTarget->code)
		{
			throw new Exception('Cannot get hash of target commit: ' . $this->executor->getLastError());
		}
		$commitTargetHash = $commitTarget->out;



		/* ?? deploy */
		$commitsSame = $commitTargetHash === $commitCurrentHash;
		if (!$commitsSame)
		{
			if ($profile->commandBefore)
			{
			$this->executor->execute($profile->commandBefore);
			}

			$this->executor->execute("git checkout -f {$profile->getFullBranch()}");

			if ($profile->commandAfter)
			{
			$this->executor->execute($profile->commandAfter);
			}


		}
	}
}
