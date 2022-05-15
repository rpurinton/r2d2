<?php

$funcs[] = function ($channel, $userid, $username, $cmd, $vars, $text)
{
	$text = strtolower($text);
	if (
		$text == "goodnight" ||
		$text == "good night" ||
		strpos($text, "goodnight r2") !== false ||
		strpos($text, "good night r2") !== false ||
		strpos($text, "goodnight every") !== false ||
		strpos($text, "good night every") !== false ||
		strpos($text, "night all") !== false ||
		strpos($text, "night all") !== false
	)
	{
		$first = firstname($username);
		$goodnight[] = "Nighty Night $first";
		$goodnight[] = "Sweet dreams $first!";
		$goodnight[] = "Sleep well $first";
		$goodnight[] = "Have a good sleep $first";
		$goodnight[] = "Dream about me $first!";
		$goodnight[] = "Go to bed $first, you sleepy head!";
		$goodnight[] = "Sleep tight $first!";
		$goodnight[] = "Time to ride the rainbow to dreamland $first!";
		$goodnight[] = "Lights out $first!";
		$goodnight[] = "See ya’ in the mornin’ $first!";
		$goodnight[] = "I’ll be right here in the morning $first.";
		$goodnight[] = "I’ll be dreaming of you $first!";
		$goodnight[] = "Sleep snug as a bug in a rug $first!";
		$goodnight[] = "Dream of me $first";
		$goodnight[] = "Until tomorrow $first.";
		$goodnight[] = "Always and forever $first!";
		$goodnight[] = "I’ll be dreaming of your face $first!";
		$goodnight[] = "I’m so lucky to have you, $first!";
		$goodnight[] = "I love you to the stars and back $first!";
		$goodnight[] = "I’ll dream of you tonight and see you tomorrow $first.";
		$goodnight[] = "If you need me $first, you know where to find me.";
		$goodnight[] = "Goodnight, $first!";
		$goodnight[] = "Can’t wait to wake up next to you $first!";
		return $goodnight[array_rand($goodnight)];
	}
	return false;
};
