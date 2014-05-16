<?php namespace core;

	class Base {

		/**
		 * Time when script started executing.
		 * @var integer
		 */
		protected $_renderTime   = 0;

		/**
		 * Scan of the base dir showing all files and directories.
		 * @var array
		 */
		protected $_scandir      = array();

		/**
		 * array of all used html templates.
		 * @var array
		 */
		protected $_templates    = array();

		/**
		 * 2D array that holds the placeholders for each template.
		 * @var array
		 */
		protected $_placeholders = array();

		/**
		 * [__construct description]
		 */
		public function __construct() {

			$this -> _renderTime = microtime(true); 
			$this -> _scandir    = scandir( Helper::config('base') );

			$this -> cleanScanDir();

			foreach ( array( 'index', 'link', 'tabledata' ) as $templateName ) {
				$this -> _templates[$templateName] = file_get_contents( 
					Helper::config('base') . DIRECTORY_SEPARATOR . Helper::config('project') . DIRECTORY_SEPARATOR . 'html' . DIRECTORY_SEPARATOR . $templateName . '.html'
				);
			}

			foreach( $this -> _templates as $templateName => $templateHTML ) {
				preg_match_all( "(\\{(.*?)})", $templateHTML, $matches );
				$this -> _placeholders[$templateName] = array_unique( $matches[0] );
			}
		}

		public function build() {

			// Predefine row variable for appending html to it later on.
			$rows = '';

			foreach ( $this -> _scandir as $value ) {

				$modified = date( "d F Y H:i:s.", filemtime( $value ) );
				$icon = ( is_dir( $value ) ) ? 'folder' : 'file';

				$vhosts = \core\Helper::With('VHost') -> getVhosts();
				$link = $value;

				foreach($vhosts as $vhost) {
					if( isset( $vhost['documentroot'] ) && $vhost['documentroot'] === $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . $value ) {
						$link = "http://" . $vhost['servername'];
					}
				}

				$rows .= str_replace(
					$this -> _placeholders['tabledata'],
					array(
						$icon . '-icon.png',
						str_replace( '_', ' ', ucfirst( $value ) ),
						$modified,
						str_replace(
							$this -> _placeholders['link'],
							array( $link,  str_replace( '_', ' ', ucfirst( $value ) ) ),
							$this -> _templates['link']
						),
					),
					$this -> _templates['tabledata']
				);
			}

			return str_replace(
				$this -> _placeholders['index'],
				array( get_current_user(), $rows, $this -> getPHPInfo(), ( microtime(true) - $this -> _renderTime ) ),
				$this -> _templates['index']
			);

		}

		/**
		 * [cleanScanDir description]
		 * @return [type] [description]
		 * 
		 * @todo  if $add === true then add extra links such as phpmyadmin or related.
		 */
		private function cleanScanDir( $add = false ) {
			// Remove the ., this file, and hidden files.
			unset( $this -> _scandir[0] );

			// Loop over all files and directories to remove hidden ones etc.
			foreach ( $this -> _scandir as $key => $value ) {
				if( $value === '..' ) { continue; }
				if( $value[0] === '.' ) { unset( $this -> _scandir[$key] ); continue; }
			}

			return;
		}

		/**
		 * Used to get a clean version of php info.
		 * @return string Cleaned version of the phpinfo html.
		 */
		private function getPHPInfo() {
			ob_start();
			phpinfo( Helper::config( 'phpinfo' ) );
			$pinfo = ob_get_contents();
			ob_end_clean();
			 
			return preg_replace( '%^.*<body>(.*)</body>.*$%ms','$1',$pinfo);
		}

	}