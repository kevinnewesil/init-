<?php

	if( !defined( 'DS' ) ) {
		DEFINE( 'DS', DIRECTORY_SEPARATOR );
	}

	return array(
		/* Define base paths for the project to run in. */
		'base'     => $_SERVER['DOCUMENT_ROOT'] . DS,
		'project'  => 'init-',
		/* Set the default dates and timezone configuration correct. */
		'timezone' => 'Europe/Amsterdam',
		'phpinfo'  => INFO_GENERAL,
	);
