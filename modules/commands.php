<?php

$cmd = "commands";
$cmdlist[] = $cmd;
$htmlhelp[$cmd]["commands"][] = $cmd;
$htmlhelp[$cmd]["title"] = "List All Bot Commands";
$htmlhelp[$cmd]["desc"] = "Gives you a list of all available bot commands with links to the documentation.";
$htmlhelp[$cmd]["usages"][] = "!$cmd";
$htmlhelp[$cmd]["seealso"][] = "help";
$funcs[] = function ($channel, $userid, $username, $cmd, $vars, $text)
{
	if ($cmd == "!commands")
	{
		global $cmdlist;
		sort($cmdlist);
		$message = "command list: ";
		foreach ($cmdlist as $cmd)
		{
			$message .= "<a href=\"https://r2d2bot.tk/#$cmd\" target=\"r2d2\">$cmd</a>&nbsp;";
		}
		return "$message<br />Get detailed help at <a href=\"https://r2d2bot.tk\" target=\"r2d2\">r2d2bot.tk</a>";
	}
	return false;
};
