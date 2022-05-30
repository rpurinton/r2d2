# R2D2 Chat Bot

## Foreward

This bot requires several config files with certain secrets which are not provided and will NOT run for you.   The code provided here is only for reference and collaboration.  You may however use any portions of the code here for your own purposes.  Any and all feedback and/or suggestions are welcome.

## Goals

- First ever bot for the HighViber (Mighty Networks) app.  No bots existed previously. 
- Chat commands easily added and changed using plugins (additional PHP files) in the `src/plugins.d` directory.
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

## Command Help

Help and command documentation is available at [r2d2bot.tk](https://r2d2bot.tk).

## Requirements

- Linux (Tested on CentOS 8-Stream AARCH64)
- PHP 8.1+, ext-uv, ext-parallel
- MariaDB/MySQL
- RabbitMQ
- WebServer required for HTML Docs

## Installation

```
git clone git@github.com:rpurinton/r2d2.git
ln -s r2d2/r2d2 /usr/bin/r2d2
```

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
