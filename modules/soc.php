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
   700+ Enlightenment   
   600  Peace          E
 L 540  Joy            X
 O 500  Love           P
 V 400  Reason         A
 E 350  Acceptance     N
   310  Willingness    D
 - 250  Neutrality     -
   200  Courage        C
   175  Pride          O
 F 150  Anger          N
 E 125  Desire         T
 A 100  Fear           R
 R  75  Grief          A
	50  Apathy		 C
	30  Guilt		  T
	20  Shame		   </pre>";
	}
	return false;
};
