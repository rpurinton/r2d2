<?php

$funcs[] = function ($data)
{
	extract($data);
	if($channel != $this->highviber_public_channel && $cmd == "!say" && $vars != "")
        {
		$data["platform"] = "highviber";
		$data["channel"] = $this->highviber_public_channel;
		$this->sendReply($data,$vars);
	}
};
