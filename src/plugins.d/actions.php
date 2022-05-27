<?php

$cmd = "cwtch";
$cmd_list[] = $cmd;
$html_help[$cmd]["commands"][] = $cmd;
$html_help[$cmd]["title"] = "Give a Cwtch to Someone";
$html_help[$cmd]["desc"] = "Gives a cwtch (hug) to someone if name provided, or to you if not.";
$html_help[$cmd]["usages"][] = "!$cmd [optional name]";
$html_help[$cmd]["usages"][] = "!$cmd";
$html_help[$cmd]["usages"][] = "!$cmd Mary";
$html_help[$cmd]["seealso"][] = "slap";
$funcs[] = function ($data)
{
    extract($data);
    if ($cmd == "!cwtch")
    {
        if ($vars == "")
        {
            $vars = $this->firstname($username);
        }
        $this->sendReply($data, "<i>*cwtches $vars*</i> &#129303;");
    }
};

$cmd = "slap";
$cmd_list[] = $cmd;
$html_help[$cmd]["commands"][] = $cmd;
$html_help[$cmd]["title"] = "Slap Someone With a Large Trout";
$html_help[$cmd]["desc"] = "If a name is provided, slap them with a large trout.  If no name is given, you will be slapped.";
$html_help[$cmd]["usages"][] = "!$cmd [optional name]";
$html_help[$cmd]["usages"][] = "!$cmd";
$html_help[$cmd]["usages"][] = "!$cmd Bobby";
$html_help[$cmd]["seealso"][] = "cwtch";
$funcs[] = function ($data)
{
    extract($data);
    if ($cmd == "!slap")
    {
        if ($vars == "") $vars = $this->firstname($username);
        $this->sendReply($data, "<i>slaps $vars around a bit with a large trout</i>");
    }
};
