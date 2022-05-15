<?php

require("vendor/autoload.php");

$connection = array();
$socket_id = "";
$endpoint = "a13be185126229b1a8fe";

use Amp\Websocket\Client;

$fd = inotify_init();
stream_set_blocking($fd, false);
$watch_descriptor = inotify_add_watch($fd, "tmp/typing/", IN_CREATE | IN_DELETE);

Amp\Loop::run(function ()
{
	global $connection, $endpoint, $fd, $watch_descriptor;
	$connection = yield Client\connect("wss://ws.pusherapp.com/app/$endpoint?protocol=7&client=js&version=4.2.2&flash=false");
	$message = array("event" => "pusher:subscribe");
	$message["data"]["channel"] = "system_notification_production";
	yield $connection->send(json_encode($message));
	$message = yield $connection->receive();
	$payload = yield $message->buffer();
	process_message(json_decode($payload, true));
	while ($connection->isConnected())
	{
		$read = array($fd);
		$write = null;
		$except = null;
		stream_select($read, $write, $except, 0, 500000);
		$events = inotify_read($fd);
		if ($events !== false)
		{
			foreach ($events as $event)
			{
				$channel = substr($event["name"], 8);
				if ($event["mask"] == 256)
				{
					$files[$channel][$event["name"]] = 1;
					start_typing($channel);
				}
				if ($event["mask"] == 512)
				{
					unset($files[$channel][$event["name"]]);
					if (sizeof($files[$channel]) === 0) stop_typing($channel);
				}
			}
		}
		if ($message = yield $connection->receive())
		{
			$payload = yield $message->buffer();
		}
	}
});

function process_message($payload)
{
	global $connection, $socket_id, $mq;
	if ($payload["event"] == "pusher:connection_established")
	{
		$data = json_decode($payload["data"], true);
		$socket_id = $data['socket_id'];
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
}

function start_typing($channel)
{
	global $connection;
	$jsonmsg["channel"] = "private-space-$channel-production";
	$jsonmsg["data"]["user"]["id"] = 11029792;
	$jsonmsg["data"]["user"]["first_name"] = "R2D2";
	$jsonmsg["data"]["user"]["last_name"] = "[BOT]";
	$jsonmsg["data"]["user"]["name"] = "R2D2 [BOT]";
	$jsonmsg["event"] = "client-user_start_typing";
	$connection->send(json_encode($jsonmsg));
}

function stop_typing($channel)
{
	global $connection;
	$jsonmsg["channel"] = "private-space-$channel-production";
	$jsonmsg["data"]["user"]["id"] = 11029792;
	$jsonmsg["data"]["user"]["first_name"] = "R2D2";
	$jsonmsg["data"]["user"]["last_name"] = "[BOT]";
	$jsonmsg["data"]["user"]["name"] = "R2D2 [BOT]";
	$jsonmsg["event"] = "client-user_stop_typing";
	$connection->send(json_encode($jsonmsg));
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
