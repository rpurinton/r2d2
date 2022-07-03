<?php

$cmd = "tarot";
$cmd_list[] = $cmd;
$html_help[$cmd]["commands"][] = $cmd;
$html_help[$cmd]["title"] = "Draw One Tarot Card";
$html_help[$cmd]["desc"] = "Pulls a single tarot card for you or someone else.  For daily readings and yes or no questions.";
$html_help[$cmd]["usages"][] = "!$cmd [optional details]";
$html_help[$cmd]["usages"][] = "!$cmd";
$html_help[$cmd]["usages"][] = "!$cmd My tomorrow";
$html_help[$cmd]["usages"][] = "!$cmd how is Bobby today";
$html_help[$cmd]["usages"][] = "!$cmd you can put basically anything here";
$html_help[$cmd]["seealso"][] = "daily";
$html_help[$cmd]["seealso"][] = "dream";
$html_help[$cmd]["seealso"][] = "relationship";
$html_help[$cmd]["seealso"][] = "oracle";
$funcs[] = function ($data)
{
    extract($data);
    if ($cmd == "!tarot")
    {
        $first = $this->firstname($username);
        extract(mysqli_fetch_assoc(mysqli_query($this->sql, "SELECT * FROM `cards` ORDER BY RAND() LIMIT 0,1")));
        $reverse = rand(0, 1);
        if ($reverse === 1)
        {
            return $this->reply($data, "Pulling a card for $first...<br />&#127183;<a href=\"$revurl\" target=\"_blank\">$card in Reverse</a><br /><i>$reversed</i>");
        }
        else
        {
            return $this->reply($data, "Pulling a card for $first...<br />&#127183;<a href=\"$upurl\" target=\"_blank\">$card</a><br /><i>$upright</i>");
        }
    }
};

$cmd = "daily";
$cmd_list[] = $cmd;
$html_help[$cmd]["commands"][] = $cmd;
$html_help[$cmd]["title"] = "Get a 3-card Daily General Tarot Reading";
$html_help[$cmd]["desc"] = "A short tarot spread for understanding your daily thoughts, feelings, and actions, or those of others.";
$html_help[$cmd]["usages"][] = "!$cmd [optional details]";
$html_help[$cmd]["usages"][] = "!$cmd";
$html_help[$cmd]["usages"][] = "!$cmd My tomorrow";
$html_help[$cmd]["usages"][] = "!$cmd Bobby today";
$html_help[$cmd]["usages"][] = "!$cmd you can put basically anything here";
$html_help[$cmd]["seealso"][] = "tarot";
$html_help[$cmd]["seealso"][] = "dream";
$html_help[$cmd]["seealso"][] = "relationship";
$html_help[$cmd]["seealso"][] = "oracle";
$funcs[] = function ($data)
{
    extract($data);
    if ($cmd == "!daily")
    {
        for ($i = 1; $i < 79; $i++)
        {
            $deck[$i] = $i;
        }
        $first = $this->firstname($username);
        $message = "Daily Tarot requested by $first...<br /><br />";
        $card = array_rand($deck);
        unset($deck[$card]);
        $message .= "<b>What things are on your mind? What are you thinking about a lot today?</b><br />";
        extract(mysqli_fetch_assoc(mysqli_query($this->sql, "SELECT * FROM `cards` WHERE `id` = '$card'")));
        $reverse = rand(0, 1);
        if ($reverse === 1)
        {
            $message .= "&#127183;<a href=\"$revurl\" target=\"_blank\">$card in Reverse</a><br /><i>$reversed</i><br /><br />";
        }
        else
        {
            $message .= "&#127183;<a href=\"$upurl\" target=\"_blank\">$card</a><br /><i>$upright</i><br /><br />";
        }
        $card = array_rand($deck);
        unset($deck[$card]);
        $message .= "<b>How are your emotions today? What is the dominant feeling for today?</b><br />";
        extract(mysqli_fetch_assoc(mysqli_query($this->sql, "SELECT * FROM `cards` WHERE `id` = '$card'")));
        $reverse = rand(0, 1);
        if ($reverse === 1)
        {
            $message .= "&#127183;<a href=\"$revurl\" target=\"_blank\">$card in Reverse</a><br /><i>$reversed</i><br /><br />";
        }
        else
        {
            $message .= "&#127183;<a href=\"$upurl\" target=\"_blank\">$card</a><br /><i>$upright</i><br /><br />";
        }
        $card = array_rand($deck);
        unset($deck[$card]);
        $message .= "<b>What tasks are you focused on accomplishing today?</b><br />";
        extract(mysqli_fetch_assoc(mysqli_query($this->sql, "SELECT * FROM `cards` WHERE `id` = '$card'")));
        $reverse = rand(0, 1);
        if ($reverse === 1)
        {
            $message .= "&#127183;<a href=\"$revurl\" target=\"_blank\">$card in Reverse</a><br /><i>$reversed</i>";
        }
        else
        {
            $message .= "&#127183;<a href=\"$upurl\" target=\"_blank\">$card</a><br /><i>$upright</i>";
        }
        $this->reply($data, $message);
    }
};

