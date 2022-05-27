<?php

$funcs[] = function ($data)
{
    extract($data);
    if ($platform == "highviber" && $channel == $this->config["highviber"]["public_channel"])
    {
        $this->discordQueue($this->config["discord"]["relay_channel"], "**$username** $text");
    }
};
