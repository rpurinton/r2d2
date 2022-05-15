<?php

$cmd = "cookie";
$cmdlist[] = $cmd;
$htmlhelp[$cmd]["commands"][] = $cmd;
$htmlhelp[$cmd]["title"] = "Get a Chinese Fortune Cookie";
$htmlhelp[$cmd]["desc"] = "Gives you a traditional chinese fortune cookie including a proverb, lucky numbers, and a learn chinese lesson.";
$htmlhelp[$cmd]["usages"][] = "!$cmd";
$htmlhelp[$cmd]["seealso"][] = "tarot";
$htmlhelp[$cmd]["seealso"][] = "oracle";
$funcs[] = function ($channel, $userid, $username, $cmd, $vars, $text)
{
	if ($cmd == "!cookie")
	{
		start_typing($channel);
		$sql = mysqli_connect("127.0.0.1", "cookie", "cookie", "cookie");
		extract(mysqli_fetch_assoc(mysqli_query($sql, "SELECT * FROM `proverbs` ORDER BY RAND() LIMIT 0,1")));
		extract(mysqli_fetch_assoc(mysqli_query($sql, "SELECT * FROM `lessons` ORDER BY RAND() LIMIT 0,1")));

		$lotto = array();
		for ($i = 1; $i < 70; $i++)
		{
			$lotto[$i] = $i;
		}
		for ($i = 0; $i < 5; $i++)
		{
			$randkey = array_rand($lotto);
			$balls[] = $randkey;
			unset($lotto[$randkey]);
		}
		sort($balls);
		$powerball = rand(1, 26);

		$first = firstname($username);
		$message = "&#129376; a fortune cookie for $first...<br />";
		$message .= "<i>\"$proverb\"</i><br />";

		$message .= "Lucky Numbers:";
		foreach ($balls as $ball)
		{
			$message .= " $ball";
		}
		$message .= "<br />Powerball: $powerball<br />";

		$message .= "Learn Chinese: $chinese<br />";
		$message .= "Pronounced: $pronounce<br />";
		$message .= "English: $english";
		return $message;
	}
	return false;
};

