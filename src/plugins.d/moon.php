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
		if($input >= 0 && $input <= 0.125) return "&#127761; New Moon";
		if($input >= 0.875 && $input <= 1) return "&#127765; Full Moon";
		if($increasing)
		{
			if($input >= 0.125 && $input <= 0.375) return "&#127762; Waxing Cresent";
			if($input >= 0.375 && $input <= 0.625) return "&#127763; First Quarter";
			if($input >= 0.625 && $input <= 0.875) return "&#127764; Waxing Gibbous";
		}
		else
		{
			if($input >= 0.625 && $input <= 0.875) return "&#127766; Waning Gibbous";
			if($input >= 0.375 && $input <= 0.625) return "&#127767; Last Quarter";
			if($input >= 0.125 && $input <= 0.375) return "&#127768; Waning Crescent";
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

	$message = "<b>".round($line01*100,0)."% ".$moonPhase($line01,$increasing)."</b><i> in ".$moon_sign_emoji($line001)."<br />";

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
	$message .= date("m-d",$time)." at ".date("H:i:s",$time)." &#57908;".$moon_sign_emoji($next_sign)."<br />";

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
	$message .= date("m-d",$time)." at ".date("H:i:s",$time)." &#57908;".$moon_sign_emoji($next_sign)."<br />";

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
	$message .= date("m-d",$time)." at ".date("H:i:s",$time)." &#57908;".$moon_sign_emoji($next_sign)."</i><br />";

	$this->reply($data, $message);
    }
};

