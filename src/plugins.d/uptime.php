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
        $timehuman = function ($num)
        {
            $num = (int) ($num / 60);
            $mins = $num % 60;
            $num = (int) ($num / 60);
            $hours = $num % 24;
            $num = (int) ($num / 24);
            $days = $num;
            return $days . "d " . $hours . "h " . $mins . "m";
        };
        $system_time = explode(" ", file_get_contents("/proc/uptime"))[0];
        $message = "<pre>linux booted " . $timehuman($system_time) . " ago";
        $message .= "<br />bot started " . $timehuman(time() - $this->start_time) . " ago";
        $message .= "<br />plugins loaded " . $timehuman(time() - $this->reload_time) . " ago</pre>";
        $this->reply($data, $message);
    }
};
