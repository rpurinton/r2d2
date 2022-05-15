<?php

$funcs[] = function ($channel, $userid, $username, $cmd, $vars, $text)
{
	if (strpos(strtolower($text), "jinx") !== false)
	{
		return $text;
	}
	return false;
};
