<?php namespace core;

	class Base {

		/**
		 * Time when script started executing.
		 * @var integer
		 */
		protected $_renderTime   = 0;

		/**
		 * Base location of dir that should be scanned to show as index page for localhost.
		 * @var string
		 */
		protected $_scandir      = '';

		/**
		 * array of all used html templates.
		 * @var array
		 */
		protected $_templates    = array();

		/**
		 * 2D array that holds the placeholders for each template
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
					Helper::config('base') . DS . Helper::config('project') . DS . 'html' . DS . $templateName . '.html'
				);
			}

			foreach( $this -> _templates as $templateName => $templateHTML ) {
				preg_match_all( "(\\{(.*?)})", $templateHTML, $matches );
				$this -> _placeholders[$templateName] = array_unique( $matches[0] );
			}
		}

		public function build() {



		}

		private function cleanScanDir() {
			// Remove the ., this file, and hidden files.
			unset( $this -> _scandir[0] );

			// Loop over all files and directories to remove hidden ones etc.
			foreach ( $this -> _scandir as $key => $value ) {
				if( $value === '..' ) { continue; }
				if( $value[0] === '.' ) { unset( $this -> _scandir[$key] ); continue; }
			}

			Helper::dd($this -> _scandir);
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