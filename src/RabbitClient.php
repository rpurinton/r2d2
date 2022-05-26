<?php

namespace R2D2;

require_once(__DIR__ . "/../vendor/autoload.php");

use PhpAmqpLib\Message\AMQPMessage;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class RabbitClient
{

    protected
            $config;
    protected
            $mq_conn;
    protected
            $mq_chan;

    function __construct()
    {
        $this->config = json_decode(file_get_contents(__DIR__ . "/../config.json"), true);
        $this->rabbitConnect($this->config["rabbit"]);
    }

    function __destruct()
    {
        if ($this->mq_chan != \null)
        {
            $this->mq_chan->close();
        }
        if ($this->mq_conn != \null)
        {
            $this->mq_conn->close();
        }
    }

    protected
            function rabbitConnect($config)
    {
        extract($config);
        $this->mq_conn = new AMQPStreamConnection($host, $port, $user, $pass);
        $this->mq_chan = $this->mq_conn->channel();
        $this->mq_chan->basic_qos(\null, 1, \null);
    }

    protected
            function publish($queue, $data)
    {
        $message = new AMQPMessage(json_encode($data));
        $this->mq_chan->basic_publish($message, '', $queue);
    }
}

