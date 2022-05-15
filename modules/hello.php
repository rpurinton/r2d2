<?php

$funcs[] = function ($channel, $userid, $username, $cmd, $vars, $text)
{
	$text = strtolower($text);
	if (
			$text == "hello " ||
			$text == "hi " ||
			$text == "hey " ||
			strpos($text, "hello r2") !== false ||
			strpos($text, "hi r2") !== false ||
			strpos($text, "hey r2") !== false ||
			strpos($text, "hello every") !== false ||
			strpos($text, "hi every") !== false ||
			strpos($text, "hey every") !== false ||
			strpos($text, "hello all") !== false ||
			strpos($text, "hi all") !== false ||
			strpos($text, "hey all") !== false
	)
	{
		$first = firstname($username);
		$hello[] = "Hello $first!";
		$hello[] = "Hi there $first";
		$hello[] = "Greetings $first";
		$hello[] = "Howdy $first";
		$hello[] = "Hey, what's up $first?";
		$hello[] = "Good morning $first";
		$hello[] = "Good afternoon $first";
		$hello[] = "Good evening $first";
		$hello[] = "Hi, What's going on $first?";
		$hello[] = "Hey! There you are $first!";
		$hello[] = "How's everything $first?";
		$hello[] = "How are things $first?";
		$hello[] = "Good to see you $first";
		$hello[] = "Great to see you $first";
		$hello[] = "Nice to see you $first";
		$hello[] = "What's happening $first?";
		$hello[] = "How's it going $first?";
		$hello[] = "Hey boo!";
		$hello[] = "Nice to meet you $first!";
		$hello[] = "Long time no see $first!";
		$hello[] = "What's good $first?";
		$hello[] = "What's new $first?";
		$hello[] = "Look who it is! It's $first!";
		$hello[] = "How have you been $first?";
		$hello[] = "Nice to see you again $first";
		$hello[] = "Greetings and Salutations $first";
		$hello[] = "How are you doing today $first?";
		$hello[] = "What have you been up to $first?";
		$hello[] = "How are you feeling today $first?";
		$hello[] = "Look at what the cat dragged in!";
		$hello[] = "Good day $first, how are you today?";
		$hello[] = "Speak of the devil...";
		return $hello[array_rand($hello)];
	}
	return false;
};
