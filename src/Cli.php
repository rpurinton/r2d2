<?php

namespace rpurinton\r2d2;

require_once(__DIR__ . "/DiscordFunctions.php");

class Cli Extends DiscordFunctions
{

    protected
            $thread;
    protected
            $future;

    function __construct()
    {
        parent::__construct();
	echo(chr(27).chr(91)."H".chr(27).chr(91)."J
 ▄▄▄▄▄▄▄▄▄▄▄  ▄▄▄▄▄▄▄▄▄▄▄  ▄▄▄▄▄▄▄▄▄▄   ▄▄▄▄▄▄▄▄▄▄▄
▐░░░░░░░░░░░▌▐░░░░░░░░░░░▌▐░░░░░░░░░░▌ ▐░░░░░░░░░░░▌
▐░█▀▀▀▀▀▀▀█░▌ ▀▀▀▀▀▀▀▀▀█░▌▐░█▀▀▀▀▀▀▀█░▌ ▀▀▀▀▀▀▀▀▀█░▌
▐░▌       ▐░▌          ▐░▌▐░▌       ▐░▌          ▐░▌
▐░█▄▄▄▄▄▄▄█░▌          ▐░▌▐░▌       ▐░▌          ▐░▌
▐░░░░░░░░░░░▌ ▄▄▄▄▄▄▄▄▄█░▌▐░▌       ▐░▌ ▄▄▄▄▄▄▄▄▄█░▌
▐░█▀▀▀▀█░█▀▀ ▐░░░░░░░░░░░▌▐░▌       ▐░▌▐░░░░░░░░░░░▌
▐░▌     ▐░▌  ▐░█▀▀▀▀▀▀▀▀▀ ▐░▌       ▐░▌▐░█▀▀▀▀▀▀▀▀▀
▐░▌      ▐░▌ ▐░█▄▄▄▄▄▄▄▄▄ ▐░█▄▄▄▄▄▄▄█░▌▐░█▄▄▄▄▄▄▄▄▄
▐░▌       ▐░▌▐░░░░░░░░░░░▌▐░░░░░░░░░░▌ ▐░░░░░░░░░░░▌
 ▀         ▀  ▀▀▀▀▀▀▀▀▀▀▀  ▀▀▀▀▀▀▀▀▀▀   ▀▀▀▀▀▀▀▀▀▀▀
");
        echo(">");
        $this->thread = new \parallel\Runtime(__DIR__ . "/CliSender.php");
        $this->future = $this->thread->run(function ()
        {
            new CliSender;
        });
        while ($line = fgets(STDIN))
        {
            if ($this->future->done())
            {
                $this->future = $this->thread->run(function ()
                {
                    new CliSender;
                });
            }
            $line = trim($line);
            switch ($line)
            {
                case "exit":
                case "quit":
                    $this->thread->kill();
                    die();
                    break;
                case "start":
                    passthru("r2d2 start");
                    break;
                case "stop":
                    passthru("r2d2 stop");
                    break;
                case "restart":
                    passthru("r2d2 restart");
                    break;
                case "reload":
                    passthru("r2d2 reload");
                    break;
                case "status":
                    passthru("r2d2 status");
                    break;
                default:
                    $packet["platform"] = "cli";
                    $packet["channel"] = "console";
                    $packet["userid"] = "101";
                    $packet["username"] = "Console User";
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
                    if ($line === "debug")
                    {
                        $this->publish("cli_send", $packet);
                    }
                    else
                    {
                        $this->publish("worker", $packet);
                    }
            }
            echo(">");
        }
    }

    function __destruct()
    {
        $this->thread->kill();
        parent::__destruct();
    }

}
