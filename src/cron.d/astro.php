#!/usr/local/bin/php -f
<?php
$time = time();
$message = "";
$results1 = getResults($time-60);
$results2 = getResults($time);

foreach($results2 as $planet => $result2)
{
	if($results1[$planet]["sign"] !== $result2["sign"]) $message .= "<b>Astrology Update!</b><br ><i>".astro_planet_emoji($planet)." is now in ".astro_sign_emoji($result2["sign"])."</i><br />";
	if($results1[$planet]["retro"] !== $result2["retro"])
	{
		$message .= "<b>Astrology Update!</b><br /><i>".astro_planet_emoji($planet)." ( in ".astro_sign_emoji($result2["sign"])." ) is ";
		if($result2["retro"] === "R") $message .= "now Retrograde</i><br />";
		if($result2["retro"] === " ") $message .= "no longer Retrograde</i><br />";
	}
}

if($message != "")
{
	require_once("../Worker.php");
	$worker = new \rpurinton\r2d2\Worker(0);
	$worker->reply(["platform" => "highviber", "channel" => $worker->config["highviber"]["public_channel"]],$message);
}

function getResults($time)
{
	$swecmd = "swetest -b".date("d.m.Y",$time)." -utc".date("G:i:s",$time)." -roundmin -g -head -fpZS";
	exec($swecmd,$results);
	foreach($results as $key => $result)
	{
		$results[$key] = array();
		$input = explode("\t",$result);
		$input1 = $input[1];
		while(strpos($input1,"  ") !== false) $input1 = str_replace("  "," ",$input1);
		if(substr($input1,0,1) === " ") $input1 = substr($input1,1);
		$input1 = explode(" ",$input1);
		if(strlen($input1[0]) === 1) $results[$key]["degs"] = " ".$input1[0];
		else $results[$key]["degs"] = $input1[0];
		$results[$key]["sign"] = $input1[1];
		if(strlen($input1[2]) === 1) $results[$key]["mins"] = "0".$input1[2];
		else $results[$key]["mins"] = $input1[2];
		$input2 = $input[2];
		while(strpos($input2," ") !== false) $input2 = str_replace(" ","",$input2);
		if(substr($input2,0,1) === "-") $results[$key]["retro"] = "R";
		else $results[$key]["retro"] = " ";
	}
	unset($results[11]);
	return $results;
}

function astro_sign_emoji($input)
{
	switch($input)
	{
		case "ar": return "♈︎ Aries";
		case "ta": return "♉︎ Taurus";
		case "ge": return "♊︎ Gemini";
		case "cn": return "♋︎ Cancer";
		case "le": return "♌︎ Leo";
		case "vi": return "♍︎ Virgo";
		case "li": return "♎︎ Libra";
		case "sc": return "♏︎ Scorpio";
		case "sa": return "♐︎ Sagittarius";
		case "cp": return "♑︎ Capricorn";
		case "aq": return "♒︎ Aquarius";
		case "pi": return "♓︎ Pisces";
	}
}

function astro_planet_emoji($input)
{
	switch($input)
	{
		case 0: return "☉ Sun";
		case 1: return "☾ Moon";
		case 2: return "☿ Mercury";
		case 3: return "♀ Venus";
		case 4: return "♂ Mars";
		case 5: return "♃ Jupiter";
		case 6: return "♄ Saturn";
		case 7: return "♅ Uranus";
		case 8: return "♆ Neptune";
		case 9: return "♇ Pluto";
		case 10: return "T Node";
		case 12: return "Lilith";
	}
}

