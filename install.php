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
	
	if( empty( $_POST ) ) { 
		die( file_get_contents( 'html/install/index.html' ) ); 
	}

	$vhost    = $_POST['vhost'];
	$phpinfo  = $_POST['phpinfo'];
	$timezone = $_POST['timezone'];
	$project  = $_POST['foldername'];

	unset($_POST);

	if( !is_dir( 'config' ) ) { if(!mkdir( 'config' )) { die('error creating config folder'); } }
	$fh = fopen( 'config/config.php', 'w' );

	$data = '<?php
	return array(
		/* Define base paths for the project to run in. */
		\'base\'     => $_SERVER[\'DOCUMENT_ROOT\'] . DIRECTORY_SEPARATOR,
		\'project\'  => \'' . $project . '\',
		/* Set the default dates and timezone configuration correct. */
		\'timezone\' => \'' . $timezone . '\',
		\'phpinfo\'  => ' . $phpinfo . ',
		/* Location of vhost file to fetch server aliases instead of localhost links */
		\'vhost\'    => \'' . $vhost . '\',
	);';

	fwrite( $fh, $data );
	fclose( $fh );

	header( 'location:http://localhost' );

	