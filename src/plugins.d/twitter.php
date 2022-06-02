<?php

$cmd = "twitter";
$cmd_list[] = $cmd;
$html_help[$cmd]["commands"][] = $cmd;
$html_help[$cmd]["title"] = "Get a link to my Twitter";
$html_help[$cmd]["desc"] = "Follow me on twitter <a href=\"https://twitter.com/astrologbot\" target=\"_blank\">https://twitter.com/astrologbot</a>";
$html_help[$cmd]["usages"][] = "!$cmd";

$funcs[] = function ($data)
{
    extract($data);
    if ($cmd === "!twitter")
    {
        $this->reply($data, "Follow me on twitter! <a href=\"https://twitter.com/astrologbot\" target=\"_blank\">https://twitter.com/astrologbot</a>");
    }
};
