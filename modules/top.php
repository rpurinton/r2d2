<?php

$cmd = "top";
$cmdlist[] = $cmd;
$htmlhelp[$cmd]["commands"][] = $cmd;
$htmlhelp[$cmd]["title"] = "Get Top-10 Users (Trophy System)";
$htmlhelp[$cmd]["desc"] = "Returns a list of the top-10 chat contributors, their level, and number of messages.";
$htmlhelp[$cmd]["usages"][] = "!$cmd";
$htmlhelp[$cmd]["seealso"][] = "level";
$htmlhelp[$cmd]["seealso"][] = "levels";
$htmlhelp[$cmd]["seealso"][] = "seen";
$funcs[] = function ($channel, $userid, $username, $cmd, $vars, $text)
{
	if ($cmd == "!top")
	{
		start_typing($channel);
		$sql = mysqli_connect("127.0.0.1", "chatbot", "chatbot", "chatbot");
		$query = "SELECT * FROM `users` ORDER BY `message_count` DESC LIMIT 0,10;";
		$result = mysqli_query($sql, $query);
		$i = 0;
		$results = "<pre>-- Top 10 Chat Contributors --<br />";
		while ($row = mysqli_fetch_assoc($result))
		{
			extract($row);
			$i++;
			if ($i === 1)
			{
				$results .= "&#129351; ";
			}
			if ($i === 2)
			{
				$results .= "&#129352; ";
			}
			if ($i === 3)
			{
				$results .= "&#129353; ";
			}
			if ($i > 3 && $i < 10)
			{
				$results .= " $i ";
			}
			if ($i == 10)
			{
				$results .= "10 ";
			}
			$first = firstname($username);
			while (strlen($first) < 10) $first .= " ";
			$first = substr($first, 0, 10);
			$results .= "$first - lvl " . get_level($message_count) . " ($message_count)<br />";
		}
		return $results . "---- since April 30, 2022 ----</pre>";
	}
	return false;
};
