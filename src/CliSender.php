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
            if ($data["channel"] === "console")
            {
                switch($data["cmd"])
                {
                    case "exit": posix_kill(posix_getpid(),SIGKILL);
                    case "debug":
                        $this->debug = !$this->debug;
                        if ($this->debug)
                        {
                            echo("\rr2d2 debugging enabled\n>");
                        }
                        else
                        {
                            echo("\rr2d2 debugging disabled\n>");
                        }
                }
            }
            else
            {
                if ($this->debug)
                {
                    echo("\r" . print_r($data, true) . "\n");
                }
                echo("\r" . $this->cliClean($data["response"]) . "\n>");
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
