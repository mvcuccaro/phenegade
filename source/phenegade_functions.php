<?php
function phenExec($arg_command)
{
	$my_output 	= null;
	$shell_command	= $arg_command;
	phenegadeLog('phenExec: ' . $shell_command);
	passthru($shell_command);
}

function phenShowView($arg_path, $arg_unix2dos = false)
{
	phenegadeLog('Displaying View: ' . $arg_path);
	$view = file_get_contents($arg_path);
	if( $arg_unix2dos )
	{
		phenegadeLog('Converting View To Dos');
		$view = str_replace("\n", "\r\n", $view);
	}
	echo($view);
}

function phenSay($arg_say, $arg_newline = 0)
{
	$out 	= $arg_newline ? $arg_say . "\n\r" : $arg_say;
	echo($arg_say);
}

function phenShowMenu($arg_menu_name)
{
	clearLine();
	$file_extension		= file_exists('ansi/' . $arg_menu_name . '.asc') ? 'asc' : null;
	$file_extension		= file_exists('ansi/' . $arg_menu_name . '.ans') ? 'ans' : null;
	if( !is_null($file_extension) )
	{
		phenShowView('ansi/' . $arg_menu_name . '.' . $file_extension);
	}
}

function phenPressAnyKey()
{
	phenegadeLog('phenPressAnyKey');
	echo(' -- Press Any Key To Continue -- ');
	phenReadInput(STDIN);
}

function nextLine()
{
	echo("\r\n");
}

function clearLine()
{
	echo( chr(27) . "[2J" . chr(27) . "[;H");
	echo("\r");
}

function clearScreen()
{
	clearLine();
}

function phenegadeProc($arg_path)
{
	system($arg_path);
}

function phenegadeLog($arg_message)
{
	global $master_controller_process_id;
	$id_string	= isset($master_controller_process_id) && $master_controller_process_id > 0 ? $master_controller_process_id : null;
	error_log('[' . $id_string . ']' . $arg_message . "\n", 3, 'logs/phenegade.log');
}


/**
* Create a dropfile 
* Serialize the input and write it to the dropfile
* run the dispatch program - give it the dropfile path as an argument
* when the program returns, read the dropfile and get any data that came back 
* return the dropfile payload
*/
function dispatch($arg_pid, $arg_input)
{
	$arg_input['master_controller_process_id'] = $arg_pid;

	$dropfile_path		= 'dropfiles/' . $arg_pid . '-' . time() . '.dat';
	
	$dropfile_handle	= fopen($dropfile_path, 'w+');
	fwrite($dropfile_handle, serialize($arg_input));
	fclose($dropfile_handle);

	$pid 				= phenExec('./dispatch.php ' . $dropfile_path);

	$dropfile_payload	= unserialize(file_get_contents($dropfile_path));
	unlink($dropfile_path);

	return $dropfile_payload;
}

/**
* Load the menu file for the current menu variable
*/
function loadMenu($arg_menu_name)
{
	INCLUDE('menus/' . $arg_menu_name  . '.mnu');
	return $menu;
}

function phenReadInput()
{
	global $terminal_echo;
	$mystdin	= fopen('php://stdin', 'r');
	$input			= '';
	$ss_read		= array($mystdin);
	$ss_write		= null;
	$ss_execpt		= null;
	$keep_reading	= 1;

	while($keep_reading)
	{
		if (false === ($num_changed_streams = stream_select($ss_read, $ss_write, $ss_except, null)))
		{
			//do nothing
		}
		else
		{
			stream_set_blocking($mystdin,0);
			stream_set_timeout($mystdin, 1);
			$one_char	 	= fgetc($mystdin);
			if( $terminal_echo ) { echo($one_char); }
			$input  	.= $one_char;
			if( stristr($input, "\n") || stristr($input, "\r") )
			{
				$keep_reading	= 0;
			}
			
		}
		$input;
	}
	fclose($mystdin);
	return trim($input);
}

function phenReadMulti($arg_watch_stdin = true, $arg_file_paths)
{
	global $terminal_echo;

	//get handles for files
	{
		foreach($arg_file_paths as $file_path)
		{
			$ss_read[]	= $file_path;
		}
	}

	$mystdin	= fopen('php://stdin', 'r');
	$ss_read[]	= $mystdin;
	$input			= '';
	$ss_write		= null;
	$ss_execpt		= null;
	$keep_reading	= 1;

	while($keep_reading)
	{
		if (false === ($num_changed_streams = stream_select($ss_read, $ss_write, $ss_except, null)))
		{
			//do nothing
		}
		else
		{
			stream_set_blocking($mystdin,0);
			stream_set_timeout($mystdin, 1);
			$one_char	 	= fgetc($mystdin);
			if( $terminal_echo ) { echo($one_char); }
			$input  	.= $one_char;
			if( stristr($input, "\n") || stristr($input, "\r") )
			{
				$keep_reading	= 0;
			}
			
		}
		$input;
	}
	fclose($mystdin);
	return trim($input);
}

function phenFileAppend($arg_file, $arg_data)
{
	phenegadeLog('phenFileAppend: ' . $arg_file);
	$my_handle = fopen($arg_file, 'a');
	$bytes_written = fwrite($my_handle, $arg_data, 1024);
	fclose($my_handle);
	return $bytes_written;
}

function phenGetCommandPrompt($arg_user_name)
{
	$prompt = chr(27) . '[31m[User: ' . $arg_user_name .  '] Command: ' . chr(27) . '[97m';
	return $prompt;
}
?>
