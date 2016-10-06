<?php

namespace App\Console\Commands;

use \DB;
use \DateTime;
use \DateTimeZone;
use Log;

class Job {

	protected $jobname;
	protected $condition;
	protected $now;
	protected $result;

	function __construct($jobname)
	{

		$this->jobname = $jobname;
		$this->now = new DateTime(null, new DateTimeZone('Europe/Madrid'));

	}

	function query()
	{	
		$this->set_condition();
		// Log::info($this->jobname . "query is = " . $this->condition);

		if(!$r = DB::select($this->condition)) {
			Log::info('No rows for ' . $this->jobname);
			return false;
		}
		$this->result = $r;
		return true;
	}

	function exec()
	{
		foreach ($this->result as $item) {
			$this->action($item);
		}
	}

	function escape($str)
	{
		$patterns = array("/'/", "/\"/");
		$replacements = array("\\'", "\\\"");

		return preg_replace($patterns, $replacements, $str);
	}

} 
