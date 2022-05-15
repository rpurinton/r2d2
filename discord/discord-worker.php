<?php

require("vendor/autoload.php");

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Exchange\AMQPExchangeType;
use PhpAmqpLib\Message\AMQPMessage;

$mqconn = new AMQPStreamConnection("localhost", 5672, "rabbit", "rabbit");
$mq = $mqconn->channel();
$mq->queue_declare("discord-worker-queue", false, true, false, false);
$mq->exchange_declare("discord-worker-router", AMQPExchangeType::DIRECT, false, true, false);
$mq->queue_bind("discord-worker-queue", "discord-worker-router");

$webhooks = json_decode(file_get_contents("discord/discord-webhooks.json"), true);

exec("ls modules/*.php", $modules);
foreach ($modules as $module)
{
	require_once($module);
}

$consumerTag = 'discord-worker' . $argv[1];

function process_queue($message)
{
	$payload = $message->body;
	$data = json_decode($payload, true);
	if (!isset($data) ||
			!isset($data['channel_id']) ||
			!isset($data['author']) ||
			!isset($data['author']['id']) ||
			!isset($data['author']['username']) ||
			!isset($data['content']))
	{
		$message->ack();
		return;
	}
	$channel = $data['channel_id'];
	$userid = $data['author']['id'];
	$username = $data['author']['username'];
	$text = $data['content'];
	if ($username != "R2D2")
	{
		if (isset($data["member"]["nick"]))
		{
			$username = $data["member"]["nick"];
		}
		process_command($channel, $userid, $username, $text);
	}
	$message->ack();
}

$mq->basic_consume("discord-worker-queue", $consumerTag, false, false, false, false, 'process_queue');

function shutdown($mq, $mqconn)
{
	$mq->close();
	$mqconn->close();
}

register_shutdown_function('shutdown', $mq, $mqconn);

$mq->consume();

function process_command($channel, $userid, $username, $text)
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

	global $funcs;
	foreach ($funcs as $func)
	{
		$result = $func($channel, $userid, $username, $cmd, $vars, $text);
		if ($result !== false)
		{
			return send_message($channel, $result);
		}
	}
}

function start_typing($channel)
{
	
}

function send_message($channel, $message)
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
