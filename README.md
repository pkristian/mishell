Mishell - Active PHP git deploy tool.
================

Created by [Patrik Kristian](http://pkristian.cz)

Introduction
------------
Mishell is small tool, which is basically watchdog detecting changes in git repository and deploying when needed.

Features
---------
- Extremely simple installation
- Works on machines in intranets
- Allows to run pre and post deploy commands
- base functionality cross platform (fully functional on linux)
- Um... name sounds like a girl

Requirements
------------
 - PHP 5.6+
 - git
 - sudo (for advanced functionality)
 
Installation
------------
Download phar file at [release page](https://github.com/pkristian/mishell/releases) and place it somewhere.

Usage
---------
In your favorite console run:
 ```
 php mishell.phar ./profileName.ini [param1] [param2...]
 php mishell.phar ./profileDirecotry  [param1] [param2...]
 ```
 
### Parameters
At first you need to specify profile file, or directory, where profile files are located. (NON recursive and only `*.ini` files are picked)

**Aditional parameters:**

`daemon` - after executing of all profiles mishell will wait one minute and then will execute them again

`sudo` - instead of denying to deploy by wrong user, commands will be executed by rightful user

 
 
### Sample configuration file:
```ini
; name of profile - for logging purposes
; REQUIRED
name = app

; if set, profile can be triggered only by specific user
requiredUser = www-data

; working direcotry, where git root is
; REQUIRED
repositoryDirectory = /var/www/app

; name of remote, if empty, local branches are used
repositoryRemote = origin

; target branch name
; REQUIRED
repositoryBranch = master

; file, where actions will be logged
; note: path is relative to current working direcotry, NOT repositoryDirectory!
logFile = app.log

; log level taken from Monolog. integer
; REQUIRED
; - 100 DEBUG
; - 200 INFO
; - 250 NOTICE
; - 300 WARNING
; - 400 ERROR
; - 500 CRITICAL
; - 550 ALERT
; - 600 EMERGENCY
logLevel = 200

; command executed before deploy
commandBefore = php close.php

; command executed after deploy
commandAfter = rm -rf temp/

```

How to make it run periodically? Put it into **cron**.


What does it do?
----------------
Lets imagine you are on your linux system and you want to deploy your app at.

Your current working directory is `/home/user`.
Within this directory you have `mishell.phar` and `app.ini` (file above).

You execute following command: `php mishell.phat app.ini`

**What will happen:**
- checking current user, if different, than exit (unless **sudo** parameter is supplied)
- in directory `/var/www/app`:
- fetching from desired remote desired branch
- comparing hash of current and target commit
- if commits differ:
- executing closing php
- checkouts target commit (with FORCE)
- remove temp directory
- exit (unless **daemon** parameter is supplied)

log will be found in `/home/user/app.log`

Docker
--------
Yes! If your wish to run it in docker use [pkristian/mishell](https://hub.docker.com/r/pkristian/mishell/) image.

Troubleshooting
--------------
Run following commands to verify you have required dependencies available:
```
php --version
git --version
```

License
------------
Directory Lister is distributed under the terms of the [MIT License](http://www.opensource.org/licenses/mit-license.php).
