#!/usr/bin/php
<?php
INCLUDE_ONCE('source/phenegade_functions.php');

$dropfile_path	= $argv[1];
$dropfile_payload	= unserialize(file_get_contents($dropfile_path));
$master_controller_process_id = $dropfile_payload['master_controller_process_id'];
phenegadeLog('Dispatch.php Begin');

//show something before we load the module
if( isset($dropfile_payload['preview_path']) && strlen($dropfile_payload['preview_path']) )
{
	phenShowView($dropfile_payload['preview_path']);
}

//load the module
if( isset($dropfile_payload['module']) )
{
	$phen_mod	= $dropfile_payload['module'];
	phenegadeLog('Dispatch - Module Found: ' . $phen_mod);
	$shell_command	= 'php modules/' . $phen_mod . '/start.php ' . $dropfile_path;
	phenExec($shell_command);
}

//show something when the module is finished
if( isset($dropfile_payload['preview_path']) && strlen($dropfile_payload['preview_path']) )
{
	phenShowView($dropfile_payload['preview_path']);
}

nextLine();
?>
