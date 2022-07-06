<?php

$cmd = "cookie";
$cmd_list[] = $cmd;
$html_help[$cmd]["commands"][] = $cmd;
$html_help[$cmd]["title"] = "Get a Chinese Fortune Cookie";
$html_help[$cmd]["desc"] = "Gives you a traditional chinese fortune cookie including a proverb, lucky numbers, and a learn chinese lesson.";
$html_help[$cmd]["usages"][] = "!$cmd";
$html_help[$cmd]["seealso"][] = "tarot";
$html_help[$cmd]["seealso"][] = "oracle";
$funcs[] = function ($data)
{
    extract($data);
    if ($cmd !== "!cookie") return;
    extract($this->sql->single("SELECT * FROM `proverbs` ORDER BY RAND() LIMIT 0,1"));
    extract($this->sql->single("SELECT * FROM `lessons` ORDER BY RAND() LIMIT 0,1"));
    $lotto = array();
    for ($i = 1; $i < 70; $i++)
    {
        $lotto[$i] = $i;
    }
    for ($i = 0; $i < 5; $i++)
    {
        $randkey = array_rand($lotto);
        $balls[] = $randkey;
        unset($lotto[$randkey]);
    }
    sort($balls);
    $powerball = rand(1, 26);
    $first = $this->firstname($username);
    $message = "&#129376; a fortune cookie for $first...<br />";
    $message .= "<i>\"$proverb\"</i><br />";
    $message .= "Lucky Numbers:";
    foreach ($balls as $ball)
    {
        $message .= " $ball";
    }
    $message .= "<br />Powerball: $powerball<br />";
    $message .= "Learn Chinese: $chinese<br />";
    $message .= "Pronounced: $pronounce<br />";
    $message .= "English: $english";
    $this->reply($data, $message);
};

