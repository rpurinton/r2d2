<?php

if (file_exists("tmp/die/die-viber-typer")) unlink("tmp/die/die-viber-typer");
while (!file_exists("tmp/die/die-viber-typer"))
{
	passthru("php highviber/viber-typer.php");
	sleep(1);
}
unlink("tmp/die/die-viber-typer");
