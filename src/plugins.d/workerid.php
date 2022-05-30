<?php

$funcs[] = function ($data)
{
    extract($data);
    if ($cmd === "!workerid")
    {
        $this->reply($data, $this->worker_id);
    }
};
