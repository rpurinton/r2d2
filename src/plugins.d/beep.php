<?php

$cmd = "beep";
$cmd_list[] = $cmd;
$html_help[$cmd]["commands"][] = $cmd;
$html_help[$cmd]["title"] = "Make Some Beeps";
$html_help[$cmd]["desc"] = "Makes the bot beep a few times.";
$html_help[$cmd]["usages"][] = "!$cmd";

$funcs[] = function ($data)
{
    extract($data);
    if ($cmd === "!beep")
    {
        $makeBeep = function ()
        {
            $beeps = rand(1, 10);
            $sentence = "";
            for ($j = 0; $j < $beeps; $j++)
            {
                $b = rand(0, 1);
                if ($b)
                {
                    if ($j) $beep = "b";
                    else $beep = "B";
                }
                else
                {
                    if ($j) $beep = "bl";
                    else $beep = "Bl";
                }
                $e = rand(0, 1);
                if ($e) $e = "e";
                else $e = "o";
                $len = rand(1, 5);
                for ($i = 0; $i < $len; $i++) $beep .= $e;
                if ($j == $beeps - 1) $beep .= "p.";
                else
                {
                    if (!rand(0, 9)) $beep .= "p, ";
                    else $beep .= "p ";
                }
                if (!rand(0, 9)) $beep = strtoupper($beep);
                $sentence .= $beep;
            }
            return $sentence;
        };
        $this->reply($data, $makeBeep());
    }
};

$funcs[] = function ($data)
{
    extract($data);
    if ($cmd === "!beepchat")
    {
        $data["platform"] = "highviber";
        $data["channel"] = $this->config["highviber"]["public_channel"];
        $makeBeep = function ()
        {
            $beeps = rand(1, 10);
            $sentence = "";
            for ($j = 0; $j < $beeps; $j++)
            {
                $b = rand(0, 1);
                if ($b)
                {
                    if ($j) $beep = "b";
                    else $beep = "B";
                }
                else
                {
                    if ($j) $beep = "bl";
                    else $beep = "Bl";
                }
                $e = rand(0, 1);
                if ($e) $e = "e";
                else $e = "o";
                $len = rand(1, 5);
                for ($i = 0; $i < $len; $i++) $beep .= $e;
                if ($j == $beeps - 1) $beep .= "p.";
                else
                {
                    if (!rand(0, 9)) $beep .= "p, ";
                    else $beep .= "p ";
                }
                if (!rand(0, 9)) $beep = strtoupper($beep);
                $sentence .= $beep;
            }
            return $sentence;
        };
        $this->reply($data, $makeBeep());
    }
};
