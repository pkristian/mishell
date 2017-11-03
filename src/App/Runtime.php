<?php


namespace App;


use Nette\Utils\Finder;

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
	 * @var Profile\Profile[]
	 */
	public $profile = [];


	/**
	 * @inputParam
	 * @var bool
	 */
	public $daemon = false;

	/**
	 * @inputParam
	 * @var bool
	 */
	public $sudo = false;




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

		$url = reset($this->arguments);
		if (!$url)
		{
			throw new MiException('Profile file or directory not specified');
		}
		$this->loadProfiles($url);

		$params = $this->arguments;
		array_shift($params);
		if ($params)
		{
			$this->loadParams($params);
		}
	}


	private function loadProfiles($url)
	{
		$fullUrl = $this->workingDirectory . $url;
		$isFile = is_file($fullUrl);
		$isDirectory = is_dir($fullUrl);

		if ($isFile)
		{
			$this->loadProfileFile($fullUrl);
		}
		elseif ($isDirectory)
		{
			$finder = Finder::findFiles('*.ini')
				->in($fullUrl)
			;
			foreach ($finder as $item)
			{
				$this->loadProfileFile($item);
			}
		}
		else
		{
			throw new MiException('Wrong file or directory.');
		}
	}


	private function loadProfileFile($profileFilePath)
	{
		if (!file_exists($profileFilePath))
			throw new MiException('Profile file does not exists: ' . $profileFilePath);


		$ini = parse_ini_file($profileFilePath);

		$this->profile[] = new Profile\Profile($ini);

	}


	private function loadParams($params)
	{
		$cleanParams = [];
		foreach ($params as $param)
		{
			list($key, $value) = explode('=', $param, 2);
			$cleanParams[$key] = !is_null($value) ? $value : true;
		}

		/* paste params in runtime */

		foreach ($cleanParams as $param => $value)
		{
			switch ($param)
			{
				case 'daemon':
					$this->daemon = (bool) $value;
					break;
				case 'sudo':
					$this->sudo = (bool) $value;
					break;
				default:
					throw new MiException("Unknown parameter \"$param\".");

			}
		}

	}


}
