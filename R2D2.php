<?php

namespace R2D2;

require_once(__DIR__ . "/vendor/autoload.php");

use Discord\Discord;
use Amp\Websocket;
use React\EventLoop\Factory;
use Monolog\Handler\StreamHandler;
use PhpAmqpLib\Message\AMQPMessage;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class Base
{

    protected
            $config;
    protected
            $mq_conn;
    protected
            $mq_chan;

    function __construct()
    {
        $config = json_decode(file_get_contents(__DIR__ . "/config.json"), true);
        $this->rabbitConnect($config["rabbit"]);
        $config["discord"] = json_decode(file_get_contents(__DIR__ . "/" . $config["discord"]["config"]), true);
        $config["highviber"] = json_decode(file_get_contents(__DIR__ . "/" . $config["highviber"]["config"]), true);
        $config["youtube"] = json_decode(file_get_contents(__DIR__ . "/" . $config["youtube"]["config"]), true);
        $this->config = $config;
    }

    function __destruct()
    {
        if ($this->mq_chan != \null)
        {
            $this->mq_chan->close();
        }
        if ($this->mq_conn != \null)
        {
            $this->mq_conn->close();
        }
    }

    protected
            function rabbitConnect($config)
    {
        extract($config);
        $this->mq_conn = new AMQPStreamConnection($host, $port, $user, $pass);
        $this->mq_chan = $this->mq_conn->channel();
        $this->mq_chan->basic_qos(\null, 1, \null);
    }

    protected
            function publish($queue, $data)
    {
        $message = new AMQPMessage(json_encode($data));
        $this->mq_chan->basic_publish($message, '', $queue);
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

class DiscordSender Extends Base
{

    function __construct()
    {
        parent::__construct();
        echo("Starting DiscordSender...\n");
        $this->mq_chan->basic_consume("discord_send", "discord_sender", false, true, false, false, function ($message)
        {
            $result = array(1);
            $data = json_decode($message->body, true);
            while (sizeof($result) > 0)
            {
                $result = $this->discordSend($data["channel"], $data["message"]);
                if (\sizeof($result) > 0)
                {
                    $this->discordQueue($data["channel"], $data["message"]);
                    usleep($result["retry_after"] * 1000);
                }
            }
        });
        $this->mq_chan->consume();
    }

    function __destruct()
    {
        echo("Stopped DiscordSender.\n");
    }

}

class Logger Extends Base
{

    protected
            $thread;
    protected
            $future;

    function __construct()
    {
        parent::__construct();
        echo("Started Logger...\n");
        $this->thread = new \parallel\Runtime(__DIR__ . "/R2D2.php");
        $this->future = $this->thread->run(function ()
        {
            new DiscordSender;
        });
        while ($line = fgets(STDIN))
        {
            $this->myLog($line);
            if ($this->future->done())
            {
                $this->future = $this->thread->run(function ()
                {
                    new DiscordSender;
                });
            }
        }
    }

    function __destruct()
    {
        $this->thread->kill();
        echo("Stopped Logger.\n");
        parent::__destruct();
    }

}

class ProcessManager
{

    protected
            function getPids()
    {
        $ps = array();
        $ps2 = array();
        $ps3 = array();
        exec("ps aux | grep \"r2d2 wrapper\"", $ps);
        exec("ps aux | grep \"r2d2 logger\"", $ps);
        exec("ps aux | grep \"r2d2 main\"", $ps);
        foreach ($ps as $line)
        {
            if (\strpos($line, "grep") === \false)
            {
                $ps2[] = $line;
            }
        }
        foreach ($ps2 as $line)
        {
            $line = Base::myReplace("  ", " ", $line);
            $line = explode(" ", $line);
            $ps3[] = $line[1];
        }
        return $ps3;
    }

}

class Status Extends ProcessManager
{

    function __construct()
    {
        $pids = $this->getPids();
        if (\sizeof($pids) === 4)
        {
            echo("R2D2 is running... (pids " . implode(" ", $pids) . ")\n");
        }
        elseif (\sizeof($pids))
        {
            echo("WARNING; R2D2 is HALF running... (pids " . implode(" ", $pids) . ")\n");
        }
        else
        {
            echo("R2D2 is stopped.\n");
        }
    }

}

class Start Extends ProcessManager
{

    function __construct()
    {
        $pids = $this->getPids();
        if (\sizeof($pids))
        {
            die("ERROR: R2D2 is already running.  Not starting.\n");
        }
        exec("nohup r2d2 wrapper </dev/null 2>&1 | r2d2 logger > /dev/null 2>&1 &");
        new Status;
    }

}

class Wrapper
{

    function __construct()
    {
        while (true)
        {
            passthru("r2d2 main");
            sleep(1);
        }
    }

}

class Stop Extends ProcessManager
{

    function __construct()
    {
        $pids = $this->getPids();
        foreach ($pids as $pid)
        {
            posix_kill($pid, SIGTERM);
        }
        new Status;
    }

}

class Kill Extends ProcessManager
{

    function __construct()
    {
        $pids = $this->getPids();
        foreach ($pids as $pid)
        {
            posix_kill($pid, SIGKILL);
        }
        new Status;
    }

}

class Restart Extends ProcessManager
{

    function __construct()
    {
        new Status;
        new Stop;
        new Start;
    }

}

class Reload Extends Base
{

    function __construct()
    {
        parent::__construct();
        $nproc = exec("nproc");
        for ($id = 1; $id <= $nproc; $id++)
        {
            $this->publish("worker", array("channel" => "command", "command" => "reload", "worker_id" => "$id"));
        }
    }

}

class Main
{

    protected
            $nproc;
    protected
            $functions;
    protected
            $threads;
    protected
            $futures;

    function __construct()
    {
        $this->nproc = exec("nproc");
        echo("Starting Main...\n");
        for ($id = 1; $id <= $this->nproc; $id++)
        {
            $this->functions["worker$id"] = function ($workerid)
            {
                new Worker($workerid);
            };
            $this->threads["worker$id"] = new \parallel\Runtime(__DIR__ . "/R2D2.php");
            $this->futures["worker$id"] = $this->threads["worker$id"]->run($this->functions["worker$id"], array($id));
        }
        $this->functions["discord"] = function ()
        {
            new DiscordClient;
        };
        $this->threads["discord"] = new \parallel\Runtime(__DIR__ . "/R2D2.php");
        $this->futures["discord"] = $this->threads["discord"]->run($this->functions["discord"]);
        $this->functions["highviber"] = function ()
        {
            new HighViberClient;
        };
        $this->threads["highviber"] = new \parallel\Runtime(__DIR__ . "/R2D2.php");
        $this->futures["highviber"] = $this->threads["highviber"]->run($this->functions["highviber"]);
        while (true)
        {
            foreach ($this->futures as $key => $future)
            {
                if ($future->done())
                {
                    $this->futures[$key] = $this->threads[$key]->run($this->functions[$key]);
                }
            }
            sleep(1);
        }
    }

    function __destruct()
    {
        foreach ($this->threads as $thread)
        {
            $thread->kill();
        }
        echo("Stopped Main.\n");
    }

}

class Worker Extends Base
{

    protected
            $sql;
    protected
            $levels;
    protected
            $cmd_list;
    protected
            $html_help;
    protected
            $worker_id;
    protected
            $levels_reverse;
    protected
            $plugin_functions;

    function __construct($id)
    {
        parent::__construct();
        echo("Starting Worker $id...\n");
        $this->worker_id = $id;
        $this->sqlConnect($this->config["sql"]);
        $this->defineLevels();
        $this->loadPlugins();
        $this->mq_chan->basic_consume("worker", "worker$id", false, true, false, false, function ($message)
        {
            $data = json_decode($message->body, true);
            if ($data["channel"] == "command")
            {
                if ($data["command"] == "reload")
                {
                    if ($data["worker_id"] == $this->worker_id)
                    {
                        echo("Reloading Worker {$this->worker_id}...\n");
                        $this->loadPlugins();
                    }
                    else
                    {
                        $this->publish("worker", array("channel" => "command", "command" => "none"));
                        $this->publish("worker", $data);
                    }
                }
                return;
            }
            try
            {
                foreach ($this->plugin_functions as $func)
                {
                    $func($data);
                }
            }
            catch (Exception $e)
            {
                print_r($e);
            }
        });
        $this->mq_chan->consume();
    }

    function __destruct()
    {
        $this->sql->close();
        echo("Stopped Worker {$this->worker_id}.\n");
        parent::__destruct();
    }

    protected
            function sqlConnect($config)
    {
        extract($config);
        $this->sql = mysqli_connect($host, $user, $pass)
                or die("sql connection error\n");
    }

    protected
            function defineLevels()
    {
        $total = 0;
        for ($i = 1; $i < 101; $i++)
        {
            if ($i === 1)
            {
                $count = 4;
            }
            else
            {
                $count = floor($count * 1.25);
            }
            $total += $count;
            $this->levels[$total] = $i;
            $this->levels_reverse[$i] = $total;
        }
    }

    protected
            function sendReply($data, $message)
    {
        extract($data);
        switch ($platform)
        {
            case "discord":
                $this->discordQueue($channel, $message);
                break;
            case "highviber":
                $this->highviberSend($channel, $message);
                if ($channel == $this->config["highviber"]["public_channel"])
                {
                    $this->discordQueue($this->config["discord"]["relay_channel"], "**R2D2** $message");
                }
        }
    }

    protected
            function highviberSend($channel, $message)
    {
        sleep(1);
        $url = "https://www.highviber.com/api/web/v1/spaces/$channel/chats";
        $packet["user"]["id"] = 11029792;
        $packet["user"]["name"] = "R2D2 [BOT]";
        $packet["user"]["avatar_url"] = "https://media1-production-mightynetworks.imgix.net/asset/38584369/wp1867298.jpg?ixlib=rails-0.3.0&fm=jpg&q=100&auto=format&w=400&h=400&fit=crop&crop=faces&impolicy=Avatar";
        $packet["text"] = $message . "<div id=" . $this->randId() . " />";
        $packet["created_at"] = gmdate("Y-m-d\TH:i:s.\9\9\9\Z", time() + 1);
        $postData = json_encode($packet);
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_HTTP_VERSION, 3);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $this->config["highviber"]["chat_headers"]);
        curl_setopt($curl, CURLINFO_HEADER_OUT, true);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($curl);
        curl_close($curl);
        return json_decode($result, true);
    }

    protected
            function logSql($userid, $username, $message)
    {
        mysqli_select_db($this->sql, "chatbot");
        $username = mysqli_real_escape_string($this->sql, $username);
        $message = mysqli_real_escape_string($this->sql, $message);
        mysqli_query($this->sql, "INSERT INTO `users` (`userid`,`username`,`message_count`,`last_text`) VALUES ('$userid','$username',1,'$message') ON DUPLICATE KEY UPDATE `username` = '$username', `message_count` = `message_count` + 1, `last_text` = '$message'");
        extract(mysqli_fetch_assoc(mysqli_query($this->sql, "SELECT `message_count` FROM `users` WHERE `userid` = '$userid'")));
        if (isset($this->levels[$message_count]))
        {
            return $this->levels[$message_count];
        }
        return 0;
    }

    protected
            function getLevel($messages)
    {
        if ($messages < 4)
        {
            return 0;
        }
        for ($i = 1; $i < 100; $i++)
        {
            if ($messages >= $this->levels_reverse[$i] && $messages < $this->levels_reverse[$i + 1])
            {
                return $i;
            }
        }
        return 100;
    }

    protected
            function loadPlugins()
    {
        exec("ls " . __DIR__ . "/plugins/*.php", $modules);
        foreach ($modules as $module)
        {
            include($module);
        }
        $this->cmd_list = $cmd_list;
        $this->html_help = $html_help;
        $this->plugin_functions = $funcs;
    }

}

