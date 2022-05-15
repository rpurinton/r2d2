<?php

$cmd = "level";
$cmdlist[] = $cmd;
$htmlhelp[$cmd]["commands"][] = $cmd;
$htmlhelp[$cmd]["title"] = "Get Current Level (Trophy System)";
$htmlhelp[$cmd]["desc"] = "Gives you the current level, and how many messages needed for the next level.  If name is not provided it gives your own level.  If you provide a name, it gives you the level of that person.";
$htmlhelp[$cmd]["usages"][] = "!$cmd [optional name]";
$htmlhelp[$cmd]["usages"][] = "!$cmd";
$htmlhelp[$cmd]["usages"][] = "!$cmd Mary";
$htmlhelp[$cmd]["usages"][] = "!$cmd John Smith";
$htmlhelp[$cmd]["seealso"][] = "levels";
$htmlhelp[$cmd]["seealso"][] = "top";
$htmlhelp[$cmd]["seealso"][] = "seen";
$funcs[] = function ($channel, $userid, $username, $cmd, $vars, $text)
{
	if ($cmd == "!level")
	{
		start_typing($channel);
		$sql = mysqli_connect("127.0.0.1", "chatbot", "chatbot", "chatbot");
		if ($vars === "")
		{
			$vars = $username;
		}
		$targetnew = mysqli_real_escape_string($sql, $vars);
		$query = "SELECT * FROM `users` WHERE `username` LIKE '%$targetnew%' ORDER BY `message_count` DESC LIMIT 0,1;";
		$result = mysqli_query($sql, $query);
		if (mysqli_num_rows($result))
		{
			extract(mysqli_fetch_assoc($result));
			$level = get_level($message_count);
			global $levelsrev;
			$togo = $levelsrev[$level + 1] - $message_count;
			return firstname($username) . " is level $level ($message_count messages)<br />$togo more messages to level up!";
		}
		return "no users like \"$vars\" have been seen";
	}
	return false;
};

$levels = array();
$levelsrev = array();
$total = 0;
for ($i = 1; $i < 101; $i++)
{
	if ($i === 1)
	{
		$count = 4;
	}
	else
	{
		$count = floor($count * 1.25);
	}
	$total += $count;
	$levels[$total] = $i;
	$levelsrev[$i] = $total;
}

function get_level($messages)
{
	global $levelsrev;
	if ($messages < 4)
	{
		return 0;
	}
	for ($i = 1; $i < 100; $i++)
	{
		if ($messages >= $levelsrev[$i] && $messages < $levelsrev[$i + 1])
		{
			return $i;
		}
	}
	return 100;
}
