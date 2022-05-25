<?php

namespace R2D2;

class ProcessManager
{

    protected
            function __construct($command)
    {
        switch($command)
        {
            case "status":$this->status();
                break;
            case "start":$this->start();
                break;
            case "restart":$this->restart();
                break;
            case "stop":$this->stop();
                break;
            case "kill":$this->kill();
                break;
            case "reload":$this->reload();
                break;
            case "wrapper":$this->reload();
                break;
            case "main":$this->reload();
                break;
            case "logger":$this->reload();
                break;
            default: die("ERROR: Invalid Command\n");
        }
    }

    protected
            function getPids()
    {
        $ps = array();
        $ps2 = array();
        $ps3 = array();
        exec("ps aux | grep \"r2d2 wrapper\"", $ps);
        exec("ps aux | grep \"r2d2 logger\"", $ps);
        exec("ps aux | grep \"r2d2 main\"", $ps);
        foreach ($ps as $line)
        {
            if (\strpos($line, "grep") === \false)
            {
                $ps2[] = $line;
            }
        }
        foreach ($ps2 as $line)
        {
            $line = Base::myReplace("  ", " ", $line);
            $line = explode(" ", $line);
            $ps3[] = $line[1];
        }
        return $ps3;
    }

    protected
            function status()
    {
        $pids = $this->getPids();
        if (\sizeof($pids) === 4)
        {
            echo("R2D2 is running... (pids " . implode(" ", $pids) . ")\n");
        }
        elseif (\sizeof($pids))
        {
            echo("WARNING; R2D2 is HALF running... (pids " . implode(" ", $pids) . ")\n");
        }
        else
        {
            echo("R2D2 is stopped.\n");
        }
    }

    protected
            function start()
    {
        $pids = $this->getPids();
        if (\sizeof($pids))
        {
            die("ERROR: R2D2 is already running.  Not starting.\n");
        }
        exec("nohup r2d2 wrapper </dev/null 2>&1 | r2d2 logger > /dev/null 2>&1 &");
        $this->status();
    }

    protected
            function stop()
    {
        $pids = $this->getPids();
        foreach ($pids as $pid)
        {
            posix_kill($pid, SIGTERM);
        }
        $this->status();
    }

    protected
            function kill()
    {
        $pids = $this->getPids();
        foreach ($pids as $pid)
        {
            posix_kill($pid, SIGKILL);
        }
        $this->status();
    }

    protected
            function restart()
    {
        $this->status();
        $this->stop();
        $this->start();
    }

}