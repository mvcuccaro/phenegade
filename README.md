# phenegade
php inetd bbs emulator ::
This was written as a demonstration of some modular architecture for php. 
It uses a simple dispatcher to swap between modules/plugins feeding data between them with a dropfile - similar to old bbs doors. 
It can be used as a nice telnet bbs if served up by inetd. 
I named it phenegade in honor of my favorite bbs software - Renegade BBS. 

![alt text](https://github.com/mvcuccaro/phenegade/blob/master/screenshots/phenegade_main.jpg)
![alt text](https://github.com/mvcuccaro/phenegade/blob/master/screenshots/phenegade_wall.jpg)

## Getting Started
Download or clone this repo. 
Change to the directory that you downloaded phenegade into. 
At the command prompt type:
>php go.php

You should see a loading prompt followed by a login.  
The login module currently supports a hardcoded guest account: 
Type "guest" to login.

The included logon and wall modules can be used as examples to create your own modules using the dropfile method. Have fun pretending its 1988 again!
