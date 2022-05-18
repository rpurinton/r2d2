<?php
define("_PLATFORM_","highviber");
require("vendor/autoload.php");

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Exchange\AMQPExchangeType;
use PhpAmqpLib\Message\AMQPMessage;

$mqconn = new AMQPStreamConnection("localhost", 5672, "rabbit", "rabbit");
$mq = $mqconn->channel();
$mq->queue_declare("viber-worker-queue", false, true, false, false);
$mq->exchange_declare("viber-worker-router", AMQPExchangeType::DIRECT, false, true, false);
$mq->queue_bind("viber-worker-queue", "viber-worker-router");

exec("ls modules/*.php", $modules);
foreach ($modules as $module)
{
	require_once($module);
}

$consumerTag = 'worker' . $argv[1];

function process_queue($message)
{
	$payload = $message->body;
	$data = json_decode($payload, true);
	$socket_id = $data["socket_id"];
	$timestamp = $data["created_at"];
	$channel = $data["conversation_id"];
	$userid = $data["user"]["id"];
	$username = $data["user"]["name"];
	if (isset($data["text"]))
	{
		$text = $data["text"];
		process_command($socket_id, $channel, $userid, $username, $text);
	}
	$message->ack();
}

$mq->basic_consume("viber-worker-queue", $consumerTag, false, false, false, false, 'process_queue');

function shutdown($mq, $mqconn)
{
	$mq->close();
	$mqconn->close();
}

register_shutdown_function('shutdown', $mq, $mqconn);
$mq->consume();

function process_command($socket_id, $channel, $userid, $username, $text)
{
	while (substr($text, 0, 1) == " ") $text = substr($text, 1);
	$firstspace = strpos($text, " ");
	if ($firstspace === false)
	{
		$cmd = strtolower($text);
		$vars = "";
	}
	else
	{
		$cmd = strtolower(substr($text, 0, $firstspace));
		$vars = substr($text, $firstspace + 1);
	}

	if ($cmd == "!say" && $channel != 4619306)
	{
		return send_message($socket_id, 4619306, $vars);
	}

	global $funcs;
	foreach ($funcs as $func)
	{
		$result = $func($channel, $userid, $username, $cmd, $vars, $text);
		if ($result !== false)
		{
			return send_message($socket_id, $channel, $result);
		}
	}
}

function send_message($socket_id, $channel, $message)
{
	start_typing($channel);
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
	stop_typing($channel);
	return($results);
}

function start_typing($channel)
{
	global $consumerTag;
	touch("tmp/typing/$consumerTag-$channel");
}

function stop_typing($channel)
{
	global $consumerTag;
	@unlink("tmp/typing/$consumerTag-$channel");
}
