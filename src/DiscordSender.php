<?php

namespace rpurinton\r2d2;

require_once(__DIR__ . "/DiscordFunctions.php");

class DiscordSender Extends DiscordFunctions
{

    function __construct()
    {
        parent::__construct();
        $this->mq_chan->basic_consume("discord_send", "discord_sender", false, true, false, false, function ($message)
        {
            $result = array(1);
            $data = json_decode($message->body, true);
            while (sizeof($result) > 0)
            {
                $result = $this->discordSend($data["channel"], $data["message"]);
                if (\sizeof($result) > 0)
                {
                    if (isset($result["retry_after"]))
                    {
                        usleep($result["retry_after"] * 1000);
                    }
                    else
                    {
                        $result = array();
                    }
                }
            }
        });
        $this->mq_chan->consume();
    }

}
