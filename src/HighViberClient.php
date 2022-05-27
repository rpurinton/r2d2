<?php

namespace R2D2;

require_once(__DIR__."/RabbitClient.php");
class HighViberClient Extends RabbitClient
{

    protected
            $users;
    protected
            $socket_id;

    function __construct()
    {
        parent::__construct();
        echo("Starting HighViberClient...\n");
        \Amp\Loop::run(function ()
        {
            $connection = yield \Amp\Websocket\Client\connect("wss://ws.pusherapp.com/app/a13be185126229b1a8fe?protocol=7&client=js&version=4.2.2&flash=false");
            $message = array("event" => "pusher:subscribe");
            $message["data"]["channel"] = "system_notification_production";
            yield $connection->send(json_encode($message));
            while ($message = yield $connection->receive())
            {
                $payload = yield $message->buffer();
                $this->processMessage($connection, json_decode($payload, true));
            }
        });
    }

    function processMessage($connection, $payload)
    {
        if ($payload["event"] == "pusher:connection_established")
        {
            $data = json_decode($payload["data"], true);
            $this->socket_id = $data['socket_id'];
            $pusher_auth = $this->pusherAuth($this->socket_id);
            $message = array("event" => "pusher:subscribe");
            $channel = "private-user-11029792-production";
            $message["data"]["channel"] = $channel;
            $message["data"]["auth"] = $pusher_auth[$channel]["data"]["auth"];
            $connection->send(json_encode($message));

            $message = array("event" => "pusher:subscribe");
            $channel = "private-space-4619306-production";
            $message["data"]["channel"] = $channel;
            $message["data"]["auth"] = $pusher_auth[$channel]["data"]["auth"];
            $connection->send(json_encode($message));

            $message = array("event" => "pusher:subscribe");
            $channel = "presence-private-space-4619306-production";
            $message["data"]["channel"] = $channel;
            $message["data"]["auth"] = $pusher_auth[$channel]["data"]["auth"];
            $message["data"]["channel_data"] = $pusher_auth[$channel]["data"]["channel_data"];
            $connection->send(json_encode($message));

            $message = array("event" => "pusher:subscribe");
            $channel = "private-space-7542752-production";
            $message["data"]["channel"] = $channel;
            $message["data"]["auth"] = $pusher_auth[$channel]["data"]["auth"];
            $connection->send(json_encode($message));

            $message = array("event" => "pusher:subscribe");
            $channel = "private-space-7569686-production";
            $message["data"]["channel"] = $channel;
            $message["data"]["auth"] = $pusher_auth[$channel]["data"]["auth"];
            $connection->send(json_encode($message));
        }
        elseif ($payload["event"] == "pusher_internal:subscription_succeeded" &&
                $payload["channel"] == "presence-private-space-4619306-production")
        {
            $data = json_decode($payload["data"], true);
            $data = $data["presence"]["hash"];
            $message = "";
            foreach ($data as $key => $value)
            {
                $this->users[substr($key, 0, strpos($key, "-"))] = $value["name"];
                $platform = substr($key, strpos($key, "-") + 1);
            }
        }
        elseif ($payload["event"] == "pusher_internal:member_added")
        {
            $data = json_decode($payload["data"], true);
            $key = $data["user_id"];
            $key = substr($key, 0, strpos($key, "-"));
            $name = $data["user_info"]["name"];
            $platform = $data["user_info"]["client"];
            $this->users[$key] = $name;
        }
        elseif ($payload["event"] == "pusher_internal:member_removed")
        {
            
        }
        elseif ($payload["event"] == "new_post")
        {
            $data = json_decode($payload["data"], true);
            extract($data);
            $name = $this->users[$creator_id];
            $message = "$name $status a $post_type<br /><a href=\"https://www.highviber.com/posts/$post_id\" target=\"_blank\">highviber.com/posts/$post_id</a>\n";
            $packet["socket_id"] = $this->socket_id;
            $packet["platform"] = "highviber";
            $packet["channel"] = "4619306";
        }
        elseif ($payload["event"] == "new_message")
        {
            $data = json_decode($payload['data'], true);
            if ($data["user"]["first_name"] === "R2D2")
            {
                return;
            }
            $packet["platform"] = "highviber";
            $packet["socket_id"] = $this->socket_id;
            $packet["channel"] = $data["conversation_id"];
            $packet["userid"] = $data["user"]["id"];
            $packet["username"] = $data["user"]["name"];
            $text = $data["text"];
            $packet["text"] = $text;
            $packet["cmd"] = strtolower($this->firstname($text));
            if (strpos($text, " ") !== false)
            {
                $packet["vars"] = substr($text, strpos($text, " ") + 1);
            }
            else
            {
                $packet["vars"] = "";
            }
            $this->publish("worker", $packet);
        }
    }

    function pusherAuth($socket_id)
    {
        $host = "https://www.highviber.com";
        $request = "/api/web/v1/pusher-auth";

        $postdata = "&socket_id=$socket_id";
        $postdata .= "&channel_name[0]=private-user-11029792-production";
        $postdata .= "&channel_name[1]=private-space-4619306-production";
        $postdata .= "&channel_name[2]=presence-private-space-4619306-production";
        $postdata .= "&channel_name[3]=private-space-7542752-production";
        $postdata .= "&channel_name[4]=private-space-7569686-production";

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $host . $request);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $this->config["highviber"]["push_headers"]);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $postdata);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 60);
        curl_setopt($curl, CURLOPT_TIMEOUT, 60);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $result1 = curl_exec($curl);
        $result2 = gzdecode($result1);
        $result3 = json_decode($result2, true);
        return($result3);
    }

}
