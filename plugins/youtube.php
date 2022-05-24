<?php

$cmd = "youtube";
$cmd_list[] = $cmd;
$html_help[$cmd]["commands"][] = $cmd;
$html_help[$cmd]["title"] = "Search YouTube";
$html_help[$cmd]["desc"] = "Gives you the first result from YouTube searching for the provided terms (required).";
$html_help[$cmd]["usages"][] = "!$cmd &lt;search terms required&gt;";
$html_help[$cmd]["usages"][] = "!$cmd bots are cool";
$html_help[$cmd]["usages"][] = "!$cmd Aaron Doughty";
$funcs[] = function ($data)
{
    extract($data);
    if ($cmd == "!youtube")
    {
        if ($vars === "") return $this->sendReply($data, "@" . $this->firstname($username) . ": you must provide some search terms");
        $search = urlencode($vars);
        $requestUrl = "https://www.googleapis.com/youtube/v3/search?type=video&part=snippet&q=$search&maxResults=1&key=" . $this->config["youtube"]["api_key"];

        $result = file_get_contents($requestUrl);
        $result = json_decode($result, true);

        if (!isset($result['items'][0]))
        {
            return $this->sendReply($data, "Sorry " . $this->firstname($username) . ", there were no results");
        }

        $videoId = $result['items'][0]['id']['videoId'];
        $videoTitle = $result['items'][0]['snippet']['title'];
        $channelTitle = $result['items'][0]['snippet']['channelTitle'];

        $this->sendReply($data, "<a href=\"https://youtu.be/$videoId\" target=\"_blank\">https://youtu.be/$videoId</a><br />$videoTitle<br />by $channelTitle");
    }
};

$funcs[] = function ($data)
{
    extract($data);
    if ($platform == "discord") return;
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
        $requestUrl = "https://www.googleapis.com/youtube/v3/videos?id=$videoID&key=" . $this->config["youtube"]["api_key"] . "&part=snippet,contentDetails,statistics,status";

        $result = file_get_contents($requestUrl);
        $result = json_decode($result, true);

        if (isset($result['items'][0]))
        {
            $videoTitle = $result['items'][0]['snippet']['title'];
            $channelTitle = $result['items'][0]['snippet']['channelTitle'];
            $duration = strtolower(substr($result['items'][0]['contentDetails']['duration'], 2));
            return $this->sendReply($data, $this->firstname($username) . " shared a $duration video<br /><a href=\"https://youtu.be/$videoID\" target=\"_blank\">$videoTitle</a><br />by $channelTitle");
        }
        return $this->sendReply($data, "404 not found");
    }
};

$cmd = "latest";
$cmd_list[] = $cmd;
$html_help[$cmd]["commands"][] = $cmd;
$html_help[$cmd]["title"] = "Get the latest video by Aaron Doughty";
$html_help[$cmd]["desc"] = "Gets you a link to the latest video posted by Aaron Doughty on YouTube.";
$html_help[$cmd]["usages"][] = "!$cmd";
$html_help[$cmd]["seealso"][] = "youtube";
$funcs[] = function ($data)
{
    extract($data);
    if ($cmd == "!latest")
    {
        global $ytapikey;
        $channelId = 'UC48MclMZIY_EaOQwatzCpvw';
        $requestUrl = "https://www.googleapis.com/youtube/v3/search?key=" . $this->config["youtube"]["api_key"] . "&channelId=$channelId&part=snippet,id&maxResults=1&order=date";

        $result = file_get_contents($requestUrl);
        $result = json_decode($result, true);

        $videoID = $result['items'][0]['id']['videoId'];
        $videoTitle = $result['items'][0]['snippet']['title'];

        $this->sendReply($data, "<a href=\"https://youtu.be/$videoID\" target=\"_blank\">https://youtu.be/$videoID</a><br />Here's the latest video by Aaron Doughty<br />$videoTitle");
    }
};
