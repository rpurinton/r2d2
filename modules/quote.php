<?php

$cmd = "quote";
$cmdlist[] = $cmd;
$htmlhelp[$cmd]["commands"][] = $cmd;
$htmlhelp[$cmd]["title"] = "Get a Random Quote";
$htmlhelp[$cmd]["desc"] = "Gives you a random quote from our database of over 75,000 quotes.";
$htmlhelp[$cmd]["usages"][] = "!$cmd";
$htmlhelp[$cmd]["seealso"][] = "love";
$htmlhelp[$cmd]["seealso"][] = "chuck";
$funcs[] = function ($channel, $userid, $username, $cmd, $vars, $text)
{
	if ($cmd == "!quote")
	{
		start_typing($channel);
		extract(json_decode(file_get_contents("https://api.quot.tk"), true));
		return("<i>\"$quote #$subject\"</i> - <b>$author</b>");
	}
	return false;
};
