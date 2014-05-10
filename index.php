<?php

	/**
	 * @author Kevin Newesil <newesil.kevin@gmail.com>
	 * @version 0.1-BETA
	 *
	 * @todo get icons for file extentions and show file extention as fileTypeIcon
	 */

	session_start();
	error_reporting(-1);

	date_default_timezone_set('Europe/Amsterdam');

	$start    = microtime(true);

	$scandir  = scandir( $_SERVER['DOCUMENT_ROOT'] );
	
	$template = file_get_contents( 'webserver_index/index.html' );
	$linkTmp  = file_get_contents( 'webserver_index/link.html' );
	$tableTmp = file_get_contents( 'webserver_index/tabledata.html' );

	$tablePH  = array( '{fileTypeIcon}', '{name}', '{lastModified}', '{link}' );

	ob_start();
	phpinfo(INFO_GENERAL);
	$pinfo = ob_get_contents();
	ob_end_clean();
	 
	$pinfo = preg_replace( '%^.*<body>(.*)</body>.*$%ms','$1',$pinfo);

	// Predefine empty variables for appending.
	$rows = '';
	
	// Remove the ., .. and this file from the array.
	unset( $scandir[0] );
	unset( $scandir[1] );
	unset( $scandir[array_search( 'index.php', $scandir )] );
	unset( $scandir[array_search( '.DS_Store', $scandir )] );

	foreach( $scandir as $value ) {

		$modified = date( "d F Y H:i:s.", filemtime( $value ) );

		if( is_dir( $value ) ) {
			$icon = 'folder';
		} else {
			$icon = 'file';
		}

		$rows .= str_replace(
			$tablePH, 
			array(
				$icon . '-icon.png',
				str_replace( '_', ' ', ucfirst( $value ) ),
				$modified,
				str_replace( array("{href}","{link}"), array($value, str_replace( '_', ' ', ucfirst( $value ) ) ), $linkTmp) ,
			),
			$tableTmp 
		);
	}

	$temp = str_replace( 
		array(
			'{currentUser}',
			'{rows}',
			'{phpinfo}',
			'{loadTime}'
		),
		array(
			get_current_user(),
			$rows,
			$pinfo,
			microtime(true) - $start
		),
		$template
	);

	die($temp);