<?php
declare(ticks=1);
function tick_handler() { pcntl_signal_dispatch(); }
register_tick_function('tick_handler');
DEFINE('TIMEOUT_LIMIT', 200);
$module_process_id	= getmypid();
$mystdin	= fopen('php://stdin', 'r');
?>