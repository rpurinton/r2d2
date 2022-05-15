cd /var/www/r2d2
echo -n > logs/discord-websocket.log
echo -n > logs/discord-worker1.log
echo -n > logs/discord-worker2.log
echo -n > logs/viber-websocket.log
echo -n > logs/viber-typer.log
echo -n > logs/viber-worker1.log
echo -n > logs/viber-worker2.log
echo -n > logs/viber-worker3.log
echo -n > logs/viber-worker4.log
echo -n > logs/viber-logger.log
/usr/bin/nohup /usr/bin/php -f discord/run-discord-websocket.php </dev/null &>logs/discord-websocket.log 2>&1 &
/usr/bin/nohup /usr/bin/php -f discord/run-discord-worker.php 1 </dev/null &>logs/discord-worker1.log 2>&1 &
/usr/bin/nohup /usr/bin/php -f discord/run-discord-worker.php 2 </dev/null &>logs/discord-worker2.log 2>&1 &
/usr/bin/nohup /usr/bin/php -f highviber/run-viber-websocket.php </dev/null &>logs/viber-websocket.log 2>&1 &
/usr/bin/nohup /usr/bin/php -f highviber/run-viber-typer.php </dev/null &>logs/viber-typer.log 2>&1 &
/usr/bin/nohup /usr/bin/php -f highviber/run-viber-worker.php 1 </dev/null &>logs/viber-worker1.log 2>&1 &
/usr/bin/nohup /usr/bin/php -f highviber/run-viber-worker.php 2 </dev/null &>logs/viber-worker2.log 2>&1 &
/usr/bin/nohup /usr/bin/php -f highviber/run-viber-worker.php 3 </dev/null &>logs/viber-worker3.log 2>&1 &
/usr/bin/nohup /usr/bin/php -f highviber/run-viber-worker.php 4 </dev/null &>logs/viber-worker4.log 2>&1 &
/usr/bin/nohup /usr/bin/php -f highviber/run-viber-logger.php </dev/null &>logs/viber-logger.log 2>&1 &
./monitor.php
