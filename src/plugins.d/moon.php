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
        $moonPhase = function ($input,$increasing)
        {
		if($input >= 0 && $input <= 0.125) return "<b>&#127761; New Moon</b>";
		if($input >= 0.875 && $input <= 1) return "<b>&#127765; Full Moon</b>";
		if($increasing)
		{
			if($input >= 0.125 && $input <= 0.375) return "<b>&#127762; Waxing Cresent</b>";
			if($input >= 0.375 && $input <= 0.625) return "<b>&#127763; First Quarter</b>";
			if($input >= 0.625 && $input <= 0.875) return "<b>&#127764; Waxing Gibbous</b>";
		}
		else
		{
			if($input >= 0.625 && $input <= 0.875) return "<b>&#127766; Waning Gibbous</b>";
			if($input >= 0.375 && $input <= 0.625) return "<b>&#127767; Last Quarter</b>";
			if($input >= 0.125 && $input <= 0.375) return "<b>&#127768; Waning Crescent</b>";
		}
	};

        $moon_sign_emoji = function ($input)
        {
            switch($input)
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
        };

        $swetest = "swetest -g -head -p1 -fZ- -s1s -n2 -b".date("d.m.Y")." -utc".date("G:i:s");
        exec($swetest,$results);

	$line0 = explode("\t",$results[0]);
	$line1 = explode("\t",$results[1]);

	$line00 = $this->myReplace("  "," ",$line0[0]);
	if(substr($line00,0,1) === " ") $line00 = substr($line00,1);

	$line00 = explode(" ",$line00);
	$line001 = $line00[1];

	$line01 = $this->myReplace(" ","",$line0[1]);
	$line11 = $this->myReplace(" ","",$line1[1]);

	$increasing = $line01 < $line11;

	$message = $moonPhase($line01,$increasing)." <i>in</i> <b>".$moon_sign_emoji($line001)."</b><br />";

	if($increasing) $message .= "<i>Illumination ".round($line01*100,0)."% and increasing</i>";
	else $message .= "<i>Illumination ".round($line01*100,0)."% and decreasing</i>";

	$this->reply($data, $message);
    }
};

