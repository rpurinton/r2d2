<?php

if (file_exists("tmp/die/die-discord-websocket")) unlink("tmp/die/die-discord-websocket");
while (!file_exists("tmp/die/die-discord-websocket"))
{
	passthru("php discord/discord-websocket.php");
	sleep(1);
}
unlink("tmp/die/die-discord-websocket");
