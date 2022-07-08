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
                    $this->publish("cli_send", $this->makePacket("exit"));
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
                case "debug":
                    $this->publish("cli_send", $this->makePacket($line));
                    break;
		case "check":
                    $this->publish("worker", $this->makePacket("!workerid"));
                    $this->publish("worker", $this->makePacket("!workerid"));
                    $this->publish("worker", $this->makePacket("!workerid"));
                    $this->publish("worker", $this->makePacket("!workerid"));
                    break;
                default:
                    $this->publish("worker", $this->makePacket($line));
            }
            echo(">");
        }
    }

    private function makePacket($text)
    {
        $packet["platform"] = "cli";
        $packet["channel"] = "console";
        $packet["userid"] = "101";
        $packet["username"] = "Console User";
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
        return $packet;
    }

    function __destruct()
    {
        $this->thread->kill();
        parent::__destruct();
    }

}
