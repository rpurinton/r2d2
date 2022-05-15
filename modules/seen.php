<?php

$cmd = "seen";
$cmdlist[] = $cmd;
$htmlhelp[$cmd]["commands"][] = $cmd;
$htmlhelp[$cmd]["title"] = "Get the Last Time a User Was Seen";
$htmlhelp[$cmd]["desc"] = "Gives you the last time a user was seen chatting, and what they said last.";
$htmlhelp[$cmd]["usages"][] = "!$cmd &lt;user name required&gt;";
$htmlhelp[$cmd]["usages"][] = "!$cmd Mary";
$htmlhelp[$cmd]["usages"][] = "!$cmd John Smith";
$htmlhelp[$cmd]["seealso"][] = "top";
$htmlhelp[$cmd]["seealso"][] = "level";
$funcs[] = function ($channel, $userid, $username, $cmd, $vars, $text)
{
	if ($cmd == "!seen")
	{
		start_typing($channel);
		if ($vars == "")
		{
			return "you must use !seen &lt;name&gt;";
		}
		$sql = mysqli_connect("127.0.0.1", "chatbot", "chatbot", "chatbot");
		$targetnew = mysqli_real_escape_string($sql, $vars);
		$query = "SELECT * FROM `users` WHERE `username` LIKE '%$targetnew%' ORDER BY `message_count` DESC LIMIT 0,1;";
		$result = mysqli_query($sql, $query);
		if (mysqli_num_rows($result))
		{
			extract(mysqli_fetch_assoc($result));
			$lasttime = strtotime($last_time);
			$timediff = time() - $lasttime;
			$timehuman = time_human($timediff);
			return "$username was last seen $timehuman ago when they said:<br /><i>\"$last_text\"</i>";
		}
		return "no users like \"$vars\" have been seen";
	}
	return false;
};

function time_human($seconds)
{
	if ($seconds < 60)
	{
		if ($seconds === 1)
		{
			return "1 second";
		}
		return "$seconds seconds";
	}
	$minutes = floor($seconds / 60);
	if ($minutes < 60)
	{
		if ($minutes === 1)
		{
			return "1 minute";
		}
		return "$minutes minutes";
	}
	$hours = floor($minutes / 60);
	$minutes2 = $minutes % 60;
	if ($hours < 24)
	{
		if ($hours == 1)
		{
			$hourtext = "hour";
		}
		else
		{
			$hourtext = "hours";
		}
		if ($minutes2 == 1)
		{
			$minutetext = "minute";
		}
		else
		{
			$minutetext = "minutes";
		}
		return "$hours $hourtext and $minutes2 $minutetext";
	}
	$days = floor($hours / 24);
	$hours2 = $hours % 24;
	if ($days == 1)
	{
		$daytext = "day";
	}
	else
	{
		$daytext = "days";
	}
	if ($hours2 == 1)
	{
		$hourtext = "hour";
	}
	else
	{
		$hourtext = "hours";
	}
	return "$days $daytext and $hours2 $hourtext";
}
