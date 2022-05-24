<?php

$cmd = "quote";
$cmd_list[] = $cmd;
$html_help[$cmd]["commands"][] = $cmd;
$html_help[$cmd]["title"] = "Get a Random Quote";
$html_help[$cmd]["desc"] = "Gives you a random quote from our database of over 75,000 quotes.";
$html_help[$cmd]["usages"][] = "!$cmd";
$html_help[$cmd]["seealso"][] = "love";
$html_help[$cmd]["seealso"][] = "chuck";
$funcs[] = function ($data)
{
	extract($data);
	if ($cmd == "!quote")
	{
		extract(json_decode(file_get_contents("https://api.quot.tk"), true));
		$this->sendReply($data,"<i>\"$quote #$subject\"</i> - <b>$author</b>");
	}
};

$cmd = "love";
$cmd_list[] = $cmd;
$html_help[$cmd]["commands"][] = $cmd;
$html_help[$cmd]["title"] = "Get a Random Quote About Love";
$html_help[$cmd]["desc"] = "Gives you a random quote about love from our database of over 75,000 quotes.";
$html_help[$cmd]["usages"][] = "!$cmd";
$html_help[$cmd]["seealso"][] = "quote";
$html_help[$cmd]["seealso"][] = "chuck";

$funcs[] = function ($data)
{
	extract($data);
	if ($cmd == "!love")
	{
		extract(json_decode(file_get_contents("https://api.quot.tk?subject=love"), true));
		$this->sendReply($data,"<i>\"$quote #$subject\"</i> - <b>$author</b>");
	}
};
