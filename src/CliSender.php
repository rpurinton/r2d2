<?php

namespace rpurinton\r2d2;

require_once(__DIR__ . "/DiscordFunctions.php");

class CliSender Extends DiscordFunctions
{

    private
            $debug = false;

    function __construct()
    {
        parent::__construct();
        $this->mq_chan->basic_consume("cli_send", "cli_sender", false, true, false, false, function ($message)
        {
            $data = json_decode($message->body, true);
            if ($data["channel"] == "console" && $data["cmd"] == "debug")
            {
                $this->debug = !$this->debug;
                if ($this->debug)
                {
                    echo("\rr2d2 debugging enabled\nC:\>");
                }
                else
                {
                    echo("\rr2d2 debugging disabled\nC:\>");
                }
            }
            else
            {
                if ($this->debug)
                {
                    echo("\r" . print_r($data, true) . "\n");
                }
                echo("\r" . $this->cliClean($data["response"]) . "\nC:\>");
            }
        });
        $this->mq_chan->consume();
    }

    protected
            function cliClean($message)
    {
        $message = $this->myReplace("<br />", "\n", $message);
        $message = $this->myReplace("<br>", "\n", $message);
        $message = strip_tags($message);
        $message = html_entity_decode($message);
        return $message;
    }

}
