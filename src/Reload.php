<?php

namespace R2D2;

require_once(__DIR__ . "/CommonFunctions.php");

class Reload Extends CommonFunctions
{

    function __construct()
    {
        parent::__construct();
        $nproc = exec("nproc");
        for ($id = 1; $id <= $nproc; $id++)
        {
            $this->publish("worker", array("channel" => "command", "command" => "reload", "worker_id" => "$id"));
        }
    }

}

