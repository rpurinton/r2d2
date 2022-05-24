<?php

$cmd = "rock";
$cmd_list[] = $cmd;
$html_help[$cmd]["commands"][] = $cmd;
$html_help[$cmd]["title"] = "Show Rock (Rock, Paper, Scissors Game)";
$html_help[$cmd]["desc"] = "Choose rock in a game of rock, paper, scissors.";
$html_help[$cmd]["usages"][] = "!$cmd";
$html_help[$cmd]["seealso"][] = "paper";
$html_help[$cmd]["seealso"][] = "scissors";
$funcs[] = function ($data)
{
    extract($data);
    if ($cmd === "!rock")
    {
        $rock = "&#129704;";
        $paper = "&#129531;";
        $scissors = "&#9986;";

        $first = $this->firstname($username);
        mysqli_select_db($this->sql, "chatbot");
        $rand = rand(0, 2);
        if ($rand === 0)
        {
            mysqli_query($this->sql, "UPDATE `users` SET `tie` = `tie`+1 WHERE `userid` = '$userid'");
            if ($result = mysqli_fetch_assoc(mysqli_query($this->sql, "SELECT `win`,`loss`,`tie` FROM `users` WHERE `userid` = '$userid'")))
            {
                extract($result);
                return $this->sendReply($data, "@$first: $rock, Me: $rock, it's a tie...<br />your personal record: W: $win L: $loss T: $tie");
            }
            else return $this->sendReply($data, "@$first: $rock, Me: $rock, it's a tie");
        }
        if ($rand === 1)
        {
            mysqli_query($this->sql, "UPDATE `users` SET `loss` = `loss`+1 WHERE `userid` = '$userid'");
            if ($result = mysqli_fetch_assoc(mysqli_query($this->sql, "SELECT `win`,`loss`,`tie` FROM `users` WHERE `userid` = '$userid'")))
            {
                extract($result);
                return $this->sendReply($data, "@$first: $rock, Me: $paper, I win...<br />your personal record: W: $win L: $loss T: $tie");
            }
            else return $this->sendReply($data, "@$first: $rock, Me: $paper, I win");
        }
        mysqli_query($this->sql, "UPDATE `users` SET `win` = `win`+1 WHERE `userid` = '$userid'");
        if ($result = mysqli_fetch_assoc(mysqli_query($this->sql, "SELECT `win`,`loss`,`tie` FROM `users` WHERE `userid` = '$userid'")))
        {
            extract($result);
            return $this->sendReply($data, "@$first: $rock, Me: $scissors, You win...<br />your personal record: W: $win L: $loss T: $tie");
        }
        else return $this->sendReply($data, "@$first: $rock, Me: $scissors, You win...");
    }
};

