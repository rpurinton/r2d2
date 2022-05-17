<?php

require("vendor/autoload.php");
require_once("modules/level.php");
require_once("modules/core-functions.php");

$webhooks = json_decode(file_get_contents("discord/discord-webhooks.json"), true);

$connection = array();
$socket_id = "";
$endpoint = "a13be185126229b1a8fe";

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Exchange\AMQPExchangeType;
use PhpAmqpLib\Message\AMQPMessage;

$mqconn = new AMQPStreamConnection("localhost", 5672, "rabbit", "rabbit");
$mq = $mqconn->channel();
$mq->queue_declare("viber-logger-queue", false, true, false, false);
$mq->exchange_declare("viber-logger-router", AMQPExchangeType::DIRECT, false, true, false);
$mq->queue_bind("viber-logger-queue", "logger-router");
$consumerTag = 'viber-logger';

function process_queue($message)
{
	$payload = $message->body;
	$message->ack();
	$data = json_decode($payload, true);
	$socket_id = $data["socket_id"];
	$timestamp = $data["created_at"];
	$channel = $data["conversation_id"];
	$userid = $data["user"]["id"];
	$username = $data["user"]["name"];
	if (isset($data["text"]))
	{
		$text = $data["text"];
		$level_result = log_sql($userid, $username, $text);
		if ($level_result)
		{
			$firstname = firstname($username);
			send_message($socket_id, $channel, "$firstname has earned <b>Level $level_result</b> &#127942;");
		}
	}
}

$mq->basic_consume("viber-logger-queue", $consumerTag, false, false, false, false, 'process_queue');

function shutdown($mq, $mqconn)
{
	$mq->close();
	$mqconn->close();
}

register_shutdown_function('shutdown', $mq, $mqconn);
$mq->consume();

function send_message($socket_id, $channel, $message)
{
	sleep(1);
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
	$csrf = urldecode(file_get_contents("highviber/csrf.txt"));
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
	$packet["text"] = "<div id=" . rand_id() . ">$message</div>";
	$packet["created_at"] = gmdate("Y-m-d\TH:i:s.\9\9\9\Z", time() + 1);
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
	$results = json_decode($result1, true);
	return($results);
}

function log_sql($userid, $username, $text)
{
	global $levels;
	discord_send_message("976233852685131786",$username.": ".fix_hyperlinks(discord_cleanup($text)));
	$sql = mysqli_connect("127.0.0.1", "chatbot", "chatbot", "chatbot");
	$username2 = mysqli_real_escape_string($sql, $username);
	$text2 = mysqli_real_escape_string($sql, $text);
	$query1 = "INSERT INTO `users` (`userid`,`username`,`message_count`,`last_text`) VALUES ('$userid','$username2',1,'$text2') ON DUPLICATE KEY UPDATE `username` = '$username2', `message_count` = `message_count` + 1, `last_text` = '$text2';";
	$query2 = "SELECT `message_count` FROM `users` WHERE `userid` = '$userid';";
	mysqli_query($sql, $query1);
	extract(mysqli_fetch_assoc(mysqli_query($sql, $query2)));
	if (isset($levels[$message_count]))
	{
		return $levels[$message_count];
	}
	return 0;
}

function discord_send_message($channel, $message)
{
	global $webhooks;
	$webhookurl = $webhooks[$channel];
	$timestamp = date("c", strtotime("now"));
	$data["content"] = discord_cleanup($message);
	$json_data = json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
	$ch = curl_init($webhookurl);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$response = curl_exec($ch);
	echo $response;
	curl_close($ch);
}

function discord_cleanup($message)
{
	$message = my_replace("<br />", "\n", $message);
	$message = my_replace("<i>", "*", $message);
	$message = my_replace("</i>", "*", $message);
	$message = my_replace("<b>", "**", $message);
	$message = my_replace("</b>", "**", $message);
	$message = my_replace("<u>", "__", $message);
	$message = my_replace("</u>", "__", $message);
	$message = my_replace("<pre>", "`", $message);
	$message = my_replace("</pre>", "`", $message);
	$message = fix_hyperlinks($message);
	return html_entity_decode($message);
}

function fix_hyperlinks($message)
{
	while (strpos($message, "<a href") !== false)
	{
		$pos = strpos($message, "<a href");
		$previous = substr($message, 0, $pos);
		$thelink = substr($message, $pos);
		$pos2 = strpos($thelink, "</a>");
		$theremainder = substr($thelink, $pos2 + 4);
		$thelink = substr($thelink, 0, $pos2);
		$thelink = my_replace("<a href=\"", "", $thelink);
		$thelink = my_replace("</a>", "", $thelink);
		$thelink = my_replace("\" target=\"r2d2\">", "##!##", $thelink);
		$thelink = explode("##!##", $thelink);
		$thelink = "[" . $thelink[1] . "](" . $thelink[0] . ")";
		$message = "$previous $thelink $theremainder";
	}
	return ($message);
}
