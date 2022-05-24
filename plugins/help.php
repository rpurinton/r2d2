<?php

$cmd = "help";
$cmd_list[] = $cmd;
$html_help[$cmd]["commands"][] = $cmd;
$html_help[$cmd]["title"] = "Get Help With a Command";
$html_help[$cmd]["desc"] = "Provides the description of a given command, a usage example, and related commands.  If a command is not specifed, a link to the documentation is provided.";
$html_help[$cmd]["usages"][] = "!$cmd [optional command]";
$html_help[$cmd]["usages"][] = "!$cmd";
$html_help[$cmd]["usages"][] = "!$cmd commands";
$html_help[$cmd]["seealso"][] = "commands";
$funcs[] = function ($data)
{
	extract($data);
	if ($cmd == "!help")
	{
		$message = "";
		if (isset($vars) && substr($vars, 0, 1) == "!") $vars = substr($vars, 1);
		if (isset($vars) && isset($this->html_help[strtolower($vars)]))
		{
			$help = $this->html_help[strtolower($vars)];
			$message = "<b>" . $help["title"] . "</b><br />";
			$message .= "<i>" . $help["desc"] . "</i><br /><br />";
			$message .= "<b><u>Usage Example</u></b><br /><pre>";
			foreach ($help["usages"] as $usage) $message .= "$usage<br />";
			$message .= "</pre>";
			if (isset($help["seealso"]))
			{
				$message .= "<b><u>See Also</u></b><br />";
				foreach ($help["seealso"] as $also) $message .= "&nbsp;&nbsp;&nbsp;&nbsp;&bull;&nbsp;&nbsp;<a href=\"https://r2d2bot.tk/#$also\" target=\"_blank\">!$also</a><br />";
			}
		}
		if (isset($vars) && $vars != "" && !isset($this->html_help[$vars]))
		{
			$message = "$vars command not found<br />Get detailed help at <a href=\"https://r2d2bot.tk\" target=\"_blank\">r2d2bot.tk</a>";
		}
		if ($message != "") return $this->sendReply($data, $message);
		$this->sendReply($data, "Get detailed help at <a href=\"https://r2d2bot.tk\" target=\"_blank\">r2d2bot.tk</a>");
	}
};

$cmd = "commands";
$cmd_list[] = $cmd;
$html_help[$cmd]["commands"][] = $cmd;
$html_help[$cmd]["title"] = "List All Bot Commands";
$html_help[$cmd]["desc"] = "Gives you a list of all available bot commands with links to the documentation.";
$html_help[$cmd]["usages"][] = "!$cmd";
$html_help[$cmd]["seealso"][] = "help";
$funcs[] = function ($data)
{
	extract($data);
	if ($cmd == "!commands")
	{
		sort($this->cmd_list);
		$message = "command list: ";
		foreach ($this->cmd_list as $cmd)
		{
			$message .= "<a href=\"https://r2d2bot.tk/#$cmd\" target=\"_blank\">$cmd</a>&nbsp;";
		}
		$this->sendReply($data, "$message<br />Get detailed help at <a href=\"https://r2d2bot.tk\" target=\"_blank\">r2d2bot.tk</a>");
	}
};
