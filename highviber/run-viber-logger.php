<?php

if (file_exists("tmp/die/die-viber-logger")) unlink("tmp/die/die-viber-logger");
while (!file_exists("tmp/die/die-viber-logger"))
{
	passthru("php highviber/viber-logger.php");
	sleep(1);
}
unlink("tmp/die/die-viber-logger");
