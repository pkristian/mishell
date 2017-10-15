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
	 * @var \App\Profile
	 */
	public $profile;

	/**
	 * @var string
	 */
	public $profileFile;


	/**
	 * Runtime constructor.
	 *
	 * @param $arguments
	 */
	public function __construct($arguments)
	{
		array_shift($arguments);
		$this->arguments = $arguments;
		$workingDirectory = getcwd();
		if (!$workingDirectory)
		{
			throw new \Exception('Working directory not available');
		}
		$this->workingDirectory = $workingDirectory . DIRECTORY_SEPARATOR;

		$profileFile = reset($this->arguments);
		if (!$profileFile)
		{
			throw new \Exception('Profile file not specified');
		}
		$this->profileFile = $profileFile;


		$this->loadProfile();
	}


	private function loadProfile()
	{
		$profileFilePath = $this->workingDirectory . $this->profileFile;

		if (!file_exists($profileFilePath))
		{
			throw new \Exception('Profile file does not exists: ' . $profileFilePath);
		}

		$ini = parse_ini_file($profileFilePath);

		$this->profile = new Profile();

		foreach ($this->profile as $key => $item)
		{
			if (isset($ini[$key]))
			{
				$this->profile->$key = (string) $ini[$key];
			}

		}
	}


}
