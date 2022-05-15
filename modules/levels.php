<?php

$cmd = "levels";
$cmdlist[] = $cmd;
$htmlhelp[$cmd]["commands"][] = $cmd;
$htmlhelp[$cmd]["title"] = "Display Level Requirements (Trophy System)";
$htmlhelp[$cmd]["desc"] = "Gives the number of messages required to reach each level in steps of 10.";
$htmlhelp[$cmd]["usages"][] = "!$cmd";
$htmlhelp[$cmd]["seealso"][] = "level";
$htmlhelp[$cmd]["seealso"][] = "top";
$htmlhelp[$cmd]["seealso"][] = "seen";
$funcs[] = function ($channel, $userid, $username, $cmd, $vars, $text)
{
	if ($cmd == "!levels")
	{
		global $levelsrev;
		$result = "Level Requirements...<br /><pre>";
		for ($i = 10; $i < 101; $i += 10)
		{
			$result .= "Level $i: " . number_format($levelsrev[$i], 0, ".", ",") . " msgs\r\n";
		}
		return $result . "</pre>";
	}
	return false;
};
