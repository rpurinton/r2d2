<?php

$cmd = "time";
$cmdlist[] = $cmd;
$htmlhelp[$cmd]["commands"][] = $cmd;
$htmlhelp[$cmd]["title"] = "Get the Time in Various Timezones";
$htmlhelp[$cmd]["desc"] = "Gives you the day and current time in various timezones around the world.";
$htmlhelp[$cmd]["usages"][] = "!$cmd";
$funcs[] = function ($channel, $userid, $username, $cmd, $vars, $text)
{
	if ($cmd === "!time")
	{
		$tz["America/Los_Angeles"] = "Los Angeles";
		$tz["America/New_York"] = "New York";
		$tz["Europe/London"] = "London";
		$tz["Europe/Rome"] = "Rome";
		$tz["Europe/Moscow"] = "Moscow";
		$tz["Asia/Calcutta"] = "New Delhi";
		$tz["Asia/Tokyo"] = "Tokyo";
		$tz["Australia/Melbourne"] = "Melbourne";

		$timestamp = time();
		$message = "<pre>";
		foreach ($tz as $key => $value)
		{
			date_default_timezone_set($key);
			$message .= date("D h:i A", $timestamp) . " $value\r\n";
		}
		date_default_timezone_set("UTC");
		return $message . "</pre>";
	}
	return false;
};
