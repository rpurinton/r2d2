<?php

namespace R2D2;

require_once(__DIR__ . "/DiscordFunctions.php");

class Worker Extends DiscordFunctions
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
                        $this->loadConfig();
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
        exec("ls " . __DIR__ . "/plugins.d/*.php", $modules);
        foreach ($modules as $module)
        {
            include($module);
        }
        $this->cmd_list = $cmd_list;
        $this->html_help = $html_help;
        $this->plugin_functions = $funcs;
    }

}
