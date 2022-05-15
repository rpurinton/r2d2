<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>R2D2 Bot Help</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="R2D2 Bot Help and Command Documentation">
		<meta name="author" content="R2D2 [BOT]">
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
		<style>
			html,body{
				background-color:#222;
				color: #ddd;
				width: 100%;
			}
			table,tr,td,th {
				border: 1px solid;
				padding: 5px;
				spacing: 5px;
			}
			table {
				width: 100%;
				table-layout: fixed;
				overflow-wrap: break-word;
			}
			.tdmin {
				width: 120px;
			}
		</style>
	</head>
	<body>
		<h1 id="topofpage">R2D2 [BOT] Help and Command Documentation</h1>
		<table>
			<tr><th class="tdmin">Command(s)</th><th>Description / Usage</th></tr>
			<?php
			exec("ls /var/www/chatbot/modules/*.php", $modules);
			foreach ($modules as $module) require_once($module);
			ksort($htmlhelp);
			foreach ($htmlhelp as $help)
			{
				if (isset($seealso)) unset($seealso);
				extract($help);
				echo("<tr><td class=\"tdmin\" valign=top><br /><br /><b>");
				foreach ($commands as $command) echo("!$command<br />");
				echo("</b></td><td valign=top><h2 id=\"" . $commands[0] . "\">$title</h2><i>$desc</i></br /><br /><u><b>Usage Example</b></u><pre>");
				foreach ($usages as $usage) echo("$usage\n");
				echo("</pre>");
				if (isset($seealso))
				{
					sort($seealso);
					echo("<u><b>See Also</b></u><br /><ul>");
					foreach ($seealso as $also) echo("<li><a href=\"https://r2d2bot.tk/#$also\">!$also</a></li>\n");
					echo("</ul>\n");
				}
				echo("</td></tr>\n");
			}
			?>
		</table>
		<div style="height: 1024px;"><a href="#topofpage">^top</a></div>
		<script src="https://code.jquery.com/jquery-3.6.0.slim.min.js" integrity="sha256-u7e5khyithlIdTpu22PHhENmPcRdFiHRjhAuHcs05RI=" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
	</body>
</html>
