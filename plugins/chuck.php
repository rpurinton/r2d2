<?php

$cmd = "chuck";
$cmd_list[] = $cmd;
$html_help[$cmd]["commands"][] = $cmd;
$html_help[$cmd]["commands"][] = "fact";
$html_help[$cmd]["title"] = "Get a Random Chuck Norris Fact";
$html_help[$cmd]["desc"] = "Gives you a random true fact about Chuck Norris. (joke)";
$html_help[$cmd]["usages"][] = "!$cmd";
$html_help[$cmd]["seealso"][] = "quote";
$html_help[$cmd]["seealso"][] = "love";
$funcs[] = function ($data)
{
    extract($data);
    if ($cmd == "!chuck" || $cmd == "!fact")
    {
        $requestUrl = "https://api.chucknorris.io/jokes/random";
        $results = json_decode(file_get_contents($requestUrl), true);
        $this->sendReply($data, "True Fact: " . $results["value"]);
    }
};
