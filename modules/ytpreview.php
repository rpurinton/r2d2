<?php

$funcs[] = function ($channel, $userid, $username, $cmd, $vars, $text)
{
	$pos = strpos($text, "https://youtu.be/");
	if ($pos !== false)
	{
		$videoID = substr($text, $pos + 17, 11);
	}
	$pos = strpos($text, "https://m.youtube.com/watch?v=");
	if ($pos !== false)
	{
		$videoID = substr($text, $pos + 30, 11);
	}
	$pos = strpos($text, "https://www.youtube.com/watch?v=");
	if ($pos !== false)
	{
		$videoID = substr($text, $pos + 32, 11);
	}
	if (isset($videoID))
	{
		start_typing($channel);
		global $ytapikey;
		$requestUrl = "https://www.googleapis.com/youtube/v3/videos?id=$videoID&key=$ytapikey&part=snippet,contentDetails,statistics,status";

		$result = file_get_contents($requestUrl);
		$result = json_decode($result, true);

		if (isset($result['items'][0]))
		{
			$videoTitle = $result['items'][0]['snippet']['title'];
			$channelTitle = $result['items'][0]['snippet']['channelTitle'];
			$duration = strtolower(substr($result['items'][0]['contentDetails']['duration'], 2));
			return firstname($username) . " shared a $duration video<br /><a href=\"https://youtu.be/$videoID\" target=\"r2d2\">$videoTitle</a><br />by $channelTitle";
		}
		return "404 not found";
	}
	return false;
};
