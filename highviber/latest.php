<?php

youtube_latest();

function send_message($socket_id, $channel, $message)
{
	if ($socket_id == "")
	{
		$socket_id = trim(file_get_contents("tmp/socket.txt"));
	}
	if (!defined('CURL_HTTP_VERSION_2_0'))
	{
		define('CURL_HTTP_VERSION_2_0', 3);
	}
	$request = "/api/web/v1/spaces/$channel/chats";

	$outHeaders = unserialize(file_get_contents("highviber/chatHeaders.txt"));
	unset($outHeaders[21]);
	unset($outHeaders[22]);
	unset($outHeaders[23]);
	$outHeaders[] = "Dnt: 1";
	$csrf = urldecode(file_get_contents("csrf.txt"));
	$outHeaders[] = "X-Csrf-Token: $csrf";
	foreach ($outHeaders as $headerkey => $headervalue)
	{
		if (substr($headervalue, 0, 6) == "Cookie")
		{
			$cookie = str_replace("Cookie: ", "", $headervalue);
			$cookie2 = explode("; ", $cookie);
			unset($outHeaders[$headerkey]);
			foreach ($cookie2 as $cookievalue)
			{
				$outHeaders[] = "Cookie: $cookievalue";
			}
		}
		if (substr($headervalue, 0, 8) == "X-Pusher")
		{
			$outHeaders[$headerkey] = "X-Pusher-Socket-Id: $socket_id";
		}
	}
	$outHeaders[] = "Cookie: locale=";
	$outHeaders[] = "Cookie: CSRF-TOKEN=$csrf";
	$host = "https://www.highviber.com";
	$packet["user"]["id"] = 11029792;
	$packet["user"]["name"] = "R2D2 [BOT]";
	$packet["user"]["avatar_url"] = "https://media1-production-mightynetworks.imgix.net/asset/38584369/wp1867298.jpg?ixlib=rails-0.3.0&fm=jpg&q=100&auto=format&w=400&h=400&fit=crop&crop=faces&impolicy=Avatar";
	$packet["text"] = $message;
	$packet["created_at"] = gmdate("Y-m-d\TH:i:s.v\Z"); // 2022-04-27T05:09:47.604Z
	$postdata = json_encode($packet);
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_2_0);
	curl_setopt($curl, CURLOPT_URL, $host . $request);
	curl_setopt($curl, CURLOPT_HTTPHEADER, $outHeaders);
	curl_setopt($curl, CURLINFO_HEADER_OUT, true);
	curl_setopt($curl, CURLOPT_POST, 1);
	curl_setopt($curl, CURLOPT_POSTFIELDS, $postdata);
	curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 60);
	curl_setopt($curl, CURLOPT_TIMEOUT, 60);
	curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	$result1 = curl_exec($curl);
	$curl_errno = curl_errno($curl);
	$curl_error = curl_error($curl);
	if (!strlen($result1))
	{
		die("CURL ERROR: no result - #$curl_errno: $curl_error\n");
	}
	$results = json_decode($result1, true);
	return($results);
}

function youtube_latest()
{
	$apiKey = trim(file_get_contents("modules/ytapikey.txt"));
	$channelId = 'UC48MclMZIY_EaOQwatzCpvw';
	$requestUrl = "https://www.googleapis.com/youtube/v3/search?key=$apiKey&channelId=$channelId&part=snippet,id&maxResults=1&order=date";
	$result = file_get_contents($requestUrl);
	$result2 = json_decode($result, true);

	$videoID = $result2['items'][0]['id']['videoId'];
	$videoTitle = $result2['items'][0]['snippet']['title'];

	if (!file_exists("tmp/latest/$videoID"))
	{
		touch("tmp/latest/$videoID");
		$message = "<a href=\"https://youtu.be/$videoID\" target=\"r2d2\">https://youtu.be/$videoID</a><br />Aaron Doughty just posted a new video!<br />$videoTitle";
		send_message("", "4619306", $message);
	}
}
