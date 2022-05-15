<?php

$cmd = "love";
$cmdlist[] = $cmd;
$htmlhelp[$cmd]["commands"][] = $cmd;
$htmlhelp[$cmd]["title"] = "Get a Random Quote About Love";
$htmlhelp[$cmd]["desc"] = "Gives you a random quote about love from our database of over 75,000 quotes.";
$htmlhelp[$cmd]["usages"][] = "!$cmd";
$htmlhelp[$cmd]["seealso"][] = "quote";
$htmlhelp[$cmd]["seealso"][] = "chuck";

$funcs[] = function ($channel, $userid, $username, $cmd, $vars, $text)
{
	if ($cmd == "!love")
	{
		start_typing($channel);
		extract(json_decode(file_get_contents("https://api.quot.tk?subject=love"), true));
		return("<i>\"$quote #$subject\"</i> - <b>$author</b>");
	}
	return false;
};
