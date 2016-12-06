#!/usr/bin/php
<?php
INCLUDE_ONCE('__init.php');
phenegadeLog('Phenegade Node Loading');
#phenegadeLog(print_r($_ENV, true));
phenShowView('ansi/loading.ans');

/**
* Keep running the Login Module till we get a valid user id
*/
while( $user_id == 0)
{
	sleep(1);
	$dispatch_input		= array('input' => null, 'module' => 'logon');
	$dispatch_payload 	= dispatch($master_controller_process_id, $dispatch_input);
	$user_id	= $dispatch_payload['user_id'];
	$user_name	= $dispatch_payload['user_name'];
}
phenShowMenu($menu_name);

/**
* Run an event loop and check STD IN for input
*/
while($input_check)
{
	usleep(200000);
	phenegadeLog('Reading STDIN');

	echo(phenGetCommandPrompt($user_name));

	$input  	= phenReadInput();

	phenegadeLog('Selected Input: ' . $input);
	if( $timeout_count == TIMEOUT_LIMIT )
	{
		phenegadeLog('Timeout'); exit;
	}
	else
	{
		$timeout_count++;
	}
	switch($input)
	{
		default:
			$active_menu	= loadMenu($menu_name);
			if( isset($active_menu[$input]) )
			{
				$menu_send		= $active_menu[$input];
				$data_send		= array('input' => $input, 'user_name' => $user_name, 'user_id' => $user_id, 'terminal_echo' => $terminal_echo);
				$dispatch_send	= array_merge($data_send, $menu_send);
				$dispatch_receive = dispatch($master_controller_process_id, $dispatch_send);
				$timeout_count	= 0;
			}
			clearScreen();
			phenShowMenu($menu_name);
			
			break;

		case '':
			phenegadeLog('No Input - Do Nothing');
			phenShowMenu($menu_name);
			break;

		case 'exit':
			clearScreen();
			phenShowView('ansi/goodbye.ans');
			phenegadeLog('User Exit');
			exit;
			break;

		case 'motd':
			phenShowView('ansi/motd.asc');
			nextLine();
			break;
		
		case 'who':
			phenExec('who | unix2dos');
			phenPressAnyKey();
			nextline();
			break;

		case 'echo':
			$terminal_echo = $terminal_echo ? 0 : 1;
			phenPressAnyKey();
			break;
	
	}
}
phenegadeLog('Phenegade Node Exiting');
exit;
?>
