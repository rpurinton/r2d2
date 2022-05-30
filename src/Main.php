<?php

namespace rpurinton\r2d2;

class Main
{

    protected
            $nproc;
    protected
            $functions;
    protected
            $threads;
    protected
            $futures;

    function __construct()
    {
        $this->nproc = exec("nproc");
        for ($id = 1; $id <= $this->nproc; $id++)
        {
            $this->functions["worker$id"] = function ($workerid)
            {
                $worker = new Worker($workerid);
                $worker->start();
            };
            $this->threads["worker$id"] = new \parallel\Runtime(__DIR__ . "/Worker.php");
            $this->futures["worker$id"] = $this->threads["worker$id"]->run($this->functions["worker$id"], array($id));
        }
        $this->functions["discord"] = function ()
        {
            new DiscordClient;
        };
        $this->threads["discord"] = new \parallel\Runtime(__DIR__ . "/DiscordClient.php");
        $this->futures["discord"] = $this->threads["discord"]->run($this->functions["discord"]);
        $this->functions["highviber"] = function ()
        {
            new HighViberClient;
        };
        $this->threads["highviber"] = new \parallel\Runtime(__DIR__ . "/HighViberClient.php");
        $this->futures["highviber"] = $this->threads["highviber"]->run($this->functions["highviber"]);
        while (true)
        {
            foreach ($this->futures as $key => $future)
            {
                if ($future->done())
                {
                    $this->futures[$key] = $this->threads[$key]->run($this->functions[$key]);
                }
            }
            sleep(1);
        }
    }

    function __destruct()
    {
        foreach ($this->threads as $thread)
        {
            $thread->kill();
        }
    }

}
