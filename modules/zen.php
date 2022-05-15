<?php

$cmd = "zen";
$cmdlist[] = $cmd;
$htmlhelp[$cmd]["commands"][] = $cmd;
$htmlhelp[$cmd]["title"] = "Get a Zen Koan";
$htmlhelp[$cmd]["desc"] = "Gives you one of 101 Zen Koans (short stories used by Zen Masters in teaching Zen students.  If a koan number is not provided, a random koan will be given, otherwise you are given the requested koan.";
$htmlhelp[$cmd]["usages"][] = "!$cmd [optional 1 to 101]";
$htmlhelp[$cmd]["usages"][] = "!$cmd";
$htmlhelp[$cmd]["usages"][] = "!$cmd 7";
$htmlhelp[$cmd]["seealso"][] = "cookie";
$htmlhelp[$cmd]["seealso"][] = "quote";
$funcs[] = function ($channel, $userid, $username, $cmd, $vars, $text)
{
	if ($cmd == "!zen")
	{
		if ($vars != "" && (!is_numeric($vars) || $vars < 1 || $vars > 101))
		{
			return "number must be between 1 and 101";
		}
		start_typing($channel);
		$sql = mysqli_connect("127.0.0.1", "koans", "koans", "koans");
		if ($vars === "")
		{
			$query = "SELECT * FROM `koans` ORDER BY RAND() LIMIT 0,1;";
		}
		else
		{
			$query = "SELECT * FROM `koans` WHERE `id` = $vars";
		}
		extract(mysqli_fetch_assoc(mysqli_query($sql, $query)));
		return "<b><u>Zen Koan $id - $title</u></b><br /><i>$text</i>";
	}
	return false;
};
