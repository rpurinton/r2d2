<?php

$cmd = "cwtch";
$cmdlist[] = $cmd;
$htmlhelp[$cmd]["commands"][] = $cmd;
$htmlhelp[$cmd]["title"] = "Give a Cwtch to Someone";
$htmlhelp[$cmd]["desc"] = "Gives a cwtch (hug) to someone if name provided, or to you if not.";
$htmlhelp[$cmd]["usages"][] = "!$cmd [optional name]";
$htmlhelp[$cmd]["usages"][] = "!$cmd";
$htmlhelp[$cmd]["usages"][] = "!$cmd Mary";
$htmlhelp[$cmd]["seealso"][] = "slap";
$funcs[] = function ($channel, $userid, $username, $cmd, $vars, $text)
{
	if ($cmd == "!cwtch")
	{
		if ($vars == "")
		{
			$vars = firstname($username);
		}
		return "<i>*cwtches $vars*</i> &#129303;";
	}
	return false;
};
