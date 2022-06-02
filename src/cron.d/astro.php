#!/usr/local/bin/php -f
<?php

$message = "";
$time = time();
$results1 = getResults($time - 60);
$results2 = getResults($time);
foreach ($results2 as $planet => $result2)
{
    if ($results1[$planet]["sign"] !== $result2["sign"])
    {
	if($planet === 1)
	{
            $increasing = $results2[1]["phase"] > $results1[1]["phase"];
            $message .= round($result2["phase"]*100,0)."% ".moon_phase_name($result2["phase"],$increasing) . " ";
            $message .= moon_phase_emoji($result2["phase"],$increasing) . " #Moon is now in " . astro_sign_emoji($result2["sign"]);
	}
	else
	{
            $message .= astro_planet_emoji($planet) . " is now in " . astro_sign_emoji($result2["sign"]);
	}
    }
    if ($results1[$planet]["retro"] !== $result2["retro"])
    {
        $message .= astro_planet_emoji($planet) . " in " . astro_sign_emoji($result2["sign"]) . " is ";
        if ($result2["retro"] === "R") $message .= "now #Retrograde";
        if ($result2["retro"] === " ") $message .= "no longer #Retrograde";
    }
}
if ($message != "")
{
	tweet(html_entity_decode($message));
}

function tweet($message)
{
	require_once(__DIR__ . "/../Worker.php");
	$worker = new \rpurinton\r2d2\Worker(0);
	$twitter = $worker->config["twitter"];
	$connection = new \Abraham\TwitterOAuth\TwitterOAuth($twitter["api_key"],$twitter["api_key_secret"],$twitter["access_token"],$twitter["access_token_secret"]);
	$result = $connection->post("statuses/update", ["status" => $message." #Astrology #Zodiac"]);
	while(strpos($message,"#") !== false) $message = str_replace("#","",$message);
	$worker->reply(["platform" => "highviber", "channel" => $worker->config["highviber"]["public_channel"]], $message);
}

function getResults($time)
{
    $swecmd = "/usr/local/bin/swetest -b" . date("d.m.Y", $time) . " -utc" . date("G:i", $time) . " -roundmin -g -head -fpZS-";
    exec($swecmd, $results);
    foreach ($results as $key => $result)
    {
        $results[$key] = array();
        $input = explode("\t", $result);
        $input1 = $input[1];
        while (strpos($input1, "  ") !== false) $input1 = str_replace("  ", " ", $input1);
        if (substr($input1, 0, 1) === " ") $input1 = substr($input1, 1);
        $input1 = explode(" ", $input1);
        if (strlen($input1[0]) === 1) $results[$key]["degs"] = " " . $input1[0];
        else $results[$key]["degs"] = $input1[0];
        $results[$key]["sign"] = $input1[1];
        if (strlen($input1[2]) === 1) $results[$key]["mins"] = "0" . $input1[2];
        else $results[$key]["mins"] = $input1[2];
        $input2 = $input[2];
        while (strpos($input2, " ") !== false) $input2 = str_replace(" ", "", $input2);
        if (substr($input2, 0, 1) === "-") $results[$key]["retro"] = "R";
        else $results[$key]["retro"] = " ";
	$input3 = $input[3];
        while (strpos($input3, " ") !== false) $input3 = str_replace(" ", "", $input3);
	$results[$key]["phase"] = $input3;
    }
    unset($results[11]);
    return $results;
}

function astro_sign_emoji($input)
{
    switch ($input)
    {
        case "ar": return "♈︎ #Aries";
        case "ta": return "♉︎ #Taurus";
        case "ge": return "♊︎ #Gemini";
        case "cn": return "♋︎ #Cancer";
        case "le": return "♌︎ #Leo";
        case "vi": return "♍︎ #Virgo";
        case "li": return "♎︎ #Libra";
        case "sc": return "♏︎ #Scorpio";
        case "sa": return "♐︎ #Sagittarius";
        case "cp": return "♑︎ #Capricorn";
        case "aq": return "♒︎ #Aquarius";
        case "pi": return "♓︎ #Pisces";
    }
}

function astro_planet_emoji($input)
{
    switch ($input)
    {
        case 0: return "☉ #Sun";
        case 1: return "☾ #Moon";
        case 2: return "☿ #Mercury";
        case 3: return "♀ #Venus";
        case 4: return "♂ #Mars";
        case 5: return "♃ #Jupiter";
        case 6: return "♄ #Saturn";
        case 7: return "♅ #Uranus";
        case 8: return "♆ #Neptune";
        case 9: return "♇ #Pluto";
        case 10: return "#TrueNode";
        case 12: return "#Lilith";
    }
}

function moon_phase_name($input, $increasing)
{
	if ($input >= 0 && $input <= 0.05)
	{
		return "#NewMoon";
	}
	if ($input >= 0.95 && $input <= 1)
	{
		return "#FullMoon";
	}
	if ($increasing)
	{
		if ($input >= 0.05 && $input <= 0.35)
		{
			return "Waxing Cresent";
		}
		if ($input >= 0.35 && $input <= 0.65)
		{
			return "First Quarter";
		}
		if ($input >= 0.65 && $input <= 0.95)
		{
			return "Waxing Gibbous";
		}
	}
	else
	{
		if ($input >= 0.65 && $input <= 0.95)
		{
			return "Waning Gibbous";
		}
		if ($input >= 0.35 && $input <= 0.65)
		{
			return "Last Quarter";
		}
		if ($input >= 0.05 && $input <= 0.35)
		{
			return "Waning Crescent";
		}
	}
}

function moon_phase_emoji($input, $increasing)
{
	if ($input >= 0 && $input <= 0.05)
	{
		return "&#127761;";
	}
	if ($input >= 0.95 && $input <= 1)
	{
		return "&#127765;";
	}
	if ($increasing)
	{
		if ($input >= 0.05 && $input <= 0.35)
		{
			return "&#127762;";
		}
		if ($input >= 0.35 && $input <= 0.65)
		{
			return "&#127763;";
		}
		if ($input >= 0.65 && $input <= 0.95)
		{
			return "&#127764;";
		}
	}
	else
	{
		if ($input >= 0.65 && $input <= 0.95)
		{
			return "&#127766;";
		}
		if ($input >= 0.35 && $input <= 0.65)
		{
			return "&#127767;";
		}
		if ($input >= 0.05 && $input <= 0.35)
		{
			return "&#127768;";
		}
	}
}
