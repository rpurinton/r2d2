<?php

$funcs[] = function ($data)
{
	extract($data);
	$text = strtolower($text);
	if (
			$text == "hello" ||
			$text == "hi" ||
			$text == "hey" ||
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
		$first = $this->firstname($username);
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
		$this->sendReply($data, $hello[array_rand($hello)]);
	}
};

$funcs[] = function ($data)
{
	extract($data);
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
		$first = $this->firstname($username);
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
		$this->sendReply($data, $goodnight[array_rand($goodnight)]);
	}
};

$funcs[] = function ($data)
{
	extract($data);
	if (strpos(strtolower($text), "jinx") !== false)
	{
		$this->sendReply($data, $text);
	}
};

$funcs[] = function ($data)
{
	extract($data);
	if (file_exists(__DIR__."/tmp/knockknock2/$userid"))
	{
		$response[] = "lol";
		$response[] = "lmao";
		$response[] = "rofl";
		$response[] = "roflmao";
		$response[] = "crickets...";

		unlink(__DIR__."/tmp/knockknock2/$userid");
		return $this->sendReply($data, $response[array_rand($response)]);
	}
	if (file_exists(__DIR__."/tmp/knockknock1/$userid"))
	{
		unlink(__DIR__."/tmp/knockknock1/$userid");
		touch(__DIR__."/tmp/knockknock2/$userid");
		return $this->sendReply($data, "$text who?");
	}
	if ($cmd === "knock" && strtolower($vars) === "knock")
	{
		touch(__DIR__."/tmp/knockknock1/$userid");
		return $this->sendReply($data, "Who's there?");
	}
};

$funcs[] = function ($data)
{
	extract($data);
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
		$first = $this->firstname($username);
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
		$this->sendReply($data, $welcome[array_rand($welcome)]);
	}
};
