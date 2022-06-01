<?php

$cmd = "astro";
$cmd_list[] = $cmd;
$html_help[$cmd]["commands"][] = $cmd;
$html_help[$cmd]["title"] = "Get Current Astrology Transits and Aspects";
$html_help[$cmd]["desc"] = "Gives you a report of the current zodiac locations for each planet, their aspects, and a summary of the masculine and feminine, elemental, and positive and negative influences.";
$html_help[$cmd]["usages"][] = "!$cmd";
$html_help[$cmd]["seealso"][] = "moon";
$html_help[$cmd]["seealso"][] = "oracle";
$funcs[] = function ($data)
{
    extract($data);
    if ($cmd === "!astro")
    {
        $astro["masculine"] = 0;
        $astro["feminine"] = 0;
        $astro["earth"] = 0;
        $astro["air"] = 0;
        $astro["water"] = 0;
        $astro["fire"] = 0;
        $astro["fixed"] = 0;
        $astro["mutable"] = 0;
        $astro["cardinal"] = 0;

        $astro_sign_emoji = function (&$astro, $input)
        {
            if ($input == "ar")
            {
                $input = "Aries    ";
                $astro["masculine"]++;
                $astro["fire"]++;
                $astro["cardinal"]++;
                return "♈︎ $input";
            }
            if ($input == "ta")
            {
                $input = "Taurus   ";
                $astro["feminine"]++;
                $astro["earth"]++;
                $astro["fixed"]++;
                return "♉︎ $input";
            }
            if ($input == "ge")
            {
                $input = "Gemini   ";
                $astro["masculine"]++;
                $astro["air"]++;
                $astro["mutable"]++;
                return "♊︎ $input";
            }
            if ($input == "cn")
            {
                $input = "Cancer   ";
                $astro["feminine"]++;
                $astro["water"]++;
                $astro["cardinal"]++;
                return "♋︎ $input";
            }
            if ($input == "le")
            {
                $input = "Leo      ";
                $astro["masculine"]++;
                $astro["fire"]++;
                $astro["fixed"]++;
                return "♌︎ $input";
            }
            if ($input == "vi")
            {
                $input = "Virgo    ";
                $astro["feminine"]++;
                $astro["earth"]++;
                $astro["mutable"]++;
                return "♍︎ $input";
            }
            if ($input == "li")
            {
                $input = "Libra    ";
                $astro["masculine"]++;
                $astro["air"]++;
                $astro["cardinal"]++;
                return "♎︎ $input";
            }
            if ($input == "sc")
            {
                $input = "Scorpio  ";
                $astro["feminine"]++;
                $astro["water"]++;
                $astro["fixed"]++;
                return "♏︎ $input";
            }
            if ($input == "sa")
            {
                $input = "Sagittari";
                $astro["masculine"]++;
                $astro["fire"]++;
                $astro["mutable"]++;
                return "♐︎ $input";
            }
            if ($input == "cp")
            {
                $input = "Capricorn";
                $astro["feminine"]++;
                $astro["earth"]++;
                $astro["cardinal"]++;
                return "♑︎ $input";
            }
            if ($input == "aq")
            {
                $input = "Aquarius ";
                $astro["masculine"]++;
                $astro["air"]++;
                $astro["fixed"]++;
                return "♒︎ $input";
            }
            if ($input == "pi")
            {
                $input = "Pisces   ";
                $astro["feminine"]++;
                $astro["water"]++;
                $astro["mutable"]++;
                return "♓︎ $input";
            }
        };
        $astro_planet_emoji = function ($input)
        {
            switch ($input)
            {
                case 0: return "☉ Sun    ";
                case 1: return "☾ Moon   ";
                case 2: return "☿ Mercury";
                case 3: return "♀ Venus  ";
                case 4: return "♂ Mars   ";
                case 5: return "♃ Jupiter";
                case 6: return "♄ Saturn ";
                case 7: return "♅ Uranus ";
                case 8: return "♆ Neptune";
                case 9: return "♇ Pluto  ";
                case 10: return "  T Node ";
                case 12: return "  Lilith ";
            }
        };

        $message = "<pre>--Current Astrology Transit--<br />--" . gmdate("c") . "--<br />";

        $swecmd = array();
        $swecmd[] = "swetest";
        $swecmd[] = "-b" . date("d.m.Y");
        $swecmd[] = "-utc" . date("G:i:s");
        $swecmd[] = "-roundmin";
        $swecmd[] = "-g";
        $swecmd[] = "-head";
        $swecmd[] = "-fpZS";
        $results = array();
        exec(implode(" ", $swecmd), $results);
        foreach ($results as $key => $result)
        {
            $results[$key] = array();
            $input = explode("\t", $result);
            $input1 = $input[1];
            $input1 = $this->myReplace("  ", " ", $input1);
            if (substr($input1, 0, 1) === " ")
            {
                $input1 = substr($input1, 1);
            }
            $input1 = explode(" ", $input1);
            if (strlen($input1[0]) === 1)
            {
                $results[$key]["degs"] = " " . $input1[0];
            }
            else
            {
                $results[$key]["degs"] = $input1[0];
            }
            $results[$key]["sign"] = $input1[1];
            if (strlen($input1[2]) === 1)
            {
                $results[$key]["mins"] = "0" . $input1[2];
            }
            else
            {
                $results[$key]["mins"] = $input1[2];
            }
            $input2 = $input[2];
            $input2 = $this->myReplace(" ", "", $input2);
            if (substr($input2, 0, 1) === "-")
            {
                $results[$key]["retro"] = "R";
            }
            else
            {
                $results[$key]["retro"] = " ";
            }
        }

        unset($results[11]);

        foreach ($results as $key => $value)
        {
            $message .= $astro_planet_emoji($key) . " " . $astro_sign_emoji($astro, $value["sign"]) . " ";
            $message .= $value["degs"] . "&deg;" . $value["mins"] . "'" . $value["retro"] . "\n";
        }

        $message .= "-----------------------------<br />";
        $message .= "♂ Masculine " . $astro["masculine"] . " ♀ Feminine  " . $astro["feminine"] . "  <br />";
        $message .= "  Fire      " . $astro["fire"] . "   Earth     " . $astro["earth"] . "  <br />";
        $message .= "  Air       " . $astro["air"] . "   Water     " . $astro["water"] . "  <br />";
        $message .= "  Fixed     " . $astro["fixed"] . "   Mutable   " . $astro["mutable"] . "  <br />";
        $message .= "         Cardinal " . $astro["cardinal"] . "          <br />";
        $message .= "-----------------------------<br /></pre>";

        $this->reply($data, $message);
    }
};

