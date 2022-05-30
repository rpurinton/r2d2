<?php

$cmd = "zen";
$cmd_list[] = $cmd;
$html_help[$cmd]["commands"][] = $cmd;
$html_help[$cmd]["title"] = "Get a Zen Koan";
$html_help[$cmd]["desc"] = "Gives you one of 101 Zen Koans (short stories used by Zen Masters in teaching Zen students.  If a koan number is not provided, a random koan will be given, otherwise you are given the requested koan.";
$html_help[$cmd]["usages"][] = "!$cmd [optional 1 to 101]";
$html_help[$cmd]["usages"][] = "!$cmd";
$html_help[$cmd]["usages"][] = "!$cmd 7";
$html_help[$cmd]["seealso"][] = "cookie";
$html_help[$cmd]["seealso"][] = "quote";
$funcs[] = function ($data)
{
    extract($data);
    if ($cmd == "!zen")
    {
        if ($vars != "" && (!is_numeric($vars) || $vars < 1 || $vars > 101)) return $this->reply($data, "number must be between 1 and 101");
        mysqli_select_db($this->sql, "koans");
        if ($vars === "")
        {
            $query = "SELECT * FROM `koans` ORDER BY RAND() LIMIT 0,1;";
        }
        else
        {
            $query = "SELECT * FROM `koans` WHERE `id` = $vars";
        }
        extract(mysqli_fetch_assoc(mysqli_query($this->sql, $query)));
        $this->reply($data, "<b><u>Zen Koan $id - $title</u></b><br /><i>$text</i>");
    }
};
