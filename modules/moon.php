<?php

$cmd = "moon";
$cmdlist[] = $cmd;
$htmlhelp[$cmd]["commands"][] = $cmd;
$htmlhelp[$cmd]["title"] = "Get Current Moon Phase and Info";
$htmlhelp[$cmd]["desc"] = "Gives you a report of the current moon phase, illumination, zodiac signs, as well as upcoming main moon phase events.";
$htmlhelp[$cmd]["usages"][] = "!$cmd";
$htmlhelp[$cmd]["seealso"][] = "astro";
$htmlhelp[$cmd]["seealso"][] = "oracle";
$funcs[] = function ($channel, $userid, $username, $cmd, $vars, $text)
{
	if ($cmd === "!moon")
	{
		start_typing($channel);
		$results = file_get_contents("https://lunaf.com/lunar-calendar/");
		$results = substr($results, strpos($results, "<body"));
		$results = substr($results, 0, strpos($results, "</body"));

		$result1 = substr($results, strpos($results, "</h3><p"));
		$result1 = substr($result1, 0, strpos($result1, "</p>"));
		$result1 = strip_tags($result1, "<b>");
		$message = "$result1<br />";

		$result2 = substr($results, strpos($results, "Next Full Moon"));
		$result2 = substr($result2, 0, strpos($result2, "</p>"));
		$result2 = strip_tags($result2, "<b>");
		$message .= "$result2<br />";

		$result3 = substr($results, strpos($results, "Upcoming main"));
		$result3 = substr($result3, 0, strpos($result3, "</ul>") + 5);
		$result3 = my_replace("<li>", "<br />", $result3);
		$result3 = my_replace("after", "<br />in", $result3);
		$result3 = strip_tags($result3, "<b>,<br>");
		$message .= "$result3";

		$message = my_replace("<b>New Moon</b>", "<b>&#127761; New Moon</b>", $message);
		$message = my_replace("<b>Waxing Cresent</b>", "<b>&#127762; Waxing Cresent</b>", $message);
		$message = my_replace("<b>First Quarter</b>", "<b>&#127763; First Quarter</b>", $message);
		$message = my_replace("<b>Waxing Gibbous</b>", "<b>&#127764; Waxing Gibbous</b>", $message);
		$message = my_replace("<b>Full Moon</b>", "<b>&#127765; Full Moon</b>", $message);
		$message = my_replace("<b>Waning Gibbous</b>", "<b>&#127766; Waning Gibbous</b>", $message);
		$message = my_replace("<b>Last Quarter</b>", "<b>&#127767; Last Quarter</b>", $message);
		$message = my_replace("<b>Waning Crescent</b>", "<b>&#127768; Waning Crescent</b>", $message);

		return $message;
	}
	return false;
};
