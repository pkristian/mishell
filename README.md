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
- Cross platform
- Um... name sounds like a girl

Requirements
------------
 - PHP 5.6+
 - git
 
Installation
------------
Download [mishell.phar](https://github.com/pkristian/mishell/releases/download/v0.1.0/mishell.phar) and place it somewhere.

Usage
---------
In your favorite console run:
 ```
 php mishell.phar <profileName.ini|profile_directory/>
 ```
Sample configuration file is [here](https://github.com/pkristian/mishell/blob/v0.1.0/tests/testProfile.ini) ([raw](https://raw.githubusercontent.com/pkristian/mishell/v0.1.0/tests/testProfile.ini)).

How to make it run periodically? Put it into **cron**.

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
