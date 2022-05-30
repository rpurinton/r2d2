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
        $request = "/natal.php";
        $host = "https://astro.cafeastrology.com";

        $outHeaders = $this->config["highviber"]["push_headers"];
        $outHeaders[3] = "Accept-Encoding: gzip";
        $outHeaders[4] = "Referer: $host$request";
        unset($outHeaders[21]);
        $postdata = "index=0&recalc=&command=new&userid=171811489&name=Now&sex=2";
        date_default_timezone_set("America/New_York");
        $postdata .= "&d1day=" . date("j");
        $postdata .= "&d1month=" . date("n");
        $postdata .= "&d1year=" . date("Y");
        $postdata .= "&d1hour=" . date("G");
        $postdata .= "&d1min=" . date("i");
        date_default_timezone_set("UTC");
        $postdata .= "&citylist=Portland%2C23%2C1%2C43.65%2C-70.25&lang=en";
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $host . $request);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $outHeaders);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $postdata);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 60);
        curl_setopt($curl, CURLOPT_TIMEOUT, 60);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $results = curl_exec($curl);
        $results = gzdecode($results) or $results = $results;
        $planets = substr($results, strpos($results, "<table"));
        $planets = substr($planets, 0, strpos($planets, "</table>") + 8);
        $planets = $this->myReplace("</td>", ",", $planets);
        $planets = $this->myReplace("&nbsp;", "", $planets);
        $planets = strip_tags($planets);
        $planets = "," . substr($planets, strpos($planets, "Sun"));
        $planets = explode("\n", $planets);
        unset($planets[sizeof($planets) - 1]);

        foreach ($planets as $planet)
        {
            $planet = explode(",", $planet);
            $astrodata[$planet[1]]["sign"] = $planet[3];
            $astrodata[$planet[1]]["deg"] = $planet[4] . $planet[5];
        }

        $astro["masculine"] = 0;
        $astro["feminine"] = 0;
        $astro["earth"] = 0;
        $astro["air"] = 0;
        $astro["water"] = 0;
        $astro["fire"] = 0;
        $astro["fixed"] = 0;
        $astro["mutable"] = 0;
        $astro["cardinal"] = 0;

        $valid = function ($input)
        {
            return($input == "Sun" ||
            $input == "Moon" ||
            $input == "Mercury" ||
            $input == "Venus" ||
            $input == "Mars" ||
            $input == "Jupiter" ||
            $input == "Saturn" ||
            $input == "Uranus" ||
            $input == "Neptune" ||
            $input == "Pluto" ||
            $input == "Lilith" ||
            $input == "NNode");
        };

        $astro_get_emoji = function (&$astro, $input)
        {
            if ($input == "Aries    ")
            {
                $astro["masculine"]++;
                $astro["fire"]++;
                $astro["cardinal"]++;
                return "♈︎ $input";
            }
            if ($input == "Taurus   ")
            {
                $astro["feminine"]++;
                $astro["earth"]++;
                $astro["fixed"]++;
                return "♉︎ $input";
            }
            if ($input == "Gemini   ")
            {
                $astro["masculine"]++;
                $astro["air"]++;
                $astro["mutable"]++;
                return "♊︎ $input";
            }
            if ($input == "Cancer   ")
            {
                $astro["feminine"]++;
                $astro["water"]++;
                $astro["cardinal"]++;
                return "♋︎ $input";
            }
            if ($input == "Leo      ")
            {
                $astro["masculine"]++;
                $astro["fire"]++;
                $astro["fixed"]++;
                return "♌︎ $input";
            }
            if ($input == "Virgo    ")
            {
                $astro["feminine"]++;
                $astro["earth"]++;
                $astro["mutable"]++;
                return "♍︎ $input";
            }
            if ($input == "Libra    ")
            {
                $astro["masculine"]++;
                $astro["air"]++;
                $astro["cardinal"]++;
                return "♎︎ $input";
            }
            if ($input == "Scorpio  ")
            {
                $astro["feminine"]++;
                $astro["water"]++;
                $astro["fixed"]++;
                return "♏︎ $input";
            }
            if ($input == "Sagittarius")
            {
                $astro["masculine"]++;
                $astro["fire"]++;
                $astro["mutable"]++;
                $input = "Sagittari";
                return "♐︎ $input";
            }
            if ($input == "Capricorn")
            {
                $astro["feminine"]++;
                $astro["earth"]++;
                $astro["cardinal"]++;
                return "♑︎ $input";
            }
            if ($input == "Aquarius ")
            {
                $astro["masculine"]++;
                $astro["air"]++;
                $astro["fixed"]++;
                return "♒︎ $input";
            }
            if ($input == "Pisces   ")
            {
                $astro["feminine"]++;
                $astro["water"]++;
                $astro["mutable"]++;
                return "♓︎ $input";
            }

            if ($input == "Sun    ") return "☉ Sun    ";
            if ($input == "Moon   ") return "☾ Moon   ";
            if ($input == "Mercury") return "☿ Mercury";
            if ($input == "Venus  ") return "♀ Venus  ";
            if ($input == "Mars   ") return "♂ Mars   ";
            if ($input == "Jupiter") return "♃ Jupiter";
            if ($input == "Saturn ") return "♄ Saturn ";
            if ($input == "Uranus ") return "♅ Uranus ";
            if ($input == "Neptune") return "♆ Neptune";
            if ($input == "Pluto  ") return "♇ Pluto  ";
            if ($input == "NNode  ") return "  N Node ";
            return "  " . $input;
        };

        $message = "--Current Astrology Transit--<br />--" . gmdate("c") . "--<br />";
        foreach ($astrodata as $planet => $value)
        {
            while (strlen($planet) < 7) $planet .= " ";
            while (strlen($value['sign']) < 9) $value['sign'] .= " ";
            if (strlen($value['deg']) == 6) $value['deg'] = " " . $value['deg'];
            if (strlen($value['deg']) == 7 && substr($value['deg'], 6) == "R") $value['deg'] = " " . $value['deg'];
            $message .= "" . $astro_get_emoji($astro, $planet) . " " . $astro_get_emoji($astro, $value['sign']) . " " . $value['deg'] . "<br />";
        }

        $message .= "----------------------------<br />";
        $message .= "♂ Masculine " . $astro["masculine"] . " ♀ Feminine  " . $astro["feminine"] . "<br />";
        $message .= "  Fire      " . $astro["fire"] . "   Earth     " . $astro["earth"] . "<br />";
        $message .= "  Air       " . $astro["air"] . "   Water     " . $astro["water"] . "<br />";
        $message .= "  Fixed     " . $astro["fixed"] . "   Mutable   " . $astro["mutable"] . "<br />";
        $message .= "         Cardinal " . $astro["cardinal"] . "<br />";
        $message .= "----------------------------<br />";

        $aspects = substr($results, strpos($results, "class=\"datatable2\""));
        $aspects = substr($aspects, strpos($aspects, "<table"));
        $aspects = substr($aspects, 0, strpos($aspects, "</table>"));
        $aspects = $this->myReplace("</td>", ",", $aspects);
        $aspects = $this->myReplace("</tr>", "\n", $aspects);
        $aspects = strip_tags($aspects);
        $aspects = explode("\n", $aspects);
        unset($aspects[sizeof($aspects) - 1]);
        unset($aspects[sizeof($aspects) - 1]);
        unset($aspects[0]);

        $positives = 0;
        $negatives = 0;
        foreach ($aspects as $aspect)
        {
            $aspect = str_replace(" ", "", $aspect);
            $aspect = explode(",", $aspect);
            $p1 = $aspect[1];
            $p2 = $aspect[5];
            $asp = substr($aspect[3], 0, 3);
            $val = $aspect[7];
            if ($valid($p1) && $valid($p2))
            {
                while (strlen($p1) < 7) $p1 .= " ";
                while (strlen($p2) < 7) $p2 .= " ";
                $p1 = $astro_get_emoji($astro, $p1);
                $p2 = $astro_get_emoji($astro, $p2);
                if ($val > 0) $positives += $val;
                if ($val < 0) $negatives += $val;
                $valtext = $val;
                while (strlen($valtext) < 4) $valtext = " " . $valtext;
                $message .= "$p1 $asp $p2 $valtext<br />";
            }
        }
        $message .= "----------------------------<br />";
        while (strlen($positives) < 4) $positives = " " . $positives;
        while (strlen($negatives) < 5) $negatives = " " . $negatives;
        $message .= "Positive $positives Negative $negatives<br />";
        $balance = $positives + $negatives;
        $message .= "        Balance $balance";
        $this->reply($data, "<pre>$message</pre>");
    }
};

