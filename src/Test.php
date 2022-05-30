<?php

namespace rpurinton\r2d2;

require_once(__DIR__ . "/DiscordFunctions.php");

class Test Extends DiscordFunctions
{

    protected
            $thread;
    protected
            $future;

    function __construct()
    {
        parent::__construct();
        echo("r2d2 Test mode... use ^C or press...\nr2d2>");
        $this->thread = new \parallel\Runtime(__DIR__ . "/TestSender.php");
        $this->future = $this->thread->run(function ()
        {
            new TestSender;
        });
        while ($line = trim(fgets(STDIN)))
        {
            if ($this->future->done())
            {
                $this->future = $this->thread->run(function ()
                {
                    new TestSender;
                });
            }
            switch($line)
            {
                case "exit":
                case "quit":
                    $this->thread->kill();
                    die();
                    break;
                default:
                    echo("r2d2>");
                    $packet["platform"] = "test";
                    $packet["channel"] = "console";
                    $packet["userid"] = "101";
                    $packet["username"] = "tester";
                    $text = $line;
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
                    if($line === "debug") $this->publish("test_send", $packet);
                    else $this->publish("worker", $packet);
            }
        }
    }

    function __destruct()
    {
        $this->thread->kill();
        parent::__destruct();
    }

}
