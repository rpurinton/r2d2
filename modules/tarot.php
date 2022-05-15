<?php

$cmd = "tarot";
$cmdlist[] = $cmd;
$htmlhelp[$cmd]["commands"][] = $cmd;
$htmlhelp[$cmd]["title"] = "Draw One Tarot Card";
$htmlhelp[$cmd]["desc"] = "Pulls a single tarot card for you or someone else.  For daily readings and yes or no questions.";
$htmlhelp[$cmd]["usages"][] = "!$cmd [optional details]";
$htmlhelp[$cmd]["usages"][] = "!$cmd";
$htmlhelp[$cmd]["usages"][] = "!$cmd My tomorrow";
$htmlhelp[$cmd]["usages"][] = "!$cmd how is Bobby today";
$htmlhelp[$cmd]["usages"][] = "!$cmd you can put basically anything here";
$htmlhelp[$cmd]["seealso"][] = "daily";
$htmlhelp[$cmd]["seealso"][] = "dream";
$htmlhelp[$cmd]["seealso"][] = "relationship";
$htmlhelp[$cmd]["seealso"][] = "oracle";
$funcs[] = function ($channel, $userid, $username, $cmd, $vars, $text)
{
	if ($cmd == "!tarot")
	{
		start_typing($channel);
		$first = firstname($username);
		$sql = mysqli_connect("127.0.0.1", "tarot", "tarot", "tarot");
		extract(mysqli_fetch_assoc(mysqli_query($sql, "SELECT * FROM `cards` ORDER BY RAND() LIMIT 0,1")));
		$reverse = rand(0, 1);
		if ($reverse === 1)
		{
			return "Pulling a card for $first...<br />&#127183;<a href=\"$revurl\" target=\"r2d2\">$card in Reverse</a><br /><i>$reversed</i>";
		}
		else
		{
			return "Pulling a card for $first...<br />&#127183;<a href=\"$upurl\" target=\"r2d2\">$card</a><br /><i>$upright</i>";
		}
	}
	return false;
};
