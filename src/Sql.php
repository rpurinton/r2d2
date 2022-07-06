<?php

namespace rpurinton\r2d2;

require_once(__DIR__."/CommonFunctions.php");

class Sql Extends CommonFunctions
{
	private $sql = null;

	function __construct()
	{
		parent::__construct();
		$this->connect();
	}

	function __destruct()
	{
		if($this->sql != \null) $this->sql->close();
		parent::__destruct();
	}

	public function connect()
	{
		$sql = $this->config["sql"];
		$this->sql = mysqli_connect($sql["host"],$sql["user"],$sql["pass"],$sql["db"]);
	}

	public function query($query)
	{
		if(!mysqli_ping($this->sql)) $this->connect();
		return mysqli_query($this->sql,$query);
	}

	public function numRows($result)
	{
		return mysqli_num_rows($result);
	}

        public function assoc($result)
	{
		return mysqli_fetch_assoc($result);
	}

        public function escape($result)
	{
		return mysqli_real_escape_string($this->sql,$result);
	}

	public function single($query)
	{
		if(!mysqli_ping($this->sql)) $this->connect();
		return mysqli_fetch_assoc(mysqli_query($this->sql,$query));
	}
}
