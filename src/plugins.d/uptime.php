<?php

$cmd = "uptime";
$cmd_list[] = $cmd;
$html_help[$cmd]["commands"][] = $cmd;
$html_help[$cmd]["title"] = "Check the Bot's Uptime";
$html_help[$cmd]["desc"] = "Shows how long the bot has been running for.";
$html_help[$cmd]["usages"][] = "!$cmd";

$funcs[] = function ($data)
{
    extract($data);
    if ($cmd === "!uptime")
    {
        $this->sendReply($data, exec("uptime"));
    }
};
