<?php

$cmd = "userid";
$cmdlist[] = $cmd;
$htmlhelp[$cmd]["commands"][] = $cmd;
$htmlhelp[$cmd]["title"] = "Get your User ID";
$htmlhelp[$cmd]["desc"] = "Gives your unique HighViber User ID and calculates the numerology for it.";
$htmlhelp[$cmd]["usages"][] = "!$cmd";
$htmlhelp[$cmd]["seealso"][] = "num";
$funcs[] = function ($channel, $userid, $username, $cmd, $vars, $text)
{
	if ($cmd === "!userid")
	{
		$runningtotal = 0;
		$message = "Your HighViber User ID is: $userid<br /><pre>";
		for ($i = 0; $i < strlen($userid); $i++)
		{
			$char = substr($userid, $i, 1);
			$runningtotal += $char;
			$message .= "$char+";
		}
		$message = substr($message, 0, strlen($message) - 1) . "=$runningtotal<br />";
		while (strlen($runningtotal) > 1)
		{
			$newtotal = 0;
			for ($i = 0; $i < strlen($runningtotal); $i++)
			{
				$char = substr($runningtotal, $i, 1);
				$newtotal += $char;
				$message .= "$char+";
			}
			$message = substr($message, 0, strlen($message) - 1) . "=$newtotal<br />";
			$runningtotal = $newtotal;
		}
		$message .= "</pre>";
		return $message;
	}
	return false;
};
