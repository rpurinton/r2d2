<?php

$cmd = "rock";
$cmdlist[] = $cmd;
$htmlhelp[$cmd]["commands"][] = $cmd;
$htmlhelp[$cmd]["title"] = "Show Rock (Rock, Paper, Scissors Game)";
$htmlhelp[$cmd]["desc"] = "Choose rock in a game of rock, paper, scissors.";
$htmlhelp[$cmd]["usages"][] = "!$cmd";
$htmlhelp[$cmd]["seealso"][] = "paper";
$htmlhelp[$cmd]["seealso"][] = "scissors";
$funcs[] = function ($channel, $userid, $username, $cmd, $vars, $text)
{
	if ($cmd === "!rock")
	{
		start_typing($channel);
		$rock = "&#129704;";
		$paper = "&#129531;";
		$scissors = "&#9986;";

		$first = firstname($username);
		$sql = mysqli_connect("127.0.0.1", "chatbot", "chatbot", "chatbot");
		$rand = rand(0, 2);
		if ($rand === 0)
		{
			mysqli_query($sql, "UPDATE `users` SET `tie` = `tie`+1 WHERE `userid` = '$userid'");
			if ($result = mysqli_fetch_assoc(mysqli_query($sql, "SELECT `win`,`loss`,`tie` FROM `users` WHERE `userid` = '$userid'")))
			{
				extract($result);
				return "@$first: $rock, Me: $rock, it's a tie...<br />your personal record: W: $win L: $loss T: $tie";
			}
			else return "@$first: $rock, Me: $rock, it's a tie";
		}
		if ($rand === 1)
		{
			mysqli_query($sql, "UPDATE `users` SET `loss` = `loss`+1 WHERE `userid` = '$userid'");
			if ($result = mysqli_fetch_assoc(mysqli_query($sql, "SELECT `win`,`loss`,`tie` FROM `users` WHERE `userid` = '$userid'")))
			{
				extract($result);
				return "@$first: $rock, Me: $paper, I win...<br />your personal record: W: $win L: $loss T: $tie";
			}
			else return "@$first: $rock, Me: $paper, I win";
		}
		mysqli_query($sql, "UPDATE `users` SET `win` = `win`+1 WHERE `userid` = '$userid'");
		if ($result = mysqli_fetch_assoc(mysqli_query($sql, "SELECT `win`,`loss`,`tie` FROM `users` WHERE `userid` = '$userid'")))
		{
			extract($result);
			return "@$first: $rock, Me: $scissors, You win...<br />your personal record: W: $win L: $loss T: $tie";
		}
		else return "@$first: $rock, Me: $scissors, You win...";
	}
	return false;
};
