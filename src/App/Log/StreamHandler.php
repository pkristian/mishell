<?php


namespace App\Log;


class StreamHandler extends \Monolog\Handler\StreamHandler
{

	/**
	 * @param string $url
	 */
	public function setUrl($url)
	{
		$this->url = $url;
		$this->stream = null;
	}

}
