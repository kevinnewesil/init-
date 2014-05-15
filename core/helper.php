<?php namespace core;
	
	/**
	 * 
	 */
	class Helper {

		/**
		 * [with description]
		 * @param  [type] $object [description]
		 * @param  string $ns     [description]
		 * @return [type]         [description]
		 */
		public static function with( $object, $ns = '\\core' ) {
			$class = ( substr( $ns, -2 ) !== "\\" ? $ns . "\\" : $ns ) . $object;
			return new $class;
		}

		/**
		 * [config description]
		 * @param  [type] $param [description]
		 * @return [type]        [description]
		 */
		public static function config( $param ) {
			$config = require('webserver_index/config/config.php');
			return $config[$param];
		}

		/**
		 * [dd description]
		 * @param  [type] $data [description]
		 * @return [type]       [description]
		 */
		public static function dd( $data ) {
			ob_start();
			
			echo '<pre>';
			var_dump($data);
			echo '</pre>';

			$dd = ob_get_contents();
			ob_end_clean();

			die($dd);
		}

	}