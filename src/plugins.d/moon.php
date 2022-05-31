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
                case "ar": return "&#9800; Aries";
                case "ta": return "&#9801; Taurus";
                case "ge": return "&#9802; Gemini";
                case "cn": return "&#9803; Cancer";
                case "le": return "&#9804; Leo";
                case "vi": return "&#9805; Virgo";
                case "li": return "&#9806; Libra";
                case "sc": return "&#9807; Scorpio";
                case "sa": return "&#9808; Sagittarius";
                case "cp": return "&#9809; Capricorn";
                case "aq": return "&#9810; Aquarius";
                case "pi": return "&#9811; Pisces";
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

	if($increasing) $message .= "<i>Illumination ".round($line01*100,0)."% and increasing</i><br />";
	else $message .= "<i>Illumination ".round($line01*100,0)."% and decreasing</i><br />";

	$time = time();
	$cmd = "swetest -g -head -p1 -fZ -s60m -n72 -b".date("d.m.Y",$time)." -utc".date("G:i:s",$time);
	$results = array();
	exec($cmd,$results);
	$current_sign = substr($results[0],3,2);
	$next_sign = $current_sign;
	for($i=0;$i<71 && $next_sign == $current_sign;$i++) $next_sign = substr($results[$i+1],3,2);
	$time += ($i-1) * 3600;
	$cmd = "swetest -g -head -p1 -fZ -s1m -n60 -b".date("d.m.Y",$time)." -utc".date("G:i:s",$time);
	$results = array();
	exec($cmd,$results);
	$current_sign = substr($results[0],3,2);
	$next_sign = $current_sign;
	for($i=0;$i<59 && $next_sign == $current_sign;$i++) $next_sign = substr($results[$i+1],3,2);
	$time += ($i-1) * 60;
	$cmd = "swetest -g -head -p1 -fZ -s1s -n60 -b".date("d.m.Y",$time)." -utc".date("G:i:s",$time);
	$results = array();
	exec($cmd,$results);
	$current_sign = substr($results[0],3,2);
	$next_sign = $current_sign;
	for($i=0;$i<59 && $next_sign == $current_sign;$i++) $next_sign = substr($results[$i+1],3,2);
	$time += $i + 1;
	$message .= "<i>&#57908;".$moon_sign_emoji($next_sign)." on ".date("m-d",$time)." at ".date("G:i:s",$time)."</i><br />";
	$cmd = "swetest -g -head -p1 -fZ -s60m -n72 -b".date("d.m.Y",$time)." -utc".date("G:i:s",$time);
	$results = array();
	exec($cmd,$results);
	$current_sign = substr($results[0],3,2);
	$next_sign = $current_sign;
	for($i=0;$i<71 && $next_sign == $current_sign;$i++) $next_sign = substr($results[$i+1],3,2);
	$time += ($i-1) * 3600;
	$cmd = "swetest -g -head -p1 -fZ -s1m -n60 -b".date("d.m.Y",$time)." -utc".date("G:i:s",$time);
	$results = array();
	exec($cmd,$results);
	$current_sign = substr($results[0],3,2);
	$next_sign = $current_sign;
	for($i=0;$i<59 && $next_sign == $current_sign;$i++) $next_sign = substr($results[$i+1],3,2);
	$time += ($i-1) * 60;
	$cmd = "swetest -g -head -p1 -fZ -s1s -n60 -b".date("d.m.Y",$time)." -utc".date("G:i:s",$time);
	$results = array();
	exec($cmd,$results);
	$current_sign = substr($results[0],3,2);
	$next_sign = $current_sign;
	for($i=0;$i<59 && $next_sign == $current_sign;$i++) $next_sign = substr($results[$i+1],3,2);
	$time += $i + 1;
	$message .= "<i>&#57908;".$moon_sign_emoji($next_sign)." on ".date("m-d",$time)." at ".date("G:i:s",$time)."</i><br />";
	$cmd = "swetest -g -head -p1 -fZ -s60m -n72 -b".date("d.m.Y",$time)." -utc".date("G:i:s",$time);
	$results = array();
	exec($cmd,$results);
	$current_sign = substr($results[0],3,2);
	$next_sign = $current_sign;
	for($i=0;$i<71 && $next_sign == $current_sign;$i++) $next_sign = substr($results[$i+1],3,2);
	$time += ($i-1) * 3600;
	$cmd = "swetest -g -head -p1 -fZ -s1m -n60 -b".date("d.m.Y",$time)." -utc".date("G:i:s",$time);
	$results = array();
	exec($cmd,$results);
	$current_sign = substr($results[0],3,2);
	$next_sign = $current_sign;
	for($i=0;$i<59 && $next_sign == $current_sign;$i++) $next_sign = substr($results[$i+1],3,2);
	$time += ($i-1) * 60;
	$cmd = "swetest -g -head -p1 -fZ -s1s -n60 -b".date("d.m.Y",$time)." -utc".date("G:i:s",$time);
	$results = array();
	exec($cmd,$results);
	$current_sign = substr($results[0],3,2);
	$next_sign = $current_sign;
	for($i=0;$i<59 && $next_sign == $current_sign;$i++) $next_sign = substr($results[$i+1],3,2);
	$time += $i + 1;
	$message .= "<i>&#57908;".$moon_sign_emoji($next_sign)." on ".date("m-d",$time)." at ".date("G:i:s",$time)."</i><br />";

	$this->reply($data, $message);
    }
};

