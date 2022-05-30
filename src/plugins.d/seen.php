<?php

$cmd = "seen";
$cmd_list[] = $cmd;
$html_help[$cmd]["commands"][] = $cmd;
$html_help[$cmd]["title"] = "Get the Last Time a User Was Seen";
$html_help[$cmd]["desc"] = "Gives you the last time a user was seen chatting, and what they said last.";
$html_help[$cmd]["usages"][] = "!$cmd &lt;user name required&gt;";
$html_help[$cmd]["usages"][] = "!$cmd Mary";
$html_help[$cmd]["usages"][] = "!$cmd John Smith";
$html_help[$cmd]["seealso"][] = "top";
$html_help[$cmd]["seealso"][] = "level";
$funcs[] = function ($data)
{
    extract($data);
    if ($cmd == "!seen")
    {
        if ($vars == "")
        {
            return $this->reply($data, "you must use !seen &lt;name&gt;");
        }
        mysqli_select_db($this->sql, "chatbot");
        $targetnew = mysqli_real_escape_string($this->sql, $vars);
        $query = "SELECT * FROM `users` WHERE `username` LIKE '%$targetnew%' ORDER BY `message_count` DESC LIMIT 0,1;";
        $result = mysqli_query($this->sql, $query);
        if (mysqli_num_rows($result))
        {
            $time_human = function ($seconds)
            {
                if ($seconds < 60)
                {
                    if ($seconds === 1) return "1 second";
                    return "$seconds seconds";
                }
                $minutes = floor($seconds / 60);
                if ($minutes < 60)
                {
                    if ($minutes === 1) return "1 minute";
                    return "$minutes minutes";
                }
                $hours = floor($minutes / 60);
                $minutes2 = $minutes % 60;
                if ($hours < 24)
                {
                    if ($hours == 1) $hourtext = "hour";
                    else $hourtext = "hours";
                    if ($minutes2 == 1) $minutetext = "minute";
                    else $minutetext = "minutes";
                    return "$hours $hourtext and $minutes2 $minutetext";
                }
                $days = floor($hours / 24);
                $hours2 = $hours % 24;
                if ($days == 1) $daytext = "day";
                else $daytext = "days";
                if ($hours2 == 1) $hourtext = "hour";
                else $hourtext = "hours";
                return "$days $daytext and $hours2 $hourtext";
            };

            extract(mysqli_fetch_assoc($result));
            $lasttime = strtotime($last_time);
            $timediff = time() - $lasttime;
            $timehuman = $time_human($timediff);
            return $this->reply($data, "$username was last seen $timehuman ago when they said:<br /><i>\"$last_text\"</i>");
        }
        return $this->reply($data, "no users like \"$vars\" have been seen");
    }
};

