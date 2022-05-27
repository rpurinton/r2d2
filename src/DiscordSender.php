<?php

namespace R2D2;

require_once(__DIR__ . "/DiscordFunctions.php");

class DiscordSender Extends DiscordFunctions
{

    function __construct()
    {
        parent::__construct();
        echo("Starting DiscordSender...\n");
        $this->mq_chan->basic_consume("discord_send", "discord_sender", false, true, false, false, function ($message)
        {
            $result = array(1);
            $data = json_decode($message->body, true);
            while (sizeof($result) > 0)
            {
                $result = $this->discordSend($data["channel"], $data["message"]);
                if (\sizeof($result) > 0)
                {
                    $this->discordQueue($data["channel"], $data["message"]);
                    usleep($result["retry_after"] * 1000);
                }
            }
        });
        $this->mq_chan->consume();
    }

    function __destruct()
    {
        echo("Stopped DiscordSender.\n");
    }

}
