<?php

namespace R2D2;

require_once(__DIR__ . "/RabbitClient.php");

class DiscordFunctions Extends RabbitClient
{

    protected
            function discordQueue($channel, $message)
    {
        if($channel != "" && $message != "")
        {
            $this->publish("discord_send", ["channel" => $channel, "message" => $message]);
        }
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

}
