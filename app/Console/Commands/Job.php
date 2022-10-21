<?php

namespace App\Console\Commands;

use \DB;
use \DateTime;
use \DateTimeZone;
use Log;

class Job {

	protected $jobname;
	protected $now;
	protected $result;

	function __construct($jobname)
	{

		$this->jobname = $jobname;
		$this->now = new DateTime(null, new DateTimeZone('Europe/Madrid'));

	}

	function query()
	{	
		$this->result = $this->run_query();
		if($this->result->isEmpty()) {
			return false;
		}
		return true;
	}

	function exec()
	{
		foreach ($this->result as $item) {
			try {
				$this->action($item);				
			} catch (Exception $e) {
				Log::error('Google_Service_Exception: ' . $e->getMessage());
			}

		}
	}

	function escape($str)
	{
		$patterns = array("/'/", "/\"/");
		$replacements = array("\\'", "\\\"");

		return preg_replace($patterns, $replacements, $str);
	}

} 
