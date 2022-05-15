<?php

$workerid = $argv[1];
if (file_exists("tmp/die/die-discord-worker$workerid")) unlink("tmp/die/die-discord-worker$workerid");
while (!file_exists("tmp/die/die-discord-worker$workerid"))
{
	passthru("php discord/discord-worker.php $workerid");
	sleep(1);
}
unlink("tmp/die/die-discord-worker$workerid");
