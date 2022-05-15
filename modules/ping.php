<?php

$cmd = "ping";
$cmdlist[] = $cmd;
$htmlhelp[$cmd]["commands"][] = $cmd;
$htmlhelp[$cmd]["title"] = "Send a Ping (Test The Bot)";
$htmlhelp[$cmd]["desc"] = "Check if the bot is responsive.  Should respond \"PONG!\" if so.";
$htmlhelp[$cmd]["usages"][] = "!$cmd";
$funcs[] = function ($channel, $userid, $username, $cmd, $vars, $text)
{
	if ($cmd === "!ping")
	{
		return "PONG!";
	}
	return false;
};
