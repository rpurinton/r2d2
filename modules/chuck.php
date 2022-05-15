<?php

$cmd = "chuck";
$cmdlist[] = $cmd;
$htmlhelp[$cmd]["commands"][] = $cmd;
$htmlhelp[$cmd]["commands"][] = "fact";
$htmlhelp[$cmd]["title"] = "Get a Random Chuck Norris Fact";
$htmlhelp[$cmd]["desc"] = "Gives you a random true fact about Chuck Norris. (joke)";
$htmlhelp[$cmd]["usages"][] = "!$cmd";
$htmlhelp[$cmd]["seealso"][] = "quote";
$htmlhelp[$cmd]["seealso"][] = "love";
$funcs[] = function ($channel, $userid, $username, $cmd, $vars, $text)
{
	if ($cmd == "!chuck" || $cmd == "!fact")
	{
		start_typing($channel);
		$requestUrl = "https://api.chucknorris.io/jokes/random";
		$results = json_decode(file_get_contents($requestUrl), true);
		return("True Fact: " . $results["value"]);
	}
	return false;
};
