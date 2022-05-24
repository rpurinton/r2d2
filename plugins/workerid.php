<?php

$funcs[] = function ($data)
{
	extract($data);
	if ($cmd === "!workerid")
	{
		$this->sendReply($data,$this->worker_id);
	}
};
