<?php

$cmd = "oracle";
$cmdlist[] = $cmd;
$htmlhelp[$cmd]["commands"][] = $cmd;
$htmlhelp[$cmd]["title"] = "Get a 4-card Astrology Oracle Reading";
$htmlhelp[$cmd]["desc"] = "Can be used as a general reading without a spread, or used to ask a question.";
$htmlhelp[$cmd]["usages"][] = "!$cmd [optional details]";
$htmlhelp[$cmd]["usages"][] = "!$cmd";
$htmlhelp[$cmd]["usages"][] = "!$cmd My tomorrow";
$htmlhelp[$cmd]["usages"][] = "!$cmd Bobby today";
$htmlhelp[$cmd]["usages"][] = "!$cmd you can put basically anything here";
$htmlhelp[$cmd]["seealso"][] = "tarot";
$htmlhelp[$cmd]["seealso"][] = "daily";
$htmlhelp[$cmd]["seealso"][] = "astro";
$htmlhelp[$cmd]["seealso"][] = "moon";
$funcs[] = function ($channel, $userid, $username, $cmd, $vars, $text)
{
	if ($cmd == "!oracle")
	{
		start_typing($channel);
		$sql = mysqli_connect("127.0.0.1", "oracle", "oracle", "oracle");
		$first = firstname($username);
		$message = "Oracle cards requested by $first...<br /><br />";

		$message .= "<b>Where in my life does this affect?</b><br />";
		extract(mysqli_fetch_assoc(mysqli_query($sql, "SELECT * FROM `houses` ORDER BY RAND() LIMIT 0,1")));
		$message .= "&#127183;$name - <i>$meaning</i><br /><br />";

		$message .= "<b>How am I approaching the situation?</b><br />";
		extract(mysqli_fetch_assoc(mysqli_query($sql, "SELECT * FROM `signs` ORDER BY RAND() LIMIT 0,1")));
		$message .= "" . oracle_sign_get_emoji($name) . " - <i>$meaning</i><br /><br />";

		$message .= "<b>What part of my personality is involved?</b><br />";
		extract(mysqli_fetch_assoc(mysqli_query($sql, "SELECT * FROM `planets` ORDER BY RAND() LIMIT 0,1")));
		$message .= "" . oracle_planet_get_emoji($name) . " - <i>$meaning</i><br /><br />";

		$message .= "<b>Guidance going foward from here?</b><br />";
		extract(mysqli_fetch_assoc(mysqli_query($sql, "SELECT * FROM `phases` ORDER BY RAND() LIMIT 0,1")));
		$message .= "$name - <i>$meaning</i>";

		return $message;
	}
	return false;
};

function oracle_sign_get_emoji($input)
{
	if ($input == "Aries")
	{
		return "♈︎ The $input Card";
	}
	if ($input == "Taurus")
	{
		return "♉︎ The $input Card";
	}
	if ($input == "Gemini")
	{
		return "♊︎ The $input Card";
	}
	if ($input == "Cancer")
	{
		return "♋︎ The $input Card";
	}
	if ($input == "Leo")
	{
		return "♌︎ The $input Card";
	}
	if ($input == "Virgo")
	{
		return "♍︎ The $input Card";
	}
	if ($input == "Libra")
	{
		return "♎︎ The $input Card";
	}
	if ($input == "Scorpio")
	{
		return "♏︎ The $input Card";
	}
	if ($input == "Sagittarius")
	{
		return "♐︎ The $input Card";
	}
	if ($input == "Capricorn")
	{
		return "♑︎ The $input Card";
	}
	if ($input == "Aquarius")
	{
		return "♒︎ The $input Card";
	}
	if ($input == "Pisces")
	{
		return "♓︎ The $input Card";
	}
}

function oracle_planet_get_emoji($input)
{
	if ($input == "Sun") return "☉ The Sun Card";
	if ($input == "Moon") return "☾ The Moon Card";
	if ($input == "Mercury") return "☿ The Mercury Card";
	if ($input == "Venus") return "♀ The Venus Card";
	if ($input == "Mars") return "♂ The Mars Card";
	if ($input == "Jupiter") return "♃ The Jupiter Card";
	if ($input == "Saturn") return "♄ The Saturn Card";
	if ($input == "Uranus") return "♅ The Uranus Card";
	if ($input == "Neptune") return "♆ The Neptune Card";
	if ($input == "Pluto") return "♇ The Pluto Card";
}
