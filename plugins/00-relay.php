<?php
$funcs[] = function ($data)
{
	extract($data);
	if($platform == "highviber" && $channel == $this->highviber_public_channel)
	{
		$this->discordQueue($this->discord_relay_channel,"**$username** $text");
		$result = $this->logSql($userid, $username, $text);
		if($result) $this->sendReply($data,firstname($username)." has earned <b>Level $result</b> &#127942;");
	}
};
