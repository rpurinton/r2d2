<?php

namespace rpurinton\r2d2;

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
        $this->rabbitConnect();
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

    public
            function rabbitConnect()
    {
        extract($this->config["rabbit"]);
        $this->mq_conn = new AMQPStreamConnection($host, $port, $user, $pass);
        $this->mq_chan = $this->mq_conn->channel();
        $this->mq_chan->basic_qos(\null, 1, \null);
    }

    public
            function publish($queue, $data)
    {
        $message = new AMQPMessage(json_encode($data));
        $this->mq_chan->basic_publish($message, '', $queue);
    }

}
