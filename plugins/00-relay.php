<?php
$funcs[] = function ($data)
{
	extract($data);
	if($platform == "highviber" && $channel == $this->config["highviber"]["public_channel"])
	{
		$this->discordQueue($this->config["discord"]["relay_channel"],"**$username** $text");
		$result = $this->logSql($userid, $username, $text);
		if($result) $this->sendReply($data,firstname($username)." has earned <b>Level $result</b> &#127942;");
	}
};
