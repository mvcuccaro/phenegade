<?php
chdir('/phenegade/root/goes/here/');
INCLUDE_ONCE('source/phenegade_functions.php');
declare(ticks=1);
function tick_handler() { pcntl_signal_dispatch(); }
register_tick_function('tick_handler');
DEFINE('TIMEOUT_LIMIT', 200);
$master_controller_process_id	= getmypid();

$input_check	= 1;
$timeout_count	= 0;

$mystdin	= fopen('php://stdin', 'r');
$user_id	= 0;

$menu_name	= 'main';
$terminal_echo = 0;

?>