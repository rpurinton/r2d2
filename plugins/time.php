<?php

$cmd = "time";
$cmd_list[] = $cmd;
$html_help[$cmd]["commands"][] = $cmd;
$html_help[$cmd]["title"] = "Get the Time in Various Timezones";
$html_help[$cmd]["desc"] = "Gives you the day and current time in various timezones around the world.";
$html_help[$cmd]["usages"][] = "!$cmd";
$funcs[] = function ($data)
{
	extract($data);
	if ($cmd === "!time")
	{
		$tz["America/Los_Angeles"] = "Los Angeles";
		$tz["America/New_York"] = "New York";
		$tz["Europe/London"] = "London";
		$tz["Europe/Rome"] = "Rome";
		$tz["Europe/Moscow"] = "Moscow";
		$tz["Asia/Calcutta"] = "Calcutta";
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
		$this->sendReply($data, $message . "</pre>");
	}
};
