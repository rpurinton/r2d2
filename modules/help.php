<?php

$cmd = "help";
$cmdlist[] = $cmd;
$htmlhelp[$cmd]["commands"][] = $cmd;
$htmlhelp[$cmd]["title"] = "Get Help With a Command";
$htmlhelp[$cmd]["desc"] = "Provides the description of a given command, a usage example, and related commands.  If a command is not specifed, a link to the documentation is provided.";
$htmlhelp[$cmd]["usages"][] = "!$cmd [optional command]";
$htmlhelp[$cmd]["usages"][] = "!$cmd";
$htmlhelp[$cmd]["usages"][] = "!$cmd commands";
$htmlhelp[$cmd]["seealso"][] = "commands";
$funcs[] = function ($channel, $userid, $username, $cmd, $vars, $text)
{
	if ($cmd == "!help")
	{
		global $htmlhelp;
		$message = "";
		if (isset($vars) && substr($vars, 0, 1) == "!") $vars = substr($vars, 1);
		if (isset($vars) && isset($htmlhelp[strtolower($vars)]))
		{
			$help = $htmlhelp[strtolower($vars)];
			$message = "<b>" . $help["title"] . "</b><br />";
			$message .= "<i>" . $help["desc"] . "</i><br /><br />";
			$message .= "<b><u>Usage Example</u></b><br /><pre>";
			foreach ($help["usages"] as $usage) $message .= "$usage<br />";
			$message .= "</pre>";
			if (isset($help["seealso"]))
			{
				$message .= "<b><u>See Also</u></b><br />";
				foreach ($help["seealso"] as $also) $message .= "&nbsp;&nbsp;&nbsp;&nbsp;&bull;&nbsp;&nbsp;<a href=\"https://r2d2bot.tk/#$also\" target=\"r2d2\">!$also</a><br />";
			}
		}
		if (isset($vars) && $vars != "" && !isset($htmlhelp[$vars]))
		{
			$message = "$vars command not found<br />Get detailed help at <a href=\"https://r2d2bot.tk\" target=\"r2d2\">r2d2bot.tk</a>";
		}
		if ($message != "") return $message;
		return "Get detailed help at <a href=\"https://r2d2bot.tk\" target=\"r2d2\">r2d2bot.tk</a>";
	}
	return false;
};
