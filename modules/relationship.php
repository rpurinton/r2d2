<?php

$cmd = "relationship";
$cmdlist[] = $cmd;
$htmlhelp[$cmd]["commands"][] = $cmd;
$htmlhelp[$cmd]["title"] = "Get a 3-card Relationship Tarot Reading";
$htmlhelp[$cmd]["desc"] = "A short reading of your relationship dynamics, or those of others.";
$htmlhelp[$cmd]["usages"][] = "!$cmd [optional details]";
$htmlhelp[$cmd]["usages"][] = "!$cmd";
$htmlhelp[$cmd]["usages"][] = "!$cmd Me and Bobby";
$htmlhelp[$cmd]["usages"][] = "!$cmd John and Mary";
$htmlhelp[$cmd]["usages"][] = "!$cmd you can put basically anything here";
$htmlhelp[$cmd]["seealso"][] = "tarot";
$htmlhelp[$cmd]["seealso"][] = "daily";
$htmlhelp[$cmd]["seealso"][] = "dream";
$htmlhelp[$cmd]["seealso"][] = "oracle";
$funcs[] = function ($channel, $userid, $username, $cmd, $vars, $text)
{
	if ($cmd == "!relationship")
	{
		start_typing($channel);
		$sql = mysqli_connect("127.0.0.1", "tarot", "tarot", "tarot");
		for ($i = 1; $i < 79; $i++)
		{
			$deck[$i] = $i;
		}
		$first = firstname($username);
		$message = "Relationship Tarot requested by $first...<br /><br />";

		$card = array_rand($deck);
		unset($deck[$card]);
		$message .= "<b>What is your role in this relationship? How do you perceive yourself, and how does that affect your partnership?</b><br />";
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
		$message .= "<b>How would you describe the relationship? What are the characteristics of it?</b><br />";
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
		$message .= "<b>What is their role in the relationship? How do you perceive your partner? And how does that affect the partnership?</b><br />";
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

		return $message;
	}
	return false;
};
