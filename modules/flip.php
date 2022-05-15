<?php

$cmd = "flip";
$cmdlist[] = $cmd;
$htmlhelp[$cmd]["commands"][] = $cmd;
$htmlhelp[$cmd]["title"] = "Flip a Coin";
$htmlhelp[$cmd]["desc"] = "Gives you the result; heads or tails.";
$htmlhelp[$cmd]["usages"][] = "!$cmd";
$htmlhelp[$cmd]["seealso"][] = "8";
$htmlhelp[$cmd]["seealso"][] = "ask";
$funcs[] = function ($channel, $userid, $username, $cmd, $vars, $text)
{
	if ($cmd == "!flip")
	{
		start_typing($channel);
		$first = firstname($username);
		$sql = mysqli_connect("127.0.0.1", "chatbot", "chatbot", "chatbot");
		$rand = rand(0, 1);
		if ($rand === 1)
		{
			mysqli_query($sql, "UPDATE `users` SET `heads` = `heads`+1 WHERE `userid` = '$userid'");
			if ($result = mysqli_fetch_assoc(mysqli_query($sql, "SELECT `heads`,`tails` FROM `users` WHERE `userid` = '$userid'")))
			{
				extract($result);
				return "@$first: it's heads... heads: $heads tails: $tails";
			}
			else return "@$first: it's heads";
		}
		mysqli_query($sql, "UPDATE `users` SET `tails` = `tails`+1 WHERE `userid` = '$userid'");
		if ($result = mysqli_fetch_assoc(mysqli_query($sql, "SELECT `heads`,`tails` FROM `users` WHERE `userid` = '$userid'")))
		{
			extract($row);
			return "@$first: it's tails... heads: $heads tails: $tails";
		}
		else return "@$first: it's tails";
	}
	return false;
};
