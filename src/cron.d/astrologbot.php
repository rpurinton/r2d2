#!/usr/local/bin/php -f
<?php
$time = time();
$message = "";
$hashtags = "";
$results1 = getResults($time - 60);
$results2 = getResults($time);
foreach ($results2 as $planet => $result2)
{
    if ($results1[$planet]["sign"] !== $result2["sign"])
    {
        $message .= astro_planet_emoji($planet)." now in ".astro_sign_emoji($result2["sign"]);
        $message .= "\n".astro_planet_hashtag($planet).astro_sign_hashtag($result2["sign"])."#astrology\n";
    }
    if ($results1[$planet]["retro"] !== $result2["retro"])
    {
        $message .= astro_planet_emoji($planet)." now ";
        if ($result2["retro"] === "R") $message .= "retrograde";
        if ($result2["retro"] === " ") $message .= "direct";
        $message .= "\n".astro_planet_hashtag($planet).astro_sign_hashtag($result2["sign"])."#astrology\n";
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
	$result = $connection->post("statuses/update", ["status" => $message]);
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

function astro_sign_emoji($sign)
{
    switch ($sign)
    {
        case "ar": return "Aries &#9800;";
        case "ta": return "Taurus &#9801;";
        case "ge": return "Gemini &#9802;";
        case "cn": return "Cancer &#9803;";
        case "le": return "Leo &#9804;";
        case "vi": return "Virgo &#9805;";
        case "li": return "Libra &#9806;";
        case "sc": return "Scorpio &#9807;";
        case "sa": return "Sagittarius &#9808;";
        case "cp": return "Capricorn &#9809;";
        case "aq": return "Aquarius &#9810;";
        case "pi": return "Pisces &#9811;";
    }
}

function astro_sign_hashtag($sign)
{
    switch ($sign)
    {
        case "ar": return "#aries ";
        case "ta": return "#taurus ";
        case "ge": return "#gemini ";
        case "cn": return "#cancer ";
        case "le": return "#leo ";
        case "vi": return "#virgo ";
        case "li": return "#libra ";
        case "sc": return "#scorpio ";
        case "sa": return "#sagittarius ";
        case "cp": return "#capricorn ";
        case "aq": return "#aquarius ";
        case "pi": return "#pisces ";
    }
}

function astro_planet_emoji($planet)
{
    switch ($planet)
    {
        case 0: return "&#9728; The Sun";
        case 1: return moon_phase_emoji()." The Moon";
        case 2: return "(☿) Mercury";
        case 3: return "(♀) Venus";
        case 4: return "(♂) Mars";
        case 5: return "(♃) Jupiter";
        case 6: return "(♄) Saturn";
        case 7: return "(♅) Uranus";
        case 8: return "(♆) Neptune";
        case 9: return "(♇) Pluto";
        case 10: return "True Node";
        case 12: return "Lilith";
    }
}

function astro_planet_hashtag($planet)
{
    switch ($planet)
    {
        case 0: return "#sun ";
        case 1: return "#moon ";
        case 2: return "#mercury ";
        case 3: return "#venus ";
        case 4: return "#mars ";
        case 5: return "#jupiter ";
        case 6: return "#saturn ";
        case 7: return "#uranus ";
        case 8: return "#neptune ";
        case 9: return "#pluto ";
        case 10: return "#truenode ";
        case 12: return "#lilith ";
    }
}

function moon_phase_emoji()
{
	global $results1, $results2;
	$input = $results2[1]["phase"];
	$increasing = $results2[1]["phase"] > $results1[1]["phase"];
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
