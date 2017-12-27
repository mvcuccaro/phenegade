# phenegade
php inetd bbs emulator ::
This was written as a demonstration of some modular architecture for php. 
It uses a simple dispatcher to swap between modules/plugins feeding data between them with a dropfile - similar to old bbs doors. 
It can be used as a nice telnet bbs if served up by inetd. 
I named it phenegade in honor of my favorite bbs software - Renegade BBS. 

There may or may not be a demonstration running at 35.162.14.69 7575 available via a telnet client on linux or a good bbs client on windows/dos (windows telnet doesnt render the default ansi very good at all) - Just log in with username 'guest'

## Getting Started
Download or clone this repo. 
Change to the directory that you downloaded phenegade into. 
At the command prompt type:
>php go.php

You should see a loading prompt followed by a login.  
The login module currently supports a hardcoded guest account: 
Type "guest" to login.

The included logon and wall modules can be used as examples to create your own modules using the dropfile method. Have fun pretending its 1988 again!
