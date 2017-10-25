<?php


namespace App\Profile;


class Profile
{

	/**
	 * @required
	 * @var string
	 */
	public $name;

	/**
	 * @var string|null
	 */
	public $requiredUser;

	/**
	 * @required
	 * @var string
	 */
	public $repositoryDirectory;

	/**
	 * @var string|null
	 */
	public $repositoryRemote;

	/**
	 * @required
	 * @var string
	 */
	public $repositoryBranch;

	/**
	 * @var string|null
	 */
	public $logFile;

	/**
	 * @var int
	 */
	public $logLevel = 100;

	/**
	 * @var string|null
	 */
	public $commandBefore;

	/**
	 * @var  string|null
	 */
	public $commandAfter;


	/**
	 * Profile constructor.
	 *
	 * @param array $ini
	 */
	public function __construct(array $ini = null)
	{
		if ($ini)
		{
			$this->import($ini);
			$this->checkProfileValidity();

		}


	}


	public function getFullBranch()
	{
		return (
			$this->repositoryRemote
				? $this->repositoryRemote . '/'
				: ''
			)
			. $this->repositoryBranch;

	}


	/**
	 * @return null|string
	 */
	public function anotherUser()
	{
		if (
			$this->requiredUser
			&&
			$this->requiredUser != get_current_user()
		)
		{
			return $this->requiredUser;

		}

		return null;
	}


	public function checkProfileValidity()
	{
		if (
			$this->name
			&&
			$this->repositoryDirectory
			&&
			$this->repositoryBranch
			&&
			in_array(
				$this->logLevel,
				[
					\Monolog\Logger::DEBUG,
					\Monolog\Logger::INFO,
					\Monolog\Logger::NOTICE,
					\Monolog\Logger::WARNING,
					\Monolog\Logger::ERROR,
					\Monolog\Logger::CRITICAL,
					\Monolog\Logger::ALERT,
					\Monolog\Logger::EMERGENCY,
				]
			)
		)
		{
			return;
		}

		throw new \App\MiException("Profile is not valid.");
	}


	/* privates */
	private function import(array $ini)
	{
		foreach ($this as $key => $item)
		{
			$value = @$ini[$key];

			if ($value)
			{
				switch ($key)
				{
					case 'logLevel':
						$value = (int) $value;
						break;
					default:
						$value = (string) $value;
				}

				$this->$key = $value;
			}

		}


	}
}
