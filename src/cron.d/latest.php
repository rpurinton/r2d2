#!/usr/local/bin/php -f
<?php

require_once(__DIR__ . "/../Worker.php");

$worker = new \rpurinton\r2d2\Worker(0);

$apiKey = $worker->config["youtube"]["api_key"];
$channelId = 'UC48MclMZIY_EaOQwatzCpvw';
$requestUrl = "https://www.googleapis.com/youtube/v3/search?key=$apiKey&channelId=$channelId&part=snippet,id&maxResults=1&order=date";
$result = file_get_contents($requestUrl);
$result2 = json_decode($result, true);

$videoID = $result2['items'][0]['id']['videoId'];
$videoTitle = $result2['items'][0]['snippet']['title'];

if (!file_exists(__DIR__ . "/tmp/latest/$videoID"))
{
    touch(__DIR__ . "/tmp/latest/$videoID");
    $message = "<a href=\"https://youtu.be/$videoID\" target=\"_blank\">https://youtu.be/$videoID</a><br />Aaron Doughty just posted a new video!<br />$videoTitle";
    $data["platform"] = "highviber";
    $data["channel"] = $worker->config["highviber"]["public_channel"];
    $worker->reply($data, $message);
}
