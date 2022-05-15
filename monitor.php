#!/usr/bin/php -f
<?php

passthru("clear");
usleep(500000);
exec("ps aux | grep php", $ps);
foreach ($ps as $process)
{
	if (strpos($process, "fpm") === false && strpos($process, "grep") === false) echo("$process\n");
}
passthru("cd logs && tail -f *.log");
