<?php

namespace rpurinton\r2d2;

require_once(__DIR__ . "/DiscordFunctions.php");

class TestSender Extends DiscordFunctions
{

    function __construct()
    {
        parent::__construct();
        $this->mq_chan->basic_consume("test_send", "test_sender", false, true, false, false, function ($message)
        {
            $data = json_decode($message->body, true);
            echo("\r" . $data["response"] . "\nr2d2>");
        });
        $this->mq_chan->consume();
    }

}
