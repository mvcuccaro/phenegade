#!/usr/bin/php
<?php
/**
*	PHENEGADE BBS LOGON MODULE
*/
INCLUDE_ONCE('source/phenegade_functions.php');
sleep(2);
clearScreen();
phenShowView('ansi/logon.ans', true);

$dropfile_path		= $argv[1];
$dropfile_payload	= unserialize(file_get_contents($dropfile_path));
$master_controller_process_id = $dropfile_payload['master_controller_process_id'];
phenegadeLog('Begin Module Login');

nextLine();
phenSay('Enter your Username: ');

$mystdin	= fopen('php://stdin', 'r');

$input		= trim(phenReadInput());

if( $input == 'guest' )
{
	$user_id = 1;
}
else
{
	$user_id = 0;
	echo('user not found');
	phenPressAnyKey();
}

$dropfile_payload['user_id']	= $user_id;
$dropfile_payload['user_name']	= $input;
file_put_contents($dropfile_path, serialize($dropfile_payload));
?>