<?php

namespace R2D2;

class CommonFunctions
{

    protected
            $config = array();

    function __construct()
    {
        $this->loadConfig();
    }

    protected
            function loadConfig()
    {
        $this->config = array();
        exec("ls " . __DIR__ . "/conf.d/*.conf", $jsons);
        foreach ($jsons as $json)
        {
            $section = substr($json, 0, strpos($json, ".conf"));
            $section = substr($section, strpos($section, "conf.d/") + 7);
            $this->config[$section] = json_decode(file_get_contents($json), true);
        }
    }

    static
            function myReplace($search, $replace, $mixed)
    {
        while (strpos($mixed, $search) !== false)
        {
            $mixed = str_replace($search, $replace, $mixed);
        }
        return $mixed;
    }

    static
            function randId()
    {
        $r = array("a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z", "0", "1", "2", "3", "4", "5", "6", "7", "8", "9");
        $result = "";
        for ($i = 0; $i < 12; $i++)
        {
            if (rand(0, 1) === 1)
            {
                $result .= \strtoupper($r[\array_rand($r)]);
            }
            else
            {
                $result .= $r[array_rand($r)];
            }
        }
        return $result;
    }

    static
            function firstname($name)
    {
        $r = array("!", "a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z", "0", "1", "2", "3", "4", "5", "6", "7", "8", "9");
        $name = explode(" ", $name);
        $first = $name[0];
        $cleanfirst = "";
        for ($i = 0; $i < strlen($first); $i++)
        {
            $char = strtolower(substr($first, $i, 1));
            if (array_search($char, $r) !== false)
            {
                $cleanfirst .= substr($first, $i, 1);
            }
        }
        return $cleanfirst;
    }

}
