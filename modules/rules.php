<?php

$cmd = "rules";
$cmdlist[] = $cmd;
$htmlhelp[$cmd]["commands"][] = $cmd;
$htmlhelp[$cmd]["title"] = "Get the Community Guidelines";
$htmlhelp[$cmd]["desc"] = "Gives you a link to the HighViber community guidelines.";
$htmlhelp[$cmd]["usages"][] = "!$cmd";
$funcs[] = function ($channel, $userid, $username, $cmd, $vars, $text)
{
	if ($cmd === "!rules")
	{
		return "<a href=\"https://www.highviber.com/posts/community-guidelines\" target=\"r2d2\">https://www.highviber.com/posts/community-guidelines</a>";
	}
	return false;
};
