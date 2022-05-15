<?php

require("vendor/autoload.php");

use Discord\Discord;
use Discord\Parts\Channel\Message;
use Psr\Http\Message\ResponseInterface;
use React\EventLoop\Factory;
use React\Http\Browser;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Exchange\AMQPExchangeType;
use PhpAmqpLib\Message\AMQPMessage;

$mqconn = new AMQPStreamConnection("localhost", 5672, "rabbit", "rabbit");
$mq = $mqconn->channel();
$mq->queue_declare("discord-worker-queue", false, true, false, false);
$mq->exchange_declare("discord-worker-router", AMQPExchangeType::DIRECT, false, true, false);
$mq->queue_bind("discord-worker-queue", "discord-worker-router");

$webhooks = json_decode(file_get_contents("discord/discord-webhooks.json"), true);

$loop = Factory::create();
$browser = new Browser($loop);
$discord = new Discord([
	'token' => $webhooks["bot_token"],
	'loop' => $loop,
	'logger' => new Logger('DiscordPHP', [new StreamHandler('php://stdout', Logger::WARNING)])
		]);
$discord->on('message', function (Message $message, Discord $discord) use ($browser)
{
	global $mq;
	$payload = new AMQPMessage(json_encode($message, true), array('content_type' => 'text/plain', 'delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT));
	$mq->basic_publish($payload, "discord-worker-router");
});
$discord->run();
