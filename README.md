# R2D2 Chat Bot

## Foreward

This bot requires several files which are not provided and will NOT run for you.   The code provided here is only for reference and collaboration.  You may however use any portions of the code here for your own purposes.  Any and all feedback and/or suggestions are welcome.

## Goals

- First ever bot for the HighViber (Mighty Networks) app.  No bots existed previously. 
- Chat commands easily added and changed using module PHP files in the modules directory.
- RabbitMQ used to queue recieved messages for later processing by multiple workers
- Scaleable to hundreds of servers

## History

April 2022 This bot was originally created for the HighViber (Mighty Networks) app.  

May 2022 Simultaneous Discord support added.

## Command Help

Help and command documentation is available at [r2d2bot.tk](https://r2d2bot.tk).

## Requirements

- Linux
- PHP 8+
- MariaDB/MySQL
- RabbitMQ

## Starting

`./start.sh`

## Stopping

`./stop.php`

## Restart Workers Only

`./restart-workers.php`

## Monitoring Status / Logs

`./monitor.php`


