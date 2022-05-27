<?php

namespace R2D2;

use Discord\Discord;
use React\EventLoop\Factory;
use Monolog\Handler\StreamHandler;

require_once(__DIR__ . "/DiscordFunctions.php");

class DiscordClient Extends DiscordFunctions
{

    function __construct()
    {
        parent::__construct();
        echo("Starting DiscordClient...\n");
        $loop = Factory::create();
        $discord = new Discord([
            "loop" => $loop,
            "token" => $this->config["discord"]["bot_token"],
            'logger' => new \Monolog\Logger('DiscordPHP', [new StreamHandler('php://stdout', \MonoLog\Logger::ERROR)])
        ]);
        $discord->on("ready", function (Discord $discord)
        {
            $discord->on("raw", function ($data, Discord $discord)
            {
                $data = json_decode(json_encode($data), true);
                if ($data["t"] === "MESSAGE_CREATE" &&
                        $data["d"]["author"]["username"] != "R2D2" &&
                        $data["d"]["author"]["username"] != "HighViber")
                {
                    $packet["platform"] = "discord";
                    $text = $data["d"]["content"];
                    $packet["text"] = $text;
                    $packet["cmd"] = strtolower($this->firstname($text));
                    if (strpos($text, " ") !== false)
                    {
                        $packet["vars"] = substr($text, strpos($text, " ") + 1);
                    }
                    else
                    {
                        $packet["vars"] = "";
                    }
                    $packet["channel"] = $data["d"]["channel_id"];
                    $packet["userid"] = $data["d"]["author"]["id"];
                    $packet["username"] = $data["d"]["author"]["username"];
                    if (isset($data["d"]["member"]["nick"]))
                    {
                        $packet["username"] = $data["d"]["member"]["nick"];
                    }
                    $this->publish("worker", $packet);
                }
            });
        });
        $discord->run();
    }

    function __destruct()
    {
        echo("Stopped DiscordClient.\n");
        parent::__destruct();
    }

}
