<?php

$funcs[] = function ($channel, $userid, $username, $cmd, $vars, $text)
{
	$text = strtolower($text);
	if (
			$text == "thanks " ||
			$text == "thank you " ||
			strpos($text, "thanks r2") !== false ||
			strpos($text, "thank you r2") !== false ||
			strpos($text, "thanks every") !== false ||
			strpos($text, "thank you every") !== false ||
			strpos($text, "thanks all") !== false ||
			strpos($text, "thank you all") !== false
	)
	{
		$first = firstname($username);
		$welcome[] = "You're welcome $first!";
		$welcome[] = "@$first, You're welcome!";
		$welcome[] = "No problem $first!";
		$welcome[] = "@$first, No problem!";
		$welcome[] = "No worries $first!";
		$welcome[] = "@$first, no worries!";
		$welcome[] = "Don't mention it $first";
		$welcome[] = "@$first, don't mention it!";
		$welcome[] = "Anytime $first!";
		$welcome[] = "@$first, Anytime!";
		$welcome[] = "It was the least I could do, $first!";
		$welcome[] = "@$first, It was the least I could do!";
		$welcome[] = "Glad to help, $first!";
		$welcome[] = "@$first, glad to help!";
		$welcome[] = "@$first just happy to help!";
		$welcome[] = "@$first glad I could help!";
		return $welcome[array_rand($welcome)];
	}
	return false;
};
