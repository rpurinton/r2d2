<?php

$cmd = "soc";
$cmd_list[] = $cmd;
$html_help[$cmd]["commands"][] = $cmd;
$html_help[$cmd]["title"] = "Display the Scale of Consciousness";
$html_help[$cmd]["desc"] = "Gives you a simple version of David R. Hawkins Scale of Consciousness.";
$html_help[$cmd]["usages"][] = "!$cmd";
$funcs[] = function ($data)
{
    extract($data);
    if ($cmd == "!soc")
    {
        $this->reply($data, " <b>The Scale of Consciousness</b><br /><pre>
   | 700+ Enlightenment | E 
 L | 600  Peace         | X 
 O | 540  Joy           | P 
 V | 500  Love          | A 
 E | 400  Reason        | N 
 S | 350  Acceptance    | D 
   | 310  Willingness   | S 
 - | 250  Neutrality    | - 
   | 200  Courage       | C 
   | 175  Pride         | O 
 F | 150  Anger         | N 
 E | 125  Desire        | T 
 A | 100  Fear          | R 
 R |  75  Grief         | A 
 S |  50  Apathy        | C 
   |  30  Guilt         | T 
   |  20  Shame         | S </pre>");
    }
};
