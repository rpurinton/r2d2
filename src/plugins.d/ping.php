<?php

$cmd = "ping";
$cmd_list[] = $cmd;
$html_help[$cmd]["commands"][] = $cmd;
$html_help[$cmd]["title"] = "Send a Ping (Test The Bot)";
$html_help[$cmd]["desc"] = "Check if the bot is responsive.  Should respond \"PONG!\" if so.";
$html_help[$cmd]["usages"][] = "!$cmd";

$funcs[] = function ($data)
{
    extract($data);
    if ($cmd === "!ping")
    {
        $this->sendReply($data, "POOOONNNNNGGGGGG!");
    }
};
