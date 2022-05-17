<?php

$cmd = "astro";
$cmdlist[] = $cmd;
$htmlhelp[$cmd]["commands"][] = $cmd;
$htmlhelp[$cmd]["title"] = "Get Current Astrology Transits and Aspects";
$htmlhelp[$cmd]["desc"] = "Gives you a report of the current zodiac locations for each planet, their aspects, and a summary of the masculine and feminine, elemental, and positive and negative influences.";
$htmlhelp[$cmd]["usages"][] = "!$cmd";
$htmlhelp[$cmd]["seealso"][] = "moon";
$htmlhelp[$cmd]["seealso"][] = "oracle";
$astro_masculine = 0;
$astro_feminine = 0;
$astro_earth = 0;
$astro_air = 0;
$astro_water = 0;
$astro_fire = 0;
$astro_fixed = 0;
$astro_mutable = 0;
$astro_cardinal = 0;
$funcs[] = function ($channel, $userid, $username, $cmd, $vars, $text)
{
	if ($cmd === "!astro")
	{
		start_typing($channel);
		$request = "/natal.php";
		$host = "https://astro.cafeastrology.com";

		$outHeaders = unserialize(file_get_contents("/var/www/highviber/outHeaders.txt"));
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
		$planets = my_replace("</td>", ",", $planets);
		$planets = my_replace("&nbsp;", "", $planets);
		$planets = strip_tags($planets);
		$planets = "," . substr($planets, strpos($planets, "Sun"));
		$planets = explode("\n", $planets);
		unset($planets[sizeof($planets) - 1]);

		foreach ($planets as $planet)
		{
			$planet = explode(",", $planet);
			$data[$planet[1]]["sign"] = $planet[3];
			$data[$planet[1]]["deg"] = $planet[4] . $planet[5];
		}

		global $astro_masculine, $astro_feminine, $astro_earth, $astro_water, $astro_air, $astro_fire, $astro_fixed, $astro_mutable, $astro_cardinal;
		$astro_masculine = 0;
		$astro_feminine = 0;
		$astro_earth = 0;
		$astro_air = 0;
		$astro_water = 0;
		$astro_fire = 0;
		$astro_fixed = 0;
		$astro_mutable = 0;
		$astro_cardinal = 0;

		$message = "--Current Astrology Transit--<br />--" . gmdate("c") . "--<br />";
		foreach ($data as $planet => $value)
		{
			while (strlen($planet) < 7) $planet .= " ";
			while (strlen($value['sign']) < 9) $value['sign'] .= " ";
			if (strlen($value['deg']) == 6) $value['deg'] = " " . $value['deg'];
			if (strlen($value['deg']) == 7 && substr($value['deg'], 6) == "R") $value['deg'] = " " . $value['deg'];
			$message .= "" . astro_get_emoji($planet) . " " . astro_get_emoji($value['sign']) . " " . $value['deg'] . "<br />";
		}

		$message .= "----------------------------<br />";
		$message .= "♂ Masculine $astro_masculine ♀ Feminine  $astro_feminine<br />";
		$message .= "  Fire      $astro_fire   Earth     $astro_earth<br />";
		$message .= "  Air       $astro_air   Water     $astro_water<br />";
		$message .= "  Fixed     $astro_fixed   Mutable   $astro_mutable<br />";
		$message .= "         Cardinal $astro_cardinal<br />";
		$message .= "----------------------------<br />";

		$aspects = substr($results, strpos($results, "class=\"datatable2\""));
		$aspects = substr($aspects, strpos($aspects, "<table"));
		$aspects = substr($aspects, 0, strpos($aspects, "</table>"));
		$aspects = my_replace("</td>", ",", $aspects);
		$aspects = my_replace("</tr>", "\n", $aspects);
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
			if (valid($p1) && valid($p2))
			{
				while (strlen($p1) < 7) $p1 .= " ";
				while (strlen($p2) < 7) $p2 .= " ";
				$p1 = astro_get_emoji($p1);
				$p2 = astro_get_emoji($p2);
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
		return "<pre>$message</pre>";
	}
	return false;
};
function astro_get_emoji($input)
{
	global $astro_masculine,$astro_feminine,$astro_earth,$astro_water,$astro_air,$astro_fire,$astro_fixed,$astro_mutable,$astro_cardinal;
	if($input == "Aries    ")
	{
		$astro_masculine++;
		$astro_fire++;
		$astro_cardinal++;
		return "♈︎ $input";
	}
	if($input == "Taurus   ")
	{
		$astro_feminine++;
		$astro_earth++;
		$astro_fixed++;
		return "♉︎ $input";
	}
	if($input == "Gemini   ")
	{
		$astro_masculine++;
		$astro_air++;
		$astro_mutable++;
		return "♊︎ $input";
	}
	if($input == "Cancer   ")
	{
		$astro_feminine++;
		$astro_water++;
		$astro_cardinal++;
		return "♋︎ $input";
	}
	if($input == "Leo      ")
	{
		$astro_masculine++;
		$astro_fire++;
		$astro_fixed++;
		return "♌︎ $input";
	}
	if($input == "Virgo    ")
	{
		$astro_feminine++;
		$astro_earth++;
		$astro_mutable++;
		return "♍︎ $input";
	}
	if($input == "Libra    ")
	{
		$astro_masculine++;
		$astro_air++;
		$astro_cardinal++;
		return "♎︎ $input";
	}
	if($input == "Scorpio  ")
	{
		$astro_feminine++;
		$astro_water++;
		$astro_fixed++;
		return "♏︎ $input";
	}
	if($input == "Sagittarius")
	{
		$astro_masculine++;
		$astro_fire++;
		$astro_mutable++;
		$input = "Sagittari";
		return "♐︎ $input";
	}
	if($input == "Capricorn")
	{
		$astro_feminine++;
		$astro_earth++;
		$astro_cardinal++;
		return "♑︎ $input";
	}
	if($input == "Aquarius ")
	{
		$astro_masculine++;
		$astro_air++;
		$astro_fixed++;
		return "♒︎ $input";
	}
	if($input == "Pisces   ")
	{
		$astro_feminine++;
		$astro_water++;
		$astro_mutable++;
		return "♓︎ $input";
	}

	if($input == "Sun    ") return "☉ Sun    ";
	if($input == "Moon   ") return "☾ Moon   ";
	if($input == "Mercury") return "☿ Mercury";
	if($input == "Venus  ") return "♀ Venus  ";
	if($input == "Mars   ") return "♂ Mars   ";
	if($input == "Jupiter") return "♃ Jupiter";
	if($input == "Saturn ") return "♄ Saturn ";
	if($input == "Uranus ") return "♅ Uranus ";
	if($input == "Neptune") return "♆ Neptune";
	if($input == "Pluto  ") return "♇ Pluto  ";
	if($input == "NNode  ") return "  N Node ";
	return "  ".$input;
}

function valid($input)
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
}
