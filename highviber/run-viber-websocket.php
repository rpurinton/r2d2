<?php

if (file_exists("tmp/die/die-viber-websocket")) unlink("tmp/die/die-viber-websocket");
while (!file_exists("tmp/die/die-viber-websocket"))
{
	passthru("php highviber/viber-websocket.php");
	sleep(1);
}
unlink("tmp/die/die-viber-websocket");
