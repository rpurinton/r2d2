<?php

$cmd = "moon";
$cmd_list[] = $cmd;
$html_help[$cmd]["commands"][] = $cmd;
$html_help[$cmd]["title"] = "Get Current Moon Phase and Info";
$html_help[$cmd]["desc"] = "Gives you a report of the current moon phase, illumination, zodiac signs, as well as upcoming main moon phase events.";
$html_help[$cmd]["usages"][] = "!$cmd";
$html_help[$cmd]["seealso"][] = "astro";
$html_help[$cmd]["seealso"][] = "oracle";
$funcs[] = function ($data)
{
	extract($data);
	if ($cmd === "!moon")
	{
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
		$result3 = $this->myReplace("<li>", "<br />", $result3);
		$result3 = $this->myReplace("after", "<br />in", $result3);
		$result3 = strip_tags($result3, "<b>,<br>");
		$message .= "$result3";

		$message = $this->myReplace("<b>New Moon</b>", "<b>&#127761; New Moon</b>", $message);
		$message = $this->myReplace("<b>Waxing Cresent</b>", "<b>&#127762; Waxing Cresent</b>", $message);
		$message = $this->myReplace("<b>First Quarter</b>", "<b>&#127763; First Quarter</b>", $message);
		$message = $this->myReplace("<b>Waxing Gibbous</b>", "<b>&#127764; Waxing Gibbous</b>", $message);
		$message = $this->myReplace("<b>Full Moon</b>", "<b>&#127765; Full Moon</b>", $message);
		$message = $this->myReplace("<b>Waning Gibbous</b>", "<b>&#127766; Waning Gibbous</b>", $message);
		$message = $this->myReplace("<b>Last Quarter</b>", "<b>&#127767; Last Quarter</b>", $message);
		$message = $this->myReplace("<b>Waning Crescent</b>", "<b>&#127768; Waning Crescent</b>", $message);

		$this->sendReply($data, $message);
	}
};
