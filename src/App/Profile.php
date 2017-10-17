<?php


namespace App;


class Profile
{

	public $name;

	public $requiredUser;

	public $repositoryDirectory;

	public $repositoryRemote;

	public $repositoryBranch;

	public $logFile;

	public $logLevel = 100;

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
