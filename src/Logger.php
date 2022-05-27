<?php

namespace R2D2;

require_once(__DIR__ . "/DiscordFunctions.php");

class Logger Extends DiscordFunctions
{

    protected
            $thread;
    protected
            $future;

    function __construct()
    {
        parent::__construct();
        echo("Started Logger...\n");
        $this->thread = new \parallel\Runtime(__DIR__ . "/DiscordSender.php");
        $this->future = $this->thread->run(function ()
        {
            new DiscordSender;
        });
        while ($line = fgets(STDIN))
        {
            $this->myLog($line);
            if ($this->future->done())
            {
                $this->future = $this->thread->run(function ()
                {
                    new DiscordSender;
                });
            }
        }
    }

    function __destruct()
    {
        $this->thread->kill();
        echo("Stopped Logger.\n");
        parent::__destruct();
    }

}
