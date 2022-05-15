<?php

$funcs[] = function ($channel, $userid, $username, $cmd, $vars, $text)
{
	if (file_exists("tmp/knockknock2/$userid"))
	{
		$response[] = "lol";
		$response[] = "lmao";
		$response[] = "rofl";
		$response[] = "roflmao";
		$response[] = "crickets...";

		unlink("tmp/knockknock2/$userid");
		return $response[array_rand($response)];
	}
	if (file_exists("tmp/knockknock/$userid"))
	{
		unlink("tmp/knockknock/$userid");
		touch("tmp/knockknock2/$userid");
		return "$text who?";
	}
	if ($cmd === "knock" && strtolower($vars) === "knock")
	{
		touch("tmp/knockknock/$userid");
		return "Who's there?";
	}
	return false;
};
