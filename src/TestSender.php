<?php

namespace rpurinton\r2d2;

require_once(__DIR__ . "/DiscordFunctions.php");

class TestSender Extends DiscordFunctions
{

    private $debug = false;

    function __construct()
    {
        parent::__construct();
        $this->mq_chan->basic_consume("test_send", "test_sender", false, true, false, false, function ($message)
        {
            $data = json_decode($message->body, true);
            if($data["channel"] == "console" && $data["cmd"] == "debug")
            {
		$this->debug = !$this->debug;
		if($this->debug) echo("\rr2d2 debugging enabled\nr2d2>");
		else echo("\rr2d2 debugging disabled\nr2d2>");
            }
            else
            {
                if($this->debug) echo("\r".print_r($data,true)."\n");
                echo("\r" . $this->testClean($data["response"]) . "\nr2d2>");
            }
        });
        $this->mq_chan->consume();
    }
    protected
            function testClean($message)
    {
        $message = $this->myReplace("<br />", "\n", $message);
        $message = $this->myReplace("<br>", "\n", $message);
        $message = html_entity_decode($message);
        $message = strip_tags($message);
        return $message;
    }


}
