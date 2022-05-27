<?php

namespace R2D2;

use PhpAmqpLib\Message\AMQPMessage;
use PhpAmqpLib\Connection\AMQPStreamConnection;

require_once(__DIR__ . "/vendor/autoload.php");
require_once(__DIR__ . "/CommonFunctions.php");

class RabbitClient Extends CommonFunctions
{

    protected
            $mq_conn;
    protected
            $mq_chan;

    function __construct()
    {
        parent::__construct();
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
