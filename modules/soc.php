<?php

$cmd = "soc";
$cmdlist[] = $cmd;
$htmlhelp[$cmd]["commands"][] = $cmd;
$htmlhelp[$cmd]["title"] = "Display the Scale of Consciousness";
$htmlhelp[$cmd]["desc"] = "Gives you a simple version of David R. Hawkins Scale of Consciousness.";
$htmlhelp[$cmd]["usages"][] = "!$cmd";
$funcs[] = function ($channel, $userid, $username, $cmd, $vars, $text)
{
	if ($cmd == "!soc")
	{
		return "<b>The Scale of Consciousness</b><br /><pre>
   | 700+ Enlightenment | E 
 L | 600  Peace         | X 
 O | 540  Joy           | P 
 V | 500  Love          | A 
 E | 400  Reason        | N 
 S | 350  Acceptance    | D 
   | 310  Willingness   |   
 - | 250  Neutrality    | - 
   | 200  Courage       |   
   | 175  Pride         | C 
 F | 150  Anger         | O 
 E | 125  Desire        | N 
 A | 100  Fear          | T 
 R |  75  Grief         | R 
 S |  50  Apathy        | A 
   |  30  Guilt         | C 
   |  20  Shame         | T </pre>";
	}
	return false;
};
