# R2D2 Chat Bot

## Foreward

This bot requires several config files with certain secrets which are not provided and so this bot will NOT run for you.   The code provided here is only for reference and collaboration.  You may however use any portions of the code here for your own purposes.  Any and all feedback and/or suggestions are welcome.

## Goals

- First ever bot for the HighViber (Mighty Networks) app.  No bots for this existed previously (that we know of) 
- Chat commands easily added and changed using plugins (additional PHP files) in the `src/plugins.d` directory
- RabbitMQ used to queue recieved messages for later processing by multiple workers
- Scaleable to hundreds of servers

## History

#### April 2022
- This bot was originally created for the HighViber (Mighty Networks) app. 

#### May 2022 
- Simultaneous Discord support added
- Rewritten into Classes
- JSON config file loader
- Multi-threading (Parallel Runtimes)
- Test Console

#### June 2022
- Added Real-Time Astrology Feature
- Added Twitter Support

## Command Help

Help and command documentation is available at [r2d2bot.tk](https://r2d2bot.tk)

## Requirements

- Linux (Tested on CentOS 8-Stream AARCH64) (will not work under Windows)
- PHP 8.1+, ext-uv, ext-parallel
- MariaDB/MySQL
- RabbitMQ
- WebServer required for HTML Docs
- Swiss Ephemeris Binary/Executable (swetest) (for Astrology Functions)
## Installation

#### Download source code 
...and optionally create a symlink for convenience

```
git clone git@github.com:rpurinton/r2d2.git
ln -s r2d2/r2d2 /usr/bin/r2d2
```

#### Import SQL Databases
...to support various plugins

```
cd sql/
mysql -p tarot < tarot.sql
mysql -p cookie < cookie.sql
mysql -p ... < ...
```

#### Edit Configuration Files
...these are in JSON format but not provided

```
cd src/conf.d/
nano sql.conf
nano rabbit.conf
nano highviber.conf
nano discord.conf
nano youtube.conf
nano twitter.conf
```

#### Install CRON Jobs
```
crontab -e
* * * * * /path/to/src/cron.d/astro.php
0 * * * * /path/to/src/cron.d/latest.php
```

#### Create RabbitMQ Queues

You will need to create 3 queues named:

-`worker`
-`discord_send`
-`cli_send`

Be sure to set the queues as "durable" otherwise they will not persist after a reboot

## Start Order

Before starting r2d2 you must ensure `mysql`, `rabbitmq-server`, `httpd`, `crond`, and `ntpd` services are running

## Command-Line-Interface

`r2d2` alone will start CLI mode. 

#### Static Commands
- `start`
- `stop`
- `status`
- `restart`
- `reload`
- `debug`
- `exit`
- `quit`

Other than the above commands, anything you type will be treated as simulated message, passed to the worker for processing and the response will be provided (with HTML and markdown stripped).  Type debug once to enable debugging mode to see the details of the data packet in the response with html included.

You can also start/stop/restart r2d2 from the Command-line outside of CLI Mode

## Starting

`r2d2 start`

## Stopping

`r2d2 stop`

## Restart Everything

`r2d2 restart`

## Reload Plugins

`r2d2 reload`

## Monitoring Status

`r2d2 status`
