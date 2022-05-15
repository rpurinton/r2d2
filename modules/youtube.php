<?php

$cmd = "youtube";
$cmdlist[] = $cmd;
$htmlhelp[$cmd]["commands"][] = $cmd;
$htmlhelp[$cmd]["title"] = "Search YouTube";
$htmlhelp[$cmd]["desc"] = "Gives you the first result from YouTube searching for the provided terms (required).";
$htmlhelp[$cmd]["usages"][] = "!$cmd &lt;search terms required&gt;";
$htmlhelp[$cmd]["usages"][] = "!$cmd bots are cool";
$htmlhelp[$cmd]["usages"][] = "!$cmd Aaron Doughty";
$funcs[] = function ($channel, $userid, $username, $cmd, $vars, $text)
{
	if ($cmd == "!youtube")
	{
		start_typing($channel);
		if ($vars === "")
		{
			return "@" . firstname($username) . ": you must provide some search terms";
		}
		$search = urlencode($vars);
		global $ytapikey;
		$requestUrl = "https://www.googleapis.com/youtube/v3/search?type=video&part=snippet&q=$search&maxResults=1&key=$ytapikey";

		$result = file_get_contents($requestUrl);
		$result = json_decode($result, true);

		if (!isset($result['items'][0]))
		{
			return "Sorry " . firstname($username) . ", there were no results";
		}

		$videoId = $result['items'][0]['id']['videoId'];
		$videoTitle = $result['items'][0]['snippet']['title'];
		$channelTitle = $result['items'][0]['snippet']['channelTitle'];

		return "<a href=\"https://youtu.be/$videoId\" target=\"r2d2\">https://youtu.be/$videoId</a><br />$videoTitle<br />by $channelTitle";
	}
	return false;
};

$ytapikey = trim(file_get_contents("modules/ytapikey.txt"));
