#!/usr/bin/php -f
<?php

touch("tmp/die/die-discord-websocket");
touch("tmp/die/die-discord-worker1");
touch("tmp/die/die-discord-worker2");
touch("tmp/die/die-viber-websocket");
touch("tmp/die/die-viber-typer");
touch("tmp/die/die-viber-worker1");
touch("tmp/die/die-viber-worker2");
touch("tmp/die/die-viber-worker3");
touch("tmp/die/die-viber-worker4");
touch("tmp/die/die-viber-logger");
exec("ps aux | grep \"php highviber/viber-websocket.php\"", $ps);
exec("ps aux | grep \"php highviber/viber-typer.php\"", $ps);
exec("ps aux | grep \"php highviber/viber-worker.php\"", $ps);
exec("ps aux | grep \"php highviber/viber-logger.php\"", $ps);
exec("ps aux | grep \"php discord/discord-websocket.php\"", $ps);
exec("ps aux | grep \"php discord/discord-worker.php\"", $ps);
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
