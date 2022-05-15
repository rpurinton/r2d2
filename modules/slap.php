<?php

$cmd = "slap";
$cmdlist[] = $cmd;
$htmlhelp[$cmd]["commands"][] = $cmd;
$htmlhelp[$cmd]["title"] = "Slap Someone With a Large Trout";
$htmlhelp[$cmd]["desc"] = "If a name is provided, slap them with a large trout.  If no name is given, you will be slapped.";
$htmlhelp[$cmd]["usages"][] = "!$cmd [optional name]";
$htmlhelp[$cmd]["usages"][] = "!$cmd";
$htmlhelp[$cmd]["usages"][] = "!$cmd Bobby";
$htmlhelp[$cmd]["seealso"][] = "cwtch";
$funcs[] = function ($channel, $userid, $username, $cmd, $vars, $text)
{
	if ($cmd == "!slap")
	{
		if ($vars == "")
		{
			$vars = firstname($username);
		}
		return "<i>*slaps $vars around a bit with a large trout*</i>";
	}
	return false;
};
