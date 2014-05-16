<?php

	/**
	 * @author Kevin Newesil <newesil.kevin@gmail.com>
	 * @version 0.1-BETA
	 *
	 * @todo get icons for file extentions and show file extention as fileTypeIcon
	 */

	// Start session and enable error reporting to all for now as it's debugging version.
	session_start();
	error_reporting( -1 );
	
	if( empty( $_POST ) ) { die( file_get_contents( 'html/install/index.html' ) ); }