<?php

$workerid = $argv[1];
if (file_exists("tmp/die/die-viber-worker$workerid")) unlink("tmp/die/die-viber-worker$workerid");
while (!file_exists("tmp/die/die-viber-worker$workerid"))
{
	passthru("php highviber/viber-worker.php $workerid");
	sleep(1);
}
unlink("tmp/die/die-viber-worker$workerid");