$cmd = "dream";
$cmd_list[] = $cmd;
$html_help[$cmd]["commands"][] = $cmd;
$html_help[$cmd]["title"] = "Get a 3-card Dream Interpretation Tarot Reading";
$html_help[$cmd]["desc"] = "After a powerful dream, this short spread helps you understand the subconscious meanings behind it.";
$html_help[$cmd]["usages"][] = "!$cmd [optional details]";
$html_help[$cmd]["usages"][] = "!$cmd";
$html_help[$cmd]["usages"][] = "!$cmd last night's dream";
$html_help[$cmd]["usages"][] = "!$cmd my dream about the unicorns";
$html_help[$cmd]["usages"][] = "!$cmd you can put basically anything here";
$html_help[$cmd]["seealso"][] = "daily";
$html_help[$cmd]["seealso"][] = "tarot";
$html_help[$cmd]["seealso"][] = "relationship";
$funcs[] = function ($data)
{
    extract($data);
    if ($cmd == "!dream")
    {
        for ($i = 1; $i < 79; $i++)
        {
            $deck[$i] = $i;
        }
        $first = $this->firstname($username);
        $message = "Dream Tarot requested by $first...<br /><br />";

        $card = array_rand($deck);
        unset($deck[$card]);
        $message .= "<b>What feelings did this dream stem from? What was the underlying emotion behind it?</b><br />";
        extract(mysqli_fetch_assoc(mysqli_query($this->sql, "SELECT * FROM `cards` WHERE `id` = '$card'")));
        $reverse = rand(0, 1);
        if ($reverse === 1)
        {
            $message .= "&#127183;<a href=\"$revurl\" target=\"_blank\">$card in Reverse</a><br /><i>$reversed</i><br /><br />";
        }
        else
        {
            $message .= "&#127183;<a href=\"$upurl\" target=\"_blank\">$card</a><br /><i>$upright</i><br /><br />";
        }

        $card = array_rand($deck);
        unset($deck[$card]);
        $message .= "<b>What is the dream trying to tell me?</b><br />";
        extract(mysqli_fetch_assoc(mysqli_query($this->sql, "SELECT * FROM `cards` WHERE `id` = '$card'")));
        $reverse = rand(0, 1);
        if ($reverse === 1)
        {
            $message .= "&#127183;<a href=\"$revurl\" target=\"_blank\">$card in Reverse</a><br /><i>$reversed</i><br /><br />";
        }
        else
        {
            $message .= "&#127183;<a href=\"$upurl\" target=\"_blank\">$card</a><br /><i>$upright</i><br /><br />";
        }

        $card = array_rand($deck);
        unset($deck[$card]);
        $message .= "<b>How can I apply this dream's lessons to my waking life?</b><br />";
        extract(mysqli_fetch_assoc(mysqli_query($this->sql, "SELECT * FROM `cards` WHERE `id` = '$card'")));
        $reverse = rand(0, 1);
        if ($reverse === 1)
        {
            $message .= "&#127183;<a href=\"$revurl\" target=\"_blank\">$card in Reverse</a><br /><i>$reversed</i><br /><br />";
        }
        else
        {
            $message .= "&#127183;<a href=\"$upurl\" target=\"_blank\">$card</a><br /><i>$upright</i><br /><br />";
        }

        $this->reply($data, $message);
    }
};

