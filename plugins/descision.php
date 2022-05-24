<?php

$cmd = "8";
$cmd_list[] = $cmd;
$html_help[$cmd]["commands"][] = $cmd;
$html_help[$cmd]["commands"][] = "8ball";
$html_help[$cmd]["commands"][] = "9ball";
$html_help[$cmd]["commands"][] = "yesno";
$html_help[$cmd]["title"] = "Ask the Magic 8-Ball";
$html_help[$cmd]["desc"] = "Simulates the popular Magic 8-ball Toy by providing an answer to any yes/no style question.";
$html_help[$cmd]["usages"][] = "!$cmd [optional question]";
$html_help[$cmd]["usages"][] = "!$cmd";
$html_help[$cmd]["usages"][] = "!$cmd Will today be a good day?";
$html_help[$cmd]["usages"][] = "!$cmd you can put basically anything here";
$html_help[$cmd]["seealso"][] = "flip";
$html_help[$cmd]["seealso"][] = "ask";

$funcs[] = function ($data)
{
    extract($data);
    if ($cmd == "!8" || $cmd == "!8ball" || $cmd == "!9ball" || $cmd === "!yesno")
    {
        $results[] = " it is certain &#128077;";
        $results[] = " it is decidedly so &#128077;";
        $results[] = " without a doubt &#128077;";
        $results[] = " yes definitely &#128077;";
        $results[] = " you may rely on it &#128077;";
        $results[] = " as i see it, yes &#128077;";
        $results[] = " most likely &#128077;";
        $results[] = " outlook good &#128077;";
        $results[] = " yes &#128077;";
        $results[] = " signs point to yes &#128077;";
        $results[] = " reply hazy, try again";
        $results[] = " ask again later";
        $results[] = " better not tell you now";
        $results[] = " cannot predict now";
        $results[] = " concentrate and ask again";
        $results[] = " don't count on it &#128078;";
        $results[] = " my reply is no &#128078;";
        $results[] = " my sources say no &#128078;";
        $results[] = " outlook not so good &#128078;";
        $results[] = " very doubtful &#128078;";
        $first = $this->firstname($username);
        $this->sendReply($data, "@$first &#127921; " . $results[array_rand($results)]);
    }
};

$cmd = "ask";
$cmd_list[] = $cmd;
$html_help[$cmd]["commands"][] = $cmd;
$html_help[$cmd]["commands"][] = "or";
$html_help[$cmd]["title"] = "Ask a Multiple Choice Question";
$html_help[$cmd]["desc"] = "Gives an answer from a list of possible options. You must provide a minimum of 2 options however you can specify as many options as you want.";
$html_help[$cmd]["usages"][] = "!$cmd &lt;option1&gt; or &lt;option2&gt; [or option3]...";
$html_help[$cmd]["usages"][] = "!$cmd apples or oranges";
$html_help[$cmd]["usages"][] = "!$cmd go to sleep or read a book or meditate";
$html_help[$cmd]["seealso"][] = "flip";
$html_help[$cmd]["seealso"][] = "8";
$funcs[] = function ($data)
{
    extract($data);
    if ($cmd == "!ask" || $cmd === "!ask")
    {
        $first = $this->firstname($username);
        $vars = $this->myReplace("?", "", $vars);
        $vars = $this->myReplace(" OR ", " or ", $vars);
        $vars = $this->myReplace(" oR ", " or ", $vars);
        $vars = $this->myReplace(" Or ", " or ", $vars);
        $inarr = explode(" or ", $vars);
        if (sizeof($inarr) === 1)
        {
            return $this->sendReply($data, "@$first: $vars or what?");
        }
        $this->sendReply($data, "@$first: " . $inarr[array_rand($inarr)]);
    }
};

$cmd = "flip";
$cmd_list[] = $cmd;
$html_help[$cmd]["commands"][] = $cmd;
$html_help[$cmd]["title"] = "Flip a Coin";
$html_help[$cmd]["desc"] = "Gives you the result; heads or tails.";
$html_help[$cmd]["usages"][] = "!$cmd";
$html_help[$cmd]["seealso"][] = "8";
$html_help[$cmd]["seealso"][] = "ask";
$funcs[] = function ($data)
{
    extract($data);
    if ($cmd == "!flip")
    {
        $first = $this->firstname($username);
        mysqli_select_db($this->sql, "chatbot");
        $rand = rand(0, 1);
        if ($rand === 1)
        {
            mysqli_query($this->sql, "UPDATE `users` SET `heads` = `heads`+1 WHERE `userid` = '$userid'");
            if ($result = mysqli_fetch_assoc(mysqli_query($this->sql, "SELECT `heads`,`tails` FROM `users` WHERE `userid` = '$userid'")))
            {
                extract($result);
                return $this->sendReply($data, "@$first: it's heads... heads: $heads tails: $tails");
            }
            else return $this->sendReply($data, "@$first: it's heads");
        }
        mysqli_query($this->sql, "UPDATE `users` SET `tails` = `tails`+1 WHERE `userid` = '$userid'");
        if ($result = mysqli_fetch_assoc(mysqli_query($this->sql, "SELECT `heads`,`tails` FROM `users` WHERE `userid` = '$userid'")))
        {
            extract($result);
            return $this->sendReply($data, "@$first: it's tails... heads: $heads tails: $tails");
        }
        else return $this->sendReply($data, "@$first: it's tails");
    }
};
