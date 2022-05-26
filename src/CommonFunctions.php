<?php

namespace R2D2;

require_once(__DIR__."/RabbitClient.php");

class CommonFunctions Extends RabbitClient
{

    protected
            $config;

    function __construct()
    {
	parent::__construct();
        $this->config["discord"] = json_decode(file_get_contents(__DIR__ . "/../" . $this->config["discord"]["config"]), true);
        $this->config["highviber"] = json_decode(file_get_contents(__DIR__ . "/../" . $this->config["highviber"]["config"]), true);
        $this->config["youtube"] = json_decode(file_get_contents(__DIR__ . "/../" . $this->config["youtube"]["config"]), true);
    }

    protected
            function discordQueue($channel, $message)
    {
        $this->publish("discord_send", ["channel" => $channel, "message" => $message]);
    }

    protected
            function myLog($message)
    {
        $this->discordQueue($this->config["discord"]["log_channel"], $message);
    }

    protected
            function discordSend($channel, $message)
    {
        $curl = curl_init($this->config["discord"][$channel]);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-type: application/json"));
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode(["content" => $this->discordClean($message)], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($curl);
        curl_close($curl);
        if ($result === "")
        {
            return array();
        }
        return json_decode($result, true);
    }

    protected
            function discordClean($message)
    {
        $start = strpos($message, "src=\"");
        if ($start !== false)
        {
            $message = substr($message, $start + 5);
            $message = substr($message, 0, strpos($message, "?"));
            return $message;
        }
        $message = $this->myReplace("<br />", "\n", $message);
        $message = $this->myReplace("<br>", "\n", $message);
        $message = $this->myReplace("<i>", "*", $message);
        $message = $this->myReplace("</i>", "*", $message);
        $message = $this->myReplace("<b>", "**", $message);
        $message = $this->myReplace("</b>", "**", $message);
        $message = $this->myReplace("<u>", "__", $message);
        $message = $this->myReplace("</u>", "__", $message);
        $message = $this->myReplace("<pre>", "`", $message);
        $message = $this->myReplace("</pre>", "`", $message);
        while (strpos($message, "<a href") !== false)
        {
            $pos = strpos($message, "<a href");
            $previous = substr($message, 0, $pos);
            $thelink = substr($message, $pos);
            $pos2 = strpos($thelink, "</a>");
            $theremainder = substr($thelink, $pos2 + 4);
            $thelink = substr($thelink, 0, $pos2);
            $thelink = $this->myReplace("<a href=\"", "", $thelink);
            $thelink = $this->myReplace("</a>", "", $thelink);
            $thelink = $this->myReplace("\" target=\"_blank\">", "##!##", $thelink);
            $thelink = explode("##!##", $thelink);
            $thelink = "[" . $thelink[1] . "](" . $thelink[0] . ")";
            $message = "$previous $thelink $theremainder";
        }
        return html_entity_decode($message);
    }

    static
            function myReplace($search, $replace, $mixed)
    {
        while (strpos($mixed, $search) !== false)
        {
            $mixed = str_replace($search, $replace, $mixed);
        }
        return $mixed;
    }

    static
            function randId()
    {
        $r = array("a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z", "0", "1", "2", "3", "4", "5", "6", "7", "8", "9");
        $result = "";
        for ($i = 0; $i < 12; $i++)
        {
            if (rand(0, 1) === 1)
            {
                $result .= \strtoupper($r[\array_rand($r)]);
            }
            else
            {
                $result .= $r[array_rand($r)];
            }
        }
        return $result;
    }

    static
            function firstname($name)
    {
        $r = array("!", "a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z", "0", "1", "2", "3", "4", "5", "6", "7", "8", "9");
        $name = explode(" ", $name);
        $first = $name[0];
        $cleanfirst = "";
        for ($i = 0; $i < strlen($first); $i++)
        {
            $char = strtolower(substr($first, $i, 1));
            if (array_search($char, $r) !== false)
            {
                $cleanfirst .= substr($first, $i, 1);
            }
        }
        return $cleanfirst;
    }

}

