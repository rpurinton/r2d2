<?php

$cmd = "8";
$cmdlist[] = $cmd;
$htmlhelp[$cmd]["commands"][] = $cmd;
$htmlhelp[$cmd]["commands"][] = "8ball";
$htmlhelp[$cmd]["commands"][] = "9ball";
$htmlhelp[$cmd]["commands"][] = "yesno";
$htmlhelp[$cmd]["title"] = "Ask the Magic 8-Ball";
$htmlhelp[$cmd]["desc"] = "Simulates the popular Magic 8-ball Toy by providing an answer to any yes/no style question.";
$htmlhelp[$cmd]["usages"][] = "!$cmd [optional question]";
$htmlhelp[$cmd]["usages"][] = "!$cmd";
$htmlhelp[$cmd]["usages"][] = "!$cmd Will today be a good day?";
$htmlhelp[$cmd]["usages"][] = "!$cmd you can put basically anything here";
$htmlhelp[$cmd]["seealso"][] = "flip";
$htmlhelp[$cmd]["seealso"][] = "ask";

$funcs[] = function ($channel, $userid, $username, $cmd, $vars, $text)
{
	if ($cmd == "!8" || $cmd == "!8ball" || $cmd == "!9ball" || $cmd === "!yesno")
	{
		$results[] = " it is certain &#128077;";
		$results[] = " it is decidedly so &#128077;";
		$results[] = " without a doubt &#128077;";
		$results[] = " yes definitely &#128077;";
		$results[] = " you may rely on it &#128077;";
		$results[] = " as i see it, yes &#128077;";
		$results[] = " most likely &#128077;";
		$results[] = " outlook good &#128077;";
		$results[] = " yes &#128077;";
		$results[] = " signs point to yes &#128077;";
		$results[] = " reply hazy, try again";
		$results[] = " ask again later";
		$results[] = " better not tell you now";
		$results[] = " cannot predict now";
		$results[] = " concentrate and ask again";
		$results[] = " don't count on it &#128078;";
		$results[] = " my reply is no &#128078;";
		$results[] = " my sources say no &#128078;";
		$results[] = " outlook not so good &#128078;";
		$results[] = " very doubtful &#128078;";
		$first = firstname($username);
		return "@$first &#127921; " . $results[array_rand($results)];
	}
	return false;
};