class DiscordClient Extends Base
{

    function __construct()
    {
        parent::__construct();
        echo("Starting DiscordClient...\n");
        $loop = Factory::create();
        $discord = new Discord([
            "loop" => $loop,
            "token" => $this->config["discord"]["bot_token"],
            'logger' => new \Monolog\Logger('DiscordPHP', [new StreamHandler('php://stdout', \MonoLog\Logger::ERROR)])
        ]);
        $discord->on("ready", function (Discord $discord)
        {
            $discord->on("raw", function ($data, Discord $discord)
            {
                $data = json_decode(json_encode($data), true);
                if ($data["t"] === "MESSAGE_CREATE" &&
                        $data["d"]["author"]["username"] != "R2D2" &&
                        $data["d"]["author"]["username"] != "HighViber")
                {
                    $packet["platform"] = "discord";
                    $text = $data["d"]["content"];
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
                    $packet["channel"] = $data["d"]["channel_id"];
                    $packet["userid"] = $data["d"]["author"]["id"];
                    $packet["username"] = $data["d"]["author"]["username"];
                    if (isset($data["d"]["member"]["nick"]))
                    {
                        $packet["username"] = $data["d"]["member"]["nick"];
                    }
                    $this->publish("worker", $packet);
                }
            });
        });
        $discord->run();
    }

    function __destruct()
    {
        echo("Stopped DiscordClient.\n");
        parent::__destruct();
    }

}

class HighViberClient Extends Base
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
            $connection = yield Websocket\Client\connect("wss://ws.pusherapp.com/app/a13be185126229b1a8fe?protocol=7&client=js&version=4.2.2&flash=false");
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

    function __destruct()
    {
        echo("Stopped HighViberClient.\n");
        parent::__destruct();
    }

}
