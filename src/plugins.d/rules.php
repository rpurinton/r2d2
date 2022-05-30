<?php

$cmd = "rules";
$cmd_list[] = $cmd;
$html_help[$cmd]["commands"][] = $cmd;
$html_help[$cmd]["title"] = "Get the Community Guidelines";
$html_help[$cmd]["desc"] = "Gives you a link to the HighViber community guidelines.";
$html_help[$cmd]["usages"][] = "!$cmd";
$funcs[] = function ($data)
{
    extract($data);
    if ($cmd === "!rules")
    {
        $this->reply($data, "<a href=\"https://www.highviber.com/posts/community-guidelines\" target=\"_blank\">https://www.highviber.com/posts/community-guidelines</a>");
    }
};
