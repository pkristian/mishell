<?php


namespace App;


class Runtime
{

	/**
	 * @var string[]
	 */
	public $arguments;

	/**
	 * @var string
	 */
	public $workingDirectory;

	/**
	 * @var Profile\Profile
	 */
	public $profile;



	/**
	 * Runtime constructor.
	 *
	 * @param $arguments
	 *
	 * @throws \Exception
	 */
	public function __construct($arguments)
	{
		array_shift($arguments);
		$this->arguments = $arguments;

		$workingDirectory = getcwd();

		if (!$workingDirectory)
			throw new MiException('Working directory not available');
		$this->workingDirectory = $workingDirectory . DIRECTORY_SEPARATOR;

		$profileFile = reset($this->arguments);
		if (!$profileFile)
			throw new MiException('Profile file not specified');
		$this->loadProfile($profileFile);
	}


	private function loadProfile($profileFile)
	{
		$profileFilePath = $this->workingDirectory . $profileFile;

		if (!file_exists($profileFilePath))
			throw new MiException('Profile file does not exists: ' . $profileFilePath);


		$ini = parse_ini_file($profileFilePath);

		$this->profile = new Profile\Profile();

		foreach ($this->profile as $key => $item)
		{
			if (isset($ini[$key]))
			{
				$this->profile->$key = (string) $ini[$key];
			}

		}
	}


}
