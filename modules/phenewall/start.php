#!/usr/bin/php
<?php
INCLUDE_ONCE('__module_init.php');
INCLUDE_ONCE('source/phenegade_functions.php');
$module_path	= 'modules/phenewall/';

$dropfile_path	= $argv[1];
$dropfile_payload	= unserialize(file_get_contents($dropfile_path));
$master_controller_process_id = $dropfile_payload['master_controller_process_id'];
phenegadeLog('Phenewall Begin');

$user_name		= $dropfile_payload['user_name'];
$user_id		= $dropfile_payload['user_id'];
$terminal_echo	= $dropfile_payload['terminal_echo'];

showWall();

phenSay('Do you want to write on the wall? [y/N]');
$input 	= phenReadInput();
phenegadeLog('Do you want to write on the wall = ' . $input);
if( strtolower($input) == 'y'  )
{
	phenSay("Tag it up! [ ");
	$my_input	= phenReadInput();
	$my_input	= "\n\r--- [ " . $user_name . " ] - " . $my_input . "\n\r";
	if( phenFileAppend($module_path . 'wall.asc', $my_input) ) 
	{
		phenSay('Done!');
		showWall();
	}
}
phenPressAnyKey();

function showWall()
{
	global $module_path;
	
	clearScreen();

	phenShowView($module_path . 'pre.ans', true);
	phenShowView($module_path . 'wall.asc', true);
	NextLine();
	nextLine();
}
?>