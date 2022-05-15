<?php

$cmd = "daily";
$cmdlist[] = $cmd;
$htmlhelp[$cmd]["commands"][] = $cmd;
$htmlhelp[$cmd]["title"] = "Get a 3-card Daily General Tarot Reading";
$htmlhelp[$cmd]["desc"] = "A short tarot spread for understanding your daily thoughts, feelings, and actions, or those of others.";
$htmlhelp[$cmd]["usages"][] = "!$cmd [optional details]";
$htmlhelp[$cmd]["usages"][] = "!$cmd";
$htmlhelp[$cmd]["usages"][] = "!$cmd My tomorrow";
$htmlhelp[$cmd]["usages"][] = "!$cmd Bobby today";
$htmlhelp[$cmd]["usages"][] = "!$cmd you can put basically anything here";
$htmlhelp[$cmd]["seealso"][] = "tarot";
$htmlhelp[$cmd]["seealso"][] = "dream";
$htmlhelp[$cmd]["seealso"][] = "relationship";
$htmlhelp[$cmd]["seealso"][] = "oracle";
$funcs[] = function ($channel, $userid, $username, $cmd, $vars, $text)
{
	if ($cmd == "!daily")
	{
		start_typing($channel);
		$sql = mysqli_connect("127.0.0.1", "tarot", "tarot", "tarot");
		for ($i = 1; $i < 79; $i++)
		{
			$deck[$i] = $i;
		}
		$first = firstname($username);
		$message = "Daily Tarot requested by $first...<br /><br />";
		$card = array_rand($deck);
		unset($deck[$card]);
		$message .= "<b>What things are on your mind? What are you thinking about a lot today?</b><br />";
		extract(mysqli_fetch_assoc(mysqli_query($sql, "SELECT * FROM `cards` WHERE `id` = '$card'")));
		$reverse = rand(0, 1);
		if ($reverse === 1)
		{
			$message .= "&#127183;<a href=\"$revurl\" target=\"r2d2\">$card in Reverse</a><br /><i>$reversed</i><br /><br />";
		}
		else
		{
			$message .= "&#127183;<a href=\"$upurl\" target=\"r2d2\">$card</a><br /><i>$upright</i><br /><br />";
		}
		$card = array_rand($deck);
		unset($deck[$card]);
		$message .= "<b>How are your emotions today? What is the dominant feeling for today?</b><br />";
		extract(mysqli_fetch_assoc(mysqli_query($sql, "SELECT * FROM `cards` WHERE `id` = '$card'")));
		$reverse = rand(0, 1);
		if ($reverse === 1)
		{
			$message .= "&#127183;<a href=\"$revurl\" target=\"r2d2\">$card in Reverse</a><br /><i>$reversed</i><br /><br />";
		}
		else
		{
			$message .= "&#127183;<a href=\"$upurl\" target=\"r2d2\">$card</a><br /><i>$upright</i><br /><br />";
		}
		$card = array_rand($deck);
		unset($deck[$card]);
		$message .= "<b>What tasks are you focused on accomplishing today?</b><br />";
		extract(mysqli_fetch_assoc(mysqli_query($sql, "SELECT * FROM `cards` WHERE `id` = '$card'")));
		$reverse = rand(0, 1);
		if ($reverse === 1)
		{
			$message .= "&#127183;<a href=\"$revurl\" target=\"r2d2\">$card in Reverse</a><br /><i>$reversed</i>";
		}
		else
		{
			$message .= "&#127183;<a href=\"$upurl\" target=\"r2d2\">$card</a><br /><i>$upright</i>";
		}
		return $message;
	}
	return false;
};