$cmd = "relationship";
$cmd_list[] = $cmd;
$html_help[$cmd]["commands"][] = $cmd;
$html_help[$cmd]["title"] = "Get a 3-card Relationship Tarot Reading";
$html_help[$cmd]["desc"] = "A short reading of your relationship dynamics, or those of others.";
$html_help[$cmd]["usages"][] = "!$cmd [optional details]";
$html_help[$cmd]["usages"][] = "!$cmd";
$html_help[$cmd]["usages"][] = "!$cmd Me and Bobby";
$html_help[$cmd]["usages"][] = "!$cmd John and Mary";
$html_help[$cmd]["usages"][] = "!$cmd you can put basically anything here";
$html_help[$cmd]["seealso"][] = "tarot";
$html_help[$cmd]["seealso"][] = "daily";
$html_help[$cmd]["seealso"][] = "dream";
$html_help[$cmd]["seealso"][] = "oracle";
$funcs[] = function ($data)
{
    extract($data);
    if ($cmd == "!relationship")
    {
        for ($i = 1; $i < 79; $i++)
        {
            $deck[$i] = $i;
        }
        $first = $this->firstname($username);
        $message = "Relationship Tarot requested by $first...<br /><br />";

        $card = array_rand($deck);
        unset($deck[$card]);
        $message .= "<b>What is your role in this relationship? How do you perceive yourself, and how does that affect your partnership?</b><br />";
        extract(mysqli_fetch_assoc(mysqli_query($this->sql, "SELECT * FROM `cards` WHERE `id` = '$card'")));
        $reverse = rand(0, 1);
        if ($reverse === 1)
        {
            $message .= "&#127183;<a href=\"$revurl\" target=\"_blank\">$card in Reverse</a><br /><i>$reversed</i><br /><br />";
        }
        else
        {
            $message .= "&#127183;<a href=\"$upurl\" target=\"_blank\">$card</a><br /><i>$upright</i><br /><br />";
        }

        $card = array_rand($deck);
        unset($deck[$card]);
        $message .= "<b>How would you describe the relationship? What are the characteristics of it?</b><br />";
        extract(mysqli_fetch_assoc(mysqli_query($this->sql, "SELECT * FROM `cards` WHERE `id` = '$card'")));
        $reverse = rand(0, 1);
        if ($reverse === 1)
        {
            $message .= "&#127183;<a href=\"$revurl\" target=\"_blank\">$card in Reverse</a><br /><i>$reversed</i><br /><br />";
        }
        else
        {
            $message .= "&#127183;<a href=\"$upurl\" target=\"_blank\">$card</a><br /><i>$upright</i><br /><br />";
        }

        $card = array_rand($deck);
        unset($deck[$card]);
        $message .= "<b>What is their role in the relationship? How do you perceive your partner? And how does that affect the partnership?</b><br />";
        extract(mysqli_fetch_assoc(mysqli_query($this->sql, "SELECT * FROM `cards` WHERE `id` = '$card'")));
        $reverse = rand(0, 1);
        if ($reverse === 1)
        {
            $message .= "&#127183;<a href=\"$revurl\" target=\"_blank\">$card in Reverse</a><br /><i>$reversed</i><br /><br />";
        }
        else
        {
            $message .= "&#127183;<a href=\"$upurl\" target=\"_blank\">$card</a><br /><i>$upright</i><br /><br />";
        }

        $this->reply($data, $message);
    }
};
