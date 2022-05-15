<?php

$cmd = "latest";
$cmdlist[] = $cmd;
$htmlhelp[$cmd]["commands"][] = $cmd;
$htmlhelp[$cmd]["title"] = "Get the latest video by Aaron Doughty";
$htmlhelp[$cmd]["desc"] = "Gets you a link to the latest video posted by Aaron Doughty on YouTube.";
$htmlhelp[$cmd]["usages"][] = "!$cmd";
$htmlhelp[$cmd]["seealso"][] = "youtube";
$funcs[] = function ($channel, $userid, $username, $cmd, $vars, $text)
{
	if ($cmd == "!latest")
	{
		start_typing($channel);
		global $ytapikey;
		$channelId = 'UC48MclMZIY_EaOQwatzCpvw';
		$requestUrl = "https://www.googleapis.com/youtube/v3/search?key=$ytapikey&channelId=$channelId&part=snippet,id&maxResults=1&order=date";

		$result = file_get_contents($requestUrl);
		$result = json_decode($result, true);

		$videoID = $result['items'][0]['id']['videoId'];
		$videoTitle = $result['items'][0]['snippet']['title'];

		return "<a href=\"https://youtu.be/$videoID\" target=\"r2d2\">https://youtu.be/$videoID</a><br />Here's the latest video by Aaron Doughty<br />$videoTitle";
	}
	return false;
};
