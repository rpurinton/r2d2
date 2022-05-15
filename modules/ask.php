<?php

$cmd = "ask";
$cmdlist[] = $cmd;
$htmlhelp[$cmd]["commands"][] = $cmd;
$htmlhelp[$cmd]["commands"][] = "or";
$htmlhelp[$cmd]["title"] = "Ask a Multiple Choice Question";
$htmlhelp[$cmd]["desc"] = "Gives an answer from a list of possible options. You must provide a minimum of 2 options however you can specify as many options as you want.";
$htmlhelp[$cmd]["usages"][] = "!$cmd &lt;option1&gt; or &lt;option2&gt; [or option3]...";
$htmlhelp[$cmd]["usages"][] = "!$cmd apples or oranges";
$htmlhelp[$cmd]["usages"][] = "!$cmd go to sleep or read a book or meditate";
$htmlhelp[$cmd]["seealso"][] = "flip";
$htmlhelp[$cmd]["seealso"][] = "8";
$funcs[] = function ($channel, $userid, $username, $cmd, $vars, $text)
{
	if ($cmd == "!ask" || $cmd === "!ask")
	{
		$first = firstname($username);
		$vars = my_replace("?", "", $vars);
		$vars = my_replace(" OR ", " or ", $vars);
		$vars = my_replace(" oR ", " or ", $vars);
		$vars = my_replace(" Or ", " or ", $vars);
		$inarr = explode(" or ", $vars);
		if (sizeof($inarr) === 1)
		{
			return "@$first: $vars or what?";
		}
		return "@$first: " . $inarr[array_rand($inarr)];
	}
	return false;
};
