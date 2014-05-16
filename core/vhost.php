<?php namespace core;

	class VHost {

		/**
		 * Path to VHOST file. Default -unix path.
		 * @var string
		 */
		protected $_vhost_conf = '/etc/apache2/sites-available/default';

		/**
		 * Name of the host
		 * @var string
		 */
		protected $_hostname   = null;

		/**
		 * Number of the apache web port.
		 * @var string
		 */
		protected $_port       = '80';

		/**
		 * List of all configured Vhosts
		 * @var array
		 */
		protected $_vhosts     = array();

		/**
		 * [__construct description]
		 */
		public function getVhosts() {
			if ( $this -> readVhosts() ) { return $this -> _vhosts; }
			return false;
		}

		/**
		 * [readVhosts description]
		 * @return boolean return what happend to the file handler
		 */
		private function readVhosts() {
			if( !$fh = fopen( $this -> _vhost_conf , 'r' ) ) { return false; }

			$i = 0;

			while( !feof( $fh ) ) {
				if( $this -> parseVhost( fgets( $fh ), $i ) ) { ++$i; }
				
			}

			return fclose( $fh );

		}

		/**
		 * [parseVhost description]
		 * @param  [type] $line [description]
		 * @return [type]       [description]
		 */
		private function parseVhost( $line, $i ) {

			if( $line === "" ) { return false; }

			$rule = true;

			if( preg_match( "/ServerName/i", $line )) {
				preg_match( "/ServerName\s+(.*)/", $line, $results );

				if( $results[1] === "localhost" ) { return false; }
				$this -> _vhosts[$i]['servername'] = $results[1];
				$rule = false;
			}

			if( preg_match( "/DocumentRoot/i", $line )) {
				preg_match( "/DocumentRoot\s+(.*)/", $line, $results );
				
				if( $results[1] === "\"" . $_SERVER['DOCUMENT_ROOT'] . "\"" ) { return false; }

				$this -> _vhosts[$i]['documentroot'] = str_replace( "\"", "", $results[1] );
				$rule = false;
			}

			return $rule;
		}

	}
