<?php

$cmd = "num";
$cmd_list[] = $cmd;
$html_help[$cmd]["commands"][] = $cmd;
$html_help[$cmd]["commands"][] = "name";
$html_help[$cmd]["title"] = "Calculate Numerology For a Name";
$html_help[$cmd]["desc"] = "Calculates the numerology for a given name or number.";
$html_help[$cmd]["usages"][] = "!$cmd &lt;required value&gt;";
$html_help[$cmd]["usages"][] = "!$cmd Mary";
$html_help[$cmd]["usages"][] = "!$cmd John Smith";
$html_help[$cmd]["usages"][] = "!$cmd 7/16/1984";
$html_help[$cmd]["seealso"][] = "userid";
$funcs[] = function ($data)
{
    extract($data);
    if ($cmd === "!name" || $cmd === "!num")
    {
        if ($vars === "") return $this->reply($data, "you must provide a name or number for me to calculate");
        $lettervals = array("0" => 0, "1" => 1, "2" => 2, "3" => 3, "4" => 4, "5" => 5, "6" => 6, "7" => 7, "8" => 8, "9" => 9, "a" => 1, "b" => 2, "c" => 3, "d" => 4, "e" => 5, "f" => 6, "g" => 7, "h" => 8, "i" => 9, "j" => 10, "k" => 11, "l" => 12, "m" => 13, "n" => 14, "o" => 15, "p" => 16, "q" => 17, "r" => 18, "s" => 19, "t" => 20, "u" => 21, "v" => 22, "w" => 23, "x" => 24, "y" => 25, "z" => 26);
        $name = strtolower($vars);
        $runningtotal = 0;
        $message = "Numerology of $vars<br /><pre>";
        for ($i = 0; $i < strlen($name); $i++)
        {
            $char = substr($name, $i, 1);
            if (isset($lettervals[$char]))
            {
                $runningtotal += $lettervals[$char];
                $message .= $lettervals[$char] . "+";
            }
        }
        $message = substr($message, 0, strlen($message) - 1) . "=$runningtotal<br />";
        while (strlen($runningtotal) > 1)
        {
            $newtotal = 0;
            for ($i = 0; $i < strlen($runningtotal); $i++)
            {
                $char = substr($runningtotal, $i, 1);
                $newtotal += $char;
                $message .= "$char+";
            }
            $message = substr($message, 0, strlen($message) - 1) . "=$newtotal<br />";
            $runningtotal = $newtotal;
        }
        $message .= "</pre>";
        $this->reply($data, $message);
    }
};
