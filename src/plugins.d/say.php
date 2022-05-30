<?php

// Hidden Function
$funcs[] = function ($data)
{
    extract($data);
    if ($channel != $this->config["highviber"]["public_channel"] && $cmd == "!say" && $vars != "")
    {
        $data["platform"] = "highviber";
        $data["channel"] = $this->config["highviber"]["public_channel"];
        $this->reply($data, $vars);
    }
};
