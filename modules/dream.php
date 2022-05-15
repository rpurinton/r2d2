<?php

$cmd = "dream";
$cmdlist[] = $cmd;
$htmlhelp[$cmd]["commands"][] = $cmd;
$htmlhelp[$cmd]["title"] = "Get a 3-card Dream Interpretation Tarot Reading";
$htmlhelp[$cmd]["desc"] = "After a powerful dream, this short spread helps you understand the subconscious meanings behind it.";
$htmlhelp[$cmd]["usages"][] = "!$cmd [optional details]";
$htmlhelp[$cmd]["usages"][] = "!$cmd";
$htmlhelp[$cmd]["usages"][] = "!$cmd last night's dream";
$htmlhelp[$cmd]["usages"][] = "!$cmd my dream about the unicorns";
$htmlhelp[$cmd]["usages"][] = "!$cmd you can put basically anything here";
$htmlhelp[$cmd]["seealso"][] = "daily";
$htmlhelp[$cmd]["seealso"][] = "tarot";
$htmlhelp[$cmd]["seealso"][] = "relationship";
$funcs[] = function ($channel, $userid, $username, $cmd, $vars, $text)
{
	if ($cmd == "!dream")
	{
		start_typing($channel);
		$sql = mysqli_connect("127.0.0.1", "tarot", "tarot", "tarot");
		for ($i = 1; $i < 79; $i++)
		{
			$deck[$i] = $i;
		}
		$first = firstname($username);
		$message = "Dream Tarot requested by $first...<br /><br />";

		$card = array_rand($deck);
		unset($deck[$card]);
		$message .= "<b>What feelings did this dream stem from? What was the underlying emotion behind it?</b><br />";
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
		$message .= "<b>What is the dream trying to tell me?</b><br />";
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
		$message .= "<b>How can I apply this dream's lessons to my waking life?</b><br />";
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
