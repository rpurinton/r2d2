<?php

$cmd = "level";
$cmd_list[] = $cmd;
$html_help[$cmd]["commands"][] = $cmd;
$html_help[$cmd]["title"] = "Get Current Level (Trophy System)";
$html_help[$cmd]["desc"] = "Gives you the current level, and how many messages needed for the next level.  If name is not provided it gives your own level.  If you provide a name, it gives you the level of that person.";
$html_help[$cmd]["usages"][] = "!$cmd [optional name]";
$html_help[$cmd]["usages"][] = "!$cmd";
$html_help[$cmd]["usages"][] = "!$cmd Mary";
$html_help[$cmd]["usages"][] = "!$cmd John Smith";
$html_help[$cmd]["seealso"][] = "levels";
$html_help[$cmd]["seealso"][] = "top";
$html_help[$cmd]["seealso"][] = "seen";
$funcs[] = function ($data)
{
	extract($data);
	if($platform == "highviber" && $channel == $this->config["highviber"]["public_channel"])
	{
		$result = $this->logSql($userid, $username, $text);
		if($result) $this->sendReply($data,firstname($username)." has earned <b>Level $result</b> &#127942;");
	}
	if ($cmd == "!level")
	{
		mysqli_select_db($this->sql,"chatbot");
		if ($vars === "") $vars = $username;
		$targetnew = mysqli_real_escape_string($this->sql, $vars);
		$query = "SELECT * FROM `users` WHERE `username` LIKE '%$targetnew%' ORDER BY `message_count` DESC LIMIT 0,1;";
		$result = mysqli_query($this->sql, $query);
		if (mysqli_num_rows($result))
		{
			extract(mysqli_fetch_assoc($result));
			$level = $this->getLevel($message_count);
			$togo = $this-levels_reverse[$level + 1] - $message_count;
			return $this->sendReply($data, $this->firstname($username) . " is level $level ($message_count messages)<br />$togo more messages to level up!");
		}
		$this->sendReply($data, "no users like \"$vars\" have been seen");
	}
};


$cmd = "levels";
$cmd_list[] = $cmd;
$html_help[$cmd]["commands"][] = $cmd;
$html_help[$cmd]["title"] = "Display Level Requirements (Trophy System)";
$html_help[$cmd]["desc"] = "Gives the number of messages required to reach each level in steps of 10.";
$html_help[$cmd]["usages"][] = "!$cmd";
$html_help[$cmd]["seealso"][] = "level";
$html_help[$cmd]["seealso"][] = "top";
$html_help[$cmd]["seealso"][] = "seen";
$funcs[] = function ($data)
{
	extract($data);
	if ($cmd == "!levels")
	{
		$result = "Level Requirements...<br /><pre>";
		for ($i = 10; $i < 101; $i += 10)
		{
			$result .= "Level $i: " . number_format($this->levels_reverse[$i], 0, ".", ",") . " msgs\r\n";
		}
		$this->sendReply($data, $result . "</pre>");
	}
};


$cmd = "top";
$cmd_list[] = $cmd;
$html_help[$cmd]["commands"][] = $cmd;
$html_help[$cmd]["title"] = "Get Top-10 Users (Trophy System)";
$html_help[$cmd]["desc"] = "Returns a list of the top-10 chat contributors, their level, and number of messages.";
$html_help[$cmd]["usages"][] = "!$cmd";
$html_help[$cmd]["seealso"][] = "level";
$html_help[$cmd]["seealso"][] = "levels";
$html_help[$cmd]["seealso"][] = "seen";
$funcs[] = function ($data)
{
	extract($data);
	if ($cmd == "!top")
	{
                mysqli_select_db($this->sql,"chatbot");
		$query = "SELECT * FROM `users` ORDER BY `message_count` DESC LIMIT 0,10;";
		$result = mysqli_query($this->sql, $query);
		$i = 0;
		$results = "<pre>-- Top 10 Chat Contributors --<br />";
		while ($row = mysqli_fetch_assoc($result))
		{
			extract($row);
			$i++;
			if ($i === 1) $results .= "&#129351; ";
			if ($i === 2) $results .= "&#129352; ";
			if ($i === 3) $results .= "&#129353; ";
			if ($i > 3 && $i < 10) $results .= " $i ";
			if ($i == 10) $results .= "10 ";
			$first = $this->firstname($username);
			while (strlen($first) < 10) $first .= " ";
			$first = substr($first, 0, 10);
			$results .= "$first - lvl " . $this->getLevel($message_count) . " ($message_count)<br />";
		}
		$this->sendReply($data, $results . "---- since April 30, 2022 ----</pre>");
	}
};
