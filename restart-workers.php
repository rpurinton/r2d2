#!/usr/bin/php -f
<?php

exec("ps aux | grep \"php highviber/viber-worker\.php\"", $ps);
exec("ps aux | grep \"php discord/discord-worker\.php\"", $ps);
foreach ($ps as $ps0)
{
	while (strpos($ps0, "  ")) $ps0 = str_replace("  ", " ", $ps0);
	if (strpos($ps0, "grep") === false)
	{
		$pi = explode(" ", $ps0);
		$pid = $pi[1];
		passthru("kill $pid");
	}
}