$cmd = "paper";
$cmd_list[] = $cmd;
$html_help[$cmd]["commands"][] = $cmd;
$html_help[$cmd]["title"] = "Show Paper (Rock, Paper, Scissors Game)";
$html_help[$cmd]["desc"] = "Choose paper in a game of rock, paper, scissors.";
$html_help[$cmd]["usages"][] = "!$cmd";
$html_help[$cmd]["seealso"][] = "rock";
$html_help[$cmd]["seealso"][] = "scissors";
$funcs[] = function ($data)
{
    extract($data);
    if ($cmd === "!paper")
    {
        $rock = "&#129704;";
        $paper = "&#129531;";
        $scissors = "&#9986;";
        $first = $this->firstname($username);
        mysqli_select_db($this->sql, "chatbot");
        $rand = rand(0, 2);
        if ($rand === 0)
        {
            mysqli_query($this->sql, "UPDATE `users` SET `tie` = `tie`+1 WHERE `userid` = '$userid'");
            if ($result = mysqli_fetch_assoc(mysqli_query($this->sql, "SELECT `win`,`loss`,`tie` FROM `users` WHERE `userid` = '$userid'")))
            {
                extract($result);
                return $this->sendReply($data, "@$first: $paper, Me: $paper, it's a tie...<br />your personal record: W: $win L: $loss T: $tie");
            }
            else return $this->sendReply($data, "@$first: $paper, Me: $paper, it's a tie");
        }
        if ($rand === 1)
        {
            mysqli_query($this->sql, "UPDATE `users` SET `loss` = `loss`+1 WHERE `userid` = '$userid'");
            if ($result = mysqli_fetch_assoc(mysqli_query($this->sql, "SELECT `win`,`loss`,`tie` FROM `users` WHERE `userid` = '$userid'")))
            {
                extract($result);
                return $this->sendReply($data, "@$first: $paper, Me: $scissors, I win...<br />your personal record: W: $win L: $loss T: $tie");
            }
            else return $this->sendReply($data, "@$first: $paper, Me: $scissors, I win");
        }
        mysqli_query($this->sql, "UPDATE `users` SET `win` = `win`+1 WHERE `userid` = '$userid'");
        if ($result = mysqli_fetch_assoc(mysqli_query($this->sql, "SELECT `win`,`loss`,`tie` FROM `users` WHERE `userid` = '$userid'")))
        {
            extract($result);
            return $this->sendReply($data, "@$first: $paper, Me: $rock, You win...<br />your personal record: W: $win L: $loss T: $tie");
        }
        else return $this->sendReply($data, "@$first: $paper, Me: $rock, You win...");
    }
};

$cmd = "scissors";
$cmd_list[] = $cmd;
$html_help[$cmd]["commands"][] = $cmd;
$html_help[$cmd]["title"] = "Show Scissors (Rock, Paper, Scissors Game)";
$html_help[$cmd]["desc"] = "Choose scissors in a game of rock, paper, scissors.";
$html_help[$cmd]["usages"][] = "!$cmd";
$html_help[$cmd]["seealso"][] = "rock";
$html_help[$cmd]["seealso"][] = "paper";
$funcs[] = function ($data)
{
    extract($data);
    if ($cmd === "!scissors")
    {
        $rock = "&#129704;";
        $paper = "&#129531;";
        $scissors = "&#9986;";

        $first = $this->firstname($username);
        mysqli_select_db($this->sql, "chatbot");
        $rand = rand(0, 2);
        if ($rand === 0)
        {
            mysqli_query($this->sql, "UPDATE `users` SET `tie` = `tie`+1 WHERE `userid` = '$userid'");
            if ($result = mysqli_fetch_assoc(mysqli_query($this->sql, "SELECT `win`,`loss`,`tie` FROM `users` WHERE `userid` = '$userid'")))
            {
                extract($result);
                return $this->sendReply($data, "@$first: $scissors, Me: $scissors, it's a tie...<br />your personal record: W: $win L: $loss T: $tie");
            }
            else return $this->sendReply($data, "@$first: $scissors, Me: $scissors, it's a tie");
        }
        if ($rand === 1)
        {
            mysqli_query($this->sql, "UPDATE `users` SET `loss` = `loss`+1 WHERE `userid` = '$userid'");
            if ($result = mysqli_fetch_assoc(mysqli_query($this->sql, "SELECT `win`,`loss`,`tie` FROM `users` WHERE `userid` = '$userid'")))
            {
                extract($result);
                return $this->sendReply($data, "@$first: $scissors, Me: $rock, I win...<br />your personal record: W: $win L: $loss T: $tie");
            }
            else return $this->sendReply($data, "@$first: $scissors, Me: $rock, I win");
        }
        mysqli_query($this->sql, "UPDATE `users` SET `win` = `win`+1 WHERE `userid` = '$userid'");
        if ($result = mysqli_fetch_assoc(mysqli_query($this->sql, "SELECT `win`,`loss`,`tie` FROM `users` WHERE `userid` = '$userid'")))
        {
            extract($result);
            return $this->sendReply($data, "@$first: $scissors, Me: $paper, You win...<br />your personal record: W: $win L: $loss T: $tie");
        }
        else return $this->sendReply($data, "@$first: $scissors, Me: $paper, You win");
    }
};
