<?php

require("vendor/autoload.php");

$connection = array();
$socket_id = "";
$endpoint = "a13be185126229b1a8fe";

use Amp\Websocket\Client;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Exchange\AMQPExchangeType;
use PhpAmqpLib\Message\AMQPMessage;

$mqconn = new AMQPStreamConnection("localhost", 5672, "rabbit", "rabbit");
$mq = $mqconn->channel();
$mq->queue_declare("viber-logger-queue", false, true, false, false);
$mq->exchange_declare("viber-logger-router", AMQPExchangeType::DIRECT, false, true, false);
$mq->queue_bind("viber-logger-queue", "viber-logger-router");
$mq->queue_declare("viber-worker-queue", false, true, false, false);
$mq->exchange_declare("viber-worker-router", AMQPExchangeType::DIRECT, false, true, false);
$mq->queue_bind("viber-worker-queue", "viber-worker-router");

Amp\Loop::run(function ()
{
	global $connection, $endpoint;
	$connection = yield Client\connect("wss://ws.pusherapp.com/app/$endpoint?protocol=7&client=js&version=4.2.2&flash=false");
	$message = array("event" => "pusher:subscribe");
	$message["data"]["channel"] = "system_notification_production";
	yield $connection->send(json_encode($message));
	while ($message = yield $connection->receive())
	{
		$payload = yield $message->buffer();
		process_message(json_decode($payload, true));
	}
});

function process_message($payload)
{
	global $connection, $socket_id, $mq;
	if ($payload["event"] == "pusher:connection_established")
	{
		$data = json_decode($payload["data"], true);
		$socket_id = $data['socket_id'];
		file_put_contents("tmp/socket.txt", $socket_id);
		$pusher_auth = pusher_auth($socket_id);

		$message = array("event" => "pusher:subscribe");
		$channel = "private-user-11029792-production";
		$message["data"]["channel"] = $channel;
		$message["data"]["auth"] = $pusher_auth[$channel]["data"]["auth"];
		$connection->send(json_encode($message));

		$message = array("event" => "pusher:subscribe");
		$channel = "private-space-4619306-production";
		$message["data"]["channel"] = $channel;
		$message["data"]["auth"] = $pusher_auth[$channel]["data"]["auth"];
		$connection->send(json_encode($message));

		$message = array("event" => "pusher:subscribe");
		$channel = "presence-private-space-4619306-production";
		$message["data"]["channel"] = $channel;
		$message["data"]["auth"] = $pusher_auth[$channel]["data"]["auth"];
		$message["data"]["channel_data"] = $pusher_auth[$channel]["data"]["channel_data"];
		$connection->send(json_encode($message));

		$message = array("event" => "pusher:subscribe");
		$channel = "private-space-7542752-production";
		$message["data"]["channel"] = $channel;
		$message["data"]["auth"] = $pusher_auth[$channel]["data"]["auth"];
		$connection->send(json_encode($message));

		$message = array("event" => "pusher:subscribe");
		$channel = "private-space-7569686-production";
		$message["data"]["channel"] = $channel;
		$message["data"]["auth"] = $pusher_auth[$channel]["data"]["auth"];
		$connection->send(json_encode($message));
	}
	elseif ($payload["event"] == "new_message")
	{
		$data = json_decode($payload['data'], true);
		$data["socket_id"] = $socket_id;
		$payload = json_encode($data);
		$message = new AMQPMessage($payload, array('content_type' => 'text/plain', 'delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT));
		if ($data["conversation_id"] == 4619306)
		{
			$mq->basic_publish($message, "viber-logger-router");
		}
		$mq->basic_publish($message, "viber-worker-router");
	}
}

function pusher_auth($socket_id)
{
	$request = "/api/web/v1/pusher-auth";
	$outHeaders = unserialize(file_get_contents("highviber/outHeaders.txt"));
	$host = "https://www.highviber.com";

	$postdata = "&socket_id=$socket_id";
	$postdata .= "&channel_name[0]=private-user-11029792-production";
	$postdata .= "&channel_name[1]=private-space-4619306-production";
	$postdata .= "&channel_name[2]=presence-private-space-4619306-production";
	$postdata .= "&channel_name[3]=private-space-7542752-production";
	$postdata .= "&channel_name[4]=private-space-7569686-production";

	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, $host . $request);
	curl_setopt($curl, CURLOPT_HTTPHEADER, $outHeaders);
	curl_setopt($curl, CURLOPT_POST, 1);
	curl_setopt($curl, CURLOPT_POSTFIELDS, $postdata);
	curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 60);
	curl_setopt($curl, CURLOPT_TIMEOUT, 60);
	curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	$result1 = curl_exec($curl);
	$result2 = gzdecode($result1);
	$results = json_decode($result2, true);
	return($results);
}
