<?php namespace core;

	class VHost {

		/**
		 * Path to VHOST file. Default -unix path.
		 * @var string
		 */
		protected $_vhost_conf = '/etc/apache2/extra/httpd-vhosts.conf';

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

			while( !feof( $fh ) ) {
				$this -> parseVhost( fgets( $fh ) );
			}

			return fclose( $fh );

		}

		/**
		 * [parseVhost description]
		 * @param  [type] $line [description]
		 * @return [type]       [description]
		 */
		private function parseVhost( $line ) {

			$rule = false;

			if ( preg_match( "/<VirtualHost/i", $line ) ) {
				preg_match( "/<VirtualHost\s+(.+):(.+)\s*>/i", $line, $results );

				if ( isset( $results[1] ) ) { $this -> _hostname = $results[1]; }
				if ( isset( $results[2] ) ) { $this -> _port = $results[2]; }

				$rule = true;
			}

			if ( preg_match( "/<\/VirtualHost>/i", $line ) && $this -> _hostname != $_SERVER['HTTP_HOST'] ) {
				$this -> _vhosts[] = $this -> _hostname . ( $this -> _port == '80' ? '' : ':'. $this -> _port );
				$rule = false;
			}

			if ( $rule === true ) {
				if ( preg_match( "/ServerName/i", $line ) ) {
					preg_match( "/ServerName\s+(.+)\s*/i", $line, $results );
					if ( isset($results[1] ) ) {
				 		$this -> _hostname = $results[1];
					}
				}
			}

			return $rule;
		}

	}
