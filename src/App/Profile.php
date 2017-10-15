<?php


namespace App;


class Profile
{

	public $requiredUser;

	public $repositoryDirectory;

	public $repositoryRemote;

	public $repositoryBranch;

	public $logFile;

	public $commandBefore;

	public $commandAfter;


	public function getFullBranch()
	{
		return (
			$this->repositoryRemote
				? $this->repositoryRemote . '/'
				: ''
			)
			. $this->repositoryBranch;

	}
}
