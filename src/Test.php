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
        echo("r2d2 Test mode... use ^C or type exit to quit...\nr2d2>");
        $this->thread = new \parallel\Runtime(__DIR__ . "/TestSender.php");
        $this->future = $this->thread->run(function ()
        {
            new TestSender;
        });
        while ($line = trim(fgets(STDIN)))
        {
            if ($line == "exit" || $line == "quit")
            {
                $this->thread->kill();
                exit(0);
            }
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
            $this->publish("worker", $packet);
            if ($this->future->done())
            {
                $this->future = $this->thread->run(function ()
                {
                    new TestSender;
                });
            }
        }
    }

    function __destruct()
    {
        $this->thread->kill();
        parent::__destruct();
    }

}
