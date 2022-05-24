<?php

$cmd = "oracle";
$cmd_list[] = $cmd;
$html_help[$cmd]["commands"][] = $cmd;
$html_help[$cmd]["title"] = "Get a 4-card Astrology Oracle Reading";
$html_help[$cmd]["desc"] = "Can be used as a general reading without a spread, or used to ask a question.";
$html_help[$cmd]["usages"][] = "!$cmd [optional details]";
$html_help[$cmd]["usages"][] = "!$cmd";
$html_help[$cmd]["usages"][] = "!$cmd My tomorrow";
$html_help[$cmd]["usages"][] = "!$cmd Bobby today";
$html_help[$cmd]["usages"][] = "!$cmd you can put basically anything here";
$html_help[$cmd]["seealso"][] = "tarot";
$html_help[$cmd]["seealso"][] = "daily";
$html_help[$cmd]["seealso"][] = "astro";
$html_help[$cmd]["seealso"][] = "moon";
$funcs[] = function ($data)
{
	extract($data);
	if ($cmd == "!oracle")
	{

		$oracle_sign_get_emoji = function ($input)
		{
			if ($input == "Aries") return "♈︎ The $input Card";
			if ($input == "Taurus") return "♉︎ The $input Card";
			if ($input == "Gemini") return "♊︎ The $input Card";
			if ($input == "Cancer") return "♋︎ The $input Card";
			if ($input == "Leo") return "♌︎ The $input Card";
			if ($input == "Virgo") return "♍︎ The $input Card";
			if ($input == "Libra") return "♎︎ The $input Card";
			if ($input == "Scorpio") return "♏︎ The $input Card";
			if ($input == "Sagittarius") return "♐︎ The $input Card";
			if ($input == "Capricorn") return "♑︎ The $input Card";
			if ($input == "Aquarius") return "♒︎ The $input Card";
			if ($input == "Pisces") return "♓︎ The $input Card";
		};

		$oracle_planet_get_emoji = function ($input)
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
		};

                mysqli_select_db($this->sql,"oracle");
		$first = $this->firstname($username);
		$message = "Oracle cards requested by $first...<br /><br />";

		$message .= "<b>Where in my life does this affect?</b><br />";
		extract(mysqli_fetch_assoc(mysqli_query($this->sql, "SELECT * FROM `houses` ORDER BY RAND() LIMIT 0,1")));
		$message .= "&#127183;$name - <i>$meaning</i><br /><br />";

		$message .= "<b>How am I approaching the situation?</b><br />";
		extract(mysqli_fetch_assoc(mysqli_query($this->sql, "SELECT * FROM `signs` ORDER BY RAND() LIMIT 0,1")));
		$message .= "" . $oracle_sign_get_emoji($name) . " - <i>$meaning</i><br /><br />";

		$message .= "<b>What part of my personality is involved?</b><br />";
		extract(mysqli_fetch_assoc(mysqli_query($this->sql, "SELECT * FROM `planets` ORDER BY RAND() LIMIT 0,1")));
		$message .= "" . $oracle_planet_get_emoji($name) . " - <i>$meaning</i><br /><br />";

		$message .= "<b>Guidance going foward from here?</b><br />";
		extract(mysqli_fetch_assoc(mysqli_query($this->sql, "SELECT * FROM `phases` ORDER BY RAND() LIMIT 0,1")));
		$message .= "$name - <i>$meaning</i>";

		$this->sendReply($data, $message);
	}
};

