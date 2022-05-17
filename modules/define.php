<?php

$cmd = "define";
$cmdlist[] = $cmd;
$htmlhelp[$cmd]["commands"][] = $cmd;
$htmlhelp[$cmd]["title"] = "Get a Dictionary Definition";
$htmlhelp[$cmd]["desc"] = "Gives you the dictionary definition of a given word (required).  Only the first word provided is searched.";
$htmlhelp[$cmd]["usages"][] = "!$cmd &lt;word required&gt;";
$htmlhelp[$cmd]["usages"][] = "!$cmd plethora";
$htmlhelp[$cmd]["usages"][] = "!$cmd anything";
$funcs[] = function ($channel, $userid, $username, $cmd, $vars, $text)
{
	if ($cmd == "!define")
	{
		if($vars === "") return "must specify a word";
		start_typing($channel);
		$vars = urlencode(strtolower(firstname($vars)));
		$requestUrl = "https://api.dictionaryapi.dev/api/v2/entries/en/$vars";
		$results = @json_decode(@file_get_contents($requestUrl), true);
		if (!isset($results[0]["meanings"]))
		{
			return("word not found");
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
		return($definition);
	}
	return false;
};

