<?php

$cmd = "define";
$cmd_list[] = $cmd;
$html_help[$cmd]["commands"][] = $cmd;
$html_help[$cmd]["title"] = "Get a Dictionary Definition";
$html_help[$cmd]["desc"] = "Gives you the dictionary definition of a given word (required).  Only the first word provided is searched.";
$html_help[$cmd]["usages"][] = "!$cmd &lt;word required&gt;";
$html_help[$cmd]["usages"][] = "!$cmd plethora";
$html_help[$cmd]["usages"][] = "!$cmd anything";
$funcs[] = function ($data)
{
    extract($data);
    if ($cmd == "!define")
    {
        if ($vars === "") return $this->sendReply($data, "must specify a word");
        $vars = urlencode(strtolower($this->firstname($vars)));
        $requestUrl = "https://api.dictionaryapi.dev/api/v2/entries/en/$vars";
        $results = @json_decode(@file_get_contents($requestUrl), true);
        if (!isset($results[0]["meanings"]))
        {
            return $this->sendReply($data, "word not found");
        }
        $results = $results[0]["meanings"];
        $definition = "definitions of $vars<br />";
        foreach ($results as $value)
        {
            $definition .= "[" . $value["partOfSpeech"] . "]<br />";
            foreach ($value["definitions"] as $key2 => $value2)
            {
                $definition .= ($key2 + 1) . ". " . $value2["definition"] . "<br />";
            }
        }
        $this->sendReply($data, $definition);
    }
};

